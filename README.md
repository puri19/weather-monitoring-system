# weather-monitoring-system

**Description**

This project implements a real-time weather monitoring system that fetches weather data from the OpenWeatherMap API and stores the data in a MySQL database. The system allows users to enter city names and fetch the current weather, including average temperature, maximum temperature, and weather conditions. The stored data is displayed on a frontend interface.

**Features:**

  Fetch real-time weather data for a city.
  
  Store weather data in a MySQL database.
  
  Display daily weather summaries.
  
  Trigger alerts if the temperature exceeds a predefined threshold.
  
**Technologies:**

  **Backend**: PHP
  
  **Database:** MySQL (via phpMyAdmin in XAMPP)
  
  **Frontend:** HTML/CSS, JavaScript
  
  **Weather API:** OpenWeatherMap
  
  **Local Server:** XAMPP (Apache, MySQL)
  
**Prerequisites:**

  **XAMPP:** Ensure XAMPP is installed and running on your machine.
  
  **MySQL:** MySQL database configured through phpMyAdmin.
  
  **API Key:** Get an API key from OpenWeatherMap to fetch real-time weather data.
  
**Setup Instructions:**
1. Clone the Repository

     git clone https://github.com/yourusername/weather-monitoring-system.git
     
2. Database Setup
   
3. Open phpMyAdmin (http://localhost/phpmyadmin).
   
4. Create a new database called weather_db.
    
Run the following SQL script in phpMyAdmin to create the DailyWeatherSummary table:

            CREATE TABLE DailyWeatherSummary (
                id INT AUTO_INCREMENT PRIMARY KEY,
                city VARCHAR(100) NOT NULL,
                date DATE NOT NULL,
                avg_temp FLOAT NOT NULL,
                max_temp FLOAT NOT NULL,
                min_temp FLOAT NOT NULL,
                dominant_condition VARCHAR(100) NOT NULL,
                alert_triggered BOOLEAN DEFAULT 0
            );
     
5. OpenWeatherMap API Configuration
     
    Replace your_openweathermap_api_key in weather_api.php with your actual API key from 
    OpenWeatherMap.
    
6. Configure XAMPP

    Place the entire project folder inside the xampp/htdocs directory.

    Start Apache and MySQL from the XAMPP Control Panel.

7. Run the Application
     
  In your browser, go to http://localhost/weather-monitoring/index.html.

  Enter a city name and fetch weather data.
  API Endpoints:

  Fetch Weather: Fetches real-time weather data for a city and stores it in the database.

              URL: weather_api.php
              Method: POST
              Parameters: city
              
Get Weather Summaries: Retrieves all weather summaries from the database.

              URL: weather_api.php
              Method: GET
              
**Bonus Features:**
**Alerts:** If the temperature exceeds 35°C, the system triggers a high-temperature alert.

**Error Handling:** Displays appropriate error messages for invalid city names or API errors.

**Testing:** You can test the system by entering city names (e.g., Delhi, New York) and fetching weather data.

**Notes:**
Ensure that the API key is valid and has not expired.
