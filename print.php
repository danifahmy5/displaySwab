<?php
include 'function.php';
$base_64 = isset($_POST['base_64']) ? $_POST['base_64'] : header('Location:' . $base_url . 'dataLab.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="assets/style/bootstrap.css">
  <link rel="stylesheet" href="assets/style/dataTables.bootstrap4.min.css">
  <style>
    @media print {
      table {
        -webkit-print-color-adjust: exact
      }

      body * {
        visibility: hidden;
      }

      .print,
      .print * {
        visibility: visible;
      }

      .print {
        margin-top: 0px;
        padding-top: 0px;
      }
    }
  </style>
</head>

<body onload="window.print()">
  <div class="mx-5 my-5 py-5 px-3 bg-dark rounded shadow">
    <div class="bg-white py-3 mx-auto" style="height: 29cm; width:21cm">
      <img width="600" class="d-block mx-auto print" src="<?= $base_64 ?>" alt="gambar ktp">
    </div>
  </div>
  <script src="assets/js/jquery-3.5.1.js"></script>

  <script>
    $(document).ready(function() {
      var beforePrint = function() {
        console.log('Functionality to run before printing.');
      };

      var afterPrint = function() {
        window.close()
      };

      if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
          if (mql.matches) {
            beforePrint();
          } else {
            afterPrint();
          }
        });
      }

      window.onbeforeprint = beforePrint;
      window.onafterprint = afterPrint;
    })
  </script>
</body>

</html>