<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="index.php">
                <i class="bi bi-house-door"></i> <span>Home</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#antibiotics-nav" role="button">
                <i class="bi bi-capsule"></i> <span>Antibiotics</span> <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="antibiotics-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="../super-admin/pages-add-antibiotic.php">
                        <i class="bi bi-circle"></i> <span>Add Antibiotic</span>
                    </a>
                </li>
                <li>
                    <a href="../super-admin/pages-manage-antibiotic.php">
                        <i class="bi bi-circle"></i> <span>Manage Antibiotic</span>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#wards-nav" role="button">
                <i class="bi bi-building-fill-gear"></i> <span>Wards</span> <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="wards-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="../super-admin/pages-add-new-ward.php">
                        <i class="bi bi-circle"></i> <span>Add New Wards</span>
                    </a>
                </li>
                <li>
                    <a href="../super-admin/pages-manage-wards.php">
                        <i class="bi bi-circle"></i> <span>Manage Wards</span>
                    </a>
                </li>
            </ul>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#users-nav" role="button">
                <i class="bi bi-people"></i> <span>Users</span> <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="users-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="add-user.php">
                        <i class="bi bi-circle"></i> <span>Add User</span>
                    </a>
                </li>
                <li>
                    <a href="manage-admins.php">
                        <i class="bi bi-circle"></i> <span>Manage Users</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#admins-nav" role="button">
                <i class="bi bi-person-gear"></i> <span>Admins</span> <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="admins-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="add-admin.php">
                        <i class="bi bi-circle"></i> <span>Add Admin</span>
                    </a>
                </li>
                <li>
                    <a href="manage-super-admins.php">
                        <i class="bi bi-circle"></i> <span>Manage Admin</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="user-profile.php">
                <i class="bi bi-person-circle"></i> <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="logout.php">
                <i class="bi bi-box-arrow-right"></i> <span>Log Out</span>
            </a>
        </li>

    </ul>
</aside><!-- End Sidebar -->
