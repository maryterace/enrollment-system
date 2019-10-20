<?php
include 'navigation.php';
if(isset($_SESSION['user'])) {
    header('location: /');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
   
<!-- login -->
    <div class="container">
        <div class="row" name="login">
        
        <div class="col-sm">
            </div>
            <span class="border border-success mt-5 rounded" style="border-width: 4px !important">
            
            <div align="center"><i class="fas fa-user fa-5x text-success mb-3 mt-2"></i></div>
            <div class="col-sm">
            
            <form method="post" action="auth.php" id="loginForm">
 
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
                <?php if(isset($_GET["wrongpassword"])){
                    echo '<small id="emailHelp" class="form-text text-danger">Incorrect Email/Password</small>';
                }?>
                
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="myInput" name="password" placeholder="Password">
                <input type="checkbox" onclick="showpass()">Show Password
            </div>
            <div align="center"><button type="submit" class="btn btn-success">LOGIN</button></div>

           </form>
            </div>
            
           </span>
            <div class="col-sm">
            </div>
        </div>
        </div>

        
        
            <script>
            function showpass() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            }
            </script>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>

<?php 
// session_start();

// if(isset($_SESSION['user']))
//  {
//      header('location: /');
//  }
?>