php
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $secretKey = 'YOUR_SECRET_KEY';
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secretKey,
        'response' => $responseKey,
        'remoteip' => $userIP
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context  = stream_context_create($options);
    $verifyResponse = file_get_contents($url, false, $context);
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {
        // reCAPTCHA was successful, process the form data
        echo 'Form submitted successfully!';
    } else {
        echo 'reCAPTCHA verification failed. Please try again.';
    }
}
?>