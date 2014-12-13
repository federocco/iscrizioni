<?php 
include_once '../object/anagrafica.class.php';
include_once '../config/session.php';

if (isset($_REQUEST["getListaAnni"]))
{
	$lista_anni = Annuale::getListaAnni();
	
	$jsonObj = new StdClass();
	$jsonObj->result = "ok";
	$jsonObj->anni = $lista_anni;
	
	print json_encode ( $jsonObj );
}

if (isset($_REQUEST["loadData"])) {
		
	$anagrafica = Anagrafica::getDatiFromAnagrafica($_REQUEST["loadData"]);
	
	$jsonObj = new StdClass();
	$jsonObj->result = "ok";
	$jsonObj->iscritti = $anagrafica;
	
	print json_encode ( $jsonObj );
}

if (isset($_REQUEST["loadIscritto"])) {

	$anagrafica = Anagrafica::getDatiIscritto($_REQUEST["loadIscritto"]);

	$anagrafica->getIscrizioni();

	$jsonObj = new StdClass();
	$jsonObj->result = "ok";
	$jsonObj->iscritto = $anagrafica;

	print json_encode ( $jsonObj );
}

if (isset($_REQUEST["saveIscritto"])) {
	$iscritto = $_POST["iscritto"];
	
	$iscrittoid = null;
	if (array_key_exists("id", $iscritto))
		$iscrittoid = $iscritto["id"];
		
	$iscrittoToSave = null;
	
	if (!is_null($iscrittoid))
		$iscrittoToSave = Anagrafica::getDatiIscritto($iscrittoid);
	else
		$iscrittoToSave = new Anagrafica();
		
	if (array_key_exists("nome", $iscritto))
		$iscrittoToSave->nome = $iscritto["nome"];
	
	if (array_key_exists("cognome", $iscritto))
		$iscrittoToSave->cognome = $iscritto["cognome"];
	
	if (array_key_exists("data_nascita", $iscritto))
		$iscrittoToSave->data_nascita = $iscritto["data_nascita"];
	
	if (array_key_exists("indirizzo", $iscritto))
		$iscrittoToSave->indirizzo = $iscritto["indirizzo"];
	
	if (array_key_exists("civico", $iscritto))
		$iscrittoToSave->civico = $iscritto["civico"];
	
	if (array_key_exists("cap", $iscritto))
		$iscrittoToSave->cap = $iscritto["cap"];
	
	if (array_key_exists("comune", $iscritto))
		$iscrittoToSave->comune = $iscritto["comune"];
	
	if (array_key_exists("prov", $iscritto))
		$iscrittoToSave->prov = $iscritto["prov"];
	
	if (array_key_exists("telefono", $iscritto))
		$iscrittoToSave->telefono = $iscritto["telefono"];
	
	if (array_key_exists("cellulare", $iscritto))
		$iscrittoToSave->cellulare = $iscritto["cellulare"];
	
	if (array_key_exists("email", $iscritto))
		$iscrittoToSave->email = $iscritto["email"];
	
	/*
	 * 
	 * */
	
	
	$res = new StdClass();
	$saveResult = $iscrittoToSave->save();
	if ($saveResult) {
		
		if (isset($iscritto["anno"])) //!is_null($this->new_tessera) ||
		{
			$annualeToSave = new Annuale();
			if (array_key_exists("tessera", $iscritto))
				$annualeToSave->tessera = $iscritto["tessera"];
			
			if (array_key_exists("anno", $iscritto))
				$annualeToSave->anno = $iscritto["anno"];
			
			if (array_key_exists("pagato", $iscritto))
				$annualeToSave->pagato = $iscritto["pagato"];
			
			if (array_key_exists("scadenza_tessera", $iscritto))
				$annualeToSave->scadenza_tessera = $iscritto["scadenza_tessera"];
			
			if (array_key_exists("scadenza_visita", $iscritto))
				$annualeToSave->scadenza_visita = $iscritto["scadenza_visita"];
			
			if (array_key_exists("idIscrizione", $iscritto))
				$annualeToSave->id = $iscritto["idIscrizione"];
			
			
			$annualeToSave->fk_idiscritto = $iscrittoToSave->id;

			
			if (!$annualeToSave->save())
				$opResult = false;
		} 
		
		$res->result = "ok";
	} else {
		//errore durante salvataggio
		$res->result = "error";
	}
	
	print json_encode($res);
}
?>