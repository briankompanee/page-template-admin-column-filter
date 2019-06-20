<?php

/**
 * The admin-filter functionality of the plugin.
 *
 * @link       https://thekompanee.com
 * @since      1.0.0
 *
 * @package    Bb_Page_Template_Column
 * @subpackage Bb_Page_Template_Column/admin
 */

/**
 * Class WordPress_Plugin_Template_Settings
 *
 */
class Bb_Page_Template_Column_Admin_Filter {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	//Add a page template admin column to the pages list view 
	function bbptc_pages_columns( $columns ) {
		$BbptcCustomColumns = array(
			'page-template-current' => __( 'Page Template', 'bb-page-template-column' )
		);
		$columns = array_merge( $columns, $BbptcCustomColumns );

		return $columns;
	}

	//Retrieve current page template slugs in theme and show nice names.
	function bbptc_page_column_content( $column_name, $post_id ) {
		if ( $column_name == 'page-template-current' ) {

			if ( $post_id ) {
				$available_templates = wp_get_theme()->get_page_templates();
				$page_template_current = get_post_meta( $post_id, '_wp_page_template', true );
				$current_template_name = '';

				if (! $page_template_current || 'default' == $page_template_current ) {
					$current_template_name = 'Default Template';
				} else {
					$current_template_name = $available_templates[$page_template_current];
				}

				update_post_meta( $post_id, 'current_page_template_name', $current_template_name );
				echo get_post_meta( $post_id, 'current_page_template_name', $current_template_name );
			}
		}
	}
}