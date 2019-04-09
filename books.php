
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
                <a class="nav-link" href="librarian.html"><i style="color:pink;"class="fa fa-home"></i>Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i style="color:pink;float: right"class="fa fa-sign-out-alt"></i>Logout <span class="sr-only">(current)</span></a>
            </li>
        </ul>
    </div>
</nav>

<form style="width: 400px;background: #fcfcfc;margin: 70px auto;">
    <div class="form-group" >
        <label for="formGroupExampleInput">Title</label>
        <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Title">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Author</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Author">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Publisher</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Publisher">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Year of publication</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="year of publication">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">ISBN no.</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="ISBN no.">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Category</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Category">
    </div>
    <div class="form-group">
        <label for="formGroupExampleInput2">Title description</label>
        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Title description">
    </div>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Choose file</label>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>