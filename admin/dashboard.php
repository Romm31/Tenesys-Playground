<?php 
    $admin_user_count = 0;
    $admin_challenge_count = 0;
    $admin_cat_count = 0;

    // Query untuk menghitung jumlah user
    $sql_users = "SELECT count(*) as count FROM users";
    $result_users = mysqli_query($conn, $sql_users);
    if ($result_users && mysqli_num_rows($result_users) > 0) {
        $row_users = mysqli_fetch_array($result_users, MYSQLI_ASSOC);
        $admin_user_count = $row_users['count'];
    }

    // Query untuk menghitung jumlah challenge
    $sql_challenges = "SELECT count(*) as count FROM challenges";
    $result_challenges = mysqli_query($conn, $sql_challenges);
    if ($result_challenges && mysqli_num_rows($result_challenges) > 0) {
        $row_challenges = mysqli_fetch_array($result_challenges, MYSQLI_ASSOC);
        $admin_challenge_count = $row_challenges['count'];
    }

    // Query untuk menghitung jumlah kategori
    $sql_cat = "SELECT count(*) as count FROM category";
    $result_cat = mysqli_query($conn, $sql_cat);
    if ($result_cat && mysqli_num_rows($result_cat) > 0) {
        $row_cat = mysqli_fetch_array($result_cat, MYSQLI_ASSOC);
        $admin_cat_count = $row_cat['count'];
    }
?>

<div class="admin-dashboard">
    <div class="dash-row">
        <div class="col">
            <h3>Users</h3>
            <h1><?php echo $admin_user_count ?></h1>
        </div>
        <div class="col">
            <h3>Challenges</h3>
            <h1><?php echo $admin_challenge_count ?></h1>
        </div>
        <div class="col">
<<<<<<< HEAD
            <h3>Categories</h3>
=======
            <h3>categories</h3>
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
            <h1><?php echo $admin_cat_count ?></h1>
        </div>
    </div>
    <div class="container">
    <div class="toolbar">
            <h3>Recent Solves</h3>
        </div>
        <table>
            <tr class="head">
                <th>Name</th>
                <th>Challenge</th>
                <th>Score</th>
            </tr>

            <?php 
                // --- QUERY SQL DIPERBAIKI ---
                // Menggunakan query yang lebih standar dan aman, diurutkan berdasarkan waktu terbaru
                $sql_solves = "SELECT u.name, ch.title, ch.score 
                               FROM scoreboard sb
                               JOIN users u ON sb.user_id = u.id
                               JOIN challenges ch ON sb.c_id = ch.id
                               ORDER BY sb.ts DESC
                               LIMIT 15"; // Dibatasi 15 data terbaru

                $result_solves = mysqli_query($conn, $sql_solves);
                
                if ($result_solves && mysqli_num_rows($result_solves) > 0) {
                    while ($row = mysqli_fetch_array($result_solves, MYSQLI_ASSOC)) {
                        echo "<tr class='content'>";
                        echo "<td>".htmlspecialchars($row["name"])."</td>";
                        echo "<td>".htmlspecialchars($row["title"])."</td>";
                        echo "<td>".$row["score"]."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No recent solves.</td></tr>";
                }
            ?>
        </table>
    </div>
</div>