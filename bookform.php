<?php

session_start();

require_once "class/config.php";

if (isset($_SESSION['user'])) {
    header('Location: bookform.php');
}

$form_error = $delete_error = $date = $success_message = '';
$show_form = $reserve_book = $edit_book = false;
$id = $title = $author = $publisher = $year_of_publication = $isbn_number = $category = $description = $user_id = $photo = $created_at = $updated_at = $photo = "";

function getPhotoLocation(){
    $target_dir = "bookimage/";
    $target_file = $target_dir . rand(10,100) . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            $form_error =  "Image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            $form_error =  "Not image.";
            $uploadOk = 0;
        }
    }

    if (file_exists($target_file)) {
        $form_error = "File already exists. Upload another";
        $uploadOk = 0;
    }

    if ($_FILES["photo"]["size"] > 500000) {
        $form_error = "File size is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $form_error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $form_error = "File was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            return false;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['create_new'])) {
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
            
            if (isset($_FILES['photo'])) {
                $photo = getPhotoLocation();
            }

            $title = $_POST["title"];
            $author = $_POST["author"];
            $publisher = $_POST["publisher"];
            $year_of_publication = $_POST["year_of_publication"];
            $isbn_number = $_POST["isbn_number"];
            $category = $_POST["category"];
            $description = $_POST["description"];
            $user_id = $_SESSION['id'];
            $created_at = new DateTime();
            $updated_at = new DateTime();

            $sql = "INSERT into books(title, author, publisher, year_of_publication
            ,isbn_number, category, description, user_id, photo) 
            VALUES ('$title', '$author', '$publisher', '$year_of_publication', '$isbn_number'
            , '$category', '$description', $user_id, '$photo')";

            $stmt = mysqli_prepare($con, $sql);

            if (mysqli_stmt_execute($stmt)) {
                
                $success_message = 'Book has been added';

            }else{
                $form_error = 'Process was unsuccessful';
            }

            header("Location: listbooks.php"); 

            
        }
    }elseif (isset($_POST['edit_action'])) {

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

    }elseif (isset($_POST['create_edit'])) {
        $bookId = $_POST["book_id"];

        if (isset($_FILES['photo'])) {
            $photo = getPhotoLocation();
        }


        if (is_null($photo)) {
            $photo = $_POST['photo'];
        }

        $title = $_POST["title"];
        $author = $_POST["author"];
        $publisher = $_POST["publisher"];
        $year_of_publication = $_POST["year_of_publication"];
        $isbn_number = $_POST["isbn_number"];
        $category = $_POST["category"];
        $description = $_POST["description"];
        $user_id = $_SESSION['id'];
        $created_at = new DateTime();
        $updated_at = new DateTime();

        $sql = "UPDATE books SET title = '$title', author = '$author', publisher = '$publisher', year_of_publication = '$year_of_publication', isbn_number = '$isbn_number', category = '$category', description = '$description', user_id = '$user_id', photo = '$photo'  WHERE id = '$bookId'";

        $stmt = mysqli_prepare($con, $sql);

        if (mysqli_stmt_execute($stmt)) {

            $success_message = 'Book has been edited successfully'; 
        }else{
            $form_error = 'Edit Process was unsuccessful';
        }

        header("Location: listbooks.php");
        
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
                <a class="nav-link" href="logout.php"><i style="color:pink;float: right" class="fa fa-sign-out-alt"></i>Logout<span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
<p><?php echo $form_error ?></p>
<p><?php echo $delete_error ?></p>
<p><?php echo $success_message; ?></p>


    <form enctype="multipart/form-data" action="bookform.php" style="width: 400px;background: #fcfcfc;margin: 70px auto;" method="POST">
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
            <label for="formGroupExampleInput2">Year of publication <?php echo $year_of_publication; ?></label>
            <input type="date" class="form-control" id="formGroupExampleInput2" placeholder="year of publication" name="year_of_publication" value="">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">ISBN no.</label>
            <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="ISBN no." name="isbn_number" value="<?php echo $isbn_number; ?>">
        </div>
        <div class="form-group">
    <label for="exampleFormControlSelect1">Category</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>Recreational</option>
      <option>Math</option>
      <option>Literature</option>
      <option>Novel</option>
      <option>Encyclopedia</option>
    </select>
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
            <input type="hidden" value="create_edit" name="create_edit"/>

            <input type="hidden" value="<?php echo $bookId; ?>" name="book_id"/>

            <input type="hidden" value="<?php echo $photo; ?>" name="photo"/>

            <input type="hidden" value="<?php echo $year_of_publication; ?>" name="year_of_publication"/>
        <?php } ?>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


    <?php if ($photo) { ?>
       <img src="<?php echo $photo; ?>" alt="" style="width: 100px; height: 100px;text-align: center;">
    <?php } ?>;

<?php mysqli_free_result($result); ?>
<?php mysqli_close($con); ?>


</body>
</html>
