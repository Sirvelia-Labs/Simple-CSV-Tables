<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://sirvelia.com
 * @since      1.0.0
 *
 * @package    Simple_CSV_Tables
 * @subpackage Simple_CSV_Tables/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Simple_CSV_Tables
 * @subpackage Simple_CSV_Tables/includes
 * @author     Sirvelia <info@sirvelia.com>
 */
class Simple_CSV_Tables_i18n
{


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain(
			'simple-csv-tables',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);
	}
}
