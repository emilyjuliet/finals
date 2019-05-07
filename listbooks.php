<?php

session_start();
require_once "class/config.php";
if (isset($_SESSION['user'])) {
    header('Location: listbooks.php');
}



$form_error = $delete_error = $success_message = '';
$show_form = $reserve_book = false;
$id = $title = $author = $publisher = $year_of_publication = $isbn_number = $category = $description = $user_id = $photo = $created_at = $updated_at = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete_action"])) {

        $bookId = $_POST["book_id"];

        $sql = "DELETE from books WHERE id='$bookId'";

        if (mysqli_query($con, $sql)) {
            header("location: listbooks.php");

            $success_message = 'Book has been deleted';
        } else {
            $delete_error = 'Deletion process was unsuccessful';
        }

    } elseif (isset($_POST['edit_action'])) {

        header('Location: bookform.php');


    } 
    // elseif (isset($_POST['reserve_action'])) {

    //     $action = $_POST['reserve_action'];

    //     if ($action == 'reserve_book') {
    //         $reserve_book = true;
    //         $bookId = $_POST["book_id"];

    //         $sql = "SELECT * FROM books WHERE id = '$bookId'";

    //         $dataBooks = mysqli_query($con, $sql);

    //         $detailsBooks = mysqli_fetch_row($dataBooks);

    //         $title = $detailsBooks[1];
    //         $user_id = $_SESSION['id'];

    //         $sqlUser = "SELECT * FROM users WHERE id = '$user_id'";

    //         $dataUser = mysqli_query($con, $sqlUser);
    //         $detailsUser = mysqli_fetch_row($dataUser);

    //         $firstname = $detailsUser[1];
    //         $lastname = $detailsUser[2];


    //     } elseif ($action == 'reserve') {

    //         $reserve_book = true;

    //         $bookId = (int)$_POST['book_id'];
    //         $user_id = $_SESSION['id'];
    //         $date = $_POST['date'];

    //         $sqlAddReservation = "INSERT into reservations (date, user_id, book_id) VALUES ('$date', '$user_id', '$bookId')";

    //         $enter = mysqli_query($con, $sqlAddReservation);

    //         if ($enter) {
    //             $success_message = "Book has been reserved";
    //         } else {
    //             $form_error = 'form error here';
    //         }

    //     }

    // }
}


// function getUserdetails($user_id)
// {
//     global $con;

//     $sql = "SELECT * FROM users WHERE id = $user_id";
//     $dataReserve = mysqli_query($con, $sql);
//     $details = mysqli_fetch_array($dataReserve);

//     return $details['firstname'] . ' ' . $details['lastname'];
// }


function checkReserved($bookId)
{
    global $con;

    $sql = "SELECT * FROM reservations WHERE book_id = $bookId";

    $res = mysqli_query($con, $sql);

    $details = mysqli_fetch_array($res);

    if ($details) {
        return false;
    }

    return true;
}

$sql = "select * from books";

$result = mysqli_query($con, $sql);


if(isset($_POST['reserveBook'])) {

    $bookId = $_POST['book_id'];
    //$user_id = 7;
    $user_id = $_SESSION['id'];
    $title = $_POST['book_title'];


    $sqlAddReservation = "INSERT into reservations (user_id, book_id) VALUES ($user_id, $bookId)";

    $enter = mysqli_query($con, $sqlAddReservation);

    if ($enter) {
        $success_message = "Book has been reserved";
    } else {
        $form_error = 'Process was unsuccessful';
    }

}


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
    <script src="./https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="./https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand">CYTONN COLLEGE LIBRARY</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if ($_SESSION["is_admin"] == 1) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="librarian.php"><i style="color:pink;" class="fa fa-home"></i>Home <span class="sr-only">(current)</span></a>
                </li>
            <?php } else { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="student.php"><i style="color:pink;" class="fa fa-home"></i>Home <span class="sr-only">(current)</span></a>
                </li>
            <?php } ?>
            <?php if ($_SESSION["is_admin"] == 1) { ?>
            <li class="nav-item active">
                <a class="nav-link" href="bookform.php"><i style="color:pink;"class="fa fa-book-reader"></i>Add books <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="listbooks.php"><i style="color:pink;"class="fa fa-book-open"></i>List books <span class="sr-only">(current)</span></a>
            </li>
            <?php } else { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="listbooks.php"><i style="color:pink;"class="fa fa-book-reader"></i>Books<span class="sr-only">(current)</span></a>
                </li>
            <?php } ?>
            <?php if ($_SESSION["is_admin"] == 1) { ?>
            <li class="nav-item active">
                <a class="nav-link" href="status.php"><i style="color:pink;"class="fa fa-info"></i>View status <span class="sr-only">(current)</span></a>
            </li>
            <?php } ?>
            <li class="nav-item active">
                <a class="nav-link" href="logout.php"><i style="color:pink;float: right" class="fa fa-sign-out-alt"></i>Logout<span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
<p><?php echo $form_error ?></p>
<p><?php echo $delete_error ?></p>
<p><?php echo $success_message; ?></p>


<?php foreach ($result as $list) { ?>


    <div class="col-sm-4" style="margin-bottom: 30px; 4px;float: left">

        <div class="card">

            <div class="card-body" style="padding-top:">

                <div class="row" style="margin-bottom:20px;background-position: center;background-size:cover;background-repeat:no-repeat;background-image: URL(<?php echo $list['photo']; ?>); height: 600px;">

                </div>

                <h5 class="card-title"><strong><?php echo $list['title']; ?></strong></h5>

                <p class="card-text">
                    <small><strong>AUTHOR: </strong><?php echo $list['author']; ?></small>
                </p>

      <?php if ($_SESSION["is_admin"] == 0) { ?>
         <?php if (checkReserved($list['id'])) { ?>
              <p>
              <form action="listbooks.php" method="POST">

                  <input type="hidden" name="book_id" value="<?php echo $list['id']; ?>">

                  <input type="hidden" value="<?php echo $list['title']; ?>" name="book_title">

                  <button type="submit" name="reserveBook" class="btn btn-primary">Reserve</button>
              </form>
              </p>
          <?php } else { ?>
              <p style="font-family: 'Pacifico', cursive;">Reserved</p>
          <?php }
       } ?>

      <?php if ($_SESSION["is_admin"] == 1) { ?>
          <p>
          <form action="listbooks.php" method="POST">
              <input type="hidden" name="book_id" value="<?php echo $list['id']; ?>">

              <input type="hidden" value="delete_action" name="delete_action">

              <button type="submit" class="btn btn-primary">Delete</button>
          </form>
          </br>

          <form action="bookform.php" method="POST">

              <input type="hidden" name="book_id" value="<?php echo $list['id']; ?>">

              <input type="hidden" name="edit_action" value="edit_action">

              <button type="submit" class="btn btn-primary">Edit</button>

          </form>
          </p>
      <?php } ?>

     </div>
     </div>
    </div>


<?php } ?>



<?php mysqli_free_result($result); ?>
<?php mysqli_close($con); ?>


</body>
</html>