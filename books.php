<?php
//session_start();
//// Check if the user is logged in, if not then redirect him to login page
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//    header("location: login.php");
//    exit;
//}

    require_once "Classes/config.php";

$form_error  = '';
//$show_form = $view_add_test = $view_user_test = false;
$title = $author =  $publisher = $year_of_publication = $isbn_number = $category = $description = $user_id = $photo = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {

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
            $user_id = $_POST["user_id"];
            $photo = $_POST["photo"];


            $sql = "INSERT into books(title, author, publisher, year_of_publication, isbn_number, category, description, user_id, photo) VALUES ('$title', '$author', '$publisher', '$year_of_publication', '$isbn_number', '$category', '$description', '$user_id', '$photo')";

            // echo (mysqli_query($conn,$sql));

            $enter = mysqli_query($con, $sql);
        }
    }
}
$sql="select * from books"; // Fetch all the records from the table address
$result=mysqli_query($con,$sql);


?>
<!DOCTYPE html>
<html>
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
            <li class="nav-item">
                <a class="nav-link" href="#"><i style="color:pink;float: right"class="fa fa-sign-out-alt"></i>Logout <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
    <p><?php echo $form_error ?></p>

<form action="books.php" style="width: 400px;background: #fcfcfc;margin: 70px auto;" method="post">
    <div class="form-group" >
        <label for="formGroupExampleInput">Title</label>
        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Title" value="<?php echo $title; ?>" >
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Author</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Author" value="<?php echo $author; ?>">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Publisher</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Publisher" value="<?php echo $publisher; ?>">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Year of publication</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="year of publication" value="<?php echo $year_of_publication; ?>">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">ISBN no.</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="ISBN no." value="<?php echo $isbn_number; ?>">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Category</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Category" value="<?php echo $category; ?>">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Title description</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Title description" value="<?php echo $description; ?>">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Created by</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Created by" value="<?php echo $user_id; ?>">
    </div>

    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile" value="<?php echo $photo; ?>">
        <label class="custom-file-label" for="customFile">Choose file</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

    <?php if(empty($id)){ ?>

    <input type="hidden" value="create_new" name="create_new">
</form>
<?php }?>
</body>
</html>