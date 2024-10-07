const ChangeBg = () => {
    if(document.getElementById("text").innerText == "Sunny"){
        document.body.style.background = "linear-gradient(100deg, rgb(33, 97, 194) 0%, rgb(32, 189, 201) 50%, rgb(178, 235, 22) 100%)";
    }
    else if(document.getElementById("text").innerText == "Cloudy"){
        document.body.style.background = "linear-gradient(100deg, rgb(66, 126, 216) 0%, rgb(152, 167, 168) 70%, rgb(93, 95, 86) 100%)";
    }
    else if(document.getElementById("text").innerText == "Clear"){
        document.body.style.background = "linear-gradient(100deg, rgb(23, 23, 49) 0%, rgb(43, 21, 122) 40%, rgb(35, 15, 105) 60%, rgb(238, 245, 199) 100%)";
        document.getElementById("left_info").style.color = "rgb(209, 205, 205)";
    }
    else if(document.getElementById("text").innerText == "Partly cloudy"){
        document.body.style.background = "linear-gradient(100deg, rgb(33, 97, 194) 0%, rgb(33, 97, 194) 30%, rgb(178, 235, 22) 60%, rgb(152, 167, 168) 80%, rgb(152, 167, 168) 100%)";
        //day
    }
    else if(document.getElementById("text").innerText == "Partly Cloudy"){
        document.body.style.background = "linear-gradient(100deg, rgb(23, 23, 49) 0%, rgb(43, 11, 90) 50%, rgb(238, 245, 229) 70%, rgb(152, 167, 168) 80%, rgb(152, 167, 168) 100%)";
        document.getElementById("left_info").style.color = "rgb(209, 205, 205)";
        //night
    }
    else if(document.getElementById("text").innerText == "Patchy rain nearby"){
        document.body.style.background = "linear-gradient(100deg, rgb(23, 23, 49) 0%, rgb(43, 11, 90) 50%, rgb(238, 245, 199) 70%, rgb(93, 95, 86) 80%, rgb(22, 69, 201) 100%)";
        document.getElementById("left_info").style.color = "rgb(209, 205, 205)";
    }
    else if(document.getElementById("text").innerText == "Light rain shower"){
        document.body.style.background = "linear-gradient(100deg, rgb(33, 97, 194) 0%, rgb(32, 189, 201) 50%, rgb(178, 235, 22) 65%, rgb(93, 95, 86) 85%, rgb(22, 69, 201) 100%)";
    }
    else if(document.getElementById("text").innerText == "Light rain"){
        document.body.style.background = "linear-gradient(100deg, rgb(152, 167, 168) 0%, rgb(152, 167, 168) 50%, rgb(33, 97, 194) 100%";
    }
    else if(document.getElementById("text").innerText == "Overcast"){
        document.body.style.background = "linear-gradient(100deg, rgb(152, 167, 168) 0%, rgb(93, 95, 86) 50%, rgb(93, 95, 86) 100%";
    }
    else if(document.getElementById("text").innerText == "Mist"){
        document.body.style.background = "linear-gradient(100deg, rgb(93, 95, 86) 0%, rgb(152, 167, 168) 50%, rgb(93, 95, 86) 100%";
    }
};

document.getElementById("submit").addEventListener("click", ChangeBg());