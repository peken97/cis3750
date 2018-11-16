<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel = "stylesheet" type = "text/css" href="./css/bootstrap.min.css"/>
        <link rel = "stylesheet" type = "text/css" href="./css/home.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script src="./src/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <h3><a class="clickable_link" href="home.php">Home</a></h3>
            <h5><a class="clickable_link ml-4" href="manage_ads.php">ADS</a></h5>
            <h5><a class="clickable_link ml-4" href="manage_users.php">Users</a></h5>
            <h5><a class="clickable_link ml-4" href="manage_groups.php">Groups</a></h5>
            <div class="d-flex flex-row-reverse w-100">
                <button type="button" id= "button_logout" class="btn btn-light">Logout</button>
            </div>

        </nav>
    </body>
    <script src="./src/navbar_functions.js"></script>
    </html>
</html>