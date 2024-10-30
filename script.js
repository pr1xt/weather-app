// Initialize the map
var map = L.map('map').setView([51.505, -0.09], 13);


L.tileLayer('http://maps.openweathermap.org/maps/2.0/weather/TA2/{z}/{x}/{y}?appid=e4d3cd73d50ad843c052abd36ad08c32', {
    attribution: 'gg'
}).addTo(map);

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
    addWeatherMarker(51.5, -0.09);
}


const ChangeBg = () => {
    if(document.getElementById("text").innerText == "Sunny"){
        document.body.style.background = "linear-gradient(100deg, rgb(33, 97, 194) 0%, rgb(32, 189, 201) 50%, rgb(178, 235, 22) 100%)";
    }
    else if(document.getElementById("text").innerText == "Cloudy"){
        document.body.style.background = "linear-gradient(100deg, rgb(66, 126, 216) 0%, rgb(152, 167, 168) 70%, rgb(93, 95, 86) 100%)";
    }
    else if(document.getElementById("text").innerText == "Clear"){
        document.body.style.background = "linear-gradient(90deg, rgb(23, 23, 49) 0%, rgb(43, 21, 122) 45%, rgb(35, 15, 105) 65%, rgb(208, 215, 199) 100%)";
        document.getElementById("left_info").style.color = "rgb(209, 205, 205)";
    }
    else if(document.getElementById("text").innerText == "Partly cloudy"){
        document.body.style.background = "linear-gradient(90deg, rgba(130,201,232,1) 0%, rgba(125,149,173,1) 55%, rgba(210,196,176,1) 100%)";
        //day
    }
    else if(document.getElementById("text").innerText == "Partly Cloudy"){
        document.body.style.background = "linear-gradient(100deg, rgb(23, 23, 49) 0%, rgb(43, 11, 90) 50%, rgb(238, 245, 229) 70%, rgb(152, 167, 168) 80%, rgb(152, 167, 168) 100%)";
        document.getElementById("left_info").style.color = "rgb(209, 205, 205)";
        //night
    }
    else if(document.getElementById("text").innerText == "Patchy rain nearby"){
        document.body.style.background = "linear-gradient(100deg, rgb(33, 97, 194) 0%, rgb(33, 97, 194) 50%, rgb(178, 235, 22) 60%, rgb(93, 95, 86) 80%, rgb(22, 69, 201) 100%)";
        document.getElementById("left_info").style.color = "rgb(209, 205, 205)";
        //change gradient
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
        document.body.style.background = "linear-gradient(100deg, rgb(93, 95, 86) 0%, rgb(152, 167, 168) 50%, rgb(93, 95, 86) 100%)";
    }
    else if(document.getElementById("text").innerText == "Light drizzle"){
        document.body.style.background = "linear-gradient(100deg, rgb(33, 97, 194) 0%, rgb(152, 167, 168) 20%, rgb(93, 95, 86) 100%)";
    }
    else if(document.getElementById("text").innerText == "Light snow"){
        document.body.style.background = "linear-gradient(185deg, rgba(233,253,255,1) 0%, rgba(218,237,255,1) 55%, rgba(253,242,225,1) 100%)";
    }
    else if(document.getElementById("text").innerText == "Moderate snow"){
        document.body.style.background = "linear-gradient(185deg, rgba(166,188,190,1) 0%, rgba(177,185,192,1) 55%, rgba(253,242,225,1) 100%)";
    }
    else if(document.getElementById("text").innerText == "Heavy snow"){
        document.body.style.background = " linear-gradient(158deg, rgba(144,144,144,1) 0%, rgba(177,185,192,1) 55%, rgba(158,150,139,1) 100%)";
    }
    else{
        document.body.style.background = " linear-gradient(158deg, rgba(173,148,148,1) 0%, rgba(177,185,192,1) 55%, rgba(132,187,185,1) 100%)";
    }
};

document.getElementById("submit").addEventListener("click", ChangeBg());

function change_prompt() {
    let x = document.forms["locForm"]["location"].value;
    let new_prompt = x.replace(" ", "_").replace("ą", "a").replace("ę", "e").replace("ł", "l").replace("ó", "o").replace("ż", "z").replace("ź", "z");
    document.forms["locForm"]["location"].value = new_prompt; 
};
function search(){
    document.getElementById("cloud-container").style.display = "none";
    document.getElementById("cloud1").style.display = "none";
    document.getElementById("cloud2").style.display = "none";

    setTimeout()
};
