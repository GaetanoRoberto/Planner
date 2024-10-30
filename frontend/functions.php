<?php
function get_nome($db, $user){
		$result=pg_query($db,"SELECT * FROM utente where username='$user'");
		$row=pg_fetch_row($result);
		return $row[0];
	}

function get_data_inizio($db,$reparto,$num_dip){
	$giorni = 0;
	$result=pg_query($db,"SELECT * FROM events where reparto = $reparto  ORDER BY end_event DESC ");
	$row=pg_fetch_assoc($result);
	

	$result2=pg_query($db,"SELECT * FROM utente where reparto = $reparto  AND ore_libere = 0 ORDER BY ORE_LIBERE,MATRICOLA");

	//tutti i dipendenti hanno un impiego per l'intera la giornata => giorno successivo
	if(pg_num_rows($result2) == $num_dip){
		$giorni++;
	}
	
	if (pg_num_rows($result) > 0){
		$data = $row['end_event'];
		//ho eventi assegnati per questo reparto => parto dalla data di fine dell'ultima attività
		return date('Y-m-d H:i:s', strtotime($data. '+ '.($giorni).'days')); 
	}
	else{
		//non ho eventi assegnati per questo reparto => assegno da giorno successivo
		$data_oggi = date('Y-m-d 10:00:00');
		return date('Y-m-d 10:00:00', strtotime($data_oggi.'+ 1 days'));
	}
	}

function assegna_ore($db,$ore_totali,$reparto,$num_dip){
		if($num_dip == 0){
			echo "Scegli reparto con dipendenti assegnati";
			header("Refresh: 2; url=index.php");
			exit(1);
		}

		$giorni = 0;
	
		while($ore_totali > 0){
			//PRENDO UTENTI LIBERI
			
			$result=pg_query($db,"SELECT * FROM utente where reparto = $reparto  AND ore_libere  > 0 ORDER BY ORE_LIBERE,MATRICOLA");
			$ris=pg_fetch_all($result);
			$dipendenti_liberi =  pg_num_rows($result);
			
	
			//finisce una giornata lavorativo
			if($dipendenti_liberi == 0){
				echo "non hai dipendenti disponibili, giorno avanti";
				scala_giorno($db,$reparto);
				$giorni++;
	
			}
			$data_inizio = get_data_inizio($db,$reparto,$num_dip);
	
			//CICLO PER OGNI UTENTE
			foreach($ris as $row)
			{
				
			 //finchè le ore_totali non sono 0 oppure non ho piu' dipendenti
			if($ore_totali>0 AND $dipendenti_liberi > 0 ){
				$ore_libere = $row["ore_libere"];
				$matricola = $row["matricola"];

				if($ore_totali  >= $ore_libere){
					$ore_totali -= $ore_libere;
					pg_query($db,"UPDATE utente set ore_libere = 0 where matricola = $matricola ");
					$dipendenti_liberi--;
				}else{
					$ore_libere -= $ore_totali;
					pg_query($db,"UPDATE utente set ore_libere = $ore_libere where matricola = $matricola");
					$ore_totali = 0;
	
					}
				
				}
	
	}
	}	
		return   date('Y-m-d H:i:s',strtotime($data_inizio . '+ '.($giorni).'days'));
	}


function aggiorna_dipendente($db,$id,$titolo,$ore_totali,$matricola){
	$result=pg_query($db,"SELECT * FROM attivita where dipendente = $matricola  AND ore_libere  > 0 ORDER BY end_event DESC");
	//seleziono evento


	$result2=pg_query($db,"SELECT * FROM events where id = $id ");


	//prendo ultima data disponibile
	if(pg_num_rows($result) > 0){
		$row=pg_fetch_assoc($result);
		$ore_libere = $row['ore_libere'];
	}else{
		$ore_libere = 6;
	}
	//data inizio
	if(pg_num_rows($result2) > 0){
		$row2=pg_fetch_assoc($result2);
		$data_inizio = $row2['end_event'];
	}else{
		$data_inizio = date('Y-m-d 10:00:00');

	}
	//assegnazione ore
	if($ore_totali - $ore_libere >= 0){
		$ore_totali -= $ore_libere;
		$ore = 0;
		$data_fine = date('Y-m-d H:i:s',strtotime($data_inizio . '+ 6 hours'));

	}else{
		$ore_libere -= $ore_totali;
		//ore libere restanti
		$ore =  6 - $ore_libere;
		$ore_totali = 0;
		$data_fine = date('Y-m-d H:i:s',strtotime($data_inizio . '+ '.$ore_libere.' hours'));

	}

	echo $id." ".$titolo." ".$data_inizio." ".$data_fine." ".$matricola." ".$ore." ";
	pg_query($db,"INSERT into attivita values($id,$titolo,$data_inizio,$data_fine,$matricola,$ore)");


}

/* FUNZIONI UTILI PER DATA*/
/*
	$hours = date('H',strtotime($data_inizio)) ; 
	return   date('Y-m-d H:i:s',strtotime($data_inizio . '+ '.($giorni).'days' . '+'.($ore_occupate).'hours'));
*/
function scala_giorno($db,$reparto){
	pg_query($db,"UPDATE utente set ore_libere = 6 where reparto = $reparto");


}
function get_data_fine($db,$ore_totali,$data_inizio,$reparto){
	/* ore_totali / numerodipendenti*/
	$result=pg_query($db,"SELECT * FROM reparto where codice = $reparto  ");

	$row=pg_fetch_assoc($result);
	$dipendenti = $row['num_dipendenti'];
	$ore_dip = ceil($ore_totali / $dipendenti);
	/*considero giornata lavorativa da 6 ore seguendo direttive del manuale Lifecycle*/
	$giorni = ceil($ore_dip/6); /*arrotonda per d*/
	echo "giorni: " ;echo $giorni;


		$data_fine = date('Y-m-d',strtotime($data_inizio . '+ '.($giorni).'days'));

	
	return $data_fine;
}
