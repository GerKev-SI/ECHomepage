const queryString = window.location.search; // holt den URL String hinter '?'
const urlParams = new URLSearchParams(queryString); // interpretiert den Querystring

if (urlParams.has('contactresponse')) {
    const response = urlParams.get('contactresponse');
    console.log(response);
    if (response == "succeeded") {
        console.log("succeeded response");
        document.getElementById("mailAlert").style.display = "block";
        document.getElementById("mailAlert").classList.add('alert-success');
        document.getElementById("mailAlertText").innerHTML = "Anfrage erfolgreich abgeschickt";
    }
    else if (response == "failed") {
        console.log("failed response");
        document.getElementById("mailAlert").style.display = "block";
        document.getElementById("mailAlert").classList.add('alert-danger');
        document.getElementById("mailAlertText").innerHTML = "Anfrage fehlgeschlagen!";
    }
}
