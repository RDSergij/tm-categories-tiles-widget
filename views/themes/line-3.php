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
		<?php foreach ( $categories as $index => $category ) : ?>
			<?php if ( 3 < $index ) : ?>
				<a href="<?php echo $category['url'] ?>">
					<div class="cell-small" 
						<?php if ( ! empty( $category['image'] ) ) : ?>
						style="background: url(<?php echo $category['image'] ?>) no-repeat;"
						<?php endif; ?>
						>
						<div class="title"><?php echo $category['name'] ?></div>
						<?php if ( 'true' == $show_count ) : ?>
						<div class="count"><?php printf( __( '%d posts', PHOTOLAB_BASE_TM_ALIAS ), $category['count'] ); ?></div>
						<?php endif; ?>
					</div>
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</div>
