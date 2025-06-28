<?php 
    include 'config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-message'])) {
        $visitor_name    = mysqli_real_escape_string($conn, $_POST['name']);
        $visitor_email   = mysqli_real_escape_string($conn, $_POST['email']);
        $visitor_phone   = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : null;
        $visitor_message = mysqli_real_escape_string($conn, $_POST['message']);

        $sql = "INSERT INTO visitors (id, name, email, phone, message) VALUES (NULL, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $visitor_name, $visitor_email, $visitor_phone, $visitor_message);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>
                    alert('Message sent successfully! Thank you for contacting us.');
                    window.location.href='contact-password.php';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Failed to send message. Please try again.');</script>";
        }
    }
?>
<html>
<head>
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <div class="background"></div>
    <div class="foreground"></div>
    <nav>
        <div class="nav-container"></div>
    </nav>
    <div class="main-container">
        <div class="login-card">
            <form id="contact-form" method="post" action="contact-password.php">
                <input name="name" type="text" class="form-control" placeholder="Your Name" required>
                <input name="email" type="email" class="form-control" placeholder="Your Email" required>
                <input name="phone" type="text" class="form-control" placeholder="Phone Number (optional)">
                <textarea name="message" class="form-control" placeholder="Message" rows="4" required></textarea>
                <input type="submit" class="form-control submit" name="submit-message" value="SEND MESSAGE">
            </form>     
        </div>
    </div>
</body>
</html>
