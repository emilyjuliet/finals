<?php

session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

    if ($is_admin == 1) {
        //librarian
        header("location: librarian.php");
    } elseif($is_admin == 0){
        //student
        header("location: student.php");
    }
    exit;
}

require_once "class/config.php";

$email = $password = $is_admin = "";
$email_err = $password_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){


    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }


    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }



    if(empty($email_err) && empty($password_err)){

        $sql = "SELECT id, email, password, is_admin FROM users WHERE email = ?";


        if($stmt = mysqli_prepare($con, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_email);


            $param_email = $email;


            var_dump(mysqli_stmt_num_rows($stmt), mysqli_stmt_execute($stmt));


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
               // var_dump(mysqli_stmt_store_result($stmt));


                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $is_admin);

                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();
//
//                            echo "session set= " . $_SESSION;
//
//                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["is_admin"] = $is_admin;

//                            header("location: home.php");

//                             Redirect user according to user type
                            if ($is_admin == 1) {
                                //var_dump('do we reach this prt');
                                //librarian
                                header("location: librarian.php");
                            } elseif($is_admin == 0){
                                //var_dump('or here');
                                //student
                            header("location: student.php");
                        }
                           // var_dump('definitely this part');


                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                    echo $email_err;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }


        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($con);
}

//session_start();
//
//include_once 'user.php';
//
//$user = new User();
//
//$email = $password = $is_admin = "";
//$email_err = $password_err = "";
//
//if (isset($_REQUEST['submit'])) {
//
//    extract($_REQUEST);
//
//    $login = $user->checkLogin($email, $password);
//
//    if ($login) {
//
//        // Registration Success
//
////	           header("location:home.php");
//        //Redirect user according to user type
//                            if ($is_admin == 1) {
//                                //var_dump('do we reach this prt');
//                                //librarian
//                                header("location: librarian.php");
//                            } elseif($is_admin == 0){
//                                //var_dump('or here');
//                                //student
//                            header("location: student.php");
//                        }
//
//    } else {
//
//        // Registration Failed
//
//        echo 'Wrong username or password';
//
//    }
//
//}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

</head>
<body>
<div class="container text-center" style="width: 400px;background: #fcfcfc;margin: 100px auto;">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <form action="login.php" method="POST">
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-block" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</div>
</body>
</html>