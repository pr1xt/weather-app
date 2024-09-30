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
        <div id="main_block">
            <div id="left_info">
                <div id="img_info">
                    <h1 id="weather-icon">🌤️</h1>
                </div>
                <div id="temp_info">
                    <h2>Temp info</h2>
                    
                    <?php
                        $date = date("Y/m/d");
                        $API_KEY = "e4d3cd73d50ad843c052abd36ad08c32";


                        function get_coord($location = "Gdańsk",$API_KEY){

                            $geo_url = "http://api.openweathermap.org/geo/1.0/direct?q=$location&limit=2&appid={$API_KEY}";

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
                            return [
                                "name" => $name,
                                "country" => $country,
                                "lat" => $lat,
                                "lon" => $lon
                            ];
                        }
                        
                        function get_weather($lon, $lat, $API_KEY){
                            $geo_url = "https://api.openweathermap.org/data/3.0/onecall?lat={$lat}&lon={$lon}&exclude={hourly,daily}&appid={$API_KEY}";

                            // // Initialize a CURL session.
                            $ch = curl_init();


                            // // Return Page contents.
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                            // //grab URL and pass it to the variable.
                            curl_setopt($ch, CURLOPT_URL, $geo_url);

                            $result = curl_exec($ch);    // get data from API page


                            $data = json_decode($result, true);
                        }


                        $result = get_coord("Warszawa", $API_KEY);
                        echo "Country: " . $result["country"];
                        echo "<br>City: " . $result["name"];
                        echo "<br>Cordinates: " . $result["lat"]. "; ". $result["lon"];
                    ?>
 
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