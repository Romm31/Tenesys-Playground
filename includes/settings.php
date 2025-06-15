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
            
            // Hanya jalankan pengecekan jika new-password diisi
            if (pswd1 !== "" || pswd2 !== "") {
                if (pswd1 !== pswd2) {
                    // Jika password tidak cocok, hentikan pengiriman form dan tampilkan error
                    e.preventDefault(); 
                    myToast.showError("Passwords doesn't match", null);
                }
                // Jika password cocok, biarkan form terkirim secara normal
            }
        });
    </script>
</div>