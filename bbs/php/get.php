<?php
$conn = curl_init();
$url = "../index.php?id=1";
curl_setopt($conn, CURLOPT_URL, $url);
$response = curl_exec($conn);
curl_close($conn);

header('Location: ' . $url);