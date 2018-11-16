var serverInformation = JSON.parse(sessionStorage.getItem("serverInformation"));

var CURRENT_USERS = undefined;

initializeEventListeners();

updateUserTable();

function initializeEventListeners(){
    //opening add user modal
    document.getElementById("link_open_modal_add_user").addEventListener("click", function(){
            open_modal_add_user();
    })
    //closing add user modal
    document.getElementById("button_close_modal_add_user").addEventListener("click", function(){
        close_modal_add_user();
    })
    document.getElementById("button_submit_modal_add_user").addEventListener("click", function(){
        add_new_user();
    })
    window.onclick = function(event) {
        let modal = document.getElementById("modal_add_user");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    
}

function validate_input_add_new_user(email, username, password, confirm_password){
    if(email == "" || username == "" || password == "" || confirm_password == ""){
        alert("Please fill out everything");
        return false;
    }
    if(password.length < 6){
        alert("Passwords is shorter than 6 characters");
        return false;
    }
    if(password == confirm_password){
        alert("Passwords dont match");
        return false;
    }
}

function add_new_user(){
    let email = document.getElementById("input_email").value;
    let username = document.getElementById("input_username").value;
    let password = document.getElementById("input_password").value;
    let confirm_password = document.getElementById("input_confirm_password").value;

    if(validate_input_add_new_user(email, username, password, confirm_password) == false){
        return;
    }
    
    let data = "action=add_new_user&email=" + email + "&username=" + username + "&password=" + password;

    $.ajax({
        url: serverInformation.serverSideURL,
        type: "POST",
        data: data,
        success: function(data){
            alert(data);
            if(data == serverInformation.return_success){
                close_modal_add_user();
                updateUserTable();
                alert("Successfully added a user");
            }
            else{
                alert("ERROR adding a user");
            }
        }
    })
}

function getAllUserData(){

    var dataToReturn = undefined;

    $.ajax({
        url: serverInformation.serverSideURL,
        type: "POST",
        data: "action=get_all_user_data",
        async: false,
        success: function(data){
            
            try{
                dataToReturn = JSON.parse(data);
                
            }
            catch(e){
                dataToReturn = undefined;
            }
            
        }
    });

    return dataToReturn;
}

function updateUserTable(){

    var data = getAllUserData();
    if(data == undefined){
        alert("Nothing to update!");
        return;
    }
    console.log(data);
    CURRENT_USERS = data;
    let table = document.getElementById("table_users");
    table.innerHTML = "";

    for(let i = 0; i < data.length; i++){
        let htmlToAdd = "<tr>"
        + "<td id='user_id_" + data[i].user_id + "'>"+ data[i].user_id + "</td>"
        + "<td>"+ data[i].email + "</td>"
        + "<td>"+ data[i].username + "</td>"
        + "<td>"+ data[i].number_of_ads + "</td>"
        + "<td>" 
        + '<a class="clickable_link"><i class="material-icons">edit</i></a> '
        + '<a onclick="deleteRow(this)" class="clickable_link"><input type="hidden" data-id="'+ data[i].user_id +'"/><i class="material-icons">delete</i></a>'
        + "</td>"
        + "</tr>"
        table.innerHTML += htmlToAdd;
    }

    

}

function deleteRow(element){

    element = element.children;
    var inputNode;

    for(let i = 0; i < element.length; i++){
        
        if(element[i].tagName == "INPUT"){
            inputNode = element[i];
        }
    }

    let user_id = inputNode.getAttribute("data-id");
    let idExists = false;

    for(let i = 0; i < CURRENT_USERS.length; i++){
        if(user_id == CURRENT_USERS[i].user_id){
            idExists = true;
        }
    }

    if(idExists == false){
        alert("Failed to delete user");
        return;
    }

    let data = "action=delete_user&user_id=" + user_id;

    $.ajax({
        url: serverInformation.serverSideURL,
        type: "POST",
        data: data,
        success: function(data){
            if(data == serverInformation.return_success){
                alert("Successfully deleted user");
                updateUserTable();
            }
            else{
                alert("Failed to delete user");
            }
        }
    });
}

function close_modal_add_user(){
    
    document.getElementById("modal_add_user").style.display = "none";
    //document.getElementById("modal_add_advertisement").style.backgroundColor = "rgb(180, 11, 11)";
}

function open_modal_add_user(){
    document.getElementById("modal_add_user").style.display = "block";
    //document.getElementById("modal_add_advertisement").style.backgroundColor = "rgb(180, 11, 11)";
}