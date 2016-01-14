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

<div class="tm-grid-1-5-widget">
	<h3><?php echo $title ?></h3>
	<div class="grid-wrap">
		<div class="cell-big" style="background: url(<?php echo $categories[0]['image'] ?>) no-repeat;">
			<div class="title"><?php echo $categories[0]['name'] ?></div>
			<?php if ( 'true' == $show_count ) : ?>
			<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $categories[0]['count'] ); ?></div>
			<?php endif; ?>
		</div>
		<div class="cell-small" style="background: url(<?php echo $categories[1]['image'] ?>) no-repeat;">
			<div class="title"><?php echo $categories[1]['name'] ?></div>
			<?php if ( 'true' == $show_count ) : ?>
			<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $categories[1]['count'] ); ?></div>
			<?php endif; ?>
		</div>
		<div class="cell-small" style="background: url(<?php echo $categories[2]['image'] ?>) no-repeat;">
			<div class="title"><?php echo $categories[2]['name'] ?></div>
			<?php if ( 'true' == $show_count ) : ?>
			<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $categories[2]['count'] ); ?></div>
			<?php endif; ?>
		</div>
		<div class="cell-small" style="background: url(<?php echo $categories[3]['image'] ?>) no-repeat;">
			<div class="title"><?php echo $categories[3]['name'] ?></div>
			<?php if ( 'true' == $show_count ) : ?>
			<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $categories[3]['count'] ); ?></div>
			<?php endif; ?>
		</div>
		<div class="cell-small" style="background: url(<?php echo $categories[4]['image'] ?>) no-repeat;">
			<div class="title"><?php echo $categories[4]['name'] ?></div>
			<?php if ( 'true' == $show_count ) : ?>
			<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $categories[4]['count'] ); ?></div>
			<?php endif; ?>
		</div>
		<div class="cell-small" style="background: url(<?php echo $categories[5]['image'] ?>) no-repeat;">
			<div class="title"><?php echo $categories[5]['name'] ?></div>
			<?php if ( 'true' == $show_count ) : ?>
			<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $categories[5]['count'] ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>
