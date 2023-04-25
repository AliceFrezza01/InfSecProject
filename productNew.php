<?php
session_start();
?>
<?php
    include ('connect.php');

    //check if user is authenticated else redirect him to the login
    if(!isset($_SESSION['loginsession'])){
        header('location: login.php');
    }

    $userid = $_SESSION['loginsession'];
    $userqueryresult = $con->query("SELECT * FROM user WHERE id = '$userid'");
    if($userqueryresult->num_rows != 1){
        //redirect also on login page because the userid does not exist or exists multiple times
        header('location: login.php');
    }

    $user = $userqueryresult->fetch_assoc();

    if (isset($_POST['sendForm'])) {
        $name = $_POST['nameproduct'];
        $price = $_POST['priceproduct'];
        $link = $_POST['linkproduct'];
        
        $result = $con->query("INSERT INTO product(`name`, `price`, `imgLink`, `creatorUserID`) VALUES ('$name',$price,'$link', $userid)");
        if (!$result) {
            echo "<script type='text/javascript'>alert('The product could not be inserted.');</script>";
        } else {
            echo "<script type='text/javascript'>alert('The product is inserted successully!');</script>";
        }
    }

    $con->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Product Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <style>
                .topnav {
                background-color: #333;
                overflow: hidden;
                }

                .topnav a {
                    float: left;
                    color: #f2f2f2;
                    text-align: center;
                    padding: 14px 16px;
                    text-decoration: none;
                    font-size: 17px;
                }

                .topnav a:hover {
                    background-color: #ddd;
                    color: black;
                }

                .topnav a.active {
                    background-color: blue;
                    color: white;
                }

                div .greetings {
                    color: white;
                    font-size: 17px;
                    padding: 14px 16px;
                }
                .form {
                    padding: 20px;
                }
        </style>
    </head>
    <body>
        <!-- TOP MENU -->
        <div class="topnav">
            <a class="active" href="./landingpage.php">Back To Landing Page</a>
            <div class="greetings">Hello, <?php echo $user['name'] ?></div>
        </div>
        <!-- TITLE -->
        <div class="header form">
            <h1>Add A new Product</h1>
        </div>
        <!-- FORM -->
        <form class="form" action=''  method='post'>
            <div class="form-group">
                <label for="inputEmail">Name product</label>
                <input type="text" class="form-control" name="nameproduct" placeholder="Enter the name of the product">
            </div>
            <div class="form-group">
                <label for="inputPrice">Price</label>
                <input type="text" class="form-control" name="priceproduct" placeholder="Enter the name of the product">
            </div>
            <div class="form-group">
                <label for="inputLink">Picture link</label>
                <input type="text" class="form-control" name="linkproduct" placeholder="Enter the name of the product">
            </div>
            <input type="submit" name="sendForm" value="Add Product" class="btn btn-primary">
        </form>
    </body>
</html>
