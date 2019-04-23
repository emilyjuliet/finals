<?php

session_start();
require_once "class/config.php";
if (isset($_SESSION['user'])) {
    header('Location: books.php');
}

//var_dump($_SESSION, 'this is a session');

$form_error = $delete_error = $date = $success_message = '';
$show_form = $reserve_book = false;
$id = $title = $author = $publisher = $year_of_publication = $isbn_number = $category = $description = $user_id = $photo = $created_at = $updated_at = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create_new'])) { // creating new
        if (

            empty(trim($_POST["title"])) &&
            empty(trim($_POST["author"])) &&
            empty(trim($_POST["publisher"])) &&
            empty(trim($_POST["year_of_publication"])) &&
            empty(trim($_POST["isbn_number"])) &&
            empty(trim($_POST["category"])) &&
            empty(trim($_POST["description"])) &&
            empty(trim($_POST["user_id"])) &&
            empty(trim($_POST["photo"]))

        ) {

            $form_error = "Please fill the form correctly.";

        } else {
            $title = $_POST["title"];
            $author = $_POST["author"];
            $publisher = $_POST["publisher"];
            $year_of_publication = $_POST["year_of_publication"];
            $isbn_number = $_POST["isbn_number"];
            $category = $_POST["category"];
            $description = $_POST["description"];
            $user_id = "10"; // I will return a session and fetch the id of the currently logged in user
            $photo = '/bookimage/' . $_POST["photo"];
            $created_at = new DateTime();
            $updated_at = new DateTime();


            $sql = "INSERT into books(title, author, publisher, year_of_publication, isbn_number, category, description, user_id, photo) VALUES ('$title', '$author', '$publisher', '$year_of_publication', '$isbn_number', '$category', '$description', '$user_id', '$photo')";

            $enter = mysqli_query($con, $sql);

        }
    } elseif (isset($_POST['create_edit'])) {
        $book_id = $_POST["book_id"];

        // echo $books_id;

        $title = $_POST["title"];
        $author = $_POST["author"];
        $publisher = $_POST["publisher"];
        $year_of_publication = $_POST["year_of_publication"];
        $isbn_number = $_POST["isbn_number"];
        $category = $_POST["category"];
        $description = $_POST["description"];
        $user_id = "10";
        $photo = '/bookimage/' . $_POST["photo"];
        $created_at = new DateTime();
        $updated_at = new DateTime();

        $sql = "UPDATE books SET title = '$title', author = '$author', publisher = '$publisher', year_of_publication = '$year_of_publication', isbn_number = '$isbn_number', category = '$category', description = '$description', user_id = '$user_id', photo = '$photo'  WHERE id = '$book_id'";

        $edit = mysqli_query($con, $sql);

    } elseif (isset($_POST["delete_action"])) {

        $book_id = $_POST["book_id"];

        $sql = "DELETE from books WHERE id='$book_id'";

        if (mysqli_query($con, $sql)) {
            header("location: books.php");
        } else {
            $delete_error = "Deletion process was unsuccessful";
        }

    } elseif (isset($_POST['edit_action'])) {

        $book_id = $_POST["book_id"];

        $sql = "SELECT * FROM books WHERE id = '$book_id'";

        $data = mysqli_query($con, $sql);

        $details = mysqli_fetch_row($data);

        $title = $details[1];
        $author = $details[2];
        $publisher = $details[3];
        $year_of_publication = $details[4];
        $isbn_number = $details[5];
        $category = $details[6];
        $description = $details[7];
        $user_id = $details[8];
        $photo = $details[9];
        $book_id = $details[0];

    } elseif (isset($_POST['reserve_action'])) {

        $action = $_POST['reserve_action'];

        if ($action == 'reserve_book') {
            $reserve_book = true;
            $book_id = $_POST["book_id"];

            $sql = "SELECT * FROM books WHERE id = '$book_id'";

            $dataBooks = mysqli_query($con, $sql);

            $detailsBooks = mysqli_fetch_row($dataBooks);

            $title = $detailsBooks[1];
            $user_id = $_SESSION['id'];

            $sqlUser = "SELECT * FROM users WHERE id = '$user_id'";

            $dataUser = mysqli_query($con, $sqlUser);
            $detailsUser = mysqli_fetch_row($dataUser);

            $firstname = $detailsUser[1];
            $lastname = $detailsUser[2];


        } elseif ($action == 'reserve') {

            $reserve_book = true;

            $book_id = (int)$_POST['book_id'];
            $user_id = $_SESSION['id'];
            $date = $_POST['date'];

            $sqlAddReservation = "INSERT into reservations (date, user_id, book_id) VALUES ('$date', '$user_id', '$book_id')";

            $enter = mysqli_query($con, $sqlAddReservation);

            if ($enter) {
                $success_message = "Book has been reserved";
            } else {
                $form_error = 'form error here';
            }

        }

    }
}


function getUserdetails($user_id)
{
    global $con;

    $sql = "SELECT * FROM users WHERE id = $user_id";
    $dataReserve = mysqli_query($con, $sql);
    $details = mysqli_fetch_array($dataReserve);

    return $details['firstname'] . ' ' . $details['lastname'];
}


function checkReserved($book_id)
{
    global $con;

    $sql = "SELECT * FROM reservations WHERE book_id = $book_id";

    $res = mysqli_query($con, $sql);

    $details = mysqli_fetch_array($res);

    if ($details) {
        return false;
    }

    return true;
}

$sql = "select * from books";

