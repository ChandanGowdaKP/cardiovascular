<?php

session_start();

require_once 'config/connection.php';

if (isset($_POST['login'])) {
    $name = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user_creation WHERE username = '$name' AND password = '$password'");

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userType = $row['usertype'];


        $_SESSION['isLogin'] = true;
        $_SESSION['username'] = $name;
        $_SESSION['userid'] = $row['user_id'];

        $_SESSION['usertype'] = $userType;

        echo "<script>alert('You have logged in successfully');location.href='index.php'</script>";
    } else {
        echo "<script>alert('Invalid credentials');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="img/favicon.ico" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
    <style>
        .gradient-custom {
            background: #0463FA;
            /* background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1)); */
        }
        @media (max-width: 576px) {
            .col-md-6,
            .col-lg-6,
            .col-xl-5 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
<section class="vh-100 gradient-custom d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white border-0 rounded-3">
                    <div class="card-body p-5 text-center bg-white">
                        <h2 class="fw-bold mb-4 text-uppercase" style="color: black;">Sign In</h2>
                        <form action="" method="POST">
                            <div class="form-outline form-white mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" id="username" name="username" class="form-control form-control-lg" placeholder="Enter Username" />
                                </div>
                            </div>
                            <div class="form-outline form-white mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter Password" />
                                </div>
                            </div>
                            <!-- <p class="small mb-4">
                                <a class="text-dark" href="#!">Forgot password?</a>
                            </p> -->
                            <button class="btn btn-outline-primary btn-lg px-5 mb-3" name="login" type="submit">Sign In</button>
                            <div class="d-flex justify-content-center text-center">
                                <a href="#!" class="text-dark me-4"><i class="fab fa-facebook-f fa-lg"></i></a>
                                <a href="#!" class="text-dark me-4"><i class="fab fa-twitter fa-lg"></i></a>
                                <a href="#!" class="text-dark"><i class="fab fa-google fa-lg"></i></a>
                            </div>
                        </form>
                        <div class="mt-4">
                            <p class="mb-0 text-dark">Don't have an account? <a href="signup.php" class="fw-bold text-decoration-none text-dark">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>


    <script src="js/main.js"></script>
</body>
</html>
