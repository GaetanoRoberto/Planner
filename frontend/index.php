<?php
    session_start();


    ?>
<!DOCTYPE html>
    <head>
        <title>Scheduling</title>
        <link rel="stylesheet" type="text/css" href="../styles/index.css">

    </head>
    <body>
    <div class="header">
            <?php include 'header.php'; ?>
    </div>
    <div class="container">

        <div class="content">
            <div class="form_cont">

            <!--<div id="dipendente" ><input id="input_dipendente"  type="text" name="dipendente" placeholder="Nuovo Dipendente"></div>
            <div id="attività" ><input id="input_attività"  type="text" name="attività" placeholder="Nuova Attività"></div>
            <div id="reparto" ><input id="input_reparto"  type="text" name="reparto" placeholder="Nuovo Reparto"></div>
            /<div id= "dipendente"><button type = "button" ><a href="dipendente.php">Nuovo dipendente</a></button></div>-->
            <div id= "attività"><button type = "button" ><a href="attività.php">Nuova attività</a></button></div>
            <div id= "reparto"><button type = "button" ><a href="reparto.php">Nuovo reparto</a></button></div>
            <div id= "calendario"><button type = "button" ><a href="../frontend/calendario2.php">Calendario</a></button></div>
           
            </div>
        </div>
        </div>
        </div>
            <?php include '../static_content/footer.html'; ?>
             </div>   
    </body>
</html>