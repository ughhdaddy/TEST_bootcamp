<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        h2 { margin-top: 0; color: #1c1e21; margin-bottom: 1.5rem; }
        form { display: flex; flex-direction: column; }
        input { padding: 12px; margin-bottom: 1rem; border: 1px solid #dddfe2; border-radius: 6px; font-size: 16px; outline: none; }
        input:focus { border-color: #1877f2; }
        .btn-group { display: flex; gap: 10px; }
        button { flex: 2; padding: 12px; background-color: #1877f2; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold; }
        .back-link { flex: 1; display: flex; align-items: center; justify-content: center; text-decoration: none; background: #e4e6eb; color: #4b4f56; border-radius: 6px; font-weight: bold; font-size: 14px; }
        button:hover { background-color: #166fe5; }
        .back-link:hover { background: #d8dadf; }
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
include 'auth.php';
include 'db.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Not allowed!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_task = $_POST['task'];

    $stmt = $db->prepare("UPDATE tasks SET task = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$new_task, $id, $user_id]);

    header("Location: dashboard.php");
}
?>

<div class="card">
    <h2>Edit Task</h2>
    <form method="POST">
        <input type="text" name="task" value="<?= htmlspecialchars($task['task']) ?>" required autofocus>
        <div class="btn-group">
            <button>Update Task</button>
            <a href="dashboard.php" class="back-link">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>