<?php 
include 'admin_session.php';
include 'config.php';

$CHALLENGES = "challenges";
$LEADERBOARD = "leaderboard";
$VISITORS = "visitors";
$SETTINGS = "settings";
$CATEGORIES = "categories";
$DASHBOARD = "dashboard";

$current_page = "";

if (isset($_GET["p"]) && $_GET["p"] == $LEADERBOARD) {
    $current_page = $LEADERBOARD;
} else if (isset($_GET["p"]) && $_GET["p"] == $CHALLENGES){
    $current_page = $CHALLENGES;
}else if (isset($_GET["p"]) && $_GET["p"] == $VISITORS){
    $current_page = $VISITORS;
} else if (isset($_GET["p"]) && $_GET["p"] == $SETTINGS){
    $current_page = $SETTINGS;
} else if (isset($_GET["p"]) && $_GET["p"] == $DASHBOARD){
    $current_page = $DASHBOARD;
} else if (isset($_GET["p"]) && $_GET["p"] == $CATEGORIES){
    $current_page = $CATEGORIES;
} else {
    header('Location: admin.php?p=dashboard');
    die();
}

?>

<!DOCTYPE html>
<html>
<?php include 'includes/header.php' ?>
<body>
    <div class="admin-nav">
        <div class="nav">
            <ul>
                <?php 
                    if($current_page == $DASHBOARD){
<<<<<<< HEAD
                        echo "<li><a href='?p=dashboard' class='active'>Dashboard</a></li>
                        <li><a href='?p=leaderboard' >Leaderboard</a></li>
=======
                        echo "<li><a href='?p=dashboard' class='active'>DashBoard</a></li>
                        <li><a href='?p=leaderboard' >LeaderBoard</a></li>
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
                        <li><a href='?p=challenges' >Challenges</a></li>
                        <li><a href='?p=categories'>Categories</a></li>
						<li><a href='?p=visitors'>Visitors</a></li>
                        <li><a href='?p=settings'>Settings</a></li>";
                    } else if ($current_page == $LEADERBOARD) {
<<<<<<< HEAD
                        echo "<li><a href='?p=dashboard' >Dashboard</a></li>
                            <li><a href='?p=leaderboard' class='active'>Leaderboard</a></li>
=======
                        echo "<li><a href='?p=dashboard' >DashBoard</a></li>
                            <li><a href='?p=leaderboard' class='active'>LeaderBoard</a></li>
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
                            <li><a href='?p=challenges' >Challenges</a></li>
                            <li><a href='?p=categories'>Categories</a></li>
							<li><a href='?p=visitors'>Visitors</a></li>
                            <li><a href='?p=settings'>Settings</a></li>";
                    }else if ($current_page == $CHALLENGES) {
<<<<<<< HEAD
                        echo "<li><a href='?p=dashboard' >Dashboard</a></li>
                        <li><a href='?p=leaderboard' >Leaderboard</a></li>
=======
                        echo "<li><a href='?p=dashboard' >DashBoard</a></li>
                        <li><a href='?p=leaderboard' >LeaderBoard</a></li>
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
                        <li><a href='?p=challenges' class='active'>Challenges</a></li>
                        <li><a href='?p=categories'>Categories</a></li>
						<li><a href='?p=visitors'>Visitors</a></li>
                        <li><a href='?p=settings'>Settings</a></li>";
                    }else if ($current_page == $CATEGORIES) {
<<<<<<< HEAD
                        echo "<li><a href='?p=dashboard' >Dashboard</a></li>
                            <li><a href='?p=leaderboard' >Leaderboard</a></li>
=======
                        echo "<li><a href='?p=dashboard' >DashBoard</a></li>
                            <li><a href='?p=leaderboard' >LeaderBoard</a></li>
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
                            <li><a href='?p=challenges' >Challenges</a></li>
                            <li><a href='?p=categories' class='active'>Categories</a></li>
							<li><a href='?p=visitors'>Visitors</a></li>
                            <li><a href='?p=settings'>Settings</a></li>";
                    }else if ($current_page == $VISITORS) {
<<<<<<< HEAD
                        echo "<li><a href='?p=dashboard' >Dashboard</a></li>
                        <li><a href='?p=leaderboard' >Leaderboard</a></li>
=======
                        echo "<li><a href='?p=dashboard' >DashBoard</a></li>
                        <li><a href='?p=leaderboard' >LeaderBoard</a></li>
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
                        <li><a href='?p=challenges' >Challenges</a></li>
                        <li><a href='?p=categories'>Categories</a></li>
						<li><a href='?p=visitors' class='active'>Visitors</a></li>
                        <li><a href='?p=settings'>Settings</a></li>";
                    }else if ($current_page == $SETTINGS) {
<<<<<<< HEAD
                        echo "<li><a href='?p=dashboard' >Dashboard</a></li>
                        <li><a href='?p=leaderboard' >Leaderboard</a></li>
=======
                        echo "<li><a href='?p=dashboard' >DashBoard</a></li>
                        <li><a href='?p=leaderboard' >LeaderBoard</a></li>
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
                        <li><a href='?p=challenges' >Challenges</a></li>
                        <li><a href='?p=categories'>Categories</a></li>
						<li><a href='?p=visitors'>Visitors</a></li>
                        <li><a href='?p=settings' class='active'>Settings</a></li>";
                    }
                ?>
            </ul>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>
    <?php 
        if($current_page == $DASHBOARD){
            include 'admin/dashboard.php';
        } else if ($current_page == $LEADERBOARD) {
            include 'admin/leaderboard.php';
        }else if ($current_page == $CHALLENGES) {
           include 'admin/challenges.php';
        }else if ($current_page == $CATEGORIES) {
            include 'admin/categories.php';
        }else if ($current_page == $VISITORS) {
            include 'admin/visitors.php';
        }else if ($current_page == $SETTINGS) {
            include 'admin/settings.php';
        }
    ?>
</body>
</html>