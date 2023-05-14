<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Employment Tracker</title>

    <!-- Header Imports -->
    <?php require_once('../include/header.php') ?>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="../uploads/bg_img.JPG" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <h2><a href="../index.php" class="text-success text-decoration-none">Cavite State University</a></h2>
                    <?php if (isset($_COOKIE['message'])) {
                        echo "<h6 class=" . $_COOKIE['message_class'] . ">" . htmlspecialchars($_COOKIE['message']) . "</h6>";
                        setcookie('message', '', time() - 3600, '/');
                    } ?>
                    <form method="POST" action="actions.php">

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email address" />
                            <label class="form-label" for="email">Email address</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter password" />
                            <label class="form-label" for="password">Password</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" value="" name="remember" id="remember" />
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <!-- <a href="#!" class="text-body">Forgot password?</a> -->
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" name="login" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="register.php" class="link-danger">Register</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-success">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Copyright © 2023. All rights reserved.
            </div>
            <!-- Copyright -->

            <!-- Right -->
            <div>
                <a href="https://cvsu.edu.ph" target="_blank" class="text-white me-4">
                    Cavite State University
                </a>
                <a href="https://www.facebook.com/CaviteStateU" target="_blank" class="text-white me-4 bg-primary p-2 rounded-pill">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </div>
            <!-- Right -->
        </div>
    </section>


    <!-- Footer Imports -->
    <?php require_once('../include/footer.php') ?>
</body>

</html>