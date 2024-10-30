

<?php
    require_once 'C:\Users\Angelapia\siti\scheduler\config\db.php';
    $data = array();

    $query =  "SELECT * FROM events ";

    $res = pg_query($db,$query);
    $ris = pg_fetch_all($res);


    foreach($ris as $row)
    {
     $data[] = array(
      'id'   => $row["id"],
      'title'   => $row["title"],
      'start'   => $row["start_event"],
      'end'   => $row["end_event"]
     );
    }
    



/*
    foreach($ris as $row)
    {
        echo $ris;
        $data[] = array(
            'id' => $row["codice"],
            'title' => $row["nome"],
            'start' => "30/08/2022",
            'end' => "31/08/2022"
        );
    }
/*dati in stringhe*/
echo json_encode($data);
?>