<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'weather_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch weather data from OpenWeatherMap API
function fetchWeather($city) {
    $apiKey = '0dd4cc7f51eb0b0b7152e327829637ec';  // Replace with your OpenWeatherMap API key
    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";  // Metric units for Celsius
    $response = file_get_contents($url);

    if ($response === FALSE) {
        return null;  // Handle API errors
    }

    return json_decode($response, true);
}

// Save weather data to the database with alert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['city'])) {
    $city = $_POST['city'];
    $weatherData = fetchWeather($city);

    if ($weatherData && $weatherData['cod'] == 200) {
        $avg_temp = $weatherData['main']['temp'];
        $max_temp = $weatherData['main']['temp_max'];
        $min_temp = $weatherData['main']['temp_min'];
        $dominant_condition = $weatherData['weather'][0]['main'];
        $date = date('Y-m-d');
        
        // Check if an alert should be triggered (threshold of 35°C)
        $alert_triggered = ($max_temp > 35) ? 1 : 0;

        // Insert data into the DailyWeatherSummary table
        $sql = "INSERT INTO DailyWeatherSummary (city, date, avg_temp, max_temp, min_temp, dominant_condition, alert_triggered) 
                VALUES ('$city', '$date', $avg_temp, $max_temp, $min_temp, '$dominant_condition', $alert_triggered)";
        
        if ($conn->query($sql) === TRUE) {
            // If alert was triggered, show a warning message
            if ($alert_triggered) {
                echo json_encode(['message' => 'Weather data saved successfully, ALERT: High temperature!']);
            } else {
                echo json_encode(['message' => 'Weather data saved successfully']);
            }
        } else {
            echo json_encode(['error' => 'Error saving weather data']);
        }
    } else {
        echo json_encode(['error' => 'City not found or API error']);
    }
}

// Get all weather summaries
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM DailyWeatherSummary");
    $summaries = [];
    while ($row = $result->fetch_assoc()) {
        $summaries[] = $row;
    }
    echo json_encode($summaries);
}

$conn->close();
?>
