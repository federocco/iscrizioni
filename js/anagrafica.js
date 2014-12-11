/**
 * Funzionalità per la gestione della tabella
 */

var datiPersonaIscritta;

var tableAnagrafica = {
	anagraficaTable: null,//dataTables

	initialize: function () {
		if (this.anagraficaTable == null) {
			this.anagraficaTable = $("#tabellaUsers").dataTable({
				"oLanguage": {
					"sEmptyTable":     "Nessun dato presente nella tabella",
		       	    "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ elementi",
		       	    "sInfoEmpty":      "Vista da 0 a 0 di 0 elementi",
		       	    "sInfoFiltered":   "(filtrati da _MAX_ elementi totali)",
		       	    "sInfoPostFix":    "",
		       	    "sInfoThousands":  ",",
		       	    "sLengthMenu":     "Visualizza _MENU_ elementi",
		       	    "sLoadingRecords": "Caricamento...",
		       	    "sProcessing":     "Elaborazione...",
		       	    "sSearch":         "",//"Cerca:",
		       	    "sSearchPlaceholder": "Cerca",
		      	    "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
		       	    "oPaginate": {
		       	        "sFirst":      "Inizio",
		       	        "sPrevious":   "Precedente",
		       	        "sNext":       "Successivo",
		       	        "sLast":       "Fine"
		       	    },
		       	    "oAria": {
		       	        "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
		       	        "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
		       	    }
		       },
		       "aaSorting": [[ 0, "asc" ]],
		       "sDom": '<"H"lTfr>t<"F"ip>',
		       "sScrollY": "auto",
		       "bPaginate": true
		       //"bJQueryUI": true
			});
		}

		$("#add_anagrafica").click(function() {
			gestioneIscritto.openDialog(null);
		});
	},
		
	loadData : function(){
		if (this.anagraficaTable == null)
			this.initialize();
			
		$.ajax({
			data:{loadData:''},
			success: function(data) {tableAnagrafica.loadDataHandler(data.iscritti);
			}
		});
	},

	loadDataHandler: function (data) {
		//trovo una percentuale di altezza della tabella, a seconda della risoluzione del monitor
//		var table_size = 60;
//		if (screen.height <= 800)
//		    table_size = 50;
//		var heigth_page = (parseInt($("html").height())*parseInt(table_size))/100;
		
		this.anagraficaTable.fnClearTable(true);
		
		var rows = new Array();
		for (var i = 0, len = data.length; i < len; i++) {
			var utente = data[i];
						
			var linkCodice = '<a class="iscritto-linkcode table-linkcode" href="#" data-idiscritto="'+utente.id+'">'+utente.id+'</a>';
			var linkNome = '<a class="iscritto-linkcode table-linkcode" href="#" data-idiscritto="'+utente.id+'">'+utente.nome+'</a>'
			var linkCognome = '<a class="iscritto-linkcode table-linkcode" href="#" data-idiscritto="'+utente.id+'">'+utente.cognome+'</a>'
			
			var row = {
				"DT_RowId": utente.id,
				"0": linkCodice, 
				"1": linkNome,
				"2": linkCognome,
				"3": utente.data_nascita,
				"4": utente.indirizzo,
				"5": utente.civico,
				"6": utente.cap,
				"7": utente.comune,
				"8": utente.prov,
				"9": utente.telefono,
				"10": utente.cellulare,
				"11": utente.email
			};
			rows.push(row);
		}
		
		if (rows.length != 0)
		{
			this.anagraficaTable.fnAddData(rows);
			this.anagraficaTable.fnAdjustColumnSizing();
		}
		
		//registro gli eventi per l'apertura della dialog utente
		$("#tabellaUsers tbody").on('click','.iscritto-linkcode',function(event) {
			var idutente = $(this).attr("data-idiscritto");
			gestioneIscritto.openDialog(idutente);
		});
	}
}

