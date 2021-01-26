<?php
session_start();
include 'function.php';
include 'proses.php'
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="assets/icon/logo.png">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/style/bootstrap.css">
  <link rel="stylesheet" href="assets/style/dataTables.bootstrap4.min.css">

  <title>Data Swab</title>
  <style>
    .zoom {
      transition: transform .2s;
      /* Animation */
      margin: 0 auto;
    }

    table.dataTable tbody td {
      vertical-align: middle;
    }

    table.dataTable thead th {
      vertical-align: middle;
    }

    .zoom:hover {
      position: relative;
      z-index: 9999;
      transform: scale(2.5);
      /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }
  </style>
</head>

<body class="bg-dark">
  <?php $responseLogin = isset($_GET['prosesLogin']) ? $_GET['prosesLogin'] : null; ?>

  <?php if (!$login) : ?>
    <div class="container">
      <div class="row">
        <div class="col-sm-4 mx-auto text-center" style="margin-top: 10%;">
          <h3 class="bg-primary text-white p-2">Login Swab/Antigen</h3>
          <?php if ($responseLogin == 'success') : ?>
            <h5 class='badge badge-success mt-1' style="width: 50%;">Login Berhasil</h5>
          <?php endif ?>
          <?php if ($responseLogin == 'failed') : ?>
            <h5 class='badge badge-danger mt-1' style="width: 50%;">Login gagal</h5>
          <?php endif ?>
          <?php if ($responseLogin == 'logout') : ?>
            <h5 class='badge badge-success mt-1' style="width: 50%;">Berhasil Logout</h5>
          <?php endif ?>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-6 mx-auto mt-3">
          <div class="card">
            <div class="card-body">
              <form method="POST">
                <input type="hidden" name="prosesLogin" value="1">
                <div class="form-group">
                  <label for="exampleInputEmail1">Username</label>
                  <input type="text" name="username" required class="form-control" placeholder="Masukkan username">
                  <small id="emailHelp" class="form-text text-muted">Username yang sudah terdaftar</small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input name="password" type="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php die;
  endif ?>
  <div class="mx-3">
    <div class="card my-2">
      <div class="card-header bg-dark text-white">
        <h4 class="text-center"><img class="mr-2" src="assets/icon/logo.png" width="50"> DATA SWAB / ANTIGEN RS AISYIYAH BOJONEGORO</h4>
        <form action="" method="POST">
          <input type="hidden" value="logout" name="logout">
          <button type="submit" class="btn btn-danger"> Logout</button>
        </form>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered table-sm" style="width:100%">
            <thead class="bg-dark text-white">
              <tr>
                <th class="text-center">ID</th>
                <th class="text-center">RM</th>
                <th class="text-center">Nama</th>
                <th class="text-center" class="d-flex">Alamat</th>
                <th width="130" class="text-center">Tanggal</th>
                <th class="text-center">Genre</th>
                <th class="text-center">Status</th>
                <th class="text-center">KTP</th>
                <th class="text-center">Bukti Tranfer</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($dataSwab['_embedded']['pxRJAntiPCRs'] as $value) :
                $date = date_create($value['tgl']);
                $dateFormat = date_format($date, 'd F, Y')
              ?>
                <tr>
                  <td><?= $value['id']; ?></td>
                  <td><?= $value['regnum']; ?></td>
                  <td><?= $value['nama']; ?></td>
                  <td><?= $value['addr']; ?></td>
                  <td align="center"><?= $dateFormat; ?></td>
                  <td align="center"><?= $value['jenis_kelamin']; ?></td>
                  <td align="center">
                    <?= $value['statustransaksirj'] ? '<span class="badge ' . getBgStatus($value['idstatustransaksirj']) . '">' . $value['statustransaksirj'] . '</span>' : 'Kosong' ?>
                  </td>
                  <td align="center"><?= $value['ktp'] ? '<img width="100" class="zoom rounded" src="' . $value['ktp'] . '" alt="">' : 'kosong' ?></td>
                  <td align="center"><?= $value['buktitransfer'] ? '<img width="100" class="zoom rounded" src="' . $value['buktitransfer'] . '" alt="">' : 'kosong' ?></td>
                  <td align="center">
                    <div class="btn-group ">
                      <a type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                      </a>
                      <ul class="dropdown-menu">
                        <li>
                          <a class="dropdown-item" onclick="_detailSwab(
                            '<?= $value['id']; ?>',
                            '<?= $value['regnum']; ?>',
                            '<?= $value['nama']; ?>',
                            '<?= $value['addr']; ?>',
                            '<?= $value['tgl']; ?>',
                            '<?= $value['jenis_kelamin']; ?>',
                            '<?= $value['ktp']; ?>',
                            '<?= $value['buktitransfer'] ?>',
                            '<?= $value['statustransaksirj']; ?>', 
                          )" href="#">Detail</a>
                        </li>
                        <li><a class="dropdown-item" onclick="_getDataSwab('<?= $value['idol']; ?>', '<?= $value['buktitransfer'] ?>')" href="#">Edit</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLabel">Detail Swab</h5>
        </div>
        <div class="modal-body">
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="nama">Nama</label>
            <div class="col-sm-10">
              <input disabled type="text" name="nama" id="nama" class="form-control">
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="id">ID</label>
            <div class="col-sm-10">
              <input disabled type="text" name="id" id="id" class="form-control">
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="rm">RM</label>
            <div class="col-sm-10">
              <input disabled type="text" name="rm" id="rm" class="form-control">
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
            <div class="col-sm-10">
              <input disabled type="text" name="alamat" id="alamat" class="form-control">
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="tanggal">Tanggal</label>
            <div class="col-sm-10">
              <input disabled type="text" name="tanggal" id="tanggal" class="form-control">
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="genre">Genre</label>
            <div class="col-sm-10">
              <input disabled type="text" name="genre" id="genre" class="form-control">
            </div>
          </div>
          <div class="row mb-2">
            <label class="col-sm-2 col-form-label" for="status">Status</label>
            <div class="col-sm-10">
              <input disabled type="text" name="status" id="status" class="form-control">
            </div>
          </div>
          <div class="bg-light m-1 row">
            <div class="col-sm-6">
              <img src="" id="ktp" class="rounded m-1">
            </div>
            <div class="col-sm-6">
              <img src="" id="bukti" class="rounded m-2">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLabel">Edit Status</h5>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <input type="hidden" name="update" value="1">
            <input type="hidden" name="id" id="postIdOl">
            <input type="hidden" name="buktiTranfer" id="postBuktiTranfer">
            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" required name="postStatus">
                <option value="">-- Pilih Status --</option>
                <option value="4">Pembayaran Berhasil </option>
                <option value="5">Pembayaran Gagal </option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery-3.5.1.js"></script>
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap4.min.js"></script>
  <script>
    $(document).ready(function() {
      alert
      $('table').DataTable();
    });

    setTimeout(function() {
      window.location.reload()
    }, 120000)

    function _detailSwab(id, rm, nama, alamat, tgl, genre, ktp, tf, status) {
      $('#nama').val(nama);
      $('#id').val(id);
      $('#rm').val(rm);
      $('#alamat').val(alamat);
      $('#tanggal').val(tgl);
      $('#genre').val(genre);
      $('#status').val(status);
      $('#bukti').attr('src', tf);
      $('#ktp').attr('src', ktp);
      $('#exampleModal').modal('show');
    }

    function _getDataSwab(id, buktiTranfer) {
      $('#postIdOl').val(id);
      $('#postBuktiTranfer').val(buktiTranfer);
      $('#edit').modal('show');
    }
  </script>
</body>

</html>