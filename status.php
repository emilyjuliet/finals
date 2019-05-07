<?php

session_start();
require_once "class/config.php";
if(isset($_SESSION['user'])) {
    header('Location: status.php');
}

$view_error  =  '';

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $book_id = (int)$_POST['book_id'];
    $user_id = (int)$_POST['user_id'];
    $reservations = $_POST['date'];

    $sql = "SELECT * FROM reservations (date, user_id, book_id) VALUES ('" . $date . "', " . $user_id . ", " . $book_id . ")";

    if (mysqli_query($con, $sql)) {
        header("location: status.php");
    } else {
        $view_error = "Process was unsuccessful";
    }



    } elseif (isset($_POST["issue_action"])) {
        $user_email = $_POST['email'];
        //issue book
        $to = $user_email;
        $subject = 'Cytonn library book reservation';
        $message = 'Hi, your reservation has been accepted';
        $headers = 'From: julietkiboi@gmail.com' . "\r\n" .
            'Reply-To: julietkiboi@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        if (mail($to, $subject, $message, $headers)) {
            echo 'Message could not be sent.';
        } else {
            echo 'Message has been sent';
        }

    } elseif (isset($_POST["reject_action"])) {
        $user_email = $_POST['email'];
        //reject book
        $to = $user_email;
        $subject = 'Cytonn library book reservation';
        $message = 'Hi, your reservation has been declined';
        $headers = 'From: julietkiboi@gmail.com' . "\r\n" .
            'Reply-To: julietkiboi@gmail.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        if (mail($to, $subject, $message, $headers)) {
            echo 'Message could not be sent.';
        } else {
            echo 'Message has been sent';
        }

}

function getUsers($user_id){
    global $con;

    $sql="SELECT * FROM users WHERE id = $user_id";
    $dataStatus = mysqli_query($con, $sql);
    $details = mysqli_fetch_array($dataStatus);

    return $details['firstname'] . ' ' . $details['lastname'];
}

function getBooks($book_id) {
    global $con;

    $sql="SELECT * FROM books WHERE id = $book_id";
    $dataStatus = mysqli_query($con, $sql);
    $details = mysqli_fetch_array($dataStatus);

    return $details['title'] . ' ' . $details['author'];
}

$sql="select * from reservations";

$result=mysqli_query($con,$sql);

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">CYTONN COLLEGE LIBRARY</a>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="librarian.php"><i style="color:pink;" class="fa fa-home"></i>Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="bookform.php"><i style="color:pink;"class="fa fa-book-reader"></i>Add books <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="listbooks.php"><i style="color:pink;"class="fa fa-book-open"></i>List books <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="status.php"><i style="color:pink;"class="fa fa-info"></i>View status <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="logout.php"><i style="color:pink;float: right"class="fa fa-sign-out-alt"></i>Logout <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
<p><?php echo $view_error ?></p>

<table class="table" style="width: 600px;background: #fcfcfc;margin: 70px auto;">
    <tr>
        <th> Name </th>
        <th> Book </th>
        <th> Actions </th>
    </tr>

    <?php while($array=mysqli_fetch_array($result)) { ?>
    <tr>
        <td class="text-center"><?php echo getUsers($array['user_id']); ?></td>
        <td class="text-center"><?php echo getBooks($array['book_id']); ?></td>


        <td>
        <form action="status.php" method="POST">
            <input type="hidden" name="reservations_id" value="<?php echo $array[0]; ?>">

            <input type="hidden" value="issue_action" name="issue_action">

            <button type="submit" class="btn btn-primary">Issue</button>
        </form>
                        </br>
        <form action="status.php" method="POST">

            <input type="hidden" name="reservations_id" value="<?php echo $array[0]; ?>">

            <input type="hidden" name="reject_action" value="reject_action">

            <button type="submit" class="btn btn-primary">Reject</button>

        </form>
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>

