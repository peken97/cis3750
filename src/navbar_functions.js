
var serverInformation = JSON.parse(sessionStorage.getItem("serverInformation"));

initializeEventListeners();

function initializeEventListeners(){
    document.getElementById("button_logout").addEventListener("click", function(){
        let email = sessionStorage.getItem("email");
        attempt_logout(email);
    })

}

function attempt_logout(email){

    var data = "action=attempt_logout&email=" + email;

    $.ajax({
        url: serverInformation.serverSideURL,
        type: "POST",
        data: data,
        success: function(data){
            console.log(data);
            if(data == serverInformation.return_success){
                sessionStorage.clear()
                window.open("./login.php", "_self");
            }
            else{
                alert("Error logging out!");
            }
        }
    })
}