<?php

    require_once 'C:\Users\Angelapia\siti\scheduler\config\db.php';
    require_once '../frontend/functions.php';

    if(isset($_POST['attività'])){
        pg_prepare($db,"add_att","INSERT INTO events values ($1,$2,$3,$4,$5)");
        pg_prepare($db,"search","SELECT * FROM events WHERE id=$1");
        pg_prepare($db,"search_reparto","SELECT * FROM reparto WHERE nome_reparto=$1");


        $codice=$_POST['Codice_attività'];
        $nome=$_POST['Nome_attività'];
        $numero_ore=$_POST['Numero_ore'];
        $reparto = $_POST['Reparto_attività'];

        $res2 = pg_execute($db,"search_reparto",array($reparto));
        $row2 = pg_fetch_assoc($res2);
        $codice_reparto = $row2['codice']; 
        $dipendenti =  $row2['num_dipendenti']; 

        $titolo = $reparto.': '.$nome; 

        
        /*echo " data inizio: ";echo $data_inizio;*/
        /*$data_fine = get_data_fine($db,$numero_ore,$data_inizio,$codice_reparto);*/
       /* echo " data fine: " ;echo $data_fine;*/


        $res = pg_execute($db,"search",array($codice));
        $row = pg_fetch_assoc($res);

            if(isset($row['id'])){
                $codice_err="Codice già in uso, riprovare";
            } else {
                
                /*per admin*/
                $data_inizio = get_data_inizio($db,$codice_reparto,$dipendenti);
                echo " data inizio: ";echo $data_inizio;
                $data_fine = assegna_ore($db,$numero_ore,$codice_reparto,$dipendenti);
                echo " data fine: " ;echo $data_fine;

                /*per utente*/
                /*$result=pg_query($db,"SELECT * FROM utente where reparto = $codice_reparto ORDER BY MATRICOLA");
                $ris=pg_fetch_all($result);
                foreach($ris as $row){
                    $matricola = $row["matricola"];
                    $numero_ore = aggiorna_dipendente($db,$codice,$titolo,$numero_ore,$matricola);
                }*/

                pg_execute($db,"add_att",array($codice,$titolo,$data_inizio,$data_fine,$codice_reparto));
                
                $msg = "Attività aggiunta correttamente";
               /* $msg2 = "Dipendenti: ".$dipendenti; 
                $msg3 = "Ore per dipendente : ".(ceil($numero_ore/$dipendenti)); 
                $msg4 = "Giorni: ".(ceil(($numero_ore/$dipendenti)/6)); */

            }
            
        }
    
?>

<html>
    <head>
        <title>Attività</title>
        <link rel="stylesheet" type="text/css" href="../styles/registrazione.css">

    </head>

    <body>
    <div class="header">
            <?php include 'header.php'; ?>
    </div>
    <div class="container">

    <div class="content">
            <div class="form_cont">
                <form id="attività_form"   method="post" autocomplete="off">
                    <div class="attività_title"><h4>AGGIUNGI ATTIVITA'</h4></div>
                    <div id="codice" ><input id="input_codice"  type="number" name="Codice_attività" placeholder="Codice attività" required></div><br>
                    <div id="err"><?php if(isset($codice_err)) echo $codice_err; ?></div>

                    <div id="nome" ><input id="input_nome"  type="text" name="Nome_attività" placeholder="Nome attività" required></div><br>
                    <div id="ore_totali" ><input id="input_ore"  type="number"  min="1" name="Numero_ore" placeholder="Ore totali "required></div><br>

                    <div id="reparto"><select name="Reparto_attività" id="Reparto_attività" style="height: 40px; width: 100%; "  required>
                    
                    
                     <?php  	
                        $query =  "SELECT * FROM reparto ";
                        $res = pg_query($db,$query);
                        $ris = pg_fetch_all($res);
                    
                        foreach($ris as $row){ ?>
                                         <option value=<?php echo $row["nome_reparto"];?> > <?php echo $row["nome_reparto"].": ".$row["num_dipendenti"]." dipendenti";?></option> 
                            <?php  }?> 

       

                    </select></div>
                    <div id="msg2"><?php if(isset($msg2)) echo $msg2; ?></div>
                    <div id="msg3"><?php if(isset($msg3)) echo $msg3; ?></div>
                    <div id="msg4"><?php if(isset($msg4)) echo $msg4; ?></div>
                   
                </form>
                    <div class="inblock">
                        <div class="subm"><button id="Aggiungi_attività" form="attività_form" type="submit" name="attività">AGGIUNGI</button></div>
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