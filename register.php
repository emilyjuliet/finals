<?php

require_once "Classes/config.php";

$firstname = $lastname = $email = $password = $confirm_password = "";
$firstname_err = $lastname_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["firstname"]))) {
        $firstname_err = "please enter a firstname.";
    } else {
// prepare a select statement
        $sql = "select id from users where firstname = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {

            // bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_firstname);

            // set parameters
            $param_firstname = trim($_POST["firstname"]);

            // attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                //            if(mysqli_stmt_num_rows($stmt) >= 1){
                //                $firstname_err = "this email is already taken.";
                //            } else{
                //                $email = trim($_post["email"]);
                //            }
            } else {
                echo "oops! something went wrong. please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
//elseif ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty(trim($_POST["lastname"]))) {
            $lastname_err = "please enter a lastname.";
        } else {
            // prepare a select statement
            $sql = "select id from users where lastname = ?";

            if ($stmt = mysqli_prepare($con, $sql)) {
                // bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_lastname);

                // set parameters
                $param_lastname = trim($_POST["lastname"]);

                // attempt to execute the prepared statement
                if (mysqli_stmt_execute($stmt)) {
                    /* store result */
                    mysqli_stmt_store_result($stmt);

                    //            if(mysqli_stmt_num_rows($stmt) >= 1){
                    //                $firstname_err = "this email is already taken.";
                    //            } else{
                    //                $email = trim($_post["email"]);
                    //            }
                } else {
                    echo "oops! something went wrong. please try again later.";
                }

                mysqli_stmt_close($stmt);

            }elseif (empty(trim($_POST["email"]))) {
                $email_err = "please enter a email.";
            } else {
                // prepare a select statement
                $sql = "select id from users where email = ?";

                if ($stmt = mysqli_prepare($con, $sql)) {
                    // bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "s", $param_email);

                    // set parameters
                    $param_email = trim($_POST["email"]);

                    // attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        /* store result */
                        mysqli_stmt_store_result($stmt);

                        if (mysqli_stmt_num_rows($stmt) >= 1) {
                            $email_err = "this email is already taken.";
                        } else {
                            $email = trim($_POST["email"]);
                        }
                    } else {
                        echo "oops! something went wrong. please try again later.";
                    }
                }

                // close statement
                mysqli_stmt_close($stmt);
            }

            // validate password
            if (empty(trim($_POST["password"]))) {
                $password_err = "please enter a password.";
            } elseif (strlen(trim($_POST["password"])) < 6) {
                $password_err = "password must have atleast 6 characters.";
            } else {
                $password = trim($_POST["password"]);
            }

            // validate confirm password
            if (empty(trim($_POST["confirm_password"]))) {
                $confirm_password_err = "please confirm password.";
            } else {
                $confirm_password = trim($_POST["confirm_password"]);
                if (empty($password_err) && ($password != $confirm_password)) {
                    $confirm_password_err = "password did not match.";
                }
            }

            // check input errors before inserting in database
            if (empty($firstname_err) && empty($lastname_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
                // prepare an insert statement
                $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($con, $sql)) {
                    // bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "ssss", $param_firstname, $param_lastname, $param_email, $param_password);

                    // set parameters
                    $param_firstname = $firstname;
                    $param_lastname = $lastname;
                    $param_email = $email;
                    $param_password = password_hash($password, password_default); // creates a password hash

                    // attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmt)) {
                        // redirect to login page
                        header("location: login.php");
                    } else {
                        echo "Something went wrong. Please try again later.";
                    }
                }

                // close statement
                mysqli_stmt_close($stmt);
            }

            // close connection
            mysqli_close($con);
            
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>sign up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body style="overflow: hidden;">
<div class="container text-center" style="width: 400px;background: #fcfcfc;margin: 70px auto;">
    <h1>Sign up</h1>
    <p>Please fill this form to create an account.</p>
    <form action="register.php" method="post">
        <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
            <label>Firstname</label>
            <input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
            <span class="help-block"><?php echo $firstname_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
            <label>Lastname</label>
            <input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
            <span class="help-block"><?php echo $lastname_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm password</label>
            <input type="password" name="confirm_password" class="form-control"
                   value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div>
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>
</body>
</html>

