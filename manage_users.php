<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <header><?php include "select_navbar.php" ?></header>
        <div class="card d-flex">
            <a id="link_open_modal_add_user"  class="clickable_link d-flex p-2"><i class="material-icons">add_circle</i><div class="ml-2">Add New User</div></a>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th># of Ads</th>
                    <th>Action</th>
                </tr>
                <tbody id="table_users">
                
                </tbody>
            </table>
            <div id="modal_add_user" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button id="button_close_modal_add_user" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email</label>
                        <input id="input_email" type="email" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input id="input_username" type="text" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="input_password" type="password" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input id="input_confirm_password" type="password" class="form-control"/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="button_submit_modal_add_user" type="button" class="btn btn-primary">Submit</button>
                </div>
                </div>
            </div>
        </div>
        </div>

    </body>
    <script src="./src/manage_users.js"></script>
    </html>
</html>