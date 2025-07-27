<?php 
    include 'config.php';

    // --- BLOK PHP DIPERBAIKI ---
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-message'])) { // Typo diperbaiki

        // Mengamankan input dari user
        $visitor_name = mysqli_real_escape_string($conn, $_POST['name']);
        $visitor_email = mysqli_real_escape_string($conn, $_POST['email']);
        $visitor_message = mysqli_real_escape_string($conn, $_POST['message']);

        // Menggunakan query yang lebih aman (prepared statement)
        $sql = "INSERT INTO visitors (id, name, email, message) VALUES (NULL, ?, ?, ?)";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $visitor_name, $visitor_email, $visitor_message);
        
        if(mysqli_stmt_execute($stmt)) {
            // Beri pesan sukses jika berhasil dan segarkan halaman
            echo "<script>
                    alert('Message sent! Thank you for contacting us.');
                    window.location.href='contact-us.php';
                  </script>";
            exit();
        } else {
            // Beri pesan error jika gagal
            echo "<script>alert('Gagal mengirim pesan. Silakan coba lagi.');</script>";
        }
    }
?>
<html>
<head>
    <?php 
    include 'includes/header.php';
    ?>
</head>

<body>
    <div class="background"></div>
    <div class="foreground"></div>
    <nav>
        <div class="nav-container">
        </div>
    </nav>
    <div class="main-container">
        <div class="login-card">
            <form id="contact-form" method="post" action="contact-us.php">
                <input name="name" type="text" class="form-control" placeholder="Your Name" required>
                <input name="email" type="email" class="form-control" placeholder="Your Email" required>
                <textarea name="message" class="form-control" placeholder="Message" row="4" required></textarea>
                <input type="submit" class="form-control submit" name="submit-message" value="SEND MESSAGE">
            </form>     
        </div>
    </div>
</body>
</html>