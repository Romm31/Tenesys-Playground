<div class="admin-categories">
    <div class="container">
        <div class="toolbar">
            <h3>Categories</h3>
            <button id="btn-add-category">ADD</button>
        </div>
        <table>
            <tr class="head">
                <th>Sl.no</th>
                <th>Cat ID</th>
                <th>Category</th>
                <th>Challenges</th>
            </tr>

            <?php 
                // --- QUERY SQL DIPERBAIKI ---
                $sql = "SELECT cat_id, name FROM category ORDER BY cat_id";
                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $sl_no = 1; // Nomor urut dimulai dari 1
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        
                        // Menghitung jumlah challenge di setiap kategori
                        $cat_id = $row['cat_id'];
                        $sql_count = "SELECT COUNT(id) as challenge_count FROM challenges WHERE cat_id = $cat_id";
                        $result_count = mysqli_query($conn, $sql_count);
                        $row_count = mysqli_fetch_array($result_count, MYSQLI_ASSOC);
                        $challenge_count = $row_count['challenge_count'];

                        echo "<tr class='content'>";
                        echo "<td>".$sl_no."</td>";
                        echo "<td>".$row["cat_id"]."</td>";
                        echo "<td>".htmlspecialchars($row["name"])."</td>";
                        echo "<td>".$challenge_count."</td>";
                        echo "</tr>";
                        $sl_no++; // Tambah nomor urut untuk baris berikutnya
                    }
                } else {
                    echo "<tr><td colspan='4'>No categories found.</td></tr>";
                }
            ?>
        </table>
    </div>
</div>

<div id="modal-add-category" class="modal">
    <div class="modal-card">
        <h2>New Category</h2>
        <form action="/admin/controllers/add_category.php" method="POST">
            <input type="text" name="title" placeholder="Category Title" required/>
            <input type="submit" name="add_category" value="CREATE">
        </form>
        <button id="btn-modal-close" class="btn-close"><img src="/images/close.svg"/></button>
    </div>
</div>

<script src="/js/modal.js"></script>
<script>
    Modal.init("modal-add-category", "btn-add-category", "btn-modal-close");
</script>