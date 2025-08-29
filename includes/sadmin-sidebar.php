<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="index.php">
               <i class="bi bi-capsule"></i> <span>Antibiogram</span>
            </a>
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
