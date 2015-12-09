var loadingDialog = {
	el : null,

	initialize : function(el) {
		this.el = el;

		// create the loading window and set autoOpen to false
		$(el).dialog({
			autoOpen : false, // set this to false so we can manually open it
			dialogClass : "loadingScreenWindow",
			closeOnEscape : false,
			draggable : false,
			width : 460,
			minHeight : 50,
			modal : true,
			buttons : {},
			resizable : false,
			open : function() {
				// scrollbar fix for IE
				$('body').css('overflow', 'hidden');
			},
			close : function() {
				// reset overflow
				$('body').css('overflow', 'auto');
			}
		}); // end of dialog
	},

	open : function(waiting) {
		$(this.el).html(
				waiting.message && '' != waiting.message ? waiting.message
						: 'Please wait...');
		$(this.el).dialog(
				'option',
				'title',
				waiting.title && '' != waiting.title ? waiting.title
						: 'Loading');
		$(this.el).dialog('open');
	},

	close : function() {
		$(this.el).dialog('close');
	}
};

var errorDialog = {
	el : null,

	initialize : function(el) {
		this.el = el;

		// create the loading window and set autoOpen to false
		$(el).dialog({
			autoOpen : false, // set this to false so we can manually open it
			closeOnEscape : true,
			draggable : false,
			width : 460,
			minHeight : 50,
			modal : true,
			buttons : {},
			resizable : false,
			open : function() {
				// scrollbar fix for IE
				$('body').css('overflow', 'hidden');
			},
			close : function() {
				// reset overflow
				$('body').css('overflow', 'auto');
			}
		}); // end of dialog
	},

	open : function(error) {
		$(this.el).html(
				error.message && '' != error.message ? error.message
						: 'Osp, something went wrong...');
		$(this.el).dialog(
				'option',
				'title',
				error.title && '' != error.title ? error.title
						: 'Error!');
		$(this.el).dialog('open');
	},

	close : function() {
		$(this.el).dialog('close');
	}
};