<?php

$coordinator_stmt = "SELECT COUNT(*) as coordinator_notif FROM users WHERE status = 'pending' AND role = 'coordinator'";
$coordinator_qry = mysqli_query($conn, $coordinator_stmt);
$coordinator_res = mysqli_fetch_assoc($coordinator_qry);

$admin_stmt = "SELECT COUNT(*) as admin_notif FROM users WHERE status = 'pending' AND role = 'admin'";
$admin_qry = mysqli_query($conn, $admin_stmt);
$admin_res = mysqli_fetch_assoc($admin_qry);
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="fa fa-chart-simple"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <hr class="nav-divider">
        </li>

        <li class="nav-item">
            <a class="nav-link collapsible" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
                <i class="fa fa-database"></i>
                <span>Data Management</span>
                <i class="fa fa-chevron-down ms-auto"></i>
            </a>
            <ul id="users-nav" class="nav-content show" data-bs-parent="#sidebar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="announcements.php">
                        <i class="fa fa-rss"></i>
                        <span>Announcements</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="records.php">
                        <i class="fa fa-chart-bar"></i>
                        <span>Records</span>
                    </a>
                </li>


            </ul>
        </li>

    </ul>
</aside>
<!-- ======= End Sidebar ======= -->