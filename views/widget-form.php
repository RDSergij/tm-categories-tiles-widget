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
	<?php echo $sort_is_html ?>

	<div class="sortable">
		<?php for ( $i = 0; $i < 6; $i++ ) : ?>
		<div class="category-area">
			<h3><?php printf( __( 'Category %d ', PHOTOLAB_BASE_TM_ALIAS ), $i + 1 ); ?></h3>
			<p>
				<?php echo $category_{$i . '_html'} ?>
			</p>

			<p>
				<label><?php _e( 'Category image', PHOTOLAB_BASE_TM_ALIAS ) ?></label><br/>
				<?php echo $upload_html ?>
				<?php echo $delete_image_html ?>
				<?php echo $image_{$i . '_html'} ?>
			</p>

			<p class="avatar">
				<?php if ( ! empty( $displayed_images[ $i ] ) ) : ?>
				<?php $src = $displayed_images[ $i ]; ?>
				<?php else : ?>
				<?php $src = $default_image; ?>
				<?php endif; ?>
				<img default_image="<?php echo $default_image ?>" src="<?php echo $src ?>">
			</p>
		</div>
		<?php endfor; ?>
	</div>

	<p>&nbsp;</p>
</div>
<!-- End widget Form -->
