/**
 * Events list
 */
jQuery( document ).ready( initWidget );
jQuery( document ).on( 'widget-updated widget-added ready', initWidget );

/**
 * Initialization widget js
 *
 * @returns {undefined}
 */
function initWidget() {
	window.CHERRY_API.ui_elements.switcher.init( jQuery( 'body' ) );
	jQuery( '.sortable' ).sortable();
	jQuery( '.sortable' ).on( 'sortchange', function( event, ui ) {
		el = ui.item.parents( '.tm-categories-tiles-form-widget' ).find( 'input.sort-is' );
		refreshForm = function( el ) {
			el.val( ( new Date ).getTime() ).focus().trigger( { type: 'keydown', which: 13 } );
			el.trigger( 'change' );
		};

		setTimeout( refreshForm( el ), 2000 );
	 } );

	jQuery( '.show-count' ).click( function() {
		jQuery( this ).find( 'input' ).trigger( 'change' );
	});

	// Upload image
	jQuery( '.upload_image_button' ).click( function() {
		var _this = jQuery( this );
		var inputImage = _this.parents( '.category-area' ).find( '.custom-image-url' );
		var inputAvatar = _this.parents( '.category-area' ).find( '.avatar img' );

		window.send_to_editor = function( html ) {

			var imgurl = jQuery( 'img', html ).attr( 'src' );

			inputImage.val( imgurl ).trigger( 'change' );
			inputAvatar.attr( 'src', imgurl );

			window.tb_remove();
		};

		window.tb_show( '', 'media-upload.php?type=image&TB_iframe=true' );
		return false;
	});

	// Delete image
	jQuery( '.delete_image_url' ).click( function() {
		var _this = jQuery( this );
		var inputImage = _this.parents( '.category-area' ).find( '.custom-image-url' );
		var inputAvatar = _this.parents( '.category-area' ).find( '.avatar img' );
		var defaultAvatar = inputAvatar.attr( 'default_image' );
		inputAvatar.attr( 'src', defaultAvatar );
		inputImage.val( '' ).trigger( 'change' );
	});
}
