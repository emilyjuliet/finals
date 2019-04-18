<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand">CYTONN COLLEGE LIBRARY</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="logout.php"><i style="color:pink;float: right"class="fa fa-sign-out-alt"></i>Logout <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

<div class="carousel-inner">
    <div class="carousel-item active"style="background-color: crimson">
        <div style="height: 400px;width:100%;background-color: crimson"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <br/><br/><br/><br/>

                <h1 style="color: white;font-family: 'Pacifico', cursive;"> Reading can seriously damage your ignorance</h1>
            </div>
            <div class="col-sm">
            </div>
            <div class="col-sm">
                <br/><br/><br/><br/>
                <div style="height: 300px;width:110%;background-repeat:no-repeat;background-size: cover;opacity:0.8;background-image: url('./image/5.jpg');"></div>

            </div>
        </div>
    </div>
</div>
<div style="background-color:rgba(211,211,211,0.5);">
    <br/><br/><br/>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <b><h>About Us</h></b><br/><br/>
                <h style="color:grey">We are located in Nairobi CBD,on Queensway Building,6th floor, Kaunda Street</h><br/>
                <h style="color:grey">Opening hours are every weekday 8.00am-5.00pm</h><br/>

                <br/><br/>

                <br/><br/><br/>
                <p><font size="-1">Kenya</font></p>
            </div>
            <div class="col-sm">
                <b><h>Contact us on</h></b><br/><br/>
                <h style="color:grey">0707 658 859</h><br/>
                <h style="color:grey">0719 582 000</h><br/>
                <h style="color:grey">0720 807 269</h><br/>
                <h style="color:grey">0721 458 779</h><br/>
                <br/><br/>

            </div>
            <div class="col-sm">
                <b><h>Email us on</h></b><br/><br/>
                <h style="color:grey">julietkiboi@gmail.com</h><br/>
                <h style="color:grey">shanellenjeru@gmail.com </h><br/>
                <h style="color:grey">stephgithinji67@gmail.com </h><br/>
                <br/><br/>

                <br/><br/><br/><br/>
                <p style="float:right"><font size="-1">2019 Cytonn College Library</font></p>


            </div>

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm">
            </div>
            <div class="col-sm">
                <center><p><font size="-1">Privacy  Terms  Legal  Site Map  Site Feedback</font></p></center>
            </div>
            <div class="col-sm">
            </div>
        </div>
    </div>
</div>
</body>
</html>