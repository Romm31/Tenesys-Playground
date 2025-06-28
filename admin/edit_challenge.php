<?php
require '../admin_session.php';
require_once '../config.php';

$id = $_GET['id'] ?? 0;
$id = intval($id);

$sql = "SELECT * FROM challenges WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
?>
    <h2>Edit Challenge</h2>
    <form action="/admin/controllers/update_challenge.php" method="POST">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>
        <textarea name="description" required><?= htmlspecialchars($row['description']) ?></textarea>
        <select name="cat_id" required>
            <?php 
            $sql_cat = "SELECT cat_id, name FROM category ORDER BY name";
            $result_cat = mysqli_query($conn, $sql_cat);
            while ($cat = mysqli_fetch_assoc($result_cat)) {
                $selected = $cat['cat_id'] == $row['cat_id'] ? 'selected' : '';
                echo "<option value=\"{$cat['cat_id']}\" $selected>".htmlspecialchars($cat['name'])."</option>";
            }
            ?>
        </select>
        <input type="number" name="score" value="<?= $row['score'] ?>" required>
        <input type="text" name="flag" value="<?= htmlspecialchars($row['flag']) ?>" required>
        <input type="submit" name="update_challenge" value="UPDATE">
    </form>
<?php 
} else {
    echo "Challenge not found.";
}
?>
