<?php

//    session_start();
//
//
//    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//        header("location: home.html");
//        exit;
//    }
//
//
//    require_once "class/config.php";

$delete_error  = '';
//$show_form = false;

$title = $author =  $publisher = $year_of_publication = $isbn_number = $category = $description = $user_id = $photo = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST['create_edit'])){

        $books_id = $_POST["books_id"];

        // echo $books_id;

        $title = $_POST["title"];
        $author = $_POST["author"];
        $publisher = $_POST["publisher"];
        $year_of_publication = $_POST["year_of_publication"];
        $isbn_number = $_POST["isbn_number"];
        $category = $_POST["category"];
        $description = $_POST["description"];
        $user_id = $_POST["user_id"];
        $photo = $_POST["photo"];

        $sql = "UPDATE books SET title = '$title', author = '$author', publisher = '$publisher', year_of_publication = '$year_of_publication', isbn_number = '$isbn_number', category = '$category', description = '$description', user_id = '$user_id', photo = '$photo'  WHERE id='$user_id'";

        $edit = mysqli_query($con, $sql);

    }elseif(isset($_POST["delete_action"])){

        $books_id = $_POST["books_id"];

        $sql = "DELETE from books WHERE id='$books_id'";

        if(mysqli_query($con, $sql)){
            header("location: booklist.php");
        }else{
            $delete_error = "Deletion process was unsuccessful";
        }

    }elseif(isset($_POST['edit_action'])){

        $books_id = $_POST["books_id"];

        $sql = "SELECT * FROM books WHERE id = '$books_id'";

        $data = mysqli_query($con, $sql);

        $details = mysqli_fetch_row($data);

        $title = $details[1]; $author = $details[2]; $publisher = $details[3];
        $year_of_publication = $details[4]; $isbn_number = $details[5]; $category = $details[6]; $description = $details[7];
        $user_id = $details[8]; $photo = $details[9];

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
            <li class="nav-item active">
                <a class="nav-link" href="logout.php"><i style="color:pink;float: right"class="fa fa-sign-out-alt"></i>Logout <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>
<h>TESTS</h>
<p><?php echo $delete_error ?></p>
<?php if(empty($id)){ ?>

<!--    <input type="hidden" value="create_new" name="create_new">-->
<?php //}else { ?>
    <input type="hidden" value="create_new" name="create_edit">

    <input type="hidden" value="<?php echo $books_id; ?>" name="books_id"/>
<?php } ?>
<button type="submit" class="btn btn-primary">Submit</button>
</form>

<div class="card" style="width: 18rem;">
    <img src="..." class="card-img-top" alt="...">
    <div class="card-body">
        <h5 class="card-title"></h5>
        <p class="card-text"></p>
    </div>
    <?php while($array=mysqli_fetch_row($result)) { ?>

        <canvas class="text-center"><?php echo $array[0]; ?></canvas>
        <img src="<?php echo $array[9]; ?>" alt="">
        <p class="text-center"><?php echo $array[1]; ?></p>
        <p class="text-center"><?php echo $array[2]; ?></p>
        <p>
        <form action="booklist.php" method="post">
            <input type="hidden" name="books_id" value="<?php echo $array[0]; ?>">

            <input type="hidden" value="delete_action" name="delete_action">

            <button class="btn" type="submit">Delete</button>
        </form>

        <form action="booklist.php" method="post">

            <input type="hidden" name="books_id" value="<?php echo $array[0]; ?>">

            <input type="hidden" name="edit_action" value="edit_action">

            <button class="btn" type="submit">Edit</button>

        </form>
        </p>
    <?php }?>
</div>

<?php mysqli_free_result($result); ?>
<?php mysqli_close($con); ?>
</body>
</html>