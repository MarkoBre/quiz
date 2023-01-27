<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kviz za debile</title>

</head>

<body>
<?php include 'header.php';?>
    <h1>Pozdrav</h1>
<?php

// Initialise new cURL session
$ch = curl_init();
$baseUrl = 'https://the-trivia-api.com/api/questions';
$query = '?limit=5&categories=history,science,geography&difficulty=medium&region=RS';

// Set URL and other options
curl_setopt($ch, CURLOPT_URL, $baseUrl . $query);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json'
));

$result = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo "jbg" . curl_error($ch);
} else {
    echo "u u \n";
}

// Close the connection and free up the system resources
curl_close($ch);

$result = json_decode($result);
$num = count($result[2]->incorrectAnswers);
for ($i=0; $i < $num; $i++) {
    echo $result[2]->incorrectAnswers[$i] . "\n";
    # code...
}

?>
</body>

</html>