<?php 
include_once 'annuale.class.php';

/*
 * Classe che definisce una Anagrafica
 */
class Anagrafica {
	public $id;
	public $nome;
	public $cognome;
	public $data_nascita;
	public $indirizzo;
	public $civico;
	public $cap;
	public $comune;
	public $prov;
	public $telefono;
	public $cellulare;
	public $email;
	
	public $listaIscrizioni;

	/**
	 * @param $id l'anagrafica utente di cui caricare i dati.
	 * @return l'anagrafica con i suoi dati, null nel caso di errore o non trovato.
	 */
	public static function getDatiIscritto($id=null) {
		
		if ($id != null)
		{
			$getQuery = 'SELECT anagrafica.* FROM anagrafica WHERE id = ' . $id . ' LIMIT 1';
			$getResult = qdb ( $getQuery );
			if ($getResult && (row ( $getResult ) > 0)) {
				$record = mysql_fetch_assoc ( $getResult );
				$singolo = self::getDatiFromDBRecord ( $record );
				
				return $singolo;
			}
			
		}		
		return null;
	}
	
	/**
	 * @return array di anagrafica
	 */
	public static function getDatiFromAnagrafica($anno=null) {

		$getQuery = 'SELECT anagrafica.* FROM anagrafica';	

		if ($anno != null)
			$getQuery = "SELECT anagrafica.* FROM anagrafica INNER JOIN annuale ON anagrafica.id = annuale.fk_idiscritto WHERE annuale.anno = '$anno';"; 
		
		$getResult = qdb ( $getQuery );
		
		$iscritti = array ();
		if ($getResult && (row ( $getResult ) > 0)) {
			while ( $record = mysql_fetch_assoc ( $getResult )) {
				$singolo = self::getDatiFromDBRecord ( $record );
				array_push ( $iscritti, $singolo );
			}
		}
		return $iscritti;
	}
	
	/**
	 * Dato il record del DB ne restituisce l'oggetto dell'anagrafica corrispondente.
	 * @param $record il record del database.
	 * @return l'oggetto Anagrafica corrispondente.
	 */
	private static function getDatiFromDBRecord($record) {
		$data = new Anagrafica();
		$data->id = $record["id"];
		$data->nome = $record["nome"];
		$data->cognome = $record["cognome"];
		$data->data_nascita = $record["data_nascita"];
		$data->indirizzo = $record["indirizzo"];
		$data->civico = $record["civico"];
		$data->cap = $record["cap"];
		$data->comune = $record["comune"];
		$data->prov = $record["prov"];
		$data->telefono = $record["telefono"];
		$data->cellulare = $record["cellulare"];
		$data->email = $record["email"];
		
		return $data;
	}
	
	public function getIscrizioni() {
		$idiscritto = $this->id;
		$listaIscrizioni = Annuale::getAllIscrizioniById($idiscritto);
		$this->listaIscrizioni = $listaIscrizioni;
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
	
		$saveQuery .= "anagrafica SET ";
	
		if (!$isUpdate) {//insert
			$saveQuery .= "insert_datetime = '".date("Y-m-d H:i:s")."', ";
		}
		else {
			$saveQuery .= "modify_datetime = '".date("Y-m-d H:i:s")."', ";
		}
			
		$saveQuery .= " nome = '".mysql_real_escape_string($this->nome)."'";
		$saveQuery .= ", cognome = '".mysql_real_escape_string($this->cognome)."'";
		$saveQuery .= ", data_nascita = '".mysql_real_escape_string($this->data_nascita)."'";
		$saveQuery .= ", indirizzo = ".(!empty($this->indirizzo) ? "'".mysql_real_escape_string($this->indirizzo)."'" : "NULL");
		$saveQuery .= ", civico = ".(!empty($this->civico) ? "'".mysql_real_escape_string($this->civico)."'" : "NULL");
		$saveQuery .= ", cap = ".(!empty($this->cap) ? "'".mysql_real_escape_string($this->cap)."'" : "NULL");
		$saveQuery .= ", comune = ".(!empty($this->comune) ? "'".mysql_real_escape_string($this->comune)."'" : "NULL");
		$saveQuery .= ", prov = ".(!empty($this->prov) ? "'".mysql_real_escape_string($this->prov)."'" : "NULL");
		$saveQuery .= ", telefono = ".(!empty($this->telefono) ? "'".mysql_real_escape_string($this->telefono)."'" : "NULL");
		$saveQuery .= ", cellulare = ".(!empty($this->cellulare) ? "'".mysql_real_escape_string($this->cellulare)."'" : "NULL");
		$saveQuery .= ", email = ".(!empty($this->email) ? "'".mysql_real_escape_string($this->email)."'" : "NULL");
		$saveQuery .= ", user_op = ".$_SESSION["idutente"];
		
							
		if ($isUpdate)
			$saveQuery .= " WHERE anagrafica.id = ".mysql_real_escape_string($this->id);
					
		$opResult = false;
		$saveResult = qdb($saveQuery);
		if ($saveResult) {
			$opResult = true;
			if (!$isUpdate)
				$this->id = mysql_insert_id();
			
// 			if (!is_null($this->new_anno)) //!is_null($this->new_tessera) ||
// 			{
// 				$annualeToSave = new Annuale();
// 				$annualeToSave->id = $this->idIscrizione; //potrebbe essere nullo in caso di nuovo iscrizione
// 				$annualeToSave->tessera = $this->new_tessera;
// 				$annualeToSave->anno = $this->new_anno;
// 				$annualeToSave->fk_idiscritto = $this->id;
// 				$annualeToSave->pagato = $this->new_pagato;
// 				$annualeToSave->scadenza_tessera = $this->new_scadenza_tessera;
// 				$annualeToSave->scadenza_visita = $this->new_scadenza_visita;
				
// 				if (!$annualeToSave->save())
// 					$opResult = false;
// 			} 
		}
		return $opResult;
	}
}
?>