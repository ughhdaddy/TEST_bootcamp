<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; margin: 0; color: #333; }
        .container { max-width: 600px; margin: 40px auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h2 { margin: 0; font-size: 20px; color: #2c3e50; }
        .logout-btn { text-decoration: none; color: #e74c3c; font-weight: bold; border: 1px solid #e74c3c; padding: 6px 12px; border-radius: 4px; transition: all 0.2s; }
        .logout-btn:hover { background: #e74c3c; color: white; }
        
        .task-form { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; gap: 10px; margin-bottom: 30px; }
        .task-form input { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 4px; outline: none; font-size: 16px; }
        .task-form button { padding: 12px 24px; background: #2ecc71; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .task-form button:hover { background: #27ae60; }

        ul { list-style: none; padding: 0; }
        li { background: white; margin-bottom: 10px; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .task-text { flex: 1; font-size: 16px; }
        .actions a { text-decoration: none; margin-left: 10px; font-size: 18px; filter: grayscale(1); transition: filter 0.2s; }
        .actions a:hover { filter: grayscale(0); }
        
        .empty-state { text-align: center; color: #95a5a6; margin-top: 40px; }
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

$user_id = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="header">
        <h2>Welcum, BATO "THE ROCK" DELA ROSA</h2>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <form action="add_task.php" method="POST" class="task-form">
        <input type="text" name="task" placeholder="What needs to be done?" required>
        <button>Add Task</button>
    </form>

    <?php if (empty($tasks)): ?>
        <p class="empty-state">No tasks yet. Add one above!</p>
    <?php else: ?>
        <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <span class="task-text"><?= htmlspecialchars($task['task']) ?></span>
                <div class="actions">
                    <a href="edit_task.php?id=<?= $task['id'] ?>" title="Edit">✏️</a>
                    <a href="delete_task.php?id=<?= $task['id'] ?>" title="Delete" onclick="return confirm('Are you sure?')">❌</a>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
</body>
</html>