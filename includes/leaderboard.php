<div class="leaderboard">
    <h3>Leaderboard</h3>
    <table>
        <thead>
            <tr class="heading">
                <th>Rank</th>
                <th>Name</th>
                <th>Solved</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>

            <?php 

                // --- QUERY SQL TELAH DIPERBAIKI ---
                // Query ini lebih aman, kompatibel, dan mengurutkan berdasarkan skor tertinggi.
                $sql = "SELECT 
                            u.name, 
                            COUNT(sb.c_id) AS solved, 
                            IFNULL(SUM(ch.score), 0) AS score 
                        FROM 
                            users u 
                        LEFT JOIN scoreboard sb ON u.id = sb.user_id 
                        LEFT JOIN challenges ch ON sb.c_id = ch.id 
                        WHERE 
                            u.role = 'user' 
                        GROUP BY 
                            u.id, u.name 
                        ORDER BY 
                            score DESC, sb.ts ASC";
                
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $rank = 1; // Peringkat dibuat manual dengan PHP
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$rank."</td>";
                        echo "<td>".htmlspecialchars($row["name"])."</td>";
                        echo "<td>".$row["solved"]."</td>";
                        echo "<td>".$row["score"]."</td>";
                        echo "</tr>";
                        $rank++;
                    }
                } else {
                    echo "<tr><td colspan='4'>No data on leaderboard yet.</td></tr>";
                }

            ?>
            
        </tbody>
    </table>
</div>