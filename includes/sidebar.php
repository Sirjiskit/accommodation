<nav class="ts-sidebar" style="background-color:#89CFF0">
    <ul class="ts-sidebar-menu">

        <li class="ts-label" style="color:white; font-size:15px; text-align: center;">ATC Jalingo</li>
        <hr>

        <?PHP if (isset($_SESSION['id'])) {
            ?>
            <?php
            $aid = $_SESSION['id'];
            $result1 = "SELECT count(*) FROM roommate_char where roommate_id ='$aid' AND roommate='0'"; //sql query
            $stmt1 = $mysqli->prepare($result1);
            $stmt1->execute();
            $stmt1->bind_result($count1);
            $stmt1->fetch();
            $stmt1->close();
            ?>
            <?php if ($_SESSION['type'] == "student") { ?>
                <li><a href="dashboard.php"><i class="fa fa-desktop"></i>Dashboard</a></li>

                <li><a href="room-mate.php"><i class="fa fa-search"></i>Search for Room-mate</a></li>
                <li><a href="book-accommodation.php"><i class="fa fa-search"></i>Search accommodation</a></li>
                <li><a href="room-details.php"><i class="fa fa-eye"></i>View accommodation</a></li>
                <li><a href="roommate_request.php"><i class="fa fa-male"></i>View (<?php echo $count1; ?>) pending request</a></li>
                <li><a href="#"><i class="fa fa-user"></i>My Profile</a>
                    <ul>
                        <li><a href="my-profile.php"><b>My Account</b></a></li>
                        <li><a href="logout.php"><b>Logout</b></a></li>
                    </ul>
                </li>
            <?php } if ($_SESSION['type'] == "admin") { ?>
                <li class="ts-label">Reports</li>
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="#"><i class="fa fa-desktop"></i> House</a>
                    <ul>
                        <li><a href="create-house.php">Add House</a></li>
                        <li><a href="manage-houses.php">Manage Houses</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fa fa-desktop"></i> Rooms</a>
                    <ul>
                        <li><a href="create-room.php">Add a Room</a></li>
                        <li><a href="manage-rooms.php">Manage Rooms</a></li>
                    </ul>
                </li>
                <li><a href="manage-students.php"><i class="fa fa-users"></i>Manage Students</a></li>
            <?php } if ($_SESSION['type'] == "school") { ?>
                <li class="ts-label">Reports</li>
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <li><a href="landload.php"><i class="fa fa-users"></i>Landlord</a></li>
                <li><a href="manage-students.php"><i class="fa fa-users"></i>Manage Students</a></li>
                <li><a href="report.php"><i class="fa fa-list-alt"></i>Report</a></li>
            <?php } ?>
            <li><a href="logout.php"><i class="fa fa-circle-o-notch"></i>Logout</a></li>
        <?php } else { ?>
            <li class="ts-label" style="color:white;">Online accommodation Portal</li>
            <li class="ts-label" style="color:white;">Student should Login with there Admission number and School password as your password</li>

            <li class="ts-label" style="color:white;">Landlord should Login with there email Address as Admission number and password</li>

            <hr>

            <li><a href="index.php"><i class="fa fa-users"></i>Login Page</a></li>
            <li><a href="registration.php"><i class="fa fa-files-o"></i> Landlord Registration</a></li>
            <li><a href="student_registration.php"><i class="fa fa-files-o"></i> Student Registration</a></li>
            <?php } ?>

    </ul>
</nav>