<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Cho phép localhost & domain thật

$query = $_GET['q'] ?? '';
if (empty($query)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing query']);
    exit;
}

// Build URL Nominatim
$url = 'https://nominatim.openstreetmap.org/search?' . http_build_query([
    'q' => $query,
    'format' => 'json',
    'addressdetails' => 1,
    'limit' => 8,
    'countrycodes' => 'vn'
]);

// Fetch từ server (PHP không bị CORS)
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'YourAppName/1.0 (anhkhoale2406@gmail.com)'); // Thay email thật
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    echo $response;
} else {
    http_response_code($httpCode ?: 500);
    echo json_encode(['error' => 'Nominatim request failed', 'code' => $httpCode]);
}
?>