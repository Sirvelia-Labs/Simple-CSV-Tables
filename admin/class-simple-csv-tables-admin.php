<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Simple_CSV_Tables
 * @subpackage Simple_CSV_Tables/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_CSV_Tables
 * @subpackage Simple_CSV_Tables/admin
 * @author     Your Name <email@example.com>
 */
class Simple_CSV_Tables_Admin {

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

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_CSV_Tables_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_CSV_Tables_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simple-csv-tables-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_CSV_Tables_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_CSV_Tables_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simple-csv-tables-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Registers CSV table Custom Post Type.
	 *
	 * @since    1.0.0
	 */
	public function create_csv_table_cpt() {

		$labels = array(
			'name'                  => _x( 'CSV tables', 'Post Type General Name', 'simple-csv-tables' ),
			'singular_name'         => _x( 'CSV table', 'Post Type Singular Name', 'simple-csv-tables' ),
		);
		$args = array(
			'label'                 => __( 'CSV table', 'simple-csv-tables' ),
			'labels'                => $labels,
			'supports'              => array( 'title' ),
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 4,
			'menu_icon'							=> 'dashicons-editor-table',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
		);
		register_post_type( 'csv-table', $args);

	}

	/**
	 * Loads Composer dependencies.
	 *
	 * @since    1.0.0
	 */
	public function load_vendor() {
		require_once SIMPLE_CSV_TABLES_PATH . 'vendor/autoload.php';
    \Carbon_Fields\Carbon_Fields::boot();
	}

	/**
	 * Creates CSV Table CPT fields
	 *
	 * @since    1.0.0
	 */
	public function create_fields() {

		Container::make( 'post_meta', __( 'Import file' ) )
				->where( 'post_type', '=', 'csv-table' )
        ->add_fields( array(
					Field::make( 'file', 'csv_file', __( 'CSV file' ) )
						->set_type( array( 'text/csv' ) )
						->set_width( 33 ),
					Field::make( 'text', 'csv_delimiter', __( 'CSV delimiter' ) )
						->set_default_value( ',' )
						->set_width( 33 ),
					Field::make( 'html', 'csv_shortcode', __( 'Shortcode' ) )
						->set_html( array($this, 'show_shortcode') )
						->set_width( 34 )
        ) );

	}

	/**
	 * Show shortcode in CPT
	 *
	 * @since    1.0.0
	 */
	function show_shortcode() {

		if(isset($_GET['post'])):
	    $post_id = $_GET['post'];
			return '
	    <div class="cf-field__head">
	      <label class="cf-field__label" style="display: block">
	        Shortcode
	      </label>
	    </div><p>[show_csv_table id=' . $post_id .']</p>';
		endif;
		return '';

	}

	/**
	 * Sets CSV Table CPT column names
	 *
	 * @since    1.0.0
	 */
	public function set_csv_admin_columns($columns) {
	    $columns['csv_shortcode'] = __( 'Shortcode', 'simple-csv-tables' );
	    return $columns;
	}

	/**
	 * Adds CSV Table CPT column data
	 *
	 * @since    1.0.0
	 */
	public function add_csv_admin_columns_data($column, $post_id) {

		switch ( $column ) {
      case 'csv_shortcode' :
        echo '[show_csv_table id=' . $post_id .']';
        break;
    }

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

		if($id):
			$file_id = carbon_get_post_meta( $id, 'csv_file' );
			$delimiter = carbon_get_post_meta( $id, 'csv_delimiter' );
			if($file_id):
				$file_path = get_attached_file( $file_id );
				if($file_path):
					$rows = array_map(
						function($v) use ($delimiter)  { return str_getcsv($v, $delimiter); },
						file($file_path)
					);

					ob_start();
					$header = array_shift($rows); ?>
					<table class="table">
        		<tr>
							<?php foreach($header as $th): ?>
								<th><?= $th ?></th>
							<?php endforeach; ?>
						</tr>
						<tr>
							<?php foreach($rows as $row): ?>
								<tr>
									<?php foreach($row as $column): ?>
										<td><?= $column ?></td>
									<?php endforeach; ?>
								</tr>
							<?php endforeach; ?>
						</tr>
					</table>
					<?php return ob_get_clean();
				endif;
				return '<p>CSV table not found.</p>';
			endif;
		endif;

		return '<p>Please provide a valid CSV table ID</p>';
	}

}
