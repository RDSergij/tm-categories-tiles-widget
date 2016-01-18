<?php
/**
 * Admin view
 *
 * @package TM_Categories_Tiles_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

?>
<!-- Widget Form -->
<div class="tm-categories-tiles-form-widget">
	<p>
		<?php echo $title_html ?>
	</p>

	<p>
		<label><?php _e( 'Theme', PHOTOLAB_BASE_TM_ALIAS ) ?></label>
		<?php echo $theme_html ?>
	</p>

	<div class="show-count">
		<label><?php _e( 'Show posts', PHOTOLAB_BASE_TM_ALIAS ) ?></label>
		<?php echo $show_count_html ?>
	</div>

	<div class="categories" count="<?php echo count( $tiles_items ) ?>">
		<?php if ( is_array( $tiles_items ) && count( $tiles_items ) >0 ) : ?>
		<?php foreach( $tiles_items as $key => $tile_item) : ?>
		<div class="category-area">
			<i class="fa fa-times delete-category"></i>
			<h3><?php echo __( 'Category', PHOTOLAB_BASE_TM_ALIAS ) ?> <span><?php echo $key + 1 ?></span></h3>
			<p>
				<?php echo $tile_item['category'] ?>
			</p>

			<p>
				<label><?php _e( 'Category image', PHOTOLAB_BASE_TM_ALIAS ) ?></label><br/>
				<?php echo $tile_item['image'] ?>
			</p>

			<div class="upload-image">
				<i class="fa fa-times delete-image-url"></i>
				<?php if ( ! empty( $tile_item['src'] ) ) : ?>
				<?php $src = $tile_item['src']; ?>
				<?php else : ?>
				<?php $src = $default_image; ?>
				<?php endif; ?>
				<img default_image="<?php echo $default_image ?>" src="<?php echo $src ?>">
			</div>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>
		<i class="add-category fa fa-plus-square"> add category</i>
	</div>

	<p>&nbsp;</p>
</div>
<!-- End widget Form -->
