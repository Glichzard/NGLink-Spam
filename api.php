<?php

function generateDeviceId($length) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-';
    $result = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = mt_rand(0, strlen($characters) - 1);
        $result .= $characters[$randomIndex];
    }

    return $result;
}

$link = $_POST["link"];
$username = explode("/", $link)[3];
$message = $_POST["message"];
$numberOfMessages = $_POST["numberOfMessages"];
$enviados = 0;

for ($index = 0; $index < $numberOfMessages; $index++) {
    $deviceId = urlencode(generateDeviceId(30));
    $postData = "username=" . $username . "&question=" . $message . "&deviceId=" . $deviceId . "&referrer=";
    $url = "https://ngl.link/api/submit";
    $headers = [
        "Accept: */*",
        "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
    ];

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => implode("\r\n", $headers),
            'content' => $postData,
        ],
    ]);

    $response = file_get_contents($url, false, $context);
    $http_status = $http_response_header[0];
    list($http_version, $http_status_code, $http_status_text) = explode(' ', $http_status, 3);

    if($http_status_code == 200) {
        $enviados += 1;
    }
    
    sleep(0.5);
}

echo $enviados;
