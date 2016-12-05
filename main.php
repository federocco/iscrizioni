<?php
include 'config/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<meta name="description" content="">
	<meta name="author" content="">
	
	<title>A.S.D. Biciverde | Gestione iscritti</title>
	
	<!-- Bootstrap core CSS -->
	<link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Global styles -->
	<link rel="stylesheet" href="css/global.css">
	
	<!-- Custom styles for this template -->
	<link rel="stylesheet" href="css/anagrafica.css">
	
	<!-- Bootstrap core JavaScript -->
	<script src="libs/jquery/jquery-1.11.1.min.js"></script>
	<script src="libs/bootstrap/js/bootstrap.min.js"></script>
	
	<!-- jQuery UI -->
	<script type="text/javascript" src="libs/jquery/ui/js/jquery-ui-1.9.2.custom.min.js"></script>
	
	<!-- Bootstrap jQuery UI -->
	<link rel="stylesheet" href="libs/bootstrap/jqueryuibootstrap/jquery-ui-1.9.2.custom.css" />
		
	<!-- <link rel="stylesheet" href="libs/jquery-ui/jquery-ui.min.css" /> -->
	
	
	<!-- DataTable -->
	<script charset="utf-8"	src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="http://cdn.datatables.net/1.10.3/css/jquery.dataTables.css"></link>
	
	<!-- My Javascript -->
	<script src="js/anagrafica.js"></script>
	<script src="js/main.js"></script>
	<script src="js/dialog.js"></script>
	
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
</head>
<body>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">A.S.D. Biciverde</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class=""><a id="open_selezionaDati" href="#">Seleziona...</a></li>
<!-- 					<li><a href="#about">Tutti</a></li> -->
<!-- 					<li><a href="#contact">Contact</a></li> -->
				</ul>
				<ul class="nav navbar-nav navbar-right">
				<li class=""><a id="loggoff" href="index.php">Esci</a></li>
				</ul>
			</div>
			
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container">

		<div class="starter-element">
		<div class="row">
			<h4>Iscritti Società 06PD077</h4>
		</div>
		<div class="row">
			<p>
				<button id="add_anagrafica" type="button" class="btn btn-success">Aggiungi
					nuovo iscritto</button>
			</p>

			<div id="status_handling">
				<div class="ui-state-highlight ui-corner-all" style="display: none;">
					<p>
						<span class="ui-icon ui-icon-info"
							style="float: left; margin-right: .3em;"></span> <strong>OK!</strong>
						operazione eseguita correttamente
					</p>
				</div>

				<div class="ui-state-error ui-corner-all" style="display: none;">
					<p>
						<span style="float: left; margin-right: .3em;"
							class="ui-icon ui-icon-alert"></span> <strong>Attenzione:</strong>
						errore nell'eseguire l'operazione richiesta
					</p>
				</div>

			</div>


			<table id="tabellaUsers" cellpadding="0" cellspacing="0" border="0"
				class="display">
				<thead>
					<tr>
						<th>Iscrivi</th>
						<th>ID</th>
						<th>Nome</th>
						<th>Cognome</th>
						<th>Data di nascita</th>
						<th>Indirizzo</th>
						<th>Civico</th>
						<th>CAP</th>
						<th>Comune</th>
						<th>Prov.</th>
						<th>Telefono</th>
						<th>Cellulare</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
		</div>
		<!-- /row -->
</div>
<!-- /.container -->

<div id="dialog_selezionaDati" title="Seleziona anno">
<!-- 	<label>Anno</label><input type="text" id="selezionaDati_anno" /> -->

	<select id="listaAnni"></select>
	
	<div>&nbsp;</div>
	
	<div>
		<button id="selezionaDati_anno_carica" type="button"
			class="btn btn-primary">Carica</button>
	</div>
</div>

<div id="dialog_gestione_iscritto" title="Gestione iscritto">
		<div id="iscritto_dettagli">
			<div>
				<label>Nome</label><input type="text" id="iscritto_nome" />
			</div>
			<div>
				<label>Cognome</label><input type="text" id="iscritto_cognome" />
			</div>
			<div>
				<label>Data di nascita</label><input type="text"
					id="iscritto_data_nascita" />
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
				<label>Telefono</label><input type="text" id="iscritto_telefono" />
			</div>
			<div>
				<label>Cellulare</label><input type="text" id="iscritto_cellulare" />
			</div>
			<div>
				<label>Email</label><input type="text" class="email-control" id="iscritto_email" />
			</div>

			<div>
				<button id="gestione_iscritto_salva" type="button"
					class="btn btn-primary">Salva</button>
			</div>
		</div>
		<div id="iscritto_storico">
			<div class="data_table-tools">
				<span>
					<button id="add_iscrizione" type="button" class="btn btn-success">Aggiungi
						iscrizione annuale</button>
				</span>
			</div>

			<div id="dati_add_iscrizione">
				<div>
					<label>Anno</label><input type="text" id="add_anno" size="4" />
				</div>
				<div>
					<label>Tessera</label><input type="text" id="add_tessera" />
				</div>
				<div>
					<label>Pagamento &euro;</label><input type="text" id="add_pagato" />
				</div>
				<div>
					<label>Scadenza Tessera</label><input type="text"
						id="add_scadenza_tessera" />
				</div>
				<div>
					<label>Scadenza Visita medica</label><input type="text"
						id="add_scadenza_visita" />
				</div>


				<div style="display: none;">
					<input type="text" id="add_anno_hide" />
				</div>
			</div>

			<div class="tabella_iscrizioni">
				<table id="tabella_iscrizioni"
					class="table table-striped table-bordered table-condensed">
					<thead>
						<tr>
							<th>ID</th>
							<th>Anno</th>
							<th>Codice tessera</th>
							<th>Pagamento &euro;</th>
							<th>Scad. tessera</th>
							<th>Scad. visita</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
	
	<!-- Loading Dialog -->
	<div id="loadingScreen"></div>
	
	<!-- Error Dialog -->
	<div id="errorScreen"></div>
	
	</body>
</html>