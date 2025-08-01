<?php
// Notifikasi jika password gagal, sukses, atau kosong
if (isset($_GET['pass_update'])) {
    $msg = '';
    $type = 'error'; // default error

    if ($_GET['pass_update'] === 'failed') {
        $msg = "❌ Incorrect current password!";
    } elseif ($_GET['pass_update'] === 'success') {
        $msg = "✅ Password updated successfully!";
        $type = 'success';
    } elseif ($_GET['pass_update'] === 'empty') {
        $msg = "⚠️ New password cannot be empty!";
    }

    if ($msg !== '') {
        echo "<script>
            window.addEventListener('DOMContentLoaded', function() {
                myToast?.show" . ucfirst($type) . "?.(" . json_encode($msg) . ", null);
            });
        </script>";
    }
}
?>

<div class="settings">
    
    <h3>Settings</h3>
    <form action="includes/edit_profile.php" method="POST">
        <label>Full Name</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($login_username); ?>">
        <input type="submit" name="change-name" value="change">
    </form>
    <form id="form-password" action="includes/edit_profile.php" method="POST">
        <label>Password</label>
        <input type="password" name="old-password" placeholder="Old Password">
        <input type="password" id="pswd1" name="new-password" placeholder="New Password">
        <input type="password" id="pswd2" placeholder="Retype new Password">
        <input type="submit" name="change-password" value="change">
    </form>

    <script>
        let form = document.getElementById('form-password');
        form.addEventListener('submit', function(e) {
            let pswd1 = document.getElementById('pswd1').value.trim();
            let pswd2 = document.getElementById('pswd2').value.trim();
            
            if (pswd1 !== "" || pswd2 !== "") {
                if (pswd1 !== pswd2) {
                    e.preventDefault(); 
                    myToast?.showError?.("Passwords don't match", null);
                }
            }
        });
    </script>
</div>
