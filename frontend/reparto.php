
<?php
	session_start();
    require_once 'C:\Users\Angelapia\siti\scheduler\config\db.php';
   /* if(!isset($_SESSION['username'])){
        header("Location:index.php");
    }*/
    $user = $_SESSION['username'];
?>	

<?php

    if(isset($_POST['reparto'])){
        pg_prepare($db,"add_rep","INSERT INTO reparto values ($1,$2,$3)");
        pg_prepare($db,"search","SELECT * FROM reparto WHERE codice=$1");
        pg_prepare($db,"search2","SELECT * FROM reparto WHERE nome_reparto=$1");

        $codice=$_POST['Codice_reparto'];
        $nome=$_POST['Nome_reparto'];
        $numero_dip=0;
        $res = pg_execute($db,"search",array($codice));
        $row = pg_fetch_assoc($res);
       $res2 = pg_execute($db,"search2",array($nome));
        $row2 = pg_fetch_assoc($res2);
            if(isset($row['codice'])){
                $codice_err="Codice già in uso, riprovare";
            } elseif(isset($row2['nome_reparto'])){
                $nome_err="Nome reparto già in uso, riprovare";
            }else {
                pg_execute($db,"add_rep",array($codice,$nome,$numero_dip));
                $msg = "Reparto aggiunto correttamente";
            }
        }
    
?>

<html>
    <head>
        <title>Reparto</title>
        <link rel="stylesheet" type="text/css" href="../styles/registrazione.css">

    </head>

    <body>
    <div class="header">
            <?php include 'header.php'; ?>
    </div>
    <div class="container">

    <div class="content">
            <div class="form_cont">
                <form id="reparto_form"   method="post" autocomplete="off">
                    <div class="reparto_title"><h3>AGGIUNGI REPARTO</h3></div>
                    <div id="codice" ><input id="input_codice"  type="number" name="Codice_reparto" placeholder="Codice reparto" required></div><br>
                    <div id="err"><?php if(isset($codice_err)) echo $codice_err; ?></div>

                    <div id="nome" ><input id="input_nome"  type="text" name="Nome_reparto" placeholder="Nome reparto" required></div><br>
                    <div id="err2"><?php if(isset($nome_err)) echo $nome_err; ?></div>

                    <div id="numero_dip" ><input id="input_dipendenti"  type="number"  min="0" name="Numero_dipendenti" placeholder="Numero dipendenti: 0" disabled ></div><br>
                   
                </form>
                    <div class="inblock">
                        <div class="subm"><button id="Aggiungi_reparto" form="reparto_form" type="submit" name="reparto">AGGIUNGI</button></div>
                        <div class="subm login"><form action="index.php">
                                                    <button type="submit" name="index">TORNA ALLA HOME</button>
                                                </form></div>
                    </div>
                
                <div id="msg"><?php if(isset($msg)) echo $msg; ?></div>
            </div>

            </div>
            <?php include '../static_content/footer.html'; ?>
             </div>     
    </body>
</html>