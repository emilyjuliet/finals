<?php
include "class/config.php";

class User
{

//    public $db;
//
//    public function __construct()
//    {
//        $this->db= new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
//
//        if(mysqli_connect_errno())
//        {
//            echo "Error: Could not connect to the database.";
//            exit;
//        }
//
//
//    }
//
//    public function regUser($firstname,$lastname,$email,$password,$confirm_password)
//    {
//        $password = md5($password);
//        $confirm_password = md5($confirm_password);
//
//        $sql = "SELECT * FROM register WHERE email='$email'";
//
//        $check = $this->db->query($sql);
//
//        $count_row = $check->num_rows;
//
//        if ($count_row == 0) {
//            $sql1 = "INSERT INTO register SET firstname='$firstname', lastname='$lastname', email='$email', password='$password', confirm_password='$confirm_password'";
//            $result = mysqli_query($this->db, $sql1) or die(mysqli_connect_errno() . "Data cannot be inserted");
//            return $result;
//        } else {
//            return false;
//        }
//    }

    public function checkLogin($email,$password)
    {
        $password = md5($password);
        $sql2="SELECT email FROM users WHERE email='$email' and password='$password'";

        $result = mysqli_query($this->db,$sql2);
        $user_data = mysqli_fetch_array($result);
        $count_row = $result->num_rows;

        if ($count_row == 1) {

            // this login var will use for the session thing

            $_SESSION['login'] = true;

            $_SESSION['email'] = $user_data['email'];

            return true;

        }

        else{

            return false;

        }

    }

//    public function get_firstname($email){
//
//        $sql3="SELECT firstname FROM users WHERE email = $email";
//
//        $result = mysqli_query($this->db,$sql3);
//
//        $user_data = mysqli_fetch_array($result);
//
//        echo $user_data['firstname'];
//
//    }
    public function getSession(){

        return $_SESSION['login'];

    }
    public function userLogout() {

        $_SESSION['login'] = FALSE;

        session_destroy();

    }

}



//$user = new User();
//$user->regUser('emily','juliet','emy@gmail.com','emy123','emy123');
//

?>