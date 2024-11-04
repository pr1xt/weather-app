<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Openweathermap</title>

<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.css" />
<style>
#headline
{
    font-family: Calibri;
    font-size: 30px;
    text-align: center;
    padding-right: 2px;
    z-index: 1;
}

#map
{
    position: absolute; 
    height: 90vh;
    min-height: 200px;
    width: 99.5vw;
    min-width: 200px;
    left: 2px;  
    border: 3px solid;
    border-color: grey;
    margin-bottom: 0;
    z-index: -2;
}
</style>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>


<body>

<p id='headline'><b>Openweathermap</b></p>

<!-- mapbox -->
<div id="map" class="map"></div>
<!-- routing -->


<br>
<!-- links !-->


<!-- custom script!-->
<script>
//MAP
var map = L.map('map', {
    center: [48.7, 11.5],
    zoom: 6,
});

//BASEMAPS
var osm = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png',{
    attribution: '&copy; <a href="http://osm.org/copyright" target = "_blank">OpenStreetMap</a> contributors'
}).addTo(map);



var popup = L.popup();

//popup function
function onMapClick(e) {
    popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString()) //esample from leaflet, will be immediately replaced by weatherpopup...
        .openOn(map);


//getting json function
$(document).ready(function(){
  $.ajax({
    url: "https://api.openweathermap.org/data/2.5/weather?lat=" + e.latlng.lat + '&lon=' + e.latlng.lng + "&appid=e4d3cd73d50ad843c052abd36ad08c32",
    dataType: 'json',
    success: function(data) {
      // storing json data in variables
      weatherlocation_lon = data.coord.lon; // lon WGS84
      weatherlocation_lat = data.coord.lat; // lat WGS84
      weatherstationname = data.name // Name of Weatherstation
      weatherstationid = data.id // ID of Weatherstation
      weathertime = data.dt // Time of weatherdata (UTC)
      temperature = data.main.temp; // Kelvin
      airpressure = data.main.pressure; // hPa
      airhumidity = data.main.humidity; // %
      temperature_min = data.main.temp_min; // Kelvin
      temperature_max = data.main.temp_max; // Kelvin
      windspeed = data.wind.speed; // Meter per second
      winddirection = data.wind.deg; // Wind from direction x degree from north
      cloudcoverage = data.clouds.all; // Cloudcoverage in %
      weatherconditionid = data.weather[0].id // ID
      weatherconditionstring = data.weather[0].main // Weatheartype
      weatherconditiondescription = data.weather[0].description // Weatherdescription
      weatherconditionicon = data.weather[0].icon // ID of weathericon

    // Converting Unix UTC Time
    var utctimecalc = new Date(weathertime * 1000);
    var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
    var year = utctimecalc.getFullYear();
    var month = months[utctimecalc.getMonth()];
    var date = utctimecalc.getDate();
    var hour = utctimecalc.getHours();
    var min = utctimecalc.getMinutes();
    var sec = utctimecalc.getSeconds();
    var time = date + '.' + month + '.' + year + ' ' + hour + ':' + min + ' Uhr';

    // recalculating
    var weathercondtioniconhtml = "http://openweathermap.org/img/w/" + weatherconditionicon + ".png";
    var weathertimenormal = time; // reallocate time var....
    var temperaturecelsius = Math.round((temperature - 273) * 100) / 100;  // Converting Kelvin to Celsius
    var windspeedknots = Math.round((windspeed * 1.94) * 100) / 100; // Windspeed from m/s in Knots; Round to 2 decimals
    var windspeedkmh = Math.round((windspeed * 3.6) * 100) / 100; // Windspeed from m/s in km/h; Round to 2 decimals
    var winddirectionstring = "Im the wind from direction"; // Wind from direction x as text
    if (winddirection > 348.75 &&  winddirection <= 11.25) {
        winddirectionstring =  "North";
    } else if (winddirection > 11.25 &&  winddirection <= 33.75) {
        winddirectionstring =  "Northnortheast";
    } else if (winddirection > 33.75 &&  winddirection <= 56.25) {
        winddirectionstring =  "Northeast";
    } else if (winddirection > 56.25 &&  winddirection <= 78.75) {
        winddirectionstring =  "Eastnortheast";
    } else if (winddirection > 78.75 &&  winddirection <= 101.25) {
        winddirectionstring =  "East";
    } else if (winddirection > 101.25 &&  winddirection <= 123.75) {
        winddirectionstring =  "Eastsoutheast";
    } else if (winddirection > 123.75 &&  winddirection <= 146.25) {
        winddirectionstring =  "Southeast";
    } else if (winddirection > 146.25 &&  winddirection <= 168.75) {
        winddirectionstring =  "Southsoutheast";
    } else if (winddirection > 168.75 &&  winddirection <= 191.25) {
        winddirectionstring =  "South";
    } else if (winddirection > 191.25 &&  winddirection <= 213.75) {
        winddirectionstring =  "Southsouthwest";
    } else if (winddirection > 213.75 &&  winddirection <= 236.25) {
        winddirectionstring =  "Southwest";
    } else if (winddirection > 236.25 &&  winddirection <= 258.75) {
        winddirectionstring =  "Westsouthwest";
    } else if (winddirection > 258.75 &&  winddirection <= 281.25) {
        winddirectionstring =  "West";
    } else if (winddirection > 281.25 &&  winddirection <= 303.75) {
        winddirectionstring =  "Westnorthwest";
    } else if (winddirection > 303.75 &&  winddirection <= 326.25) {
        winddirectionstring =  "Northwest";
    } else if (winddirection > 326.25 &&  winddirection <= 348.75) {
        winddirectionstring =  "Northnorthwest";
    } else {
        winddirectionstring =  " - currently no winddata available - ";
    };

//Popup with content
    var fontsizesmall = 1;
    popup.setContent("Weatherdata:<br>" + "<img src=" + weathercondtioniconhtml + "><br>" + weatherconditionstring + " (Weather-ID: " + weatherconditionid + "): " + weatherconditiondescription + "<br><br>Temperature: " + temperaturecelsius + "°C<br>Airpressure: " + airpressure + " hPa<br>Humidityt: " + airhumidity + "%" + "<br>Cloudcoverage: " + cloudcoverage + "%<br><br>Windspeed: " + windspeedkmh + " km/h<br>Wind from direction: " + winddirectionstring + " (" + winddirection + "°)" + "<br><br><font size=" + fontsizesmall + ">Datasource:<br>openweathermap.org<br>Measure time: " + weathertimenormal + "<br>Weatherstation: " + weatherstationname + "<br>Weatherstation-ID: " + weatherstationid + "<br>Weatherstation Coordinates: " + weatherlocation_lon + ", " + weatherlocation_lat);           


    },
    error: function() {
      alert("error receiving wind data from openweathermap");
    }
  });        
});
//getting json function ends here

//popupfunction ends here
}

//popup
map.on('click', onMapClick);
</script>

</body>
</html>