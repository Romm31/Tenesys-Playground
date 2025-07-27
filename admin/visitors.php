<div class="admin-leaderboard">
    <div class="container">
        <div class="toolbar">
            <h3>User Queries</h3>
        </div>
        <table>
            <tr class="head">
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th> <!-- Kolom tambahan -->
                <th>Message</th>
            </tr>

            <?php 
                $sql = "SELECT id, name, email, phone, message FROM visitors";
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $count = mysqli_num_rows($result);
                if ($count > 0) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo "<tr class='content'>";
                        echo "<td>".$row["id"]."</td>";
                        echo "<td>".$row["name"]."</td>";
                        echo "<td>".$row["email"]."</td>";
                        echo "<td>".($row["phone"] ? $row["phone"] : "-")."</td>"; // tampilkan "-" jika kosong
                        echo "<td>".$row["message"]."</td>";
                        echo "</tr>";
                    }
                }
            ?>
        </table>
    </div>
</div>

<!-- Modal Bawah Tidak Diubah -->
<div id="modal-add-challenge" class="modal">
    <div class="modal-card">
        <h2>New Challenge</h2>
        <form action="admin/controllers/add_challenge.php" method="POST">
            <input type="text" name="title" placeholder="Challenge Title"/>
            <textarea name="description" placeholder="Challenge Description"></textarea>
            <div class="row">
                <select name="cat_id">
                    <option disabled selected>Choose category</option>
                    <?php 
                        $sql = "SELECT cat.cat_id, cat.name FROM category cat ORDER BY cat.cat_id";
                        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                echo "<option value=\"".$row["cat_id"]."\">".$row["name"]."</option>";
                            }
                        }
                    ?>
                </select>
                <input type="text" placeholder="Score" name="score" />
                <input type="text" placeholder="Flag" name="flag" />
            </div>
            <input type="submit" name="add_challenge" value="CREATE">
        </form>
        <button id="btn-modal-close" class="btn-close"><img src="images/close.svg"/></button>
    </div>
</div>

<script src="js/modal.js"></script>
<script>
    Modal.init("modal-add-challenge", "btn-add-challenge", "btn-modal-close");
</script>
