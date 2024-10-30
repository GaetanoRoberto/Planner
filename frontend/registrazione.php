
<?php
    require_once 'C:\Users\Angelapia\siti\scheduler\config\db.php';
    if(isset($_POST['signin'])){
        pg_prepare($db,"sign_in","INSERT INTO utente values ($1,$2,$3,$4)");
        pg_prepare($db,"cerca_matricola","SELECT * FROM utente WHERE matricola = $1");
       pg_prepare($db,"cerca_username","SELECT * FROM utente WHERE username = $1");
       pg_prepare($db,"search_reparto","SELECT * FROM reparto WHERE nome_reparto=$1");
       pg_prepare($db,"add_reparto_dip","UPDATE reparto set num_dipendenti = (num_dipendenti + 1) where codice = $1");


        $matricola=$_POST['matricola'];
        $pass=$_POST['password'];
        $user=$_POST['username'];
        $reparto = $_POST['Reparto_attività'];
        
        $res = pg_execute($db,"cerca_matricola",array($matricola));
        $row = pg_fetch_assoc($res);
        $res2 = pg_execute($db,"cerca_username",array($user));
        $row2 = pg_fetch_assoc($res2);
        $res3 = pg_execute($db,"search_reparto",array($reparto));
        $row3 = pg_fetch_assoc($res3);
        $codice_reparto = $row3['codice']; 

            if(isset($row['matricola'])){
                $matricola_err="Matricola sbagliata o già registrata";
            } elseif(isset($row2['username'])){
                $username_err="Username già in uso, riprovare";
            }else {
                $pswhash = password_hash($pass,PASSWORD_DEFAULT);
                pg_execute($db,"add_reparto_dip",array($codice_reparto));
                pg_execute($db,"sign_in",array($matricola,$user,$pswhash,$codice_reparto));
                $msg = "Registrazione completata,  procedere con il login";
            }
        }
    
?>

<html>
    <head>
        <title>Registrazione</title>
        <link rel="stylesheet" type="text/css" href="../styles/registrazione.css">
        <script>
function validaModulo(modulo) {
    return false;
	var pass = modulo.input_pass.value;
	var repass = modulo.input_repass.value;
    var matricola = modulo.input_matricola.value;
	if(pass.length >= 7 && isUpper(pass) && pass != "" && pass == repass  && matricola!="")
		return true;
	else
		return false;
}</script>
    </head>

    <body>
    <div class="header">
            <?php include 'header.php'; ?>
    </div>
    <div class="container">

    <div class="content">
            <div class="form_cont">
                <form id="main_form" action="registrazione.php" onsubmit="return validaModulo(this);" method="post" autocomplete="off">
                    <div class="reg_title"><h2>REGISTRAZIONE</h2></div>
                    <div id="matr" class="usn"><input id="input_matricola"  type="number" min="1" name="matricola" placeholder="Matricola" required></div>
                    <div id="err2"><?php if(isset($matricola_err)) echo $matricola_err; ?></div>

                    <div id="usn" class="usn"><input id="input_username"  type="text" name="username" placeholder="Username" required></div>
                    <div id="err"><?php if(isset($username_err)) echo $username_err; ?></div>

                    <div class="psw"><input type="password" id="input_pass" name="password" onkeyup="checkPsw(this)" placeholder="Password" required></div>
                    <div class="warningAll">
                        <p class="warning" id="capsWarning">Inserisci almeno una lettera maiuscola.</p>
                        <p class="warning" id="lengthWarning">La password deve essere almeno lunga 7 caratteri.</p>
                        <p class="warning" id="checkEmpty">Inserisci una password.</p>
                    </div>

                    <div class="psw"><input type="password" id="input_repass" onkeyup="checkRepsw(this)" name="re_password" placeholder="Re-enter Password" required></div> 
                    <div class="warningAll">
                        <p class="warning" id="checkRpwd">Le password non coincidono</p>
                        <p class="warning" id="checkReEmpty">Inserisci una password.</p>
                    </div>
                    
                    <div id="reparto"><select name="Reparto_attività" id="Reparto_attività" style="height: 40px; width: 100%; "  required>
                    
                    
                     <?php  	
                        $query =  "SELECT * FROM reparto ";
                        $res = pg_query($db,$query);
                        $ris = pg_fetch_all($res);
                    
                        foreach($ris as $row){ ?>
                                         <option value=<?php echo $row["nome_reparto"];?> > <?php echo $row["nome_reparto"].": ".$row["num_dipendenti"]." dipendenti";?></option> 
                            <?php  }?> 

       

                    </select></div>
                    <!-- controllo con js -->
                </form>
                    <div class="inblock">
                        <div class="subm"><button id="registrati" form="main_form" type="submit" name="signin">REGISTRATI</button></div>
                        <div class="subm login"><form action="login.php">
                                                    <button type="submit" name="login">TORNA AL LOGIN</button>
                                                </form></div>
                    </div>
                
                <div id="msg"><?php if(isset($msg)) echo $msg; ?></div>
            </div>
            <script  type="text/javascript" src="../backend/registrazione.js"></script>

            </div>
            <?php include '../static_content/footer.html'; ?>
             </div>     
    </body>
</html>