<?php
/**
 * Plugin Name:  TM Categories Tiles Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Categories tiles widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab-base-tm
 *
 * @package TM_Categories_Tiles_Widget
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'TM_Categories_Tiles_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab-base-tm' );
	}

	/**
	 * Set constant path of text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_PATH' ) ) {
		define( 'PHOTOLAB_BASE_TM_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Adds TM_Categories_Tiles_Widget widget.
	 */
	class TM_Categories_Tiles_Widget extends WP_Widget {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $instance_default = array();
		/**
		 * Default themes
		 *
		 * @var type array
		 */
		private $themes = array();
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'tm_categories_tiles_widget', // Base ID
				__( 'TM Categories Tiles Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'Categories Tiles widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'title'			=> __( 'Tiles', PHOTOLAB_BASE_TM_ALIAS ),
				'theme'			=> 0,
				'show_count'	=> 'false',
				'sort_is'		=> '1',
				'categories'	=> array( ),
			);

			$this->themes = array( 'grid-1-2', 'grid-1-5', 'line-3' );
		}

		/**
		 * Load languages
		 *
		 * @since 1.0.0
		 */
		public function include_languages() {
			load_plugin_textdomain( PHOTOLAB_BASE_TM_ALIAS, false, PHOTOLAB_BASE_TM_PATH );
		}

		/**
		 * Frontend view
		 *
		 * @param type $args array.
		 * @param type $instance array.
		 */
		public function widget( $args, $instance ) {
			foreach ( $this->instance_default as $key => $value ) {
				$$key = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			// Custom js
			wp_register_script( 'tm-categories-tiles-script-frontend', plugins_url( 'assets/js/frontend.min.js', __FILE__ ), '', '', true );
			wp_enqueue_script( 'tm-categories-tiles-script-frontend' );

			// Custom styles
			wp_register_style( 'tm-categories-tiles-frontend', plugins_url( 'assets/css/frontend.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-categories-tiles-frontend' );

			foreach ( $categories as &$category_item ) {
				$category_data = get_category( $category_item['category'] );
				$category_item['count'] = $category_data->category_count;
				$category_item['name'] = $category_data->name;
				$category_item['url'] = get_category_link( $category_data->term_id );
			}

			$view = __DIR__ . '/views/themes/' . $this->themes[ $theme ] . '.php';
			if ( file_exists( $view ) ) {
				require $view;
			}

		}

		/**
		 * Create admin form for widget
		 *
		 * @param type $instance array.
		 */
		public function form( $instance ) {
			foreach ( $this->instance_default as $key => $value ) {
				$$key = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			wp_enqueue_media();

			// Media uploader
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );

			// Custom styles
			wp_register_style( 'tm-categories-tiles-admin', plugins_url( 'assets/css/admin.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-categories-tiles-admin' );

			wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );

			// Custom script
			wp_register_script( 'tm-categories-tiles-admin', plugins_url( 'assets/js/', __FILE__ ) . 'admin.min.js', array( 'jquery' ) );

			wp_enqueue_script( 'tm-categories-tiles-admin' );

			wp_enqueue_style( 'thickbox' );

			// include ui-elements
			require_once __DIR__ . '/admin/lib/fox-ui-elements/ui-switcher.php';
			require_once __DIR__ . '/admin/lib/fox-ui-elements/ui-input.php';
			require_once __DIR__ . '/admin/lib/fox-ui-elements/ui-select.php';

			$title_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'title' ),
						'class'			=> 'title',
						'name'			=> $this->get_field_name( 'title' ),
						'value'			=> $title,
						'placeholder'	=> __( 'New title', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$title_html = $title_field->output();

			$theme_field = new UI_Select_Fox(
						array(
							'id'				=> $this->get_field_id( 'theme' ),
							'name'				=> $this->get_field_name( 'theme' ),
							'default'			=> $theme,
							'options'			=> $this->themes,
						)
					);
			$theme_html = $theme_field->output();

			$switcher = new UI_Switcher_Fox(
					array(
						'id'        => $this->get_field_id( 'show_count' ),
						'class'     => 'pull-right',
						'name'      => $this->get_field_name( 'show_count' ),
						'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
						'default'    => $show_count,
					)
			);
			$show_count_html = $switcher->output();

			$categories_list = get_categories( array( 'hide_empty' => 0 ) );
			$categories_array = array( '1' => 'default' );
			foreach ( $categories_list as $category_item ) {
				$categories_array[ $category_item->term_id ] = $category_item->name;
			}

			// Universal
			$default_image = plugins_url( 'images/', __FILE__ ) . 'default-image.jpg';

			$tiles_items = array();
			if ( is_array( $categories ) && count( $categories ) > 0 ) {
				foreach ( $categories as $key => $category_item ) {
					$category_field = new UI_Select_Fox(
								array(
									'id'				=> $this->get_field_id( 'category_' . $key ),
									'name'				=> $this->get_field_name( 'category[]' ),
									'default'			=> $category_item['category'],
									'options'			=> $categories_array,
								)
							);
					$image_field = new UI_Input_Fox(
								array(
									'id'			=> $this->get_field_id( 'image_' . $key ),
									'class'			=> 'custom-image-url',
									'type'			=> 'hidden',
									'name'			=> $this->get_field_name( 'image[]' ),
									'value'			=> $categories[ $key ]['image'],
								)
							);
					$tiles_items[] = array( 'src' => $categories[ $key ]['image'], 'image' => $image_field->output(), 'category' => $category_field->output() );
				}
			}

			$category_field = new UI_Select_Fox(
								array(
									'id'				=> $this->get_field_id( 'category_new' ),
									'name'				=> $this->get_field_name( 'category_new' ),
									'default'			=> 0,
									'options'			=> $categories_array,
								)
							);
			$image_field = new UI_Input_Fox(
								array(
									'id'			=> $this->get_field_id( 'image_new'),
									'class'			=> 'custom-image-url',
									'type'			=> 'hidden',
									'name'			=> $this->get_field_name( 'image_new' ),
									'value'			=> '',
								)
							);
			$tile_new = array( 'image' => $image_field->output(), 'category' => $category_field->output() );
			// show view
			require 'views/widget-form.php';
		}

		/**
		 * Update settings
		 *
		 * @param type $new_instance array.
		 * @param type $old_instance array.
		 * @return type array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ! empty( $new_instance['title'] ) ? $new_instance['title'] : $this->instance_default['title'];
			$instance['theme'] = ( ! empty( $new_instance['theme'] ) || 0 == $new_instance['theme'] ) ? $new_instance['theme'] : $this->instance_default['theme'];
			$instance['show_count'] = ! empty( $new_instance['show_count'] ) ? $new_instance['show_count'] : $this->instance_default['show_count'];
			$instance['sort_is'] = ! empty( $new_instance['sort_is'] ) ? $new_instance['sort_is'] : $this->instance_default['sort_is'];

			foreach ( $new_instance['category'] as $key => $category ) {
				if ( ! empty( $category ) ) {
					$instance['categories'][] = array( 'category' => $category, 'image' => $new_instance['image'][ $key ] );
				}
			}

			return $instance;
		}
	}

	/**
	 * Register widget
	 */
	function register_tm_categories_tiles_widget() {
		register_widget( 'tm_categories_tiles_widget' );
	}
	add_action( 'widgets_init', 'register_tm_categories_tiles_widget' );

}
