var serverInformation = JSON.parse(sessionStorage.getItem("serverInformation"));
updateAdvertisementTable();
initializeEventListeners();
var CURRENT_ADVERTISEMENTS = undefined;


add_user_to_form();

function initializeEventListeners(){
    //opening add advertisement modal
    document.getElementById("link_open_modal_add_advertisement").addEventListener("click", function(){
            open_modal_add_advertisement();
    })
    //closing add advertisement modal
    document.getElementById("button_close_modal_add_advertisement").addEventListener("click", function(){
        close_modal_add_advertisement();
    })
    document.getElementById("button_close_modal_edit_advertisement").addEventListener("click", function(){
        close_modal_edit_advertisement();
    })
    document.getElementById('button_close_modal_edit_advertisement_button').addEventListener("click", function(){
        close_modal_edit_advertisement();
    })
    //document.getElementById("button_submit").addEventListener("click", function(){
        //add_new_advertisement();
    //})
    $('.delete_ad').on('click', function(event){
        //console.log("delete");
        var ad_id = $(event.target).parent().parent().siblings('.ad_id')[0].innerHTML;
        //console.log(ad_id);
        delete_ad(ad_id);//.parent());
        //console.log();
    });
    $('.edit_ad').on('click',function(event){
        //console.log("edit");
        var ad_info = $(event.target).parent().parent().parent()[0].children;
        //console.log(ad_info);
        edit_ad(ad_info);//.parent());
    });
    window.onclick = function(event) {
        let modal = document.getElementById("modal_add_advertisement");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    
}

function get_file_name_from_path(fullPath){
    if (fullPath) {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
        var filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }
        return filename;
    }
}

function add_new_advertisement(){
    
    console.log(sessionStorage);
    
    let user_id = sessionStorage.getItem("user_id");
    let advertisement_name = document.getElementById("input_advertisement_name").value;
    let full_path = document.getElementById("input_file_name").value;

    console.log(full_path);
    if(full_path == undefined){
        alert("Please select a file!");
        return;
    }
    
    let file_name = get_file_name_from_path(full_path);

    let data = "action=add_new_advertisement&user_id=" + user_id + "&advertisement_name=" + advertisement_name + "&file_name=" + file_name;
    console.log(data);
    
    $.ajax({
        url: serverInformation.serverSideURL,
        type: "POST",
        data: data,
        success: function(data){
            alert(data);
            if(data == serverInformation.return_success){
                close_modal_add_advertisement();
                //updateAdvertisementTable();
                alert("Successfully added an advertisement");
            }
            else{
                alert("ERROR adding an advertisement");
            }
        }
    })
}

function getAllAdvertisementData(){

    var dataToReturn = undefined;

    $.ajax({
        url: serverInformation.serverSideURL,
        type: "POST",
        data: "action=get_all_advertisement_data",
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

function get_username(user_id){
    let data = "action=get_username&constraint_name=user_id&constraint_value=" + user_id;
    var id = undefined;
    $.ajax({

        url: serverInformation.serverSideURL,
        type: "POST",
        data: data,
        async: false,
        success: function(data){
            
            id = data;
        }
    });
    return id; 
}

function updateAdvertisementTable(){

    var data = getAllAdvertisementData();
    if(data == undefined){
        alert("Nothing to update!");
        return;
    }
    CURRENT_ADVERTISEMENTS = data;

    let table = document.getElementById("table_advertisements");
    table.innerHTML = "";

    for(let i = 0; i < data.length; i++){
        let username = get_username(data[i].user_id);
        let htmlToAdd = "<tr>"
        + "<td class='ad_id'>"+ data[i].advertisement_id + "</td>"
        + "<td class='user_name'>"+ username + "</td>"
        + "<td class='ad_name'>"+ data[i].advertisement_name + "</td>"
        + "<td class='file_name'>"+ data[i].file_name + "</td>"
        + "<td><img src='/images/" + data[i].file_name + "'>" + "</td>"
        + "<td>" 
        + '<a class="clickable_link edit_ad"><i class="material-icons">edit</i></a> '
        + '<a class="clickable_link delete_ad"><input type="hidden" data-id="'+ data[i].advertisement_id +'"/><i class="material-icons">delete</i></a>'
        + "</td>"
        + "</tr>"
        table.innerHTML += htmlToAdd;
    }
}

function add_user_to_form(){
    document.getElementById("input_file_name").outerHTML +="<input name='user' value='" + sessionStorage.getItem("user_id") + "' hidden>";
}


function close_modal_add_advertisement(){
    
    document.getElementById("modal_add_advertisement").style.display = "none";
    //document.getElementById("modal_add_advertisement").style.backgroundColor = "rgb(180, 11, 11)";
}

function open_modal_add_advertisement(){
    
    document.getElementById("modal_add_advertisement").style.display = "block";
    //document.getElementById("modal_add_advertisement").style.backgroundColor = "rgb(180, 11, 11)";
}
function open_modal_edit_advertisement(){
    document.getElementById("modal_edit_advertisement").style.display = "block";
}

function close_modal_edit_advertisement(){
    document.getElementById("modal_edit_advertisement").style.display = "none";
}

function delete_ad(ad_id){    
     var dataToReturn = undefined;

    $.ajax({
        url: serverInformation.serverSideURL,
        type: "POST",
        data: "action=delete_ad&ad_id=" + ad_id,
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
    location.reload();
    return dataToReturn;
}

function edit_ad(ad_info) {
    var name = ad_info[2].innerHTML;
    var ad_id = ad_info[0].innerHTML;
    var user_id =  sessionStorage.getItem("user_id");
    console.log(ad_info);
    $('.edit_ad_id').remove();
    $('#edit_advertisement_name').val(name);
    $('#edit_advertisement_name').after('<input class="edit_ad_id" type="hidden" name="ad_id" value="' + ad_id + '">');
    $('#edit_advertisement_name').after('<input class="edit_user_id" type="hidden" name="user_id" value="' + user_id + '">');
    open_modal_edit_advertisement();
}