$result = mysqli_query($con, $sql);


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
                    <a class="nav-link" href="librarian.php"><i style="color:pink;" class="fa fa-home"></i>Home <span
                                class="sr-only">(current)</span></a>
                </li>
            <?php } else { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="student.php"><i style="color:pink;" class="fa fa-home"></i>Home <span
                                class="sr-only">(current)</span></a>
                </li>
            <?php } ?>
            <li class="nav-item active">
                <a class="nav-link" href="logout.php"><i style="color:pink;float: right" class="fa fa-sign-out-alt"></i>Logout
                    <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
<p><?php echo $form_error ?></p>
<p><?php echo $delete_error ?></p>
<p><?php echo $success_message; ?></p>

<?php if ($_SESSION["is_admin"] == 1) { ?>
    <form action="books.php" style="width: 400px;background: #fcfcfc;margin: 70px auto;" method="POST">
        <div class="form-group">
            <label for="formGroupExampleInput">Title</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Title" name="title"
                   value="<?php echo $title; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Author</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Author" name="author"
                   value="<?php echo $author; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Publisher</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Publisher" name="publisher"
                   value="<?php echo $publisher; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Year of publication</label>
            <input type="date" class="form-control" id="formGroupExampleInput2" placeholder="year of publication"
                   name="year_of_publication" value="<?php echo $year_of_publication; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">ISBN no.</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="ISBN no."
                   name="isbn_number" value="<?php echo $isbn_number; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Category</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Category" name="category"
                   value="<?php echo $category; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Title description</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Title description"
                   name="description" value="<?php echo $description; ?>">
        </div>
        <!--    <div class="form-group">-->
        <!--        <label for="formGroupExampleInput2">Created by</label>-->
        <!--        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Created by" name="user_id" value=" -->
        <?php //echo $user_id; ?><!--">-->
        <!--    </div>-->

        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="photo" value=" <?php echo $photo; ?>">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>


        <?php if (empty($book_id)) { ?>

            <input type="hidden" value="create_new" name="create_new">
        <?php } else { ?>
            <input type="hidden" value="create_edit" name="create_edit">

            <input type="hidden" value="<?php echo $book_id; ?>" name="book_id"/>
        <?php } ?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php } ?>

<!--<div class="card" style="width: 18rem;">-->
<!--    <div class="card-details">-->
<?php while ($array = mysqli_fetch_row($result)) { ?>

    <!--           <div class="card-section">-->
    <!--        <div class="card" style="width: 18rem;">-->
    <!--               <img src="--><?php // echo $array[9]; ?><!--" alt="" style="height: 400px">-->
    <!--               <b><p class="text-center">--><?php //echo $array[1]; ?><!--</p></b>-->
    <!--               <b><p class="text-center">--><?php //echo $array[2]; ?><!--</p></b>-->
    <div class="col-sm-4" style="margin-bottom: 30px; 4px;float: left">

        <div class="card">

            <div class="card-body" style="padding-top:">

                <div class="row" style="margin-bottom:20px;background-position: center;background-size:cover;background-repeat:no-repeat;background-image: URL(<?php echo $array[9]; ?>); height: 600px;">

                </div>

                <h5 class="card-title"><strong><?php echo $array[1]; ?></strong></h5>

                <p class="card-text">
                    <small><strong>AUTHOR:</strong><?php echo $array[2]; ?></small>
                </p>

                <?php if ($_SESSION["is_admin"] == 0) { ?>
                    <?php if (checkReserved($array[0])) { ?>
                        <p>
                        <form action="books.php" method="POST">
                            <input type="hidden" name="book_id" value="<?php echo $array[0]; ?>">
                            <input type="hidden" value="reserve_book" name="reserve_action">

                            <button type="submit" class="btn btn-primary">Reserve</button>
                        </form>
                        </p>
                    <?php } else { ?>
                        <p style="font-family: 'Pacifico', cursive;">Reserved</p>
                    <?php }
                } ?>

                <?php if ($_SESSION["is_admin"] == 1) { ?>
                    <p>
                    <form action="books.php" method="POST">
                        <input type="hidden" name="book_id" value="<?php echo $array[0]; ?>">

                        <input type="hidden" value="delete_action" name="delete_action">

                        <button type="submit" class="btn btn-primary">Delete</button>
                    </form>
                    </br>

                    <form action="books.php" method="POST">

                        <input type="hidden" name="book_id" value="<?php echo $array[0]; ?>">

                        <input type="hidden" name="edit_action" value="edit_action">

                        <button type="submit" class="btn btn-primary">Edit</button>

                    </form>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div>


<?php } ?>
<!--    </div>-->
<!--</div>-->


<?php mysqli_free_result($result); ?>
<?php mysqli_close($con); ?>

<?php if ($reserve_book) { ?>
    <form action="books.php" style="width: 400px;background: #fcfcfc;margin: 70px auto;" method="POST">
        <div class="form-group">
            <label for="formGroupExampleInput">Date</label>
            <input type="date" class="form-control" id="formGroupExampleInput" placeholder="date" name="date"
                   value="<?php echo $date; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Firstname</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="firstname" name="firstname"
                   value="<?php echo $firstname; ?>" />
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Lastname</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="lastname" name="lastname"
                   value="<?php echo $lastname; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Book title</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="title" name="title"
                   value="<?php echo $title; ?>">
        </div>
        <input type="hidden" value="reserve" name="reserve_action">

        <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">

        <input type="hidden" value="<?php echo $book_id; ?>" name="book_id">

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php } ?>
</body>
</html>