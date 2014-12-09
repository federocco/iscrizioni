<?php 
include_once '../object/anagrafica.class.php';
include_once '../config/session.php';

if (isset($_REQUEST["loadData"])) {

	$anagrafica = Anagrafica::getDatiFromAnagrafica();
	
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
	
	if (array_key_exists("tessera", $iscritto))
		$iscrittoToSave->new_tessera = $iscritto["tessera"];
	
	if (array_key_exists("anno", $iscritto))
		$iscrittoToSave->new_anno = $iscritto["anno"];
	
	if (array_key_exists("pagato", $iscritto))
		$iscrittoToSave->new_pagato = $iscritto["pagato"];
	
	$res = new StdClass();
	$saveResult = $iscrittoToSave->save();
	if ($saveResult) {
		$res->result = "ok";
	} else {
		//errore durante salvataggio
		$res->result = "error";
	}
	
	print json_encode($res);
}
?>