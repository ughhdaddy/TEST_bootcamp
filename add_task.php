<script>
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};
</script>

<?php
include 'auth.php';
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = trim($_POST['task']);

    if (!empty($task)) {
        $stmt = $db->prepare("INSERT INTO tasks (user_id, task) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $task]);
    }
}

header("Location: dashboard.php");