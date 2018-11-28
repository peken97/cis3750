var serverInformation = {
    serverSideURL: "server/functions.php",
    return_success: "SUCCESS",
    return_error: "FAIL"
}

sessionStorage.setItem("serverInformation", JSON.stringify(serverInformation));

var loginInformation = {
    email: undefined,
    password: undefined
}


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
        url: serverInformation.serverSideURL,
        type: "POST",
        data: data,
        success: function(data){
            console.log(data);
            if(data == serverInformation.return_success){
                sessionStorage.setItem("email", email);
                set_user_id(email);
                window.open("./home.php", "_self");
            }
            else{
                document.getElementById("text_incorrect_login_info").setAttribute("style", "color: red");
                document.getElementById("text_incorrect_login_info").hidden = false;
            }
        }
    })

}

function set_user_id(email){
    let data = "action=get_user_id&constraint_name=email&constraint_value=" + email;
    
    $.ajax({
        url: serverInformation.serverSideURL,
        type: "POST",
        data: data,
        async: false,
        success: function(data){
            sessionStorage.setItem("user_id", data);
        }
    })
}