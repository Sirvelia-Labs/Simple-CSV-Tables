<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sirvelia.com
 * @since             1.0.0
 * @package           Simple_CSV_Tables
 *
 * @wordpress-plugin
 * Plugin Name:       Simple CSV Tables
 * Plugin URI:        https://github.com/Sirvelia/Simple-CSV-Tables
 * Description:       Displays html tables from .csv files using a simple shortcode for each table.
 * Version:           1.0.1
 * Author:            Sirvelia
 * Author URI:        https://sirvelia.com
 * License:           GPL-3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       simple-csv-tables
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 *
 */
define( 'SIMPLE_CSV_TABLES_VERSION', '1.0.1' );
define( 'SIMPLE_CSV_TABLES_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-csv-tables-activator.php
 */
function activate_simple_csv_tables() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-csv-tables-activator.php';
	Simple_CSV_Tables_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-csv-tables-deactivator.php
 */
function deactivate_simple_csv_tables() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-csv-tables-deactivator.php';
	Simple_CSV_Tables_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_csv_tables' );
register_deactivation_hook( __FILE__, 'deactivate_simple_csv_tables' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-csv-tables.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_simple_csv_tables() {

	$plugin = new Simple_CSV_Tables();
	$plugin->run();

}
run_simple_csv_tables();
