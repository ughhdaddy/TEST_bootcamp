<script>
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};
</script>

<?php
session_start();
session_destroy();
header("Location: login.php");