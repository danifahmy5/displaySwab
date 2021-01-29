<?php 


$json        = getSwab();
$dataSwab    = json_decode($json, true);
$update      = isset($_POST['update']) ? $_POST['update'] : null;
$logout      = isset($_POST['logout']) ? $_POST['logout'] : null;
$login       = isset($_SESSION['login']) ? $_SESSION['login'] : false;
$prosesLogin = isset($_POST['prosesLogin']) ? $_POST['prosesLogin'] : null; 

if ($update) {
  $id           = isset($_POST['id']) ? $_POST['id'] : null;
  $status       = isset($_POST['postStatus']) ? $_POST['postStatus'] : null;
  $buktiTranfer = isset($_POST['buktiTranfer']) ? $_POST['buktiTranfer'] : null;
  // proses update
  $responseSwab = updateSwab($id, $status, $buktiTranfer);
  if ($responseSwab['id']) {
    header("Location:" . $base_url . "?prosesUpdate=success"); 
  }else {
    header("Location:" . $base_url . "?prosesUpdate=error");

  } 
}

if ($prosesLogin) {
  $username       = isset($_POST['username']) ? $_POST['username'] : null;
  $password       = isset($_POST['password']) ? $_POST['password'] : null;

  $responseLogin = prosesLogin($username, $password);

  if ($responseLogin) {
    header("Location:" . $base_url . "?prosesLogin=success");
    die;
  } else {
    header("Location:" . $base_url . "?prosesLogin=failed");
    die;
  }
}
echo $logout;
if ($logout) {
  session_unset();
  header("Location:" . $base_url . "?prosesLogin=logout");
}
