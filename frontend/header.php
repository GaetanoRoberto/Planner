
<html>
<head>
<link href="../styles/login.css" type="text/css" rel="stylesheet">
</head>
<body>
<h1>Scheduler</h1>
<?php if (isset($_SESSION['username']))
 echo "<h5>Benvenuto " . $_SESSION['username'] . "! Oggi è il giorno " .  date("d/m/Y") . "</h5>" 
 ?>
                <form name="logout" id="logout" action="logout.php" method="post">
                    <button id="logout_btn" class="bottone"  type="submit" >Logout</button>
                </form></body>
</html>