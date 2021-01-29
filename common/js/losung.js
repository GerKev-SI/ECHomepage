xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) // 4: request finished and response is ready;  200: Status ok
    {
        var splitresult = String(this.responseText).split("###");
        if (splitresult.length > 4) {
            document.getElementById("LosungHeader").innerHTML = "Losung " + splitresult[0];
            document.getElementById("LosungContent").innerHTML = splitresult[1];
            document.getElementById("LosungFooter").innerHTML = "&mdash; " + splitresult[2];
            document.getElementById("LehrtextHeader").innerHTML = "Lehrtext " + splitresult[0];
            document.getElementById("LehrtextContent").innerHTML = splitresult[3];
            document.getElementById("LehrtextFooter").innerHTML = "&mdash; " + splitresult[4];
        }
    }
};
xhttp.open("GET", "common/php/Losung/losungphp2.php", true);
xhttp.send();
