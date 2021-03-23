const queryString = window.location.search; // holt den URL String hinter '?'
const urlParams = new URLSearchParams(queryString); // interpretiert den Querystring

//jquerry change html after page is ready
$(window).load(function() {
    if (urlParams.has('contactresponse')) {
        const response = urlParams.get('contactresponse');
        console.log(response);
        if (response == "succeeded") {
            console.log("succeeded response");
            document.getElementById("mailAlert").style.display = "block";
            document.getElementById("mailAlert").classList.add('alert-success');
            document.getElementById("mailAlertText").innerHTML = "Die Anfrage wurde erfolgreich abgeschickt";
        }
        else if (response == "failed") {
            console.log("failed response");
            document.getElementById("mailAlert").style.display = "block";
            document.getElementById("mailAlert").classList.add('alert-danger');
            document.getElementById("mailAlertText").innerHTML = "Die Anfrage konnte nicht gesendet werden!";
        }
    }
});
