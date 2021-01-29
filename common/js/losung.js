xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) // 4: request finished and response is ready;  200: Status ok
    {
        var splitresult = String(this.responseText).split("###");
        if (splitresult.length > 4) {
            //document.getElementById("txtHint").innerHTML = this.responseText;
            console.log(splitresult[0]);
            console.log(splitresult[1]);
            console.log(splitresult[2]);
            console.log(splitresult[3]);
            console.log(splitresult[4]);
        }
    }
};
xhttp.open("GET", "../php/Losung/losungphp1.php", true);
xhttp.send();
