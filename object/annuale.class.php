<?php 

/*
 * Classe che definisce una iscrizione Annuale
 */
class Annuale {
	public $id;
	public $fk_iscritto;
	public $tessera;
	public $pagato;
	public $anno;
	public $scadenza_tessera;
	public $scadenza_visita;
		
	public static function getListaAnni()
	{
		$query = "SELECT COUNT(fk_idiscritto)AS iscritti, anno FROM annuale GROUP BY anno";
		$result = qdb($query);
		
		$listaAnni = array();
		
		while($record = mysql_fetch_assoc($result)) {
			$anno = self::getDatiListaAnni($record);
			array_push($listaAnni, $anno);
		}
		
		return $listaAnni;
	}
	
	public static function getAllIscrizioniById($idutente) {
		$getAllQuery = "
			SELECT annuale.*
			FROM annuale
			WHERE annuale.fk_idiscritto = ".mysql_real_escape_string($idutente);

		$getAllResult = qdb($getAllQuery);
	
		$iscrizioni = array();
		if ($getAllResult) {
				
			if (row($getAllResult) > 0) {
				while($record = mysql_fetch_assoc($getAllResult)) {
					$annuale = self::getDatiAnnualeFromDBRecord($record);
					array_push($iscrizioni, $annuale);
				}
			}
		}
		return $iscrizioni;
	}

	
	/**
	 * Dato il record del DB ne restituisce l'oggetto di una annualità corrispondente.
	 * @param $record il record del database.
	 * @return l'oggetto Annuale corrispondente.
	 */
	private static function getDatiAnnualeFromDBRecord($record) {
		$data = new Annuale();
		$data->id = $record["id"];
		$data->fk_idiscritto = $record["fk_idiscritto"];
		$data->tessera = $record["tessera"];
		$data->anno = $record["anno"];
		$data->pagato = $record["pagato"];
		$data->scadenza_tessera = $record["scadenza_tessera"];
		$data->scadenza_visita = $record["scadenza_visita"];

		return $data;
	}
	
	private static function getDatiListaAnni($record) {
		$data = new StdClass();
		$data->iscritti = $record["iscritti"];
		$data->anno = $record["anno"];
		
		return $data;
	}
	
	public function save() {
		$isUpdate = false;
	
		if (!is_null($this->id) && !is_numeric($this->id))
			return null;
	
		if (!is_null($this->id))
			$isUpdate = true;
	
		$saveQuery = "";
		if ($isUpdate)
			$saveQuery .= "UPDATE ";
		else
			$saveQuery .= "INSERT INTO ";
	
		$saveQuery .= "annuale SET ";
	
		if (!$isUpdate) {//insert
			$saveQuery .= "insert_datetime = '".date("Y-m-d H:i:s")."', ";
		}
		else
			$saveQuery .= "modify_datetime = '".date("Y-m-d H:i:s")."', ";
	
		$saveQuery .= "tessera = '".mysql_real_escape_string($this->tessera)."'";		
		$saveQuery .= ", anno = '".mysql_real_escape_string($this->anno)."'";
		$saveQuery .= ", fk_idiscritto = '".mysql_real_escape_string($this->fk_idiscritto)."'";
		$saveQuery .= ", pagato = '".mysql_real_escape_string($this->pagato)."'";
		$saveQuery .= ", scadenza_tessera = '".mysql_real_escape_string($this->scadenza_tessera)."'";
		$saveQuery .= ", scadenza_visita = '".mysql_real_escape_string($this->scadenza_visita)."'";	
		$saveQuery .= ", user_op = ".$_SESSION["idutente"];
					
		if ($isUpdate)
			$saveQuery .= " WHERE annuale.id = ".mysql_real_escape_string($this->id);
			
		$opResult = false;
		$saveResult = qdb($saveQuery);
				
		if ($saveResult) {
			$opResult = true;
			if (!$isUpdate)
				$this->id = mysql_insert_id();
		}
		return $opResult;
	}
}
?>