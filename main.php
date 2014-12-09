<?php 
include 'config/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="libs/jquery/jquery-1.11.1.min.js"></script>
    <script src="libs/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="libs/jquery-ui/jquery-ui.min.js"></script>
<!--     <link rel="stylesheet" href="libs/jquery-ui/jquery-ui.min.css" /> -->
    
    <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libs/jqueryuibootstrap/jquery-ui-1.9.2.custom.css" />
    

    <!-- DataTable -->
	<script charset="utf-8" src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="http://cdn.datatables.net/1.10.3/css/jquery.dataTables.css"></link>
	
	<link rel="stylesheet" href="css/anagrafica.css">
	    
    <script src="js/anagrafica.js"></script>
    <script src="js/main.js"></script>         
</head>
 
<body>


<div class="container">
    <div class="row">
	    <h3>Iscrizioni A.S.D. Biciverde</h3>
	    <h4>Cod. Società 06PD077</h4>
    </div>
    <div class="row">
    <p>
   		<button id="add_anagrafica" type="button" class="btn btn-success">Aggiungi nuovo iscritto</button>
    </p>
    
    <div id="status_handling">
	    <div class="ui-state-highlight ui-corner-all" style="display:none;">
			<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
			<strong>OK!</strong> operazione eseguita correttamente</p>
		</div>
	
		<div class="ui-state-error ui-corner-all" style="display:none;">
        	<p><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span>
        	<strong>Attenzione:</strong> errore nell'eseguire l'operazione richiesta</p>
        </div>
    
    </div>
    
    
    <table id="tabellaUsers" cellpadding="0" cellspacing="0" border="0"	class="display">
	    <thead>
		    <tr>
		    	<th>ID</th>
		        <th>Nome</th>
		        <th>Cognome</th>
		        <th>Data di nascita</th>
		        <th>Indirizzo</th>
		        <th>Civico</th>
		        <th>CAP</th>
		        <th>Comune</th>
		        <th>Prov.</th>
		    </tr>
	    </thead>
	    <tbody>
	    </tbody>
    </table>
    </div><!-- /row -->
</div><!-- /container -->


<div id="dialog_gestione_iscritto" title="Gestione iscritto">
		<div id="iscritto_dettagli">
			<div>
				<label>Nome</label><input type="text" id="iscritto_nome"  />
			</div>
			<div>
				<label>Cognome</label><input type="text" id="iscritto_cognome" />
			</div>
			<div>
				<label>Data di nascita</label><input type="text" id="iscritto_data_nascita" />
			</div>
			<div>
				<label>Indirizzo</label><input type="text" id="iscritto_indirizzo" />
			</div>
			<div>
				<label>Civico</label><input type="text" id="iscritto_civico" />
			</div>
			<div>
				<label>CAP</label><input type="text" id="iscritto_cap" />
			</div>
			<div>
				<label>Comune</label><input type="text" id="iscritto_comune" />
			</div>
			<div>
				<label>Provincia</label><input type="text" id="iscritto_prov" />
			</div>
	
			<div>
				<button id="gestione_iscritto_salva" type="button" class="btn btn-primary">Salva</button>
			</div>
		</div>
		<div id="iscritto_storico">
			<div class="data_table-tools">
				<span>
					<button id="add_iscrizione" type="button" class="btn btn-success">Aggiungi iscrizione annuale</button>
				</span>
			</div>
			
			<div id="dati_add_iscrizione">
				<div><label>Anno</label><input type="text" id="add_anno" size="4"/></div>
				<div><label>Tessera</label><input type="text" id="add_tessera"  /></div>
				<div><label>Pagamento &euro;</label><input type="text" id="add_pagato"  /></div>
				
				<div style="display:none;"><input type="text" id="add_anno_hide"  /></div>
			</div>
			
			<div class="tabella_iscrizioni">
				<table id="tabella_iscrizioni" class="table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th>ID</th>
							<th>Anno</th>
							<th>Codice tessera</th>
							<th>Pagamento &euro;</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
</div>

</body>
</html>