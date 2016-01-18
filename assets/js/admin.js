/**
 * Events list
 */
jQuery( document ).on( 'widget-updated widget-added ready', initWidget );

/**
 * ReInit widget
 * @returns {undefined}
 */
function reInitWidget() {
	jQuery( '.tm-categories-tiles-form-widget select, .tm-categories-tiles-form-widget input[type=text]' ).off( 'change' );
	jQuery( '.tm-categories-tiles-form-widget div.upload-image img' ).off( 'click' );
	jQuery( '.tm-categories-tiles-form-widget .upload-image .delete-image-url' ).off( 'click' );
	jQuery( '.tm-categories-tiles-form-widget .category-area .delete-category' ).off( 'click' );
	jQuery( '.tm-categories-tiles-form-widget .categories .add-category' ).off( 'click' );
	initWidget();
}
/**
 * Initialization widget js
 *
 * @returns {undefined}
 */
function initWidget() {

	jQuery( '.tm-categories-tiles-form-widget select, .tm-categories-tiles-form-widget input[type=text]' ).change( function() {
		jQuery( document ).trigger( 'widget-change' );
	});

	// Upload image
	jQuery( '.tm-categories-tiles-form-widget div.upload-image img' ).click( function( e ) {
		var _this = jQuery( this );
		var inputImage = _this.parents( '.category-area' ).find( '.custom-image-url' );
		var inputAvatar = _this.parents( '.category-area' ).find( '.upload-image img' );
		var customUploader = wp.media( {
			title: 'Upload a Image',
			button: {
				text: 'Select'
			},
			multiple: false
		} );

		customUploader.on( 'select', function() {
			var imgurl = customUploader.state().get( 'selection' ).first().attributes.url;
			inputImage.val( imgurl ).trigger( 'change' );
			inputAvatar.attr( 'src', imgurl );
		});
		customUploader.open();
		e.preventDefault();
	});

	// Delete image
	jQuery( '.tm-categories-tiles-form-widget .upload-image .delete-image-url' ).click( function() {
		var _this = jQuery( this );
		var inputImage = _this.parents( '.category-area' ).find( '.custom-image-url' );
		var inputAvatar = _this.parents( '.category-area' ).find( '.upload-image img' );
		var defaultAvatar = inputAvatar.attr( 'default_image' );
		inputAvatar.attr( 'src', defaultAvatar );
		inputImage.val( '' ).trigger( 'change' );
		return false;
	});

	// Delete category
	jQuery( '.tm-categories-tiles-form-widget .category-area .delete-category' ).click( function() {
		var _this = jQuery( this );
		var category = _this.parents( '.category-area' );
		category.find( 'input' ).trigger( 'change' );
		category.remove();
		reInitWidget();
	});

	// Add category
	jQuery( '.tm-categories-tiles-form-widget .categories .add-category' ).click( function() {
		var _this = jQuery( this );
		var categories = _this.parents( '.tm-categories-tiles-form-widget' ).find( '.categories' );
		var categoriesCount = parseInt( categories.attr( 'count' ), 10 ) + 1;
		var category = _this.parents( '.tm-categories-tiles-form-widget' ).find( '.category-area' ).last();
		var categoryNew = category.clone();
		category.after( categoryNew );
		categories.attr( 'count', categoriesCount );
		categoryNew.find( 'h3 span' ).html( categoriesCount );
		categoryNew.find( 'input' ).trigger( 'change' );
		jQuery( document ).trigger( 'widget-change' );
		reInitWidget();
	});
}
