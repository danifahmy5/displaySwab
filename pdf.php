<?php 
  $base64 = $_POST['base64']; 
  $file = 'pdf\filePdf.pdf';
  $decoded = base64_decode($base64); 
  file_put_contents($file, $decoded); 
  // read pdf
  header("Content-type: application/pdf");
  // header("Content-Disposition: inline; filename=filename.pdf");
  @readfile($file);
  ?>