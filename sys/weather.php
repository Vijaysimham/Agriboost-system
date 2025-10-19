<?php
$apiKey = "89c2fade782a2125a3937595fbbf3961"; // Replace with your valid API key
$city = "Anantapur"; // Change to any city if needed
$apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

$cache_file = 'weather_data.json';

// Fetch data from API
$data = @file_get_contents($apiUrl);

if ($data === FALSE) {
    die("<h3 style='color: red;'>Error: Unable to fetch weather data. Check API key or internet connection.</h3>");
}

// Save data to cache
file_put_contents($cache_file, $data);
$data = json_decode($data);

// Check if API response is valid
if (!isset($data->main)) {
    die("<h3 style='color: red;'>Error: No weather data available. Check API response.</h3>");
}

// Extract weather data
$cityName = $data->name;
$country = $data->sys->country;
$temp = $data->main->temp;
$humidity = $data->main->humidity;
$pressure = $data->main->pressure;
$windSpeed = $data->wind->speed;
$weatherDescription = $data->weather[0]->description;
$weatherIcon = "https://openweathermap.org/img/wn/" . $data->weather[0]->icon . ".png";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Report - <?php echo $cityName; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 20px;
        }
        .weather-container {
            background: white;
            padding: 20px;
            width: 50%;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .weather-icon img {
            width: 100px;
        }
        .title {
            font-size: 24px;
            color: #333;
            font-weight: bold;
        }
        .weather-info {
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="weather-container">
    <h2 class="title">Weather Report for <?php echo $cityName . " (" . $country . ")"; ?></h2>
    <div class="weather-icon">
        <img src="<?php echo $weatherIcon; ?>" alt="Weather Icon">
    </div>
    <p class="weather-info"><strong>Temperature:</strong> <?php echo $temp; ?>°C</p>
    <p class="weather-info"><strong>Weather:</strong> <?php echo ucfirst($weatherDescription); ?></p>
    <p class="weather-info"><strong>Humidity:</strong> <?php echo $humidity; ?>%</p>
    <p class="weather-info"><strong>Pressure:</strong> <?php echo $pressure; ?> hPa</p>
    <p class="weather-info"><strong>Wind Speed:</strong> <?php echo $windSpeed; ?> m/s</p>
</div>

</body>
</html>
