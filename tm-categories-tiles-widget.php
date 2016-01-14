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
				'title'			=> __( 'About me', PHOTOLAB_BASE_TM_ALIAS ),
				'theme'			=> 0,
				'show_count'	=> 'false',
				'sort_is'		=> '1',
				'categories'	=> array( 0 => array( 'category' => 1, 'image' => '' ) ),
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

			// Ui cherri api
			wp_register_script( 'tm-categories-tiles-script-api', plugins_url( 'assets/js/cherry-api.js', __FILE__ ), array( 'jquery' ) );
			wp_localize_script( 'tm-categories-tiles-script-api', 'cherry_ajax', wp_create_nonce( 'cherry_ajax_nonce' ) );
			wp_localize_script( 'tm-categories-tiles-script-api', 'wp_load_style', null );
			wp_localize_script( 'tm-categories-tiles-script-api', 'wp_load_script', null );
			wp_enqueue_script( 'tm-categories-tiles-script-api' );

			// Sortable
			wp_register_script( 'jquery-ui-sortable', plugins_url( 'assets/js/jquery-ui-sortable.min.js', __FILE__ ), array( 'jquery' ) );

			// Media uploader
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );

			// Custom styles
			wp_register_style( 'tm-categories-tiles-admin', plugins_url( 'assets/css/admin.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-categories-tiles-admin' );

			// Custom script
			wp_register_script( 'tm-categories-tiles-admin', plugins_url( 'assets/js/', __FILE__ ) . 'admin.min.js', array( 'jquery' ) );

			wp_enqueue_script( 'tm-categories-tiles-admin' );

			wp_enqueue_style( 'thickbox' );

			// include ui-elements
			require_once __DIR__ . '/admin/lib/ui-elements/ui-text/ui-text.php';
			require_once __DIR__ . '/admin/lib/ui-elements/ui-select/ui-select.php';
			require_once __DIR__ . '/admin/lib/ui-elements/ui-switcher/ui-switcher.php';

			$title_field = new UI_Text(
							array(
									'id'            => $this->get_field_id( 'title' ),
									'type'          => 'text',
									'class'			=> 'title',
									'name'          => $this->get_field_name( 'title' ),
									'placeholder'   => __( 'New title', PHOTOLAB_BASE_TM_ALIAS ),
									'value'         => $title,
									'label'         => __( 'Title widget', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$title_html = $title_field->render();

			$sort_is_field = new UI_Text(
							array(
									'id'            => $this->get_field_id( 'sort_is' ),
									'class'			=> 'sort-is',
									'type'          => 'text',
									'name'          => $this->get_field_name( 'sort_is' ),
									'value'         => $sort_is,
							)
					);
			$sort_is_html = $sort_is_field->render();

			$theme_field = new UI_Select(
						array(
							'id'				=> $this->get_field_id( 'theme' ),
							'name'				=> $this->get_field_name( 'theme' ),
							'value'				=> $theme,
							'options'			=> $this->themes,
						)
					);
			$theme_html = $theme_field->render();

			$show_count_field = new UI_Switcher2(
						array(
							'value'				=> $show_count,
							'id'				=> $this->get_field_name( 'show_count' ),
							'name'				=> $this->get_field_name( 'show_count' ),
							'style'				=> 'small',
							'toggle'			=> array(
												'true_toggle'	=> 'On',
												'false_toggle'	=> 'Off',
										),
						)
					);
			$show_count_html = $show_count_field->render();

			$categories_list = get_categories( array( 'hide_empty' => 0 ) );
			$categories_array = array( '1' => 'default' );
			foreach ( $categories_list as $category_item ) {
				$categories_array[ $category_item->term_id ] = $category_item->name;
			}

			// Universal
			$default_image = plugins_url( 'images/', __FILE__ ) . 'default-image.jpg';

			$upload_field = new UI_Text(
							array(
									'id'			=> $this->get_field_id( 'upload_image_button' ),
									'class'			=> 'upload_image_button button-image',
									'type'			=> 'button',
									'name'			=> $this->get_field_name( 'upload_image_button' ),
									'value'			=> __( 'Upload image', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$upload_html = $upload_field->render();

			$delete_field = new UI_Text(
							array(
									'id'			=> $this->get_field_id( 'delete_image' ),
									'class'			=> 'delete_image_url button-image',
									'type'			=> 'button',
									'name'			=> $this->get_field_name( 'delete_image' ),
									'value'			=> __( 'Delete image', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$delete_image_html = $delete_field->render();

			$displayed_images = array();
			for ( $i = 0; $i < 6; $i++ ) {
				$displayed_images[ $i ] = $categories[ $i ]['image'];
				if ( empty( $categories[ $i ]['category'] ) ) {
					$categories[ $i ]['category'] = 0;
				}
				if ( empty( $categories[ $i ]['image'] ) ) {
					$categories[ $i ]['image'] = '';
				}

				$category_field = new UI_Select(
							array(
								'id'				=> $this->get_field_id( 'category_' . $i ),
								'name'				=> $this->get_field_name( 'category[]' ),
								'value'				=> $categories[ $i ]['category'],
								'options'			=> $categories_array,
							)
						);
				$category_{$i . '_html'} = $category_field->render();

				$image_field = new UI_Text(
								array(
										'id'			=> $this->get_field_id( 'image_' . $i ),
										'class'			=> 'custom-image-url',
										'type'			=> 'hidden',
										'name'			=> $this->get_field_name( 'image[]' ),
										'value'			=> $categories[ $i ]['image'],
								)
						);
				$image_{$i . '_html'} = $image_field->render();
			}

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
				$instance['categories'][] = array( 'category' => $category, 'image' => $new_instance['image'][ $key ] );
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
