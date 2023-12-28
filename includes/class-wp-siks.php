<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Siks
 * @subpackage Wp_Siks/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Siks
 * @subpackage Wp_Siks/includes
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
class Wp_Siks {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Siks_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_SIKS_VERSION' ) ) {
			$this->version = WP_SIKS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp-siks';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Siks_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Siks_i18n. Defines internationalization functionality.
	 * - Wp_Siks_Admin. Defines all hooks for the admin area.
	 * - Wp_Siks_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-siks-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-siks-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-siks-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-siks-public.php';

		$this->loader = new Wp_Siks_Loader();

		// Functions tambahan
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-siks-functions.php';

		$this->functions = new Siks_Functions( $this->plugin_name, $this->version );

		$this->loader->add_action('template_redirect', $this->functions, 'allow_access_private_post', 0);

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Siks_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Siks_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Siks_Admin( $this->get_plugin_name(), $this->get_version(), $this->functions );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_sql_migrate_siks', $plugin_admin, 'sql_migrate_siks' );
  		$this->loader->add_action( 'wp_ajax_import_excel_lansia',  $plugin_admin, 'import_excel_lansia');
  		$this->loader->add_action( 'wp_ajax_import_excel_disabilitas',  $plugin_admin, 'import_excel_disabilitas');
  		$this->loader->add_action( 'wp_ajax_import_excel_bunda_kasih',  $plugin_admin, 'import_excel_bunda_kasih');
  		$this->loader->add_action( 'wp_ajax_import_excel_anak_terlantar',  $plugin_admin, 'import_excel_anak_terlantar');
  		$this->loader->add_action( 'wp_ajax_import_excel_lksa',  $plugin_admin, 'import_excel_lksa');

		$this->loader->add_action('carbon_fields_register_fields', $plugin_admin, 'crb_attach_siks_options');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Siks_Public( $this->get_plugin_name(), $this->get_version(), $this->functions );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action('wp_ajax_get_data_dtks',  $plugin_public, 'get_data_dtks');
		$this->loader->add_action('wp_ajax_nopriv_get_data_dtks',  $plugin_public, 'get_data_dtks');
		$this->loader->add_action('wp_ajax_get_data_bansos',  $plugin_public, 'get_data_bansos');
		$this->loader->add_action('wp_ajax_nopriv_get_data_bansos',  $plugin_public, 'get_data_bansos');
		$this->loader->add_action('wp_ajax_refresh_token',  $plugin_public, 'refresh_token');
		$this->loader->add_action('wp_ajax_nopriv_refresh_token',  $plugin_public, 'refresh_token');
		$this->loader->add_action('wp_ajax_set_token',  $plugin_public, 'set_token');
		$this->loader->add_action('wp_ajax_nopriv_set_token',  $plugin_public, 'set_token');
		$this->loader->add_action('wp_ajax_send_message',  $plugin_public, 'send_message');
		$this->loader->add_action('wp_ajax_nopriv_send_message',  $plugin_public, 'send_message');
		$this->loader->add_action('wp_ajax_set_captcha',  $plugin_public, 'set_captcha');
		$this->loader->add_action('wp_ajax_nopriv_set_captcha',  $plugin_public, 'set_captcha');
		$this->loader->add_action('wp_ajax_get_captcha',  $plugin_public, 'get_captcha');
		$this->loader->add_action('wp_ajax_nopriv_get_captcha',  $plugin_public, 'get_captcha');
		$this->loader->add_action('wp_ajax_proses_captcha',  $plugin_public, 'proses_captcha');
		$this->loader->add_action('wp_ajax_nopriv_proses_captcha',  $plugin_public, 'proses_captcha');
		$this->loader->add_action('wp_ajax_singkronisasi_dtks',  $plugin_public, 'singkronisasi_dtks');
		$this->loader->add_action('wp_ajax_nopriv_singkronisasi_dtks',  $plugin_public, 'singkronisasi_dtks');
		$this->loader->add_action('wp_ajax_get_datatable_lansia',  $plugin_public, 'get_datatable_lansia');
		$this->loader->add_action('wp_ajax_get_data_lansia_by_id',  $plugin_public, 'get_data_lansia_by_id');
		$this->loader->add_action('wp_ajax_tambah_data_lansia',  $plugin_public, 'tambah_data_lansia');
		$this->loader->add_action('wp_ajax_hapus_data_lansia_by_id', $plugin_public, 'hapus_data_lansia_by_id');
		$this->loader->add_action('wp_ajax_get_datatable_disabilitas',  $plugin_public, 'get_datatable_disabilitas');
		$this->loader->add_action('wp_ajax_get_data_disabilitas_by_id',  $plugin_public, 'get_data_disabilitas_by_id');
		$this->loader->add_action('wp_ajax_tambah_data_disabilitas',  $plugin_public, 'tambah_data_disabilitas');
		$this->loader->add_action('wp_ajax_hapus_data_disabilitas_by_id', $plugin_public, 'hapus_data_disabilitas_by_id');
		$this->loader->add_action('wp_ajax_get_datatable_bunda_kasih',  $plugin_public, 'get_datatable_bunda_kasih');
		$this->loader->add_action('wp_ajax_get_data_bunda_kasih_by_id',  $plugin_public, 'get_data_bunda_kasih_by_id');
		$this->loader->add_action('wp_ajax_tambah_data_bunda_kasih',  $plugin_public, 'tambah_data_bunda_kasih');
		$this->loader->add_action('wp_ajax_hapus_data_bunda_kasih_by_id', $plugin_public, 'hapus_data_bunda_kasih_by_id');
		$this->loader->add_action('wp_ajax_get_datatable_odgj',  $plugin_public, 'get_datatable_odgj');
		$this->loader->add_action('wp_ajax_get_data_odgj_by_id',  $plugin_public, 'get_data_odgj_by_id');
		$this->loader->add_action('wp_ajax_tambah_data_odgj',  $plugin_public, 'tambah_data_odgj');
		$this->loader->add_action('wp_ajax_hapus_data_odgj_by_id', $plugin_public, 'hapus_data_odgj_by_id');

