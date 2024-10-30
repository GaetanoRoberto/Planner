
<?php
    require_once 'C:\Users\Angelapia\siti\scheduler\config\db.php';
    
    session_start();


    
    
if(isset($_POST["id"]))
{
   if( $_SESSION['username'] == "admin" )
   {
   $id = $_POST["id"];
   pg_prepare($db,"remove","DELETE FROM events WHERE id=$1");
   pg_execute($db,"remove",array($id));
   }

}

    
?>
