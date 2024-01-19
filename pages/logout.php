<?php
session_start();
if (isset($_SESSION['funame'])) {
    session_destroy();
?>
    <script>
        alert('Log out Succesfully... <?php echo $_SESSION['funame'];?> !');
        window.location.href = "../frontend/index.php";
    </script>
<?php
} else {
?>
    <script>
        alert('Login First...');
        window.location.href = "login.php";
    </script>
<?php

}
