<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://fia.wapoin.xyz/send-message',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('number' => '6282143889879', 'message' => 'Percobaan server Kamis pagi', 'sender' => '689013'),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;

$data = json_decode($response);
var_dump($data);
echo '<br>';
echo $data->status;
echo '<br>';
echo $data->message;
