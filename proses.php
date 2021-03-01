<?php

$uri_path = 'test/test/test';
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path); 
$json = [];

if ($uri_segments[2] == 'dataLab.php') {
  $json = getSwabPcr(); 
}else {
  $json = getSwab(); 
}
 

$dataSwab    = json_decode($json, true);
// post detect
$proses      = isset($_POST['proses']) ? $_POST['proses'] : null; 
// session detect
$login       = isset($_SESSION['login']) ? $_SESSION['login'] : false;

switch ($proses) {
  case 'update': // proses update
    $id           = isset($_POST['id']) ? $_POST['id'] : null;
    $status       = isset($_POST['postStatus']) ? $_POST['postStatus'] : null;
    $buktiTranfer = isset($_POST['buktiTranfer']) ? $_POST['buktiTranfer'] : null;
    // run function swab
    $responseSwab = updateSwab($id, $status, $buktiTranfer);
    if ($responseSwab['id']) {
      if ($uri_segments[2] == 'dataLab.php') {
        header("Location:" . $base_url . "dataLab.php?notif=success"); 
      }else { 
        header("Location:" . $base_url . "?notif=success"); 
      }
    } else {
      if ($uri_segments[2] == 'dataLab.php') {
        header("Location:" . $base_url . "dataLab.php?notif=error"); 
      }else { 
        header("Location:" . $base_url . "?notif=error"); 
      } 
    }
    break;
  case 'login': //proses login
    $username       = isset($_POST['username']) ? $_POST['username'] : null;
    $password       = isset($_POST['password']) ? $_POST['password'] : null;
    // run function login
    $responseLogin = prosesLogin($username, $password);

    if ($responseLogin) {
      header("Location:" . $base_url ."?prosesLogin=success");
    } else {
      header("Location:" . $base_url ."?prosesLogin=failed");
    }
    break;
  case 'logout': // logout
    // menghapus semua session
    session_unset();
    header("Location:" . $base_url . "?prosesLogin=logout");
    break;
  case 'uploadPdf': //upload base64 pdf
    $id     = $_POST['id'];
    $file   = $_FILES['pdf']['tmp_name'];
    $base64 = pdfToBase64($file);
   
    $jsonHasil = postHasilPcr($id, $base64); 
    $arrayHasil = json_decode($jsonHasil,false);
    
    if ($arrayHasil->metadata->code == 400) {
      header("Location:" . $base_url . "dataLab.php?notif=pdf-tersedia"); 
    }else {
      header("Location:" . $base_url . "dataLab.php?notif=succces-upload-hasil");  
    }
    break;
  case 'deletePdf':
    $id     = $_POST['id'];  
    deleteHasilPcr($id);
    header("Location:" . $base_url . "dataLab.php?notif=delete-success");
    break; 
} 
