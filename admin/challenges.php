<div class="admin-challenges">
    <div class="container">
        <div class="toolbar">
            <h3>Challenges</h3>
            <button id="btn-add-challenge">ADD</button>
        </div>
<<<<<<< HEAD

=======
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
        <table>
            <tr class="head">
                <th>Sl.no</th>
                <th>Title</th>
                <th>Category</th>
                <th>Score</th>
                <th>Solved</th>
<<<<<<< HEAD
                <th>Actions</th>
            </tr>

            <?php 
                require_once 'config.php';

                $sql = "SELECT ch.id, ch.title, ch.description, ch.score, ch.cat_id, ch.flag, cat.name 
                        FROM challenges ch 
                        JOIN category cat ON ch.cat_id = cat.cat_id 
                        ORDER BY ch.id";
                $result = mysqli_query($conn, $sql);
                
                if ($result && mysqli_num_rows($result) > 0) {
                    $sl_no = 1;
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $challenge_id = $row['id'];

                        $sql_solved = "SELECT COUNT(s_id) as solved_count FROM scoreboard WHERE c_id = $challenge_id";
                        $result_solved = mysqli_query($conn, $sql_solved);
                        $row_solved = mysqli_fetch_array($result_solved, MYSQLI_ASSOC);
                        $solved_count = $row_solved['solved_count'] ?? 0;

                        echo "<tr class='content'>";
                        echo "<td>".$sl_no."</td>";
                        echo "<td><a href='/challenge.php?id=".$challenge_id."' target='_blank'>".htmlspecialchars($row["title"])."</a></td>";
                        echo "<td>".htmlspecialchars($row["name"])."</td>";
                        echo "<td>".$row["score"]."</td>";
                        echo "<td>".$solved_count."</td>";
                        echo "<td>
                                <a href='#' class='btn-edit'
                                    data-id='".$challenge_id."'
                                    data-title=\"".htmlspecialchars($row['title'])."\"
                                    data-description=\"".htmlspecialchars($row['description'])."\"
                                    data-category=\"".$row['cat_id']."\"
                                    data-score=\"".$row['score']."\"
                                    data-flag=\"".htmlspecialchars($row['flag'])."\"
                                >Edit</a>
                                <a href='/admin/controllers/delete_challenge.php?id=$challenge_id' class='btn-delete' onclick=\"return confirm('Are you sure you want to delete this challenge?');\">Delete</a>
                              </td>";
=======
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
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
                        echo "</tr>";
                        $sl_no++;
                    }
                } else {
<<<<<<< HEAD
                    echo "<tr><td colspan='6'>No challenges found.</td></tr>";
=======
                    echo "<tr><td colspan='5'>No challenges found.</td></tr>";
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
                }
            ?>
        </table>
    </div>
</div>

<<<<<<< HEAD
<!-- MODAL: Add Challenge -->
=======
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
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
<<<<<<< HEAD
        <button id="btn-modal-close" class="btn-close"><img src="/images/close.svg"/></button>
    </div>
</div>

<!-- MODAL: Edit Challenge -->
<div id="modal-edit-challenge" class="modal">
    <div class="modal-card">
        <h2>Edit Challenge</h2>
        <form action="/admin/controllers/update_challenge.php" method="POST">
            <input type="hidden" name="id" id="edit-id" />
            <input type="text" name="title" id="edit-title" placeholder="Challenge Title" required/>
            <textarea name="description" id="edit-description" placeholder="Challenge Description" required></textarea>
            <div class="row">
                <select name="cat_id" id="edit-cat_id" required>
                    <option value="" disabled>Choose category</option>
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
                <input type="number" name="score" id="edit-score" placeholder="Score" required/>
                <input type="text" name="flag" id="edit-flag" placeholder="Flag" required/>
            </div>
            <input type="submit" name="update_challenge" value="UPDATE">
        </form>
        <button id="btn-edit-close" class="btn-close"><img src="/images/close.svg"/></button>
    </div>
</div>

<!-- Script: Modal Handling -->
<script src="/js/modal.js"></script>
<script>
    Modal.init("modal-add-challenge", "btn-add-challenge", "btn-modal-close");

    const modalEdit = document.getElementById('modal-edit-challenge');
    const btnCloseEdit = document.getElementById('btn-edit-close');

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            document.getElementById('edit-id').value = btn.dataset.id;
            document.getElementById('edit-title').value = btn.dataset.title;
            document.getElementById('edit-description').value = btn.dataset.description;
            document.getElementById('edit-cat_id').value = btn.dataset.category;
            document.getElementById('edit-score').value = btn.dataset.score;
            document.getElementById('edit-flag').value = btn.dataset.flag;
            modalEdit.style.display = 'block';
        });
    });

    btnCloseEdit.addEventListener('click', () => {
        modalEdit.style.display = 'none';
    });
</script>

<style>
    .btn-edit, .btn-delete {
        padding: 4px 8px;
        margin-right: 5px;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        font-size: 14px;
    }

    .btn-edit {
        background-color: #2d8cff;
    }

    .btn-delete {
        background-color: #ff3b3b;
    }

    .btn-edit:hover, .btn-delete:hover {
        opacity: 0.8;
    }

    .modal-card input, .modal-card textarea, .modal-card select {
        margin-bottom: 10px;
    }
</style>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
}

.modal-card {
    background-color: #121a2f;
    color: white;
    margin: auto;
    padding: 20px;
    border-radius: 8px;
    max-width: 800px;
    width: 95%;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    animation: fadeIn 0.3s ease-in-out;
}

.modal.show {
    display: flex;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
</style>
=======
        <button id="btn-modal-close"class="btn-close"><img src="/images/close.svg"/></button>
    </div>
</div>

<script src="/js/modal.js"></script>
<script>
    Modal.init("modal-add-challenge", "btn-add-challenge", "btn-modal-close");
</script>
>>>>>>> 219c0d84be18af48f1d4c831999d5e6e4aa0e12c
