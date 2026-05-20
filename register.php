<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); width: 100%; max-width: 380px; }
        h2 { margin-top: 0; color: #1c1e21; text-align: center; font-size: 24px; }
        form { display: flex; flex-direction: column; }
        input { padding: 14px; margin-bottom: 1rem; border: 1px solid #dddfe2; border-radius: 6px; font-size: 16px; outline: none; }
        input:focus { border-color: #42b72a; box-shadow: 0 0 0 2px #ebf5e7; }
        button { padding: 14px; background-color: #42b72a; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 18px; font-weight: bold; transition: background-color 0.2s; }
        button:hover { background-color: #36a420; }
        .footer-link { margin-top: 1.5rem; text-align: center; border-top: 1px solid #dddfe2; padding-top: 1.5rem; }
        .footer-link a { color: #1877f2; text-decoration: none; font-weight: 500; }
        .error { color: #f02849; text-align: center; margin-bottom: 1rem; font-size: 14px; }
    </style>
</head>
<body>
<script>
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};
</script>

<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if ($username && $password) {
        try {
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $password]);
            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            $error = "Username already exists!";
        }
    }
}
?>

<div class="card">
    <h2>Register</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Sign Up</button>
    </form>
    <div class="footer-link">
        <a href="login.php">Already have an account?</a>
    </div>
</div>
</body>
</html>