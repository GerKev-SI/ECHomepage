const queryString = window.location.search; // holt den URL String hinter '?'
const urlParams = new URLSearchParams(queryString); // interpretiert den Querystring

//jquerry change html after page is ready
$(window).on('load', function(){
    if (urlParams.has('contactresponsesucceeded')) {
            console.log("succeeded response");
            document.getElementById("mailAlert").style.display = "block";
            document.getElementById("mailAlert").classList.add('alert-success');
            document.getElementById("mailAlertText").innerHTML = 'Die Anfrage wurde erfolgreich abgeschickt';
    }
    if (urlParams.has('contactresponsefailed')) {
        const response = urlParams.get('contactresponsefailed');
        const clean = DOMPurify.sanitize(response);
        console.log(response);
         document.getElementById("mailAlert").style.display = "block";
         document.getElementById("mailAlert").classList.add('alert-danger');
         document.getElementById("mailAlertText").innerHTML = 'Die Anfrage konnte nicht gesendet werden! ' + clean;
    }
});
