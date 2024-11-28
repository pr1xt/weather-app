<!DOCTYPE html>
<html lang="en">  
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.jpg" type="image/jpg">
    <link rel="stylesheet" href="style.css"<?php echo time();?>>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <title>Weather app</title>
</head>
    <body>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
        
    <?php
        include "keys.php";
        $date = date(format: "Y/m/d - h:i a");
        
        error_reporting(error_level: 0);

        function conn_db(): bool|mysqli{
            $conn = @mysqli_connect(hostname: 'localhost', username: 'root', password: '', database: 'baza_pogoda');
            mysqli_close(mysql: $conn);
            return $conn;
        }
        function get_weather($loc): array{
            global $API_KEY; 
            $url = "http://api.weatherapi.com/v1/current.json?key=$API_KEY&q=$loc&aqi=no";
            $ch = curl_init();

            curl_setopt(handle: $ch, option: CURLOPT_RETURNTRANSFER, value: 1);
            curl_setopt(handle: $ch, option: CURLOPT_URL, value: $url);

            $exec_result = curl_exec(handle: $ch);    // get data from API page

            $data = json_decode(json: $exec_result, associative: true);

            $name = $data["location"]["name"];
            $temperature = $data["current"]["temp_c"];
            $wind_mph = $data["current"]["wind_mph"];
            $humidity = $data["current"]["humidity"];
            $feelslike_c = $data["current"]["feelslike_c"];
            $cloud = $data["current"]["cloud"];
            $pressure_mb = $data["current"]["pressure_mb"];
            $text = $data["current"]["condition"]["text"];
            $icon = $data["current"]["condition"]["icon"];
            $localtime = $data["location"]["localtime"];

            curl_close(handle: $ch);
            return [
                "name" => $name,
                "temperature" => $temperature, 
                "wind_mph" => $wind_mph,
                "feelslike_c" => $feelslike_c,
                "icon" => $icon,
                "text" => $text,
                "humidity" => $humidity,
                "pressure_mb" => $pressure_mb,
                "cloud" => $cloud,
                "localtime" => $localtime
            ];
        }

        if(isset($_POST["look"])){
            if(isset($_POST['location'])){
                $location = $_POST["location"];

                $result = get_weather(loc: $location);    
            }
        }else{ 
            $result = get_weather(loc: "London");
        }

        //to get $result u should call get_weather($loc) where $loc is string of location in ENGLISH
 
        // $weather_data = json_decode(json: file_get_contents(filename: 'php://input'), associative: true);
        // show_ur_weather(data: $weather_data);
        
        function show_ur_weather($data): void {
            // Assuming $data['lat'] and $data['lon'] exist
            if (isset($data['lat']) && isset($data['lon'])) {
                echo json_encode(value: array('message' => 'Data received and processed', 'lat' => $data['lat'], 'lon' => $data['lon']));
            } else {
                echo json_encode(value: array('error' => 'Latitude and longitude not found'));
            }
        }

    ?>
        <div id="space">
            <div id="main_block">
                <div id="main-info">
                    <div id="left_info">
                        <div id="img_info">
                            <?php
                                echo "<img id='weather-icon' src='" . $result["icon"] . "' alt='icon' >";
                                echo "<h1 id='text'>" . $result["text"] . "</h1>";
                                echo "<h1>" . $result["temperature"] . "℃</h1>";
                                echo "<h2 class='info'>Feels like: " . $result["feelslike_c"] . "℃</h2>";
                                echo "<h2 class='info'>Wind speed: " . $result["wind_mph"] . "mph</h2>";
                                echo "<h2 class='info'>Humidity: " . $result["humidity"] . "%</h2>";
                                echo "<h2 class='info'>Clouds: " . $result["cloud"] . "%</h2>";
                                echo "<h2 class='info'>Pressure: " . $result["pressure_mb"] . "hPa</h2>";
                            ?>
                        </div>
                        <div id="temp_info">
                            <?php
                                echo "<h1 id='city_name'>" . $result["name"] . "</h1>";
                                echo "<h2 id='localtime'>" . $result["localtime"] . "</h2>";
                            ?>
                        </div>
                        <div id="forecast">
                            <div class="box" id="start-box">
                                
                            </div>
                            <div class="box">

                            </div>
                            <div class="box">

                            </div>
                            <div class="box">

                            </div>
                            <div class="box" id="end-box">

                            </div>
                        </div>
                    </div>
                    
                    <div id="right_info">
                    <button id="sub_loc" name="sub_loc" type="submit" onclick="getLocation()">Get Your Location</button>
                        <form name="locForm" action="index.php" onsubmit="return change_prompt()" method="POST">
                            <!-- ❓🌤️🌧️🌦️⛈️⛅🌥️🌨️🌩️📍🔍🔎 -->
                            <input id="search" type="text" name="location" placeholder="Search here" required>
                            <button id="submit" name="look" type="submit" onclick="search()">🔎</button>
                        </form>
                        <h2>Search history:</h2>
                        <div id="history">
                            
                        </div>
                    </div>
                </div>
                <div id="bottom_info">
                    <div id="div-map">
                        <div id="map">

                        </div>          
                    </div>
                </div>
            </div>
        </div>
        <img id="cloud1" class="cloud cloud-left"src="https://raw.githubusercontent.com/pr1xt/weather-app/refs/heads/main/cloud_left.png">
        <img id="cloud2" class="cloud cloud-right"src="https://raw.githubusercontent.com/pr1xt/weather-app/refs/heads/main/cloud_right.png">
    
    </body>
       
    <script src="script.js?<?php echo time(); ?>"></script>  
</html>