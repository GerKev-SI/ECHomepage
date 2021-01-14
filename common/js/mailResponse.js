const queryString = window.location.search; // holt den URL String hinter '?'
const urlParams = new URLSearchParams(queryString); // interpretiert den Querystring

if (urlParams.has('contactresponse')) {
    const response = urlParams.get('contactresponse');
    console.log(response);
    if (response == "succeeded") {
        console.log("succeeded response");
        document.getElementById("mailSuccessAlert").style.display = "block";
    }
    else if (response == "failed") {
        console.log("failed response");
        document.getElementById("mailFailAlert").style.display = "block";
    }
}
