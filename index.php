<!DOCTYPE html>
<html lang="en">  
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.jpg" type="image/jpg">
    <link rel="stylesheet" href="style.css">
    <title>Weather app</title>
</head>
    <body>
    <?php
        $date = date("Y/m/d - h:i a");
        $API_KEY = "e4d3cd73d50ad843c052abd36ad08c32";
        $API_KEY2 = "de8db8bb099afb5953b048671ed39c84";


        function get_coord($location = "Gdańsk"){
            global $API_KEY, $API_KEY2;

            $geo_url = "http://api.openweathermap.org/geo/1.0/direct?q=$location&limit=2&appid={$API_KEY2}";

            // // Initialize a CURL session.
            $ch = curl_init();


            // // Return Page contents.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // //grab URL and pass it to the variable.
            curl_setopt($ch, CURLOPT_URL, $geo_url);

            $result = curl_exec($ch);    // get data from API page


            $data = json_decode($result, true);

            foreach ($data as $city) {
                $name = $city["name"];
                $country = $city["country"];
                $lat = $city['lat'];
                $lon = $city['lon'];

            }
            curl_close($ch);
            return [
                "name" => $name,
                "country" => $country,
                "lat" => $lat,
                "lon" => $lon
            ];
            
        }
        
        function get_weather($lon, $lat){
            global $API_KEY, $API_KEY2; 
            $url = "https://api.openweathermap.org/data/3.0/onecall?lat={$lat}&units=metric&lon={$lon}&exclude={hourly,daily}&appid={de8db8bb099afb5953b048671ed39c84}";

            // // Initialize a CURL session.
            $ch = curl_init();


            // // Return Page contents.
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            // //grab URL and pass it to the variable.
            curl_setopt($ch, CURLOPT_URL, $url);

            $exec_result = curl_exec($ch);    // get data from API page

            $data = json_decode($exec_result, true);



            // de8db8bb099afb5953b048671ed39c84
            
            $temperature = $data;
            // $feels_like = $data['data'][0]['feels_like'] ?? 'N/A';
            // $weather_main = $data['data'][0]['weather'][0]['main'] ?? 'N/A';
            // $weather_description = $data['data'][0]['weather'][0]['description'] ?? 'N/A';
            // $wind_speed = $data['data'][0]['wind_speed'] ?? 'N/A';
            // $humidity = $data['data'][0]['humidity'] ?? 'N/A';
            curl_close($ch);
            return [

                "temperature" => $temperature, 
                // "feels_like" => $feels_like,
                // "weather_main" => $weather_main,
                // "weather_description" => $weather_description,
                // "wind_speed" => $wind_speed,
                // "humidity" => $humidity,
                // "pressure" => $pressure,
                // "clouds" => $clouds,
            ];
        }


        $res_coord = get_coord("Warszawa");


        $lon = strval($res_coord['lon']);
        $lat = strval($res_coord['lat']);
        echo''. $lon .'  '.$lat;
        //21.071432235636 52.2337172 
        $result = get_weather($lon, $lat );



        // echo "<h4>Country: " . $result["country"] . "</h4>";
        // echo "<h4>City: " . $result["name"] . "</h4>";
        // echo "<h4>Cordinates: " . $result["lat"]. "; ". $result["lon"] . "</h4>";
        // echo "<h4>Date: " . $date . "</h4>";
    ?>
        <div id="main_block">
            <div id="left_info">
                <div id="img_info">
                    <h1 id="weather-icon">🌤️</h1>
                    <?php
                        // echo "<h1>" . $result["temperature"] . "</h1>";
                        echo '<pre>'; print_r($result["temperature"]); echo '</pre>';
                    ?>
                </div>
                <div id="temp_info">
                    
                </div>
            </div>
            <div id="right_info"> 
                <form action="index.php" method="POST">
                    <!-- ❓🌤️🌧️🌦️⛈️⛅🌥️🌨️🌩️📍🔍🔎 -->
                    <input id="search" type="text" name="location" placeholder="Search here">
                    <input id="submit" type="submit" value="🔎">
                </form>
                <h2>Ostatnie wyszukiwane:</h2>
            </div>
        </div>
    </body>
</html>