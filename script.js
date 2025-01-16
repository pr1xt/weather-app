// Initialize the map
var map = L.map('map').setView([54, 18], 7);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: 'testmap'
}).addTo(map);

const weatherLayer = L.tileLayer(`https://tile.openweathermap.org/map/temp_new/{z}/{x}/{y}.png?appid=e4d3cd73d50ad843c052abd36ad08c32`, {
    maxZoom: 17
});

weatherLayer.addTo(map);

var popup = L.popup();

function create_point(){
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> gg'
    }).addTo(map);

    async function fetchWeather(lat, lon) {
        const apiKey = 'e4d3cd73d50ad843c052abd36ad08c32';
        const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${apiKey}&units=metric`;
    
        const response = await fetch(url);
        const data = await response.json();
        return data;
    }
    
    // Function to add a marker with weather info
    async function addWeatherMarker(lat, lon) {
        const weatherData = await fetchWeather(lat, lon);
        const weatherInfo = `
            <b>${weatherData.name}</b><br>
            Temperature: ${weatherData.main.temp} °C<br>
            Weather: ${weatherData.weather[0].description}<br>
        `;
    
        L.marker([lat, lon]).addTo(map)
            .bindPopup(weatherInfo)
            .openPopup();
    }
    
    // Add a marker with weather data at the given coordinates
    addWeatherMarker(54, 18);
}


// Add the weather layer to the map

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
    popup.setContent("Weatherdata:<br>" + "<img src=" + weathercondtioniconhtml + ">" +  weatherconditiondescription + "<br>Temperature: " + temperaturecelsius + "°C<br>Airpressure: " 
        + airpressure + " hPa<br>Humidityt: " + airhumidity + "%" + "<br>Cloudcoverage: " + cloudcoverage + "%<br><br>Windspeed: " + windspeedkmh 
        + " km/h<br>Wind from direction: " + winddirectionstring + " (" + winddirection + "°)" + "<br><br><font size=" + fontsizesmall 
        + ">");           


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


const ChangeBg = () => {
    if(document.getElementById("text").innerText == "Sunny"){
        document.body.style.background = "linear-gradient(90deg, rgba(157,157,228,1) 0%, rgba(71,102,140,1) 64%, rgba(146,162,50,1) 82%, rgba(197,237,26,1) 100%)";
    }
    else if(document.getElementById("text").innerText == "Cloudy"){
        document.body.style.background = "linear-gradient(100deg, rgb(66, 126, 216) 0%, rgb(152, 167, 168) 70%, rgb(93, 95, 86) 100%)";
    }
    else if(document.getElementById("text").innerText == "Clear"){
        document.body.style.background = "linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(9,9,121,1) 35%, rgba(28,28,117,1) 62%, rgba(90,90,144,1) 77%, rgba(255,255,255,1) 100%)";
        document.getElementById("left_info").style.color = "rgb(209, 205, 205)";
        document.getElementById("forecast").style.backgroundColor = "rgba(102, 96, 121, 0.6)";
    }
    else if(document.getElementById("text").innerText == "Partly cloudy"){
        document.body.style.background = "linear-gradient(90deg, rgba(114,113,129,1) 0%, rgba(99,98,125,1) 46%, rgba(74,74,140,1) 79%, rgba(24,48,152,1) 100%)";
    }
    else if(document.getElementById("text").innerText == "Partly Cloudy"){
        document.body.style.background = "linear-gradient(90deg, rgba(114,113,129,1) 0%, rgba(99,98,125,1) 46%, rgba(74,74,140,1) 79%, rgba(24,48,152,1) 100%)";
    }
    else if(document.getElementById("text").innerText == "Patchy rain nearby"){
        document.body.style.background = "linear-gradient(90deg, rgba(18,65,139,1) 0%, rgba(113,104,112,1) 64%, rgba(68,84,88,1) 100%)";
        document.getElementById("left_info").style.color = "rgb(209, 205, 205)";
    }
    else if(document.getElementById("text").innerText == "Light rain shower"){
        document.body.style.background = "linear-gradient(100deg, rgb(33, 97, 194) 0%, rgb(32, 189, 201) 50%, rgb(178, 235, 22) 65%, rgb(93, 95, 86) 85%, rgb(22, 69, 201) 100%)";
    }
    else if(document.getElementById("text").innerText == "Light rain"){
        document.body.style.background = "linear-gradient(100deg, rgb(152, 167, 168) 0%, rgb(152, 167, 168) 50%, rgb(33, 97, 194) 100%)";
    }
    else if(document.getElementById("text").innerText == "Overcast"){
        document.body.style.background = "linear-gradient(100deg, rgb(152, 167, 168) 0%, rgb(93, 95, 86) 50%, rgb(93, 95, 86) 100%)";
    }
    else if(document.getElementById("text").innerText == "Mist"){
        document.body.style.background = "linear-gradient(100deg, rgb(123, 135, 126) 0%, rgb(152, 167, 168) 50%, rgb(93, 95, 86) 100%)";
    }
    else if(document.getElementById("text").innerText == "Light drizzle"){
        document.body.style.background = "linear-gradient(100deg, rgb(33, 97, 194) 0%, rgb(152, 167, 168) 20%, rgb(93, 95, 86) 100%)";
    }
    else if(document.getElementById("text").innerText == "Light snow"){
        document.body.style.background = "linear-gradient(90deg, rgba(133,153,155,0.7) 0%, rgba(218,237,255,1) 45%, rgba(213,212,245,1) 100%)";
    }
    else if(document.getElementById("text").innerText == "Moderate snow"){
        document.body.style.background = "linear-gradient(90deg, rgba(166,188,190,1) 0%, rgba(177,185,192,1) 55%, rgba(253,242,225,1) 100%)";
    }
    else if(document.getElementById("text").innerText == "Heavy snow"){
        document.body.style.background = " linear-gradient(158deg, rgba(144,144,144,1) 0%, rgba(177,185,192,1) 55%, rgba(158,150,139,1) 100%)";
    }
    else if(document.getElementById("text").innerText == "Moderate rain"){
        document.body.style.background = " linear-gradient(100deg, rgba(144,144,144,1) 0%, rgba(177,185,192,1) 55%, rgba(98,90,219,1) 100%)";
    }
    else{
        document.body.style.background = " linear-gradient(158deg, rgba(173,148,148,1) 0%, rgba(177,185,192,1) 55%, rgba(132,187,185,1) 100%)";
    }
};

document.getElementById("submit").addEventListener("click", ChangeBg());

function change_prompt() {
    let x = document.forms["locForm"]["location"].value;
    let new_prompt = x.replace(" ", "_").replace("ą", "a").replace("ę", "e").replace("ł", "l").replace("ń", "n").replace("ó", "o").replace("ż", "z").replace("ź", "z");
    document.forms["locForm"]["location"].value = new_prompt; 
};

function search(){
    document.getElementById("cloud-container").style.display = "none";
    document.getElementById("cloud1").style.display = "none";
    document.getElementById("cloud2").style.display = "none";
    setTimeout()
}

function find_error(){
    if(document.getElementById("temp").innerText == "℃"){
        window.history.back();
        alert("We could not find place you just searched.");
    }
}

document.getElementById("submit").addEventListener("click", find_error());

//---------------- adding history ------------------

const container = document.getElementById("history");
var message = $('input[name="message"]').val();
var message_temp = $('input[name="message_temp"]').val();
var message_date = $('input[name="message_date"]').val();

// Set the maximum child count
const maxChildren = 6;

// Function to add a child div
function addChild() {
    const child = document.createElement('div');
    child.className = "history-window";
    child.textContent = "Searched at " + message_date + '\n' + message + " " + message_temp + "℃";


    const ChildForm = document.createElement('form');
    ChildForm.className = "ChildForm";
    
    // ChildForm.method = "POST";

    child.appendChild(ChildForm);
    container.appendChild(child);

    console.log(container.lastChild);
    console.log(ChildForm);

    // Check if we've reached the maximum child count
    if (container.children.length >= maxChildren) {
        console.log(container.children)
        // Remove the oldest child if we've exceeded the limit
        container.removeChild(container.children[0]);
    }

    saveHistoryState();  // Save the history every time a new div is added
}

// Function to save the current state of the history
function saveHistoryState() {
    const historyState = [];
    for (let i = 0; i < container.children.length; i++) {
        const child = container.children[i];
        historyState.push({
            textContent: child.textContent // Save the text content, not the full HTML
        });
    }
    localStorage.setItem('history', JSON.stringify(historyState));  // Store in localStorage
}
  
// Function to load the saved state from localStorage
function loadHistoryState() {
    const savedHistory = localStorage.getItem('history');
    if (savedHistory) {
        const historyState = JSON.parse(savedHistory);
        var x = 0;
        historyState.forEach(item => {

            const child = document.createElement('form');
            child.className = 'ChildForm';
            child.id = 'ChildForm'+x;
            child.method = "POST";

            var ChildForm = document.createElement('button');
            ChildForm.className = "history-window";
            ChildForm.type = "submit";
            ChildForm.name = "submit"+x;
            ChildForm.id = "history-window"+x;
            ChildForm.textContent = item.textContent;
            child.onclick = "SubForm("+x+")";
        

            var HiddenInput = document.createElement("input");
            HiddenInput.setAttribute('style', 'display:none;');
            HiddenInput.type = "text";
            // HiddenInput.type = "text";
            HiddenInput.value = item.textContent.slice(30, item.textContent.length - 1).split(" ").slice(0, -1).join(" ");
            HiddenInput.name = "loc_"+x;

            child.appendChild(HiddenInput);
            child.appendChild(ChildForm);
            container.appendChild(child);

            x++;
        });
    }
}

// Load the history when the page is loaded
window.addEventListener("load", loadHistoryState);
document.getElementById("submit").addEventListener("click", addChild);

//------------------------------------------------

document.addEventListener('click', (event) => {
    const cursorX = event.clientX;
    const cursorY = event.clientY;
    console.log({ x: cursorX, y: cursorY });
    if (cursorX == 185 && cursorY == 11) {
        alert("⛅ Congrats! You found an easter egg! 🌤️");
    }
});

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } 
  else {
    div_loc.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;

    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'json',
        },
        body: JSON.stringify({ lat, lon })
    })
    
}

function showError(error) {
    switch(error.code) {
      case error.PERMISSION_DENIED:
        alert("User denied the request for Geolocation.");
        break;
      case error.POSITION_UNAVAILABLE:
        alert("Location information is unavailable.");
        break;
      case error.TIMEOUT:
        alert("The request to get user location timed out.");
        break;
      case error.UNKNOWN_ERROR:
        alert("An unknown error occurred.");
        break;
    }
}

// rescaling

function rescale(elem) {

    var height = parseInt(elem.css('height'));
    var width = parseInt(elem.css('width'));
    var scalex = parseFloat(elem.attr('scalex'));
    var scaley = parseFloat(elem.attr('scaley'));

    if (!elem.hasClass('rescaled')){
        var ratioX = scalex;
        var ratioY = scaley;
    }else{          
        var ratioX = 1;
        var ratioY = 1;
    }

    elem.toggleClass('rescaled');
    elem.css('-webkit-transform', 'scale('+ratioX +', '+ratioY+')');        
    elem.parent().css('width', parseInt(width*ratioX) + 'px');
    elem.parent().css('height', parseInt(height*ratioY) + 'px');
}