<?php 
// set_time_limit ��� Limits the maximum execution time
set_time_limit(0); //no time limit

include("../config/database.lib.php");

//connessione al DATABASE
db_connect();

function change_date_format ($date)
{
	list($giorno, $mese, $anno) = preg_split('/[\/ ]/', $date);
	
	if ($mese < 10)
		$mese = "0".$mese;
	
	if ($giorno < 10)
		$giorno = "0".$giorno;
		
	return $anno."-".$mese."-".$giorno;
}

function import_iscritti($filename,$import_annualita)
{
	$log = "../logs/".date("Y-m-d")."_iscritti.log";
	$handle_log = fopen($log,"a+");

	$row = 0;
	if (($handle = fopen($filename, "r")) !== FALSE)
	{
		$log_record = "[".date("H:i:s")."] ### INIZIO ESECUZIONE ANAGRAFICA ###.";
		fwrite($handle_log,$log_record."\n");
		print $log_record."<br>";
			
		while (($data_array = fgetcsv($handle, 0, ";")) !== FALSE)
		{
			if ($row > 0)
			{
				$num = count ( $data_array );
				
				$cognome = ucwords (mysql_real_escape_string ( $data_array[0] ));
				
				$nome = ucwords (mysql_real_escape_string ( $data_array[1] ));
								
				$data_nascita = ($data_array[2] != "") ? "'".change_date_format($data_array[2])."'" : "'NULL'";
				
				$indirizzo = "'".ucwords (mysql_real_escape_string ( $data_array[3] )) ."'";
				
				$civico = ($data_array[4] != "") ? "'".strtoupper(mysql_real_escape_string ( $data_array[4] ))."'" : "'NULL'";
				
				$cap = is_numeric($data_array[5] != "") ? $data_array[5] : "'NULL'";
				
				$comune = ($data_array[6] != "") ? "'".ucwords(mysql_real_escape_string ( $data_array[6] ))."'" : "'NULL'";
				
				$prov = ($data_array[7] != "") ? "'".strtoupper(mysql_real_escape_string ( $data_array[7] ))."'" : "'NULL'";
				
				$query_search_exists = "SELECT * FROM anagrafica WHERE nome LIKE '%$nome%' AND cognome LIKE '%$cognome%' LIMIT 1;";			
				$result_exists = qdb ( $query_search_exists );
				
				if (row ( $result_exists ) > 0) {
					
					$id_iscritto = result($result_exists,0,"id");
						
					$log_record = "[" . date ( "H:i:s" ) . "] Iscritto ".$nome." ".$cognome." gi�� presente con codice: $id_iscritto";
					fwrite ( $handle_log, $log_record . "\n" );
					print $log_record . "<br>";
					
					$id_iscritto = result($result_exists,0,"id");
					
					$update_dati = "UPDATE anagrafica SET 
					data_nascita = $data_nascita,
					indirizzo = $indirizzo, 
					civico = $civico, 
					cap = $cap,
					comune = $comune,
					prov = $prov 
					WHERE id = $id_iscritto LIMIT 1;";
					$result_update = qdb ( $update_dati );
					
					if ($result_update && mysql_affected_rows () == 1) {
						$log_record = "[" . date ( "H:i:s" ) . "] Aggiornati dati anagrafica: " . $update_dati;
						fwrite ( $handle_log, $log_record . "\n\n" );
						print $log_record . "<br><br>";
					}
					
					$select_iscritto_annuale = "SELECT * FROM annuale WHERE fk_idiscritto = $id_iscritto AND anno = $import_annualita LIMIT 1;"; //".date("Y")."
					$result_iscritto_annuale = qdb($select_iscritto_annuale);
					if (row($result_iscritto_annuale) == 0 )
					{
						/*
						 * iscrivo l'utente nell'anno corrente
						 */
						$insert_annuale = "INSERT INTO annuale (`id`,`fk_idiscritto`,`anno`) VALUES (NULL,$id_iscritto,$import_annualita);"; //".date("Y")."
						
						$result_insert_annuale = qdb ( $insert_annuale );
						if ($result_insert_annuale === "ER") {
							$log_record = "[" . date ( "H:i:s" ) . "] Errore nell'iscrizione di $nome $cognome\n ";
							fwrite ( $handle_log, $log_record . "\n" );
							print $log_record . "<br>";
						} else {
							$log_record = "[" . date ( "H:i:s" ) . "] $nome $cognome iscritto correttamente.\n";
							fwrite ( $handle_log, $log_record . "\n" );
							print $log_record . "<br>";
						}
						/*
						 * iscrivo l'utente nell'anno corrente
						 */
					}
					
					
				} 
				else 
				{
					$query_insert = "INSERT INTO `anagrafica` (`id`, `nome`, `cognome`,`data_nascita`,`indirizzo`, `civico`, `cap`, `comune`, `prov`)
							VALUES
							(NULL, '$nome', '$cognome',$data_nascita, $indirizzo, $civico, $cap, $comune, $prov)";
					
					$log_record = "[" . date ( "H:i:s" ) . "] Nuovo iscritto $nome $cognome da inserire...";
					fwrite ( $handle_log, $log_record . "\n" );
					print $log_record . "<br>";
					
					$log_record = "[" . date ( "H:i:s" ) . "] Query: $query_insert";
					fwrite ( $handle_log, $log_record . "\n" );
					print $log_record . "<br>";
					
					$result_insert = qdb ( $query_insert );
					
					if ($result_insert === "ER") {
						$log_record = "[" . date ( "H:i:s" ) . "]  Errore inserimento anagrafica di $nome $cognome";
						fwrite ( $handle_log, $log_record . "\n" );
						print $log_record . "<br>";
					} else {
						$log_record = "[" . date ( "H:i:s" ) . "] $nome $cognome inserito in anagrafica correttamente.\n";
						fwrite ( $handle_log, $log_record . "\n" );
						print $log_record . "<br>";
						
						/*
						 * iscrivo l'utente nell'anno corrente
						*/
						$last_id = mysql_insert_id();
						$insert_annuale = "INSERT INTO annuale (`id`,`fk_idiscritto`,`anno`) VALUES (NULL,$last_id,$import_annualita);"; //".date("Y")."
						
						$result_insert_annuale = qdb ( $insert_annuale );
						if ($result_insert_annuale === "ER") {
							$log_record = "[" . date ( "H:i:s" ) . "] Errore nell'iscrizione di $nome $cognome\n";
							fwrite ( $handle_log, $log_record . "\n" );
							print $log_record . "<br>";
						} else {
							$log_record = "[" . date ( "H:i:s" ) . "] $nome $cognome iscritto correttamente.\n";
							fwrite ( $handle_log, $log_record . "\n" );
							print $log_record . "<br>";
						}
						/*
						 * iscrivo l'utente nell'anno corrente
						 */
					}
				}
			}
			else
			{
				$log_record = "[".date("H:i:s")."]Nessun record presente.\n";
				fwrite($handle_log,$log_record."\n");
				print $log_record."<br>";
			}
				
			print "ciclo $row";
			$row++;
		}
			
		$log_record = "[".date("H:i:s")."] ### FINE ESECUZIONE ANAGRAFICA ###.";
		fwrite($handle_log,$log_record."\n");
		print $log_record."<br>";

		fclose($handle);
		fclose($handle_log);
	}
	exit;
}


import_iscritti("iscritti_2013.csv",'2013');


?>