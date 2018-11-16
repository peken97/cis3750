<!DOCTYPE html>
<html>
    <head>
        <link rel = "stylesheet" type = "text/css" href="./css/bootstrap.min.css"/>
        <link rel = "stylesheet" type = "text/css" href="./css/login.css"/>
        <script src="./src/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <div id="page_login">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <h3><a >Stone Road Mall Digital Signage</a></h3>
            </nav>
            <form id="form_login" class="card p-3">             
                <div class="form-group">
                    <label>Email Address</label>
                    <input id="input_email" type="email" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input id="input_password" type="password" class="form-control"/>
                </div>
                
                <div class="form-group">
                        <a href="#">Forgot Password?</a>
                </div>
                <div class="form-group">
                    <button type="button" id="button_login" class="btn btn-primary">Login</button>
                    
                </div>
                <small hidden id="text_incorrect_login_info">Wrong email or password!</small>
            </form>
        </div>
    </body>
    <script src="./src/login.js"></script>
    </html>
</html>