		add_shortcode('cek_bansos', array($plugin_public, 'cek_bansos'));
		add_shortcode('peta_desa_siks', array($plugin_public, 'peta_desa_siks'));
		add_shortcode('peta_data_terpadu_siks', array($plugin_public, 'peta_data_terpadu_siks'));
		add_shortcode('peta_kecamatan_siks', array($plugin_public, 'peta_kecamatan_siks'));
		add_shortcode('data_dtks_siks', array($plugin_public, 'data_dtks_siks'));
		add_shortcode('management_data_lansia', array($plugin_public, 'management_data_lansia'));
		add_shortcode('management_data_disabilitas', array($plugin_public, 'management_data_disabilitas'));
		add_shortcode('management_data_bunda_kasih', array($plugin_public, 'management_data_bunda_kasih'));
		add_shortcode('management_data_anak_terlantar', array($plugin_public, 'management_data_anak_terlantar'));
		add_shortcode('management_data_anak_terlantar', array($plugin_public, 'management_data_anak_terlantar'));
		add_shortcode('management_data_odgj', array($plugin_public, 'management_data_odgj'));
		add_shortcode('management_data_lksa', array($plugin_public, 'management_data_lksa'));
		add_shortcode('data_lansia_siks', array($plugin_public, 'data_lansia_siks'));
		add_shortcode('data_disabilitas_siks', array($plugin_public, 'data_disabilitas_siks'));
		add_shortcode('data_bunda_kasih_siks', array($plugin_public, 'data_bunda_kasih_siks'));
		add_shortcode('data_anak_terlantar_siks', array($plugin_public, 'data_anak_terlantar_siks'));
		add_shortcode('data_gepeng_siks', array($plugin_public, 'data_gepeng_siks'));
		add_shortcode('data_odgj_siks', array($plugin_public, 'data_odgj_siks'));

		// untuk menjalankan conjob refresh session
		$this->loader->add_action('siks_conjob',  $plugin_public, 'refresh_token');
		// untuk menambahkan custom waktu cronjob. secara default paling sedikit adalah per 1 jam
		$this->loader->add_filter('cron_schedules',  $plugin_public, 'my_cron_schedules');
		$this->loader->add_filter('carbon_fields_map_field_api_key',  $plugin_public, 'crb_get_gmaps_api_key_siks');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Siks_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
