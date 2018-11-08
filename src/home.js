var loginInformation = {

    email: undefined,
    password: undefined

}

var serverSideURL = "server/functions.php";


initializeEventListeners();


function initializeEventListeners(){
    document.getElementById("button_login").addEventListener("click", function(){
        loginInformation.email = document.getElementById("input_email").value;
        loginInformation.password = document.getElementById("input_password").value;
        attempt_login(loginInformation.email, loginInformation.password);
    })
}

function attempt_login(email, password){

    var data = "action=attempt_login&email="+ email +"&password=" + password;

    $.ajax({
        url: serverSideURL,
        type: "POST",
        data: data,
        success: function(data){
            alert(data);
        }
    })

}

