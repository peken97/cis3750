<!DOCTYPE html>
<html>
    <head>
        <link rel = "stylesheet" type = "text/css" href="./css/home.css"/>
    </head>
    <body>
        <header><?php include "select_navbar.php" ?></header>
        
        <div class="card">
        
        <a id="link_open_modal_add_advertisement"  class="clickable_link d-flex p-2"><i class="material-icons">add_circle</i><div class="ml-2">Add New Advertisement</div></a>
            <table class="table ad_table">
                <tr>
                    <th>id</th>
                    <th>Username</th>
                    <th>Advertisement Name</th>
                    <th>File Name</th>
                    <th>Preview</th>
                    <th>Actions</th>
                </tr>
                <tbody id="table_advertisements">
                    <tr>
                        <td>EB Games</td>
                        <td>Black Ops 4 Advertisement</td>
                        <td>black ops 4.jpg</td>
                        <td>
                            <a class="clickable_link"><i class="material-icons">edit</i></a>
                            <a class="clickable_link"><i class="material-icons">delete</i></a>
                        </td>
                    </tr>
                </tbody>
            </table> 
        </div>
        <div id="modal_add_advertisement" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Advertisement</h5>
                    <button id="button_close_modal_add_advertisement" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method='POST' name='my_form' enctype='multipart/form-data' action='server/file_upload.php'>
                    <div class="modal-body">
                        
                            <div class="form-group">
                                <label>Advertisement Name</label>
                                <input name="ad_name" id="input_advertisement_name" type="text" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>File Name</label>
                                <input name="file_name" type="file" id="input_file_name" />
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <?php //<button id="button_submit" type="button" class="btn btn-primary">Submit</button>?>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div id="modal_edit_advertisement" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Advertisement</h5>
                    <button id="button_close_modal_edit_advertisement" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method='POST' name='my_form' enctype='multipart/form-data' action='server/file_upload.php'    >
                    <div class="modal-body">
                        
                            <div class="form-group">
                                <label>Advertisement Name</label>
                                <input name="ad_name" id="edit_advertisement_name" type="text" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>File Name</label>
                                <input name="file_name" type="file" id="edit_file_name" />
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" id="button_close_modal_edit_advertisement_button" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <?php //<button id="button_submit" type="button" class="btn btn-primary">Submit</button>?>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </body>
    <script src="./src/manage_ads.js"></script>
    </html>
</html>