<?php
header('Content-Type: application/json');

include '../config.php';

$apiKey = getenv('WEATHER_API_KEY');
$city = "Sukakarya";

$response = [
    "temp" => "N/A",
    "weather" => "Tidak tersedia",
    "icon" => "02d"
];

if ($apiKey) {
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric&lang=id";
    
    $weatherResponse = @file_get_contents($apiUrl);
    if ($weatherResponse) {
        $weatherData = json_decode($weatherResponse, true);
        $response["temp"] = $weatherData['main']['temp'] ?? 'N/A';
        $response["weather"] = ucfirst($weatherData['weather'][0]['description'] ?? 'N/A');
        $response["icon"] = $weatherData['weather'][0]['icon'] ?? '02d';
    }
}

echo json_encode($response);
?>