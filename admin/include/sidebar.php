<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="dashboard.php">
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
                    <a class="nav-link" href="branches.php">
                        <i class="fa fa-landmark"></i>
                        <span>Branches</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="records.php">
                        <i class="fa fa-bars-staggered"></i>
                        <span>Records</span>
                    </a>
                </li>

            </ul>
        </li>

        <li class="nav-item">
            <hr class="nav-divider">
        </li>

        <li class="nav-item">
            <a class="nav-link collapsible" data-bs-target="#data-nav" data-bs-toggle="collapse" href="#">
                <i class="fa fa-users"></i>
                <span>User Management</span>
                <i class="fa fa-chevron-down ms-auto"></i>
            </a>
            <ul id="data-nav" class="nav-content show" data-bs-parent="#sidebar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="coordinators.php">
                        <i class="fa fa-user-tie"></i>
                        <span>Coordinators</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="administrators.php">
                        <i class="fa fa-user-shield"></i>
                        <span>Administrators</span>
                    </a>
                </li>

            </ul>
        </li>

    </ul>
</aside>
<!-- ======= End Sidebar ======= -->