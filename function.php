<?php

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

function updateSwab($id, $status, $buktiTranfer)
{
  $dataUpdate = [
    'buktitransfer' => $buktiTranfer,
    'status'        => $status
  ];

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://36.94.8.228:5000/his/about/updateReg?regid=' . $id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
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
  return $response;
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
    default:
      null;
      break;
  }
}
