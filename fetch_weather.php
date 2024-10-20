<?php
// Array of cities for periodic data fetching
$cities = ['Delhi', 'Mumbai', 'London', 'New York'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'weather_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch weather data from OpenWeatherMap API
function fetchWeather($city) {
    $apiKey = 'your_openweathermap_api_key';  // Replace with your OpenWeatherMap API key
    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";
    $response = file_get_contents($url);

    if ($response === FALSE) {
        return null;
    }

    return json_decode($response, true);
}

// Loop through cities and fetch data
foreach ($cities as $city) {
    $weatherData = fetchWeather($city);

    if ($weatherData && $weatherData['cod'] == 200) {
        $avg_temp = $weatherData['main']['temp'];
        $max_temp = $weatherData['main']['temp_max'];
        $min_temp = $weatherData['main']['temp_min'];
        $dominant_condition = $weatherData['weather'][0]['main'];
        $date = date('Y-m-d');

        // Check if an alert should be triggered (threshold of 35°C)
        $alert_triggered = ($max_temp > 35) ? 1 : 0;

        // Insert data into the database
        $sql = "INSERT INTO DailyWeatherSummary (city, date, avg_temp, max_temp, min_temp, dominant_condition, alert_triggered)
                VALUES ('$city', '$date', $avg_temp, $max_temp, $min_temp, '$dominant_condition', $alert_triggered)";
        
        $conn->query($sql);
    }
}

$conn->close();
?>
