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
}