<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sirvelia.com
 * @since      1.0.0
 *
 * @package    Simple_CSV_Tables
 * @subpackage Simple_CSV_Tables/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simple_CSV_Tables
 * @subpackage Simple_CSV_Tables/public
 * @author     Sirvelia <info@sirvelia.com>
 */
class Simple_CSV_Tables_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-csv-tables-public.css', array(), $this->version, 'all' );
		wp_register_style( 'datatables-css', plugin_dir_url( __FILE__ ) . 'css/datatables.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-csv-tables-public.js', array( 'jquery' ), $this->version, false );
		wp_register_script( 'datatables-js', plugin_dir_url( __FILE__ ) . 'js/datatables.min.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Registers all plugin shortcodes
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes(){

  	add_shortcode('show_csv_table', array($this, 'shortcode_csv_tables'));

  }

	/**
	 * Show CSV Tables shortcode
	 *
	 * @since    1.0.0
	 */
	public function shortcode_csv_tables($atts) {

		extract( shortcode_atts( array(
        'id' => 0,
    ), $atts, 'show_csv_table' ) );

		if( $id && is_numeric($id) ):
			$file_id = carbon_get_post_meta( $id, 'csv_file' );
			$delimiter = carbon_get_post_meta( $id, 'csv_delimiter' );
			if(!$delimiter) $delimiter = ',';
			if($file_id):
				$file_path = get_attached_file( $file_id );
				if($file_path):
					$rows = array_map(
						function($v) use ($delimiter)  { return str_getcsv($v, $delimiter); },
						file($file_path)
					);

					ob_start();
					if( !wp_script_is('datatables-js') ) wp_enqueue_script( 'datatables-js' );
					if( !wp_script_is($this->plugin_name) ) wp_enqueue_script( $this->plugin_name );
					if( !wp_style_is('datatables-css') ) wp_enqueue_style( 'datatables-css' );

					$header = array_shift($rows); ?>
					<table class="simple_csv_table">
						<thead>
	        		<tr>
								<?php foreach($header as $th): ?>
									<th><?= esc_html( $th ) ?></th>
								<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<?php foreach($rows as $row): ?>
								<tr>
									<?php foreach($row as $column): ?>
										<td><?= esc_html( $column ) ?></td>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?php return ob_get_clean();
				endif;
				return '<p>' . __( 'CSV table not found', 'simple-csv-tables' ) . '</p>';
			endif;
		endif;

		return '<p>' . __( 'Please provide a valid CSV table ID', 'simple_csv_tables' ) . '</p>';
	}

}
