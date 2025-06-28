<?php 
    include 'session.php';
    if (!isset($conn)) {
        include 'config.php';
    }
?>
<!DOCTYPE html>
<html>

<?php include 'includes/header.php' ?>


<link rel="stylesheet" href="css/sidebar-toggle.css">

<?php 
    $CHALLENGES = "challenges";
    $LEADERBOARD = "leaderboard";
    $SETTINGS = "settings";

    $current_page = $CHALLENGES;

    if (isset($_GET["p"]) && $_GET["p"] == $LEADERBOARD) {
        $current_page = $LEADERBOARD;
    } else if (isset($_GET["p"]) && $_GET["p"] == $CHALLENGES){
        $current_page = $CHALLENGES;
    } else if (isset($_GET["p"]) && $_GET["p"] == $SETTINGS){
        $current_page = $SETTINGS;
    } else {
        header('Location: dashboard.php?p=challenges');
        die();
    }
?>
<body>
<?php 

    $sql_user_stats = "SELECT COUNT(sb.c_id) as solved, IFNULL(SUM(ch.score), 0) as score 
                       FROM users u 
                       LEFT JOIN scoreboard sb ON u.id = sb.user_id 
                       LEFT JOIN challenges ch ON sb.c_id = ch.id 
                       WHERE u.id = '$login_user_id' 
                       GROUP BY u.id";
    $result_user = mysqli_query($conn, $sql_user_stats);

    $user_score = 0;
    $user_solve = 0;
    if ($result_user && mysqli_num_rows($result_user) > 0) {
        $row_user = mysqli_fetch_array($result_user, MYSQLI_ASSOC);
        $user_score = $row_user['score'];
        $user_solve = $row_user['solved'];
    }

    $user_rank = "-"; // Default rank
    $sql_leaderboard = "SELECT u.id, IFNULL(SUM(ch.score), 0) AS total_score 
                        FROM users u 
                        LEFT JOIN scoreboard sb ON u.id = sb.user_id 
                        LEFT JOIN challenges ch ON sb.c_id = ch.id 
                        WHERE u.role = 'user' 
                        GROUP BY u.id 
                        ORDER BY total_score DESC, sb.ts ASC";
    $result_leaderboard = mysqli_query($conn, $sql_leaderboard);
    
    if ($result_leaderboard) {
        $rank_counter = 1;
        while ($row_leaderboard = mysqli_fetch_assoc($result_leaderboard)) {
            if ($row_leaderboard['id'] == $login_user_id) {
                $user_rank = $rank_counter;
                break; 
            }
            $rank_counter++;
        }
    }

    $users_count = 0;
    $challenges_count = 0;

    $sql_users = "SELECT count(id) as u_count FROM users WHERE role = 'user'";
    $result_users = mysqli_query($conn, $sql_users);
    if ($result_users && mysqli_num_rows($result_users) > 0) {
        $row_users = mysqli_fetch_array($result_users, MYSQLI_ASSOC);
        $users_count = $row_users['u_count'];
    }

    $sql_challenges = "SELECT count(id) as ch_count FROM challenges";
    $result_challenges = mysqli_query($conn, $sql_challenges);
    if ($result_challenges && mysqli_num_rows($result_challenges) > 0) {
        $row_challenges = mysqli_fetch_array($result_challenges, MYSQLI_ASSOC);
        $challenges_count = $row_challenges['ch_count'];
    }
?>
<div class="dash-container">
    <div class="dash-side-nav">
        <img src="images/head.png" alt="Logo" style="width: 120px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto;">
        <h2>Tenesys Playground</h2>
        <!-- FLAG: Tenesys{S3arch1ng-For-Th3-L0st-K3y5} -->
        <p class="nav-username"><?php echo htmlspecialchars($login_username); ?></p>
        <div class="score">
            <h1 class="score"><?php echo $user_score; ?></h1>
        </div>
        <div class="status">
            <div class="col">
                <h3><?php echo "$user_solve / $challenges_count"; ?></h3>
                <p>Solved</p>
            </div>
            <div class="col">
                <h3><?php echo "$user_rank / $users_count"; ?></h3>
                <p>Rank</p>
            </div>
        </div>
        <div class="links">
            <a href="about-us.html">About</a>
            <a href="contact-us.php">Contact Us</a>
        </div>
    </div>
    <div class="dash-content">
        <div class="dash-nav">
            <button id="toggleSidebar">☰</button>
            <div class="tabs">
                <ul>
                    <?php 
                        if ($current_page == $CHALLENGES) {
                            echo "<li><a href='dashboard.php?p=challenges' class='active'>Challenges</a></li>";
                            echo "<li><a href='dashboard.php?p=leaderboard'>Leaderboard</a></li>";
                            echo "<li><a href='dashboard.php?p=settings'>Settings</a></li>";
                        } else if($current_page == $LEADERBOARD) {
                            echo "<li><a href='dashboard.php?p=challenges'>Challenges</a></li>";
                            echo "<li><a href='dashboard.php?p=leaderboard' class='active'>Leaderboard</a></li>";
                            echo "<li><a href='dashboard.php?p=settings'>Settings</a></li>";
                        } else if($current_page == $SETTINGS) {
                            echo "<li><a href='dashboard.php?p=challenges'>Challenges</a></li>";
                            echo "<li><a href='dashboard.php?p=leaderboard'>Leaderboard</a></li>";
                            echo "<li><a href='dashboard.php?p=settings' class='active'>Settings</a></li>";
                        }  
                    ?>
                </ul>
            </div>
            <a href="logout.php" class="logout">Logout</a>
        </div>
        <div class="dash-challenge-container">
            <?php 
                if ($current_page == $CHALLENGES) {
                    include 'includes/challenges.php';
                } else if ($current_page == $LEADERBOARD){
                    include 'includes/leaderboard.php';
                } else if ($current_page == $SETTINGS) {
                    include 'includes/settings.php';
                }
            ?>
        </div>
    </div>
</div>

<div class="toast" id="toast">
    <h3 id="message">Error</h3>
</div>

<script>
let myToast = new Toast();
myToast.init(document.getElementById("toast")); 
</script>

<script src="js/sidebar-toggle.js"></script>

</body>
</html>
