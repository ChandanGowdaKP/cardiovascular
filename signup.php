<?php
require_once 'config/connection.php';

if (isset($_POST['add'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];
    $password = $_POST['password'];

    if (mysqli_query($conn, "INSERT INTO user_creation (username, email, usertype, password) 
                             VALUES ('$username', '$email', '$usertype', '$password')")) {
        echo "<script>alert('User added successfully .');location.href='login.php';</script>";
    } else {
        echo "<script>alert('Unable to add User.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        /* Custom gradient background */
        .gradient-custom {
            background: #0463FA;
            /* background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));
            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1)); */
        }

        /* Adjustments for small screens */
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
    <!-- Sign Up Form Start -->
    <section class="vh-100 gradient-custom d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-dark text-white border-0 rounded-3">
                    <div class="card-body p-5 text-center bg-white"> <!-- added bg-white class here -->
                        <!-- Sign Up Heading -->
                        <h2 class="fw-bold mb-4 text-uppercase" style="color: black;">Sign Up</h2> <!-- changed color to black -->


                        <form action="" method="POST">

                            <div class="form-outline form-white mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" id="typeUsername" class="form-control form-control-lg" name="username" placeholder="Enter Username" />
                                </div>
                            </div>

                            <div class="form-outline form-white mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" id="typeEmail" name="email" class="form-control form-control-lg" placeholder="Enter Email" />
                                </div>
                            </div>

                            <div class="form-outline form-white mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="typePassword" name="password" class="form-control form-control-lg" placeholder="Enter Password"/>
                                </div>
                            </div>

                            <div class="form-outline form-white mb-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" id="typeConfirmPassword" name="password" class="form-control form-control-lg" placeholder="Enter To Confirm Password" />
                                </div>
                            </div>

                            <div class="form-outline form-white mb-4">
                                <select class="form-select form-select-lg" name="usertype" id="userType">
                                    <option value="">Select User Type</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Doctors">Doctor</option>
                                    <option value="Patients">Patient</option>
                                </select>
                            </div>

                            <!-- Sign Up button -->
                            <button class="btn btn-outline-primary btn-lg px-5 mb-3" name="add" type="submit">Sign Up</button>
                        </form>
                        <!-- Sign up link -->
                        <div class="mt-4">
                            <p class="mb-0 text-dark">Already have an account? <a href="login.php" class="fw-bold text-decoration-none text-dark">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Sign Up Form End -->

    <!-- JavaScript Libraries -->  
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>
