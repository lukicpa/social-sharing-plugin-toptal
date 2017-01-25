(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    $(document).ready( function() {

        //Drag and Drop
		$( '#social-enabled' ).sortable( {
			receive: function( event, ui ) {
				var position = ui.item.index();
				var service = ui.item.attr('id');
				var hidden_input = $( '#social-services .'+service );
				var hidden_input_position = $( '#social-services .'+service+'_pos' );
				hidden_input.attr('value', 'on');
				hidden_input_position.attr('value', position);

			},
			update: function( event, ui ) {
				$(this).find( 'div.social-service' ).enableSelection();   // Fixes a problem with Chrome
				var position = ui.item.index();
				var service = ui.item.attr('id');
				var hidden_input_position = $( '#social-services .'+service+'_pos' );
				hidden_input_position.attr('value', position);

				$.map(
					$(this).find( 'div.social-service' ), function(el) {
						var enabled_service = $(el).attr('id');
						var enabled_position = $(el).index();
						var enabled_input_position = $( '#social-services .'+enabled_service+'_pos' );
						enabled_input_position.attr('value', enabled_position);
					}
				);

			},
			helper: function( event, ui ) {
				return ui.clone();
			},
			start: function( ) {
				$( 'div.social-service' ).disableSelection();   // Fixes a problem with Chrome
			},
			placeholder: 'dropzone',
			opacity: 0.8,
			delay: 150,
			forcePlaceholderSize: true,
			items: 'div.social-service',
			connectWith: '#social-catalog, #social-enabled'
		} );

		$( '#social-catalog' ).sortable( {
			opacity: 0.8,
			delay: 150,
			cursor: 'move',
			connectWith: '#social-enabled',
			placeholder: 'dropzone',
			forcePlaceholderSize: true,
			receive: function( event, ui ) {
				var service = ui.item.attr('id');
				var hidden_input = $( '#social-services .'+service );
				hidden_input.attr('value', 'off');
			}
		} );

		// Load Color Picker
		$('.icon-color').wpColorPicker();

	});

})( jQuery );
