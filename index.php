<!DOCTYPE html>
<html lang="en">  
<head> 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/icon.png" type="image/png">
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
        $MAP_KEY = "e4d3cd73d50ad843c052abd36ad08c32";
        // include "keys.php";
        $date = date(format: "Y/m/d h:ia");
        
        error_reporting(error_level: 0);

        function refreshPageOnce() {
            $cookieName = 'page_refreshed';
            $cookieExpiration = time() + (30 * 24 * 60 * 60); // 30 days

            // Check if the cookie is already set
            if (!isset($_COOKIE[$cookieName])) {
                // Set the cookie and refresh the page
                setcookie($cookieName, '1', $cookieExpiration, "/");
                header("Refresh:1"); // Refresh the page
                die();
            }
        }

        //Call the function at the start of your script


        function get_forecast($lat,$lon){
            global $MAP_KEY; 
            $url = "http://api.openweathermap.org/data/2.5/forecast?lat=$lat&lon=$lon&appid=e4d3cd73d50ad843c052abd36ad08c32&units=metric";
            $ch = curl_init();

            curl_setopt(handle: $ch, option: CURLOPT_RETURNTRANSFER, value: 1);
            curl_setopt(handle: $ch, option: CURLOPT_URL, value: $url);

            $exec_result = curl_exec(handle: $ch);    // get data from API page

            $data = json_decode(json: $exec_result, associative: true);
            $day0 = $data["list"][0]["main"]["temp"]."℃ ".$data["list"][0]["weather"][0]["main"];
            $d0_icon = $data["list"][0]["weather"][0]["icon"];
            $day1 = $data["list"][8]["main"]["temp"]."℃ ".$data["list"][8]["weather"][0]["main"];
            $d1_icon = $data["list"][8]["weather"][0]["icon"];
            $day2 = $data["list"][16]["main"]["temp"]."℃ ".$data["list"][16]["weather"][0]["main"];
            $d2_icon = $data["list"][16]["weather"][0]["icon"];
            $day3 = $data["list"][24]["main"]["temp"]."℃ ".$data["list"][24]["weather"][0]["main"];
            $d3_icon = $data["list"][24]["weather"][0]["icon"];
            $day4 = $data["list"][32]["main"]["temp"]."℃ ".$data["list"][32]["weather"][0]["main"];
            $d4_icon = $data["list"][32]["weather"][0]["icon"];
            $weather_list = [$day0,$d0_icon,$day1,$d1_icon,$day2,$d2_icon,$day3,$d3_icon,$day4,$d4_icon];
            
            return $weather_list;



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
            $wind_kph = $data["current"]["wind_kph"];
            $humidity = $data["current"]["humidity"];
            $feelslike_c = $data["current"]["feelslike_c"];
            $cloud = $data["current"]["cloud"];
            $pressure_mb = $data["current"]["pressure_mb"];
            $text = $data["current"]["condition"]["text"];
            $icon = $data["current"]["condition"]["icon"];
            $localtime = $data["location"]["localtime"];
            
            $lat = $data["location"]["lat"];
            $lon = $data["location"]["lon"];

            curl_close(handle: $ch);
            
            $weather_list = get_forecast($lat,$lon);

            return [
                "name" => $name,
                "temperature" => $temperature, 
                "wind_kph" => $wind_kph,
                "feelslike_c" => $feelslike_c,
                "icon" => $icon,        
                "text" => $text,    
                "humidity" => $humidity,
                "pressure_mb" => $pressure_mb,
                "cloud" => $cloud,
                "localtime" => $localtime,
                "lat" => $lat,
                "lon" => $lon,
                "forecast" => $weather_list
            ];
        }

        
        if(isset($_POST["look"])){
            if(isset($_POST['location'])){
                $location = $_POST["location"];

                $result = get_weather(loc: $location);    
            }
        }


    ?>
        <div id="space">
            <div id="main_block" scalex='0.9' scaley='1.2'>
                <div id="main-info">
                    <div id="left_info">
                        <div id="img_info">
                            <?php
                                echo "<h1 id='text'>" . $result["text"] . "</h1>"; //not scaling? NO BITCHES???
                                echo "<h2 class='info'>Feels like: " . $result["feelslike_c"] . "℃</h2>";
                                echo "<h2 class='info'>Wind speed: " . $result["wind_kph"] . "k/h</h2>";
                                echo "<h2 class='info'>Humidity: " . $result["humidity"] . "%</h2>";
                                echo "<h2 class='info'>Clouds: " . $result["cloud"] . "%</h2>";
                                echo "<h2 class='info'>Pressure: " . $result["pressure_mb"] . "hPa</h2>";
                            ?>
                        </div>
                        <div id="temp_info">
                            <div id="part1">
                                <?php
                                    echo "<h1 id='temp'>" . $result["temperature"] . "℃</h1>"; //not scaling? NO TOWERS???
                                    echo "<img id='weather-icon' src='" . $result["icon"] . "' alt='icon' >";
                                ?>
                            </div>
                            <div id="city_name">
                                <?php
                                    echo "<h1 id='city_name_text'>" . $result["name"] . "</h1>";
                                ?>
                            </div>
                            <div id="loc_time">
                                <?php
                                    echo "<h2 id='localtime'>" . $result["localtime"] . "</h2>"; //not scaling? NO QUEEN???
                                ?>
                            </div>
                        </div>
                        <?php
                            $today = date('w');
                            $daysAhead = array();
                            for ($i = 1; $i <= 7; $i++) {
                                $day = date('l', strtotime('+' . $i . ' days', strtotime(date('Y-m-d'))));
                                $daysAhead[] = $day;
                            }
                        ?>
                        <div id="forecast">
                            <div class="box" id="start-box">
                                <?php echo "<h2>" . $daysAhead[0] . "</h2>"; 
                                    echo "<h3>" . $result['forecast'][0] . "</h3>";
                                    $logo0 = $result["forecast"][1];
                                    echo "<img src='https://openweathermap.org/img/wn/$logo0.png'>";
                                ?>
                            </div>
                            <div class="box">
                                <?php echo "<h2>" . $daysAhead[1] . "</h2>";
                                    echo "<h3>" . $result['forecast'][2] . "</h3>";
                                    $logo1 = $result["forecast"][3];
                                    echo "<img src='https://openweathermap.org/img/wn/$logo1.png'>";
                                ?>
                            </div>
                            <div class="box">
                                <?php echo "<h2>" . $daysAhead[2] . "</h2>"; 
                                    echo "<h3>" . $result['forecast'][4] . "</h3>";
                                    $logo2 = $result["forecast"][5];
                                    echo "<img src='https://openweathermap.org/img/wn/$logo2.png'>";
                                ?>
                            </div>
                            <div class="box">
                                <?php echo "<h2>" . $daysAhead[3] . "</h2>"; 
                                    echo "<h3>" . $result['forecast'][6] . "</h3>";
                                    $logo3 = $result["forecast"][7];
                                    echo "<img src='https://openweathermap.org/img/wn/$logo3.png'>";
                                ?>
                            </div>
                            <div class="box" id="end-box">
                                <?php echo "<h2>" . $daysAhead[4] . "</h2>"; 
                                    echo "<h3>" . $result['forecast'][8] . "</h3>";
                                    $logo4 = $result["forecast"][9];
                                    echo "<img src='https://openweathermap.org/img/wn/$logo4.png'>";
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div id="right_info">
                        <form id="locForm" name="locForm" action="index.php" onsubmit="return change_prompt()" method="POST">
                            <!-- ❓🌤️🌧️🌦️⛈️⛅🌥️🌨️🌩️📍🔍🔎 -->
                            <input id="search" type="text" name="location" placeholder="Search here" required>
                            <button id="submit" name="look" type="submit" onclick="search()">🔎</button>
                        </form>
                        <h2>Search history:</h2> <!-- not scaling? -->
                        <div id="history">
                         
                        </div>
                        <?php
                            
                        ?>
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
        <img id="cloud1" class="cloud cloud-left" src="https://raw.githubusercontent.com/pr1xt/weather-app/refs/heads/main/cloud_left.png">
        <img id="cloud2" class="cloud cloud-right" src="https://raw.githubusercontent.com/pr1xt/weather-app/refs/heads/main/cloud_right.png">
    
    </body>
    <?php
        $data_date = $date;
        $data_name = $result["name"];
        $data_temp = $result["temperature"];
        echo '<input type="hidden" name="message" value="' . $data_name . '">';
        echo '<input type="hidden" name="message_temp" value="' . $data_temp . '">';
        echo '<input type="hidden" name="message_date" value="' . $data_date . '">';
    ?>
    <script src="script.js?<?php echo time(); ?>"></script>  
</html>
