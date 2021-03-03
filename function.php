<?php
// $base_url = "http://192.168.1.8/displaySwab/";
$base_url = "http://localhost/displaySwab/";
$file     = 'pdf/filePdf.pdf';

function getSwab()
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://192.168.1.200:5000/his/about/pxRJAntiPCR',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
    ),
  ));

  return curl_exec($curl);

  curl_close($curl);
}

function getSwabPcr()
{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://192.168.1.200:5000/his/reg/pxrjpcrall',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
    ),
  ));

  return curl_exec($curl);

  curl_close($curl);
}

function updateSwab($id, $status, $buktiTranfer)
{
  $dataUpdate = [
    'buktitransfer' => $buktiTranfer ? $buktiTranfer : null,
    'status'        => $status
  ];
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://192.168.1.200:5000/his/about/updateReg?regid=' . $id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => json_encode($dataUpdate),
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  return json_decode($response, true);
}

function getBgStatus($status)
{
  switch ($status) {
    case 1:
      return null;
    case 2:
      return 'badge-warning';
    case 3:
      return 'badge-warning';
    case 4:
      return 'badge-success';
    case 5:
      return 'badge-danger';
    case 6:
      return 'badge-primary';
    default:
      null;
      break;
  }
}
function prosesLogin($username, $password)
{
  $login = false;
  $user = [
    [
      'username' => 'swab',
      'password' => 'rsaswab123'
    ],
  ];

  foreach ($user as $value) {
    if ($value['username'] == (string)$username && $value['password'] == (string)$password) {
      $login = true;
    }
  }

  if ($login) {
    $_SESSION['login'] = $login;
  }

  return $login;
}

function downloadPdf($base64)
{
  global $file;
  $decoded = base64_decode($base64);

  file_put_contents($file, $decoded);

  if (file_exists($file)) {
    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=hasil-swab.pdf");
  }
  exit;
}

function readPdf($base64)
{
  global $file;
  global $base_url;
  $decoded = base64_decode($base64);
  file_put_contents($file, $decoded);

  header('Location: ' . $base_url . 'pdf.php');
}

function pdfToBase64($path)
{
  $base64 = chunk_split(base64_encode(file_get_contents($path)));
  return $base64;
}

function postHasilPcr($id, $base64)
{
  $data = [
    'id' => $id,
    'pcr' => $base64
  ];

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://192.168.1.200:5000/his/reg/hasilpcr',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);

  return $response;
}

function deleteHasilPcr($id)
{

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://192.168.1.200:5000/his/reg/deletehasilpcr?id=' . $id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'DELETE',
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}
