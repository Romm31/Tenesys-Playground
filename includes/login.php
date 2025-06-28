<form action="login.php" method="POST">
    <input type="text" name="email" placeholder="Email Address" required />
    <input type="password" name="password" placeholder="Password" required />

    <!-- Baris Remember Me & Forgot Password -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
        <label style="font-size: 0.9em;">
            <input type="checkbox" name="remember_me" style="margin-right: 4px;"> Remember Me
        </label>
        <a href="contact-password.php" style="font-size: 0.9em; color: #60a5fa; text-decoration: none;">
            Forgot your password?
        </a>
    </div>

    <input type="submit" name="login-submit" value="Sign In" style="margin-top: 12px;">
</form>
