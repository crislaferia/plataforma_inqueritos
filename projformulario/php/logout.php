<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <!-- ... (mesmo cabeçalho) ... -->
</head>
<body>
<?php include ('adeus.php'); ?>

    <script>
        setTimeout(function() {
            window.location.href = "loginadmin.php";
        }, 2000); 
    </script>
</body>
</html>
