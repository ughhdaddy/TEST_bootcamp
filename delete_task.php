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

$stmt = $db->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

header("Location: dashboard.php");