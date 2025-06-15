<div class="admin-challenges">
    <div class="container">
        <div class="toolbar">
            <h3>Challenges</h3>
            <button id="btn-add-challenge">ADD</button>
        </div>
        <table>
            <tr class="head">
                <th>Sl.no</th>
                <th>Title</th>
                <th>Category</th>
                <th>Score</th>
                <th>Solved</th>
            </tr>

            <?php 
                // --- QUERY SQL DIPERBAIKI ---
                $sql = "SELECT ch.id, ch.title, ch.score, cat.name FROM challenges ch JOIN category cat ON ch.cat_id = cat.cat_id ORDER BY ch.id";
                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $sl_no = 1; // Nomor urut dibuat dengan PHP
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        
                        // Menghitung berapa kali soal ini diselesaikan
                        $challenge_id = $row['id'];
                        $sql_solved = "SELECT COUNT(s_id) as solved_count FROM scoreboard WHERE c_id = $challenge_id";
                        $result_solved = mysqli_query($conn, $sql_solved);
                        $row_solved = mysqli_fetch_array($result_solved, MYSQLI_ASSOC);
                        $solved_count = $row_solved['solved_count'];

                        echo "<tr class='content'>";
                        echo "<td>".$sl_no."</td>";
                        echo "<td>".htmlspecialchars($row["title"])."</td>";
                        echo "<td>".htmlspecialchars($row["name"])."</td>";
                        echo "<td>".$row["score"]."</td>";
                        echo "<td>".$solved_count."</td>";
                        echo "</tr>";
                        $sl_no++;
                    }
                } else {
                    echo "<tr><td colspan='5'>No challenges found.</td></tr>";
                }
            ?>
        </table>
    </div>
</div>

<div id="modal-add-challenge" class="modal">
    <div class="modal-card">
        <h2>New Challenge</h2>
        <form action="/admin/controllers/add_challenge.php" method="POST">
            <input type="text" name="title" placeholder="Challenge Title" required/>
            <textarea name="description" placeholder="Challenge Description" required></textarea>
            <div class="row">
                <select name="cat_id" required>
                    <option value="" disabled selected>Choose category</option>
                    <?php 
                        $sql_cat = "SELECT cat_id, name FROM category ORDER BY name";
                        $result_cat = mysqli_query($conn, $sql_cat);
                        if ($result_cat && mysqli_num_rows($result_cat) > 0) {
                            while ($row_cat = mysqli_fetch_array($result_cat, MYSQLI_ASSOC)) {
                                echo "<option value=\"".$row_cat["cat_id"]."\">".htmlspecialchars($row_cat["name"])."</option>";
                            }
                        }
                    ?>
                </select>
                <input type="number" placeholder="Score" name="score" required/>
                <input type="text" placeholder="Flag" name="flag" required/>
            </div>
            <input type="submit" name="add_challenge" value="CREATE">
        </form>
        <button id="btn-modal-close"class="btn-close"><img src="/images/close.svg"/></button>
    </div>
</div>

<script src="/js/modal.js"></script>
<script>
    Modal.init("modal-add-challenge", "btn-add-challenge", "btn-modal-close");
</script>