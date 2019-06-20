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

	//Create the admin drop down filter and add template selections
	function page_template_filtering( $post_type ){
	  if('page' !== $post_type){
	    return; //filter your post
	  }

	  //Create the selector
	  $selected = '';
	  $request_attr = 'current_page_template_name';

	  if ( isset($_REQUEST[$request_attr]) ) {
	    $selected = $_REQUEST[$request_attr];
	  }

	  //get unique values of the meta field to filer by.
	  $meta_key = 'current_page_template_name';
	  global $wpdb;
	  $results = $wpdb->get_col(
	      $wpdb->prepare( "
	          SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
	          LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
	          WHERE pm.meta_key = '%s'
	          AND p.post_status IN ('publish', 'draft')
	          ORDER BY pm.meta_value",
	          $meta_key
	      )
	  );

	 //build a custom dropdown list of values to filter by
	  echo '<select id="current_page_template_name" name="current_page_template_name">';
	  echo '<option value="0">' . __( 'Show all Page Templates', 'bb-page-template-column' ) . ' </option>';
	  foreach($results as $current_page_template_name){
	    $select = ($current_page_template_name == $selected) ? ' selected="selected"':'';
	    echo '<option value="'.$current_page_template_name.'"'.$select.'>' . $current_page_template_name . ' </option>';
	  }
	  echo '</select>';
	}

	//Modify the dropdown filter query for the page templates custom field.
	function filter_request_query( $query ){

	  if( !(is_admin() AND $query->is_main_query()) ){
	    return $query;
	  }

	  if( !(isset($_REQUEST['current_page_template_name']) ) ){
	    return $query;
	  }

	  if(0 == $_REQUEST['current_page_template_name']){
	    return $query;
	  }

	 //modify the query_vars and com and compare custom field vaule to drop down selected field.
	  $query->query_vars = array(array(
	    'field' => 'current_page_template_name',
	    'value' => $_REQUEST['current_page_template_name'],
	    'compare' => '=',
	    'type' => 'CHAR'
	  ));
	  return $query;
	}

	//Add Custom Field meta to search.
	function bbptc_custom_query_vars_filter( $vars ) {
	  $vars[] .= 'current_page_template_name';
	  return $vars;
	}

	//Alter Page search query to add custom field meta to query string.
	function bbptc_alter_query( $query ) {

	  if ( !is_admin() || 'page' != $query->query['post_type'] ){
	    return;
	  }

	  if( !(isset($_REQUEST['current_page_template_name']) ) ){
	    return;
	  }

	  if ( $query->query_vars['current_page_template_name'] ) {
	      $query->set( 'meta_key', 'current_page_template_name' );
	      $query->set( 'meta_value', $query->query_vars['current_page_template_name'] );
	  }
	}

}
//Execute Filters and Actions in order as needed.
$BbptcFilterClass = new Bb_Page_Template_Column_Admin_Filter( $this->plugin_name, $this->version );
add_filter( 'manage_pages_columns', array($BbptcFilterClass,'bbptc_pages_columns') );
add_action( 'manage_pages_custom_column', array($BbptcFilterClass,'bbptc_page_column_content'), 10, 2 );
add_action('restrict_manage_posts', array($BbptcFilterClass,'page_template_filtering'), 10);
add_filter( 'parse_query', array($BbptcFilterClass,'filter_request_query'), 10);
add_filter( 'query_vars', array($BbptcFilterClass,'bbptc_custom_query_vars_filter') );
add_action( 'pre_get_posts', array($BbptcFilterClass,'bbptc_alter_query') );