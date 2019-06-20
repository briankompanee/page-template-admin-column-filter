<?php

/**
 *
 * @link              https://thekompanee.com
 * @since             1.0.0
 * @package           Bb_Page_Template_Column
 *
 * @wordpress-plugin
 * Plugin Name:       Brian's Page Template Column
 * Plugin URI:        https://thekompanee.com
 * Description:      	A plugin that lets authors easily see which template a page is using and also see only pages using a particular template.
 * Version:           1.0.0
 * Author:            Brian Brown
 * Author URI:        https://thekompanee.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bb-page-template-column
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BB_PAGE_TEMPLATE_COLUMN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bb-page-template-column-activator.php
 */
function activate_bb_page_template_column() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bb-page-template-column-activator.php';
	Bb_Page_Template_Column_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bb-page-template-column-deactivator.php
 */
function deactivate_bb_page_template_column() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bb-page-template-column-deactivator.php';
	Bb_Page_Template_Column_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bb_page_template_column' );
register_deactivation_hook( __FILE__, 'deactivate_bb_page_template_column' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bb-page-template-column.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bb_page_template_column() {

	$plugin = new Bb_Page_Template_Column();
	$plugin->run();

}
run_bb_page_template_column();
