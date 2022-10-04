<?php

require_once('connection.php');

if(isset($_SESSION['login']) && $_SESSION['Role'] == "Admin")
{
    header('location: main/');
}
else{}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="loginHome">
    <div class="loginBox">
        <h1 class="loginTitle">Login</h1>
        <form class="loginForm" method="POST" action="">
            <div class="row">
                <div class="col-25">
                    <label class="inp-lbl" for="username">Username <span class="star">*</span></label>
                </div>
                <div class="col-75">
                    <input type="text" id="fname" name="username" placeholder="Your Name.." required>
                </div>
            </div>
            <div class="row">
                <div class="col-25">
                    <label class="inp-lbl" for="fname">Password <span class="star">*</span></label>
                </div>
                <div class="col-75">
                    <input type="password" id="pass" name="password" placeholder="Your Password" required>
                </div>
            </div>
            <input type="submit" value="Login" >
        </form>
    </div>
</div>

<?php
    if(isset($_POST['username']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        if(mysqli_connect_error())
        {
            die('Connection Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        }
        else
        {
            $SELECT = "SELECT username, password, role FROM register WHERE username = '$username' AND password = '$password'";
            $result = $conn->query($SELECT);
            if( $result -> num_rows >0) 
            {
                while($row = $result->fetch_assoc()) 
                {
                    $_SESSION["Role"]=$row["role"];
                    if($row["role"] =="Admin")
                    {
                        ?>
                        <script>
                            alert("Login Successful");
                            document.location.href="main/";
                        </script>
                        <?php
                        $_SESSION['login']=$_POST['username'];
                         //echo $_SESSION['login'];
                         die();
                    }
                    if($row["role"] == "user")
                    {
                        ?>
                        <script>
                            alert("Login Successful");
                            document.location.href= "main/";
                        </script>
                        <?php
                    }
                }  
            }
            else{
                ?>
                <script>
                    alert("Invalid username / Password");
    
                        setTimeout(() => {
                            return;
                        }, 2000);
                </script>
                <?php
            }
        }
    }
?>
</body>
</html>

