<?php
/**
 * Frontend view
 *
 * @package TM_Categories_Tiles_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<div class="tm-line-3-widget">
	<h3><?php echo $title ?></h3>
	<div class="grid-wrap">
		<div class="cell-small" style="background: url(<?php echo $categories[0]['image'] ?>) no-repeat;">
			<div class="title"><?php echo $categories[0]['name'] ?></div>
			<?php if ( 'true' == $show_count ) : ?>
			<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $categories[0]['count']); ?></div>
			<?php endif; ?>
		</div>
		<div class="cell-small" style="background: url(<?php echo $categories[1]['image'] ?>) no-repeat;">
			<div class="title"><?php echo $categories[1]['name'] ?></div>
			<?php if ( 'true' == $show_count ) : ?>
			<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $categories[1]['count']); ?></div>
			<?php endif; ?>
		</div>
		<div class="cell-small" style="background: url(<?php echo $categories[2]['image'] ?>) no-repeat;">
			<div class="title"><?php echo $categories[2]['name'] ?></div>
			<?php if ( 'true' == $show_count ) : ?>
			<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $categories[2]['count']); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>
