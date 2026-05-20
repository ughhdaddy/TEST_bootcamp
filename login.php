<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); width: 100%; max-width: 380px; }
        h2 { margin-top: 0; color: #1c1e21; text-align: center; font-size: 24px; }
        form { display: flex; flex-direction: column; }
        input { padding: 14px; margin-bottom: 1rem; border: 1px solid #dddfe2; border-radius: 6px; font-size: 16px; outline: none; }
        input:focus { border-color: #1877f2; box-shadow: 0 0 0 2px #e7f3ff; }
        button { padding: 14px; background-color: #1877f2; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 18px; font-weight: bold; transition: background-color 0.2s; }
        button:hover { background-color: #166fe5; }
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
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<div class="card">
    <h2>Ughh daddy!!</h2>
    <?php if (isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Log In</button>
    </form>
    <div class="footer-link">
        <a href="register.php">Create new account</a>
    </div>
</div>
</body>
</html>