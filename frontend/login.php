<?php
    session_start();
    require_once 'C:\Users\Angelapia\siti\scheduler\config\db.php';
    if(isset($_POST['login'])){
        $matricola = $_POST['matricola'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        pg_prepare($db,"search_matricola","SELECT * from utente where matricola=$1");
        $res= pg_execute($db,"search_matricola",array($matricola));
        $row=pg_fetch_assoc($res);
        if($row){
            $matr = $row['matricola'];
            $user = $row['username'];
            $pass = $row['password'];

        }
        if( $username == "admin" && $password == "admin" && $matricola == "999"){
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit();
        }elseif(!isset($user) || password_verify($password,$pass) === false){
            $Err_msg="username o password non corretti";

        } else {
            $_SESSION['username'] = $user;
            header('Location: calendario2.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="../styles/login.css">
    <script type="text/javascript" src="../backend/login.js"></script>

</head>


<body>
<div class="header">
            <?php include 'header.php'; ?>
</div>
<div class="container">

            <div class="content">
                <div class="form_cont">
                <form action="login.php" method="post" autocomplete="off">
                    <div class="log_title"><h2>LOGIN</h2></div>
                    <div class="matr"><input id="input_matricola" type="number" name="matricola" placeholder="Matricola" required></div>
                    <div class="usn"><input id="input_name" type="text" name="username" placeholder="Username"></div>
                    <div class="psw"><input id="input_psw" type="password" name="password" placeholder="Password" required></div>
                    <div id="msgerr"><?php if(isset($Err_msg)) echo $Err_msg; ?></div>
                    <div class="subm"><button type="submit" name="login">ACCEDI</button></div>
                    
    
                </form>
                <div class="reg_log">
                    Non sei un membro? <a href="registrazione.php">Registrati</a>!
                </div>

            </div>
            </div>

            </div>
            <?php include '../static_content/footer.html'; ?>


</body>
</html>