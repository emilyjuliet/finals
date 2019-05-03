<?php

session_start();
require_once "class/config.php";
if (isset($_SESSION['user'])) {
    header('Location: add.php');
}

$form_error = $delete_error = $date = $success_message = '';
$show_form = $reserve_book = $edit_book = false;
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
            $user_id = $_SESSION['id'];
//            $photo = '/bookimage/' . $_POST["photo"];
           // $photo = $_POST["photo"];
            $photo = $_FILES['photo']['photo'];
            $created_at = new DateTime();
            $updated_at = new DateTime();

//            $photo = $_FILES['photo']['photo'];
            $tempName = explode(".", $photo);
            $newName = round(microtime(true)) . '.' . end($tempName);
            $folder = "/bookimage/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            $file = $folder . basename($newName);
            $fileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $extensions = array("jpg", "JPG", "jpeg", "JPEG", "png", "PNG");
            if (in_array($fileType, $extensions)) {
                $query = "INSERT into books(title, author, publisher, year_of_publication, isbn_number, category, description, user_id, photo) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param('sssiissis', $title, $author, $publisher, $year_of_publication, $isbn_number, $category, $description, $user_id, $photo, $newName);
                if ($stmt->execute()) {
                    // Move Image to Folder
                    move_uploaded_file($_FILES['photo']['tmp_name'], $folder . $newName);
                    echo "Book Successfully Added";
                } else {
                    die('There was a problem');
                }
            }
        }


            $sql = "INSERT into books(title, author, publisher, year_of_publication, isbn_number, category, description, user_id, photo) VALUES ('$title', '$author', '$publisher', '$year_of_publication', '$isbn_number', '$category', '$description', '$user_id', '$photo')";

            $enter = mysqli_query($con, $sql);

            if ($enter) {
                $success_message = "Book has been added";
            } else {
                $form_error = 'Process was unsuccessful';
            }

        }
    }elseif (isset($_POST['create_edit'])) {
        $bookId = $_POST["book_id"];

            $title = $_POST["title"];
            $author = $_POST["author"];
            $publisher = $_POST["publisher"];
            $year_of_publication = $_POST["year_of_publication"];
            $isbn_number = $_POST["isbn_number"];
            $category = $_POST["category"];
            $description = $_POST["description"];
            $user_id = $_SESSION['id'];
            //$photo = '/bookimage/' . $_POST["photo"];
            //$photo = $_POST["photo"];
            $photo = $_FILES['photo']['photo'];
            $created_at = new DateTime();
            $updated_at = new DateTime();


            $sql = "UPDATE books SET title = '$title', author = '$author', publisher = '$publisher', year_of_publication = '$year_of_publication', isbn_number = '$isbn_number', category = '$category', description = '$description', user_id = '$user_id', photo = '$photo'  WHERE id = '$bookId'";

            $edit = mysqli_query($con, $sql);

        if ($edit) {
            $success_message = "Book has been edited";
        } else {
            $form_error = 'Process was unsuccessful';
        }

        }
    elseif (isset($_POST['edit_action'])) {

        $bookId = $_POST["book_id"];

        $sql = "SELECT * FROM books WHERE id = '$bookId'";

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
        $bookId = $details[0];
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

                <li class="nav-item active">
                    <a class="nav-link" href="librarian.php"><i style="color:pink;" class="fa fa-home"></i>Home <span class="sr-only">(current)</span></a>
                </li>
            <li class="nav-item active">
                <a class="nav-link" href="add.php"><i style="color:pink;"class="fa fa-book-reader"></i>Add books <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="books.php"><i style="color:pink;"class="fa fa-book-open"></i>List books <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="status.php"><i style="color:pink;"class="fa fa-info"></i>View status <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="logout.php"><i style="color:pink;float: right" class="fa fa-sign-out-alt"></i>Logout<span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
<p><?php echo $form_error ?></p>
<p><?php echo $delete_error ?></p>
<p><?php echo $success_message; ?></p>


    <form enctype="multipart/form-data" action="add.php" style="width: 400px;background: #fcfcfc;margin: 70px auto;" method="POST">
        <div class="form-group">
            <label for="formGroupExampleInput">Title</label>
            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Title" name="title" value="<?php echo $title; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Author</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Author" name="author" value="<?php echo $author; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Publisher</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Publisher" name="publisher" value="<?php echo $publisher; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Year of publication</label>
            <input type="date" class="form-control" id="formGroupExampleInput2" placeholder="year of publication" name="year_of_publication" value="<?php echo $year_of_publication; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">ISBN no.</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="ISBN no." name="isbn_number" value="<?php echo $isbn_number; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Category</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Category" name="category" value="<?php echo $category; ?>">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Title description</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Title description" name="description" value="<?php echo $description; ?>">
        </div>

        <div class="form-group">
            <label for="exampleFormControlFile1">Example file input</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="photo" value="<?php echo $photo; ?>">
        </div>



        <?php if (empty($bookId)) { ?>
            <input type="hidden" value="create_new" name="create_new">
        <?php } else { ?>
            <input type="hidden" value="create_edit" name="create_edit">

            <input type="hidden" value="<?php echo $bookId; ?>" name="book_id"/>
        <?php } ?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


<?php mysqli_free_result($result); ?>
<?php mysqli_close($con); ?>


</body>
</html>
