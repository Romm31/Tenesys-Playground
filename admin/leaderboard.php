<div class="admin-leaderboard">
    <div class="container">
        <div class="toolbar">
            <h3>LeaderBoard</h3>
        </div>
        <table>
            <tr class="head">
                <th>Rank</th>
                <th>Name</th>
                <th>Score</th>
                <th>Solved</th>
            </tr>

            <?php 
                // --- QUERY SQL DIPERBAIKI ---
                // Query ini lebih aman, kompatibel, dan mengurutkan berdasarkan skor tertinggi.
                // Juga hanya menampilkan user, bukan admin.
                $sql = "SELECT 
                            u.name, 
                            COUNT(sb.c_id) AS solved, 
                            IFNULL(SUM(ch.score), 0) AS sscore 
                        FROM 
                            users u 
                        LEFT JOIN scoreboard sb ON u.id = sb.user_id 
                        LEFT JOIN challenges ch ON sb.c_id = ch.id 
                        WHERE 
                            u.role = 'user' 
                        GROUP BY 
                            u.id, u.name 
                        ORDER BY 
                            sscore DESC, sb.ts ASC";

                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $rank = 1; // Peringkat dimulai dari 1
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo "<tr class='content'>";
                        echo "<td>".$rank."</td>";
                        echo "<td>".htmlspecialchars($row["name"])."</td>";
                        echo "<td>".$row["sscore"]."</td>";
                        echo "<td>".$row["solved"]."</td>";
                        echo "</tr>";
                        $rank++; // Tambah peringkat untuk baris berikutnya
                    }
                } else {
                    echo "<tr><td colspan='4'>No data on leaderboard yet.</td></tr>";
                }
            ?>
        </table>
    </div>
</div>