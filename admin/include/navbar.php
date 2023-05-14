<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="dashboard.php" class="logo d-flex align-items-center text-decoration-none">
            <img src="../uploads/cvsu_logo.png" alt="">
            <span class="logo-text">Cavite State University</span>
        </a>

        <!-- Nav Responsive Button -->
        <i class="fa fa-bars toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <!-- <img src="assets/img/admin-profile.png" alt="Profile" class="rounded-circle"> -->
                    <span><?= $row['first_name']; ?> </span>
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                    </span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <span><?= $row['first_name'] . " " . $row['last_name']; ?> </span>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="fa fa-user"></i>
                            <span>Profile Settings</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="fa fa-users"></i>
                            <span>User Management</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="../logout/logout.php?id=<?php echo $id; ?>">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header>
<!-- End Header -->