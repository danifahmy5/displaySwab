<?php 
 
  $base64  = $_POST['base64'];
  $decoded = base64_decode($base64);
  $file = 'pdf\filePdf.pdf';
  
  file_put_contents($file, $decoded); 
 
  if (file_exists($file)) { 
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=hasil-swab.pdf');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
  }
