<?php
$fileLampiran = 'https://angsuran.grandtalawang.com/lampiran_broadcast/1669072838412.jpg';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://app.whacenter.com/api/send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('device_id' => '192042a4b780faa55dea93f2dce120b2','number' => '6281250274777',
  'message' => 'tes kirim gambar',
  'file' => $fileLampiran),
  
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