var gestioneIscritto = {
	//inizializza la dialog
	initialize: function() {
		$("#dialog_gestione_iscritto").dialog({
			autoOpen : false,
			//dialogClass: 'dialog_gestione_iscritto_ui',
			height : "auto",
			width : "auto",
			buttons: null,
			position : position,
			modal : true,
			resizable : false,
			close: function () {
				gestioneIscritto.resetData();
			}
		});
		
		$( "#iscritto_data_nascita" ).datepicker({
			dateFormat: "yy-mm-dd",
			 changeMonth: true,
			 changeYear: true
		});
		
		$( "#add_scadenza_tessera" ).datepicker({
			dateFormat: "yy-mm-dd",
			 changeMonth: true,
			 changeYear: true
		});
		
		$( "#add_scadenza_visita" ).datepicker({
			dateFormat: "yy-mm-dd",
			 changeMonth: true,
			 changeYear: true
		});
		
		$('#gestione_iscritto_salva').click(function(e) {
			var iscritto = gestioneIscritto.getDataFromDialog();
			gestioneIscritto.saveData(iscritto);
		});
		
		$('#add_iscrizione').click(function(e) {
			$("#dati_add_iscrizione input[type=text]").val("");
			$("#dati_add_iscrizione").show();

			if ($("#add_anno_hide").val() == "")
			{
				var today = new Date();
				var anno = today.getFullYear();
				var lastAnnuale = anno.toString(); 
				$("#add_anno").val(lastAnnuale);
			}
			else
			{
				$("#add_anno").val($("#add_anno_hide").val());
			}
		});
		
		//registro gli eventi per l'apertura della dialog utente
		$("#tabella_iscrizioni tbody").on('click','.iscrizione-linkcode',function(event) {
			var idiscrizione = $(this).attr("data-idiscrizione");
			gestioneIscritto.loadDatiIscrizione(idiscrizione);
		});
	},
	
	loadDatiIscrizione: function(idiscrizione) {
		$("#dati_add_iscrizione input[type=text]").val("");
		$('#dati_add_iscrizione').show();
		this.loadIntoDatiIscrizione(datiPersonaIscritta,idiscrizione);
	},
	
	loadIntoDatiIscrizione: function (iscritto,id){
		if (typeof iscritto === 'undefined' || iscritto === null)
		return;
		
		if (typeof iscritto.listaIscrizioni !== 'undefined' && iscritto.listaIscrizioni !== null)
		{
			if (iscritto.listaIscrizioni.length > 0)
			{
				for (iscr in iscritto.listaIscrizioni)
				{
					if (iscritto.listaIscrizioni[iscr].id == id)
					{
						$("#add_anno").val(iscritto.listaIscrizioni[iscr].anno);
						$("#add_tessera").val(iscritto.listaIscrizioni[iscr].tessera);
						$("#add_pagato").val(iscritto.listaIscrizioni[iscr].pagato);
						$("#add_scadenza_tessera").val(iscritto.listaIscrizioni[iscr].scadenza_tessera);
						$("#add_scadenza_visita").val(iscritto.listaIscrizioni[iscr].scadenza_visita);
						
						$('#gestione_iscritto_salva').attr("mod-iscrizione", iscritto.listaIscrizioni[iscr].id);
						
						break;
					}
				}
			}	
		}
	},
	
	resetData: function() {
		$("#dialog_gestione_iscritto input[type=text]").val("");
		$('#gestione_iscritto_salva').removeAttr("data-idiscritto");
		$('#dati_add_iscrizione').hide();
		$("#tabella_iscrizioni tbody").html("");
	},

	openDialog: function(id) {
		var iscritto = null;
		if (id != null)
			iscritto = this.loadData(id);
				
		this.resetData();
		
		if (iscritto != null) {
			//modifico esistente
			this.loadIntoDialog(iscritto);
			datiPersonaIscritta = iscritto;
		}
//		else{
//			//inserimento
//		}
		
		$("#dialog_gestione_iscritto").dialog("open");

	},
	
	loadIntoDialog: function(iscritto) {
		if (typeof iscritto === 'undefined' || iscritto === null)
			return;
		
		if (typeof iscritto.nome !== 'undefined' && iscritto.nome !== null)
			$("#iscritto_nome").val(iscritto.nome);
	
		if (typeof iscritto.cognome !== 'undefined' && iscritto.cognome !== null)
			$("#iscritto_cognome").val(iscritto.cognome);
		
		if (typeof iscritto.data_nascita !== 'undefined' && iscritto.data_nascita !== null)
			$("#iscritto_data_nascita").val(iscritto.data_nascita);
		
		if (typeof iscritto.indirizzo !== 'undefined' && iscritto.indirizzo !== null)
			$("#iscritto_indirizzo").val(iscritto.indirizzo);
		
		if (typeof iscritto.civico !== 'undefined' && iscritto.civico !== null)
			$("#iscritto_civico").val(iscritto.civico);
		
		if (typeof iscritto.cap !== 'undefined' && iscritto.cap !== null)
			$("#iscritto_cap").val(iscritto.cap);
		
		if (typeof iscritto.comune !== 'undefined' && iscritto.comune !== null)
			$("#iscritto_comune").val(iscritto.comune);
		
		if (typeof iscritto.prov !== 'undefined' && iscritto.prov !== null)
			$("#iscritto_prov").val(iscritto.prov);
		
		if (typeof iscritto.cellulare !== 'undefined' && iscritto.cellulare !== null)
			$("#iscritto_cellulare").val(iscritto.cellulare);
		
		if (typeof iscritto.telefono !== 'undefined' && iscritto.telefono !== null)
			$("#iscritto_telefono").val(iscritto.telefono);
		
		if (typeof iscritto.email !== 'undefined' && iscritto.email !== null)
			$("#iscritto_email").val(iscritto.email);
		
		
		
		if (typeof iscritto.listaIscrizioni !== 'undefined' && iscritto.listaIscrizioni !== null)
		{
			if (iscritto.listaIscrizioni.length > 0)
			{
				var html_record= "";
				for (iscr in iscritto.listaIscrizioni)
				{
					html_record += '<tr>'; 
					html_record += '<td><a class="iscrizione-linkcode" href="#" data-idiscrizione="'+iscritto.listaIscrizioni[iscr].id+'">'+iscritto.listaIscrizioni[iscr].id+'</a></td>'; 
					html_record += '<td>'+iscritto.listaIscrizioni[iscr].anno+'</td>'; 
					html_record += '<td>'+((iscritto.listaIscrizioni[iscr].tessera != null) ? iscritto.listaIscrizioni[iscr].tessera : '&nbsp;')+'</td>'; 
					html_record += '<td>'+((iscritto.listaIscrizioni[iscr].pagato != null) ? iscritto.listaIscrizioni[iscr].pagato : '&nbsp;')+'</td>'; 
					html_record += '<td>'+((iscritto.listaIscrizioni[iscr].scadenza_tessera != null) ? iscritto.listaIscrizioni[iscr].scadenza_tessera : '&nbsp;')+'</td>'; 
					html_record += '<td>'+((iscritto.listaIscrizioni[iscr].scadenza_visita != null) ? iscritto.listaIscrizioni[iscr].scadenza_visita : '&nbsp;')+'</td>'; 
					html_record += '</tr>'; 
					
					lastAnnuale = parseInt(iscritto.listaIscrizioni[iscr].anno);
				}
				$("#add_anno_hide").val(lastAnnuale+1);
				$("#tabella_iscrizioni tbody").html(html_record);	
			}	
		}
				
		$('#gestione_iscritto_salva').attr("data-idiscritto", iscritto.id);
	},
	
	loadData: function(id) {
		if (id == null || id == "")
			return;
		
		var iscritto = null;
		$.ajax({
			async: false,
			data : {
				loadIscritto: id
			},
			//complete: function(xhr){},
			success: function(data) {
				if ((typeof data.iscritto != "undefined") && (data.iscritto != null))
					iscritto = data.iscritto;
			}
		});
		return iscritto;
	},
	
	getDataFromDialog: function() {
		var iscritto = {};
		
		var val = $('#gestione_iscritto_salva').attr("data-idiscritto");
		if (typeof val !== 'undefined' && val !== null)
			iscritto.id = val;
		
		var val = $("#iscritto_nome").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.nome = val;
		
		var val = $("#iscritto_cognome").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.cognome = val;
		
		var val = $("#iscritto_data_nascita").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.data_nascita = val;
		
		var val = $("#iscritto_indirizzo").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.indirizzo = val;
		
		var val = $("#iscritto_civico").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.civico = val;
		
		var val = $("#iscritto_cap").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.cap = val;
		
		var val = $("#iscritto_comune").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.comune = val;
		
		var val = $("#iscritto_prov").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.prov = val;
		
		var val = $("#iscritto_telefono").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.telefono = val;
		
		var val = $("#iscritto_cellulare").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.cellulare = val;
		
		var val = $("#iscritto_email").val();
		if (typeof val !== 'undefined' && val !== null)
			iscritto.email = val;
		
		/*
		 * 
		 * */
		
		//controllo se sto modificando o aggiungendo una iscrizione
		var val = $('#gestione_iscritto_salva').attr("mod-iscrizione");
		if (typeof val !== 'undefined' && val !== null)
			iscritto.idIscrizione = val;
		
		var val = $("#add_tessera").val();
		if (typeof val !== 'undefined' && val !== "")
			iscritto.tessera = val;
		
		var val = $("#add_anno").val();
		if (typeof val !== 'undefined' && val !== "")
			iscritto.anno = val;
		
		var val = $("#add_pagato").val();
		if (typeof val !== 'undefined' && val !== "")
			iscritto.pagato = val;
		
		var val = $("#add_scadenza_tessera").val();
		if (typeof val !== 'undefined' && val !== "")
			iscritto.scadenza_tessera = val;
		
		var val = $("#add_scadenza_visita").val();
		if (typeof val !== 'undefined' && val !== "")
			iscritto.scadenza_visita = val;
				
		return iscritto;
	},
	
	saveData: function(iscritto) {
		if (iscritto == null || iscritto == "")
			return;
		
		if ((iscritto.nome == "") || (iscritto.cognome == "")) {
				alert('NOME e COGNOME sono campi obbligatori');
			return false;
		}
		
		$.ajax({
			data : {
				saveIscritto: "",
				iscritto: iscritto
			},
			success: function(data) {
				if (data.result == "ok") {
					tableAnagrafica.loadData();
					$(".ui-state-highlight").show(0).delay(800).hide(0);					
					
				} 
				else
				{
					$(".ui-state-error").show(0).delay(800).hide(0);
				}
				$("#dialog_gestione_iscritto").dialog("close");
			}
		});
		return iscritto;
	}
}