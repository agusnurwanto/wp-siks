<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Siks
 * @subpackage Wp_Siks/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Siks
 * @subpackage Wp_Siks/public
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */

require_once SIKS_PLUGIN_PATH . "/public/trait/CustomTrait.php";

class Wp_Siks_Public
{
	use CustomTraitSiks;

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

	private $functions;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version, $functions)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Siks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Siks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name . 'datatables', plugin_dir_url(__FILE__) . 'css/jquery.dataTables.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-siks-public.css', array(), $this->version, 'all');
		wp_enqueue_style('dashicons');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Siks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Siks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name . 'crypto-js', plugin_dir_url(__FILE__) . 'js/crypto-js.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'bootstrap', plugin_dir_url(__FILE__) . 'js/bootstrap.bundle.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'datatables', plugin_dir_url(__FILE__) . 'js/jquery.dataTables.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'chart', plugin_dir_url(__FILE__) . 'js/chart.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-siks-public.js', array('jquery'), $this->version, false);
		wp_localize_script($this->plugin_name, 'ajax', array(
			'url' => admin_url('admin-ajax.php'),
			'apikey' => get_option(SIKS_APIKEY)
		));
	}

	public function cek_bansos()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-cek-bansos.php';
	}

	public function disabilitas_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-disabilitas-per-desa.php';
	}

	public function lksa_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-lksa-per-desa.php';
	}

	public function wrse_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-wrse-per-desa.php';
	}

	public function hibah_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-hibah-per-desa.php';
	}

	public function bunda_kasih_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-bunda-kasih-per-desa.php';
	}

	public function gepeng_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-gepeng-per-desa.php';
	}

	public function dtks_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-dtks-per-desa.php';
	}

	public function odgj_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-odgj-per-desa.php';
	}

	public function anak_terlantar_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-anak-terlantar-per-desa.php';
	}

	public function p3ke_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-p3ke-per-desa.php';
	}

	public function lansia_per_desa($atts)
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-lansia-per-desa.php';
	}

	public function management_data_lansia()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-lansia.php';
	}

	public function management_calon_p3ke()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-calon-penerima-p3ke.php';
	}

	public function management_wrse()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-wrse.php';
	}

	public function management_hibah()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-hibah.php';
	}

	public function data_calon_p3ke()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-calon-penerima-p3ke.php';
	}

	public function data_hibah_siks()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-hibah.php';
	}

	public function data_wrse_siks()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-wrse.php';
	}

	public function data_odgj_siks()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-odgj.php';
	}

	public function management_data_disabilitas()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-disabilitas.php';
	}

	public function management_data_bunda_kasih()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-bunda-kasih.php';
	}

	public function management_data_anak_terlantar()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-anak-terlantar.php';
	}

	public function management_data_lksa()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-data-lksa.php';
	}

	public function management_data_odgj()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-odgj.php';
	}

	public function management_data_p3ke()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-p3ke.php';
	}

	public function peta_data_terpadu_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-peta-data-terpadu-siks.php';
	}

	public function peta_desa_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-peta-desa.php';
	}

	public function peta_kecamatan_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-peta-desa.php';
	}

	public function data_dtks_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-dtks.php';
	}

	public function data_lansia_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-lansia.php';
	}

	public function data_p3ke_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-p3ke.php';
	}

	public function data_disabilitas_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-disabilitas.php';
	}

	public function data_bunda_kasih_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-bunda-kasih.php';
	}

	public function data_anak_terlantar_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-anak-terlantar.php';
	}

	public function data_gepeng_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-gepeng.php';
	}

	public function usulan_dtks($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-usulan-dtks.php';
	}

	public function usulan_lansia($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-usulan-lansia.php';
	}

	public function usulan_disabilitas($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-usulan-disabilitas.php';
	}

	public function usulan_bunda_kasih($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-usulan-bunda-kasih.php';
	}

	public function usulan_anak_terlantar($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-usulan-anak-terlantar.php';
	}

	public function usulan_odgj($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-usulan-odgj.php';
	}

	public function usulan_p3ke($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-usulan-p3ke.php';
	}

	public function usulan_wrse($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}

		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-usulan-wrse.php';
	}

	public function usulan_hibah($atts)
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-usulan-hibah.php';
	}

	public function list_verifikasi_usulan()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/usulan/wp-siks-list-verifikasi-usulan.php';
	}

	public function get_data_bansos_lama()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data bansos!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_data_bansos()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data bansos!'
		);
		if (!empty($_POST)) {
			if (isset($_POST['g-recaptcha-response'])) {
				$captcha = $_POST['g-recaptcha-response'];
			}
			if (!$captcha) {
				$ret['status'] = 'error';
			}
			$secretKey = get_option('_crb_siks_captcha_private');
			$ip = $_SERVER['REMOTE_ADDR'];
			// post request to server
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
			$response = file_get_contents($url);
			$responseKeys = json_decode($response, true);
			if (empty($responseKeys["success"])) {
				$ret['status'] = 'error';
				$ret['message'] = 'Harap selesaikan validasi captcha dulu!';
			} else {
				if (!empty($_POST['nik']) || !empty($_POST['data'])) {
					$auto_login = get_option('_crb_siks_auto_login');
					$login = false;
					if (is_user_logged_in()) {
						$current_user = wp_get_current_user();
						if ($this->functions->user_has_role($current_user->ID, 'administrator')) {
							$login = true;
						}
					}

					if ($auto_login == 1) {
						$param_encrypt = $_POST['data'];
						$options = array(
							'url' => 'https://api.kemensos.go.id/viewbnba/bnba-list',
							'data' => array('data' => $param_encrypt),
							'header' => array(
								'Authorization: ' . get_option('_crb_siks_cookie')
							)
						);
						$data = $this->functions->curl_post($options);
						$data_asli = str_replace('"', '', $data);
						if (empty($data_asli)) {
							$ret['status'] = 'error';
							$ret['message'] = 'Tidak bisa terhubung ke server. Coba lagi nanti!';
						} else {
							if (strpos('cURL Error', $data_asli) === true) {
								$ret['status'] = 'error';
								$ret['message'] = 'Tidak bisa terhubung ke server. Coba lagi nanti!';
							}
							if ($login == false) {
								$ret['data'] = $data_asli;
							} else {
								$ret['options'] = $options;
								$ret['data'] = $data_asli;
							}
						}
					} else {
						$select = array(
							'update_at',
							'NOKK',
							'NIK',
							'Nama',
							'Alamat',
							'FIRST_SK',
							'padankan_at',
							'BPNT',
							'PKH',
							'PBI',
							'BLT',
							'BLT_BBM',
							'keterangan_meninggal',
							'keterangan_disabilitas'
						);
						if ($login == true) {
							$select[] = 'BST';
							$select[] = 'BNPT_PPKM';
							$select[] = 'RUTILAHU';
						}
						$select = implode(', ', $select);
						$data = $wpdb->get_results($wpdb->prepare("
							SELECT
								$select
							FROM data_dtks
							WHERE NIK=%s
						", $_POST['nik']), ARRAY_A);
						$ret['data'] = $data;
						if ($login == true) {
							$ret['sql'] = $wpdb->last_query;
						}
					}
				} else {
					$ret['status'] = 'error';
					$ret['message'] = 'NIK tidak boleh kosong!';
				}
			}
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function refresh_token()
	{
		$no_error = get_option('siks_cronjob_error');
		$no = get_option('siks_cronjob');
		$current_cookie = get_option('_crb_siks_cookie');
		$last_cookie = get_option('siks_last_cookie');
		if ($current_cookie != $last_cookie) {
			$no = 0;
			$no_error = 0;
			update_option('siks_last_cookie', $current_cookie);
		}
		if ($no_error >= 10) {
			die('Maksimal error get data ke server. RUN sukses ke ' . $no . ' dan RUN error ke ' . $no_error);
		}
		$param_encrypt = get_option('_crb_siks_param_encrypt');
		$data = $this->functions->curl_post(array(
			'url' => 'https://api.kemensos.go.id/viewbnba/bnba-list',
			'data' => array('data' => $param_encrypt),
			'header' => array(
				'Authorization: ' . $current_cookie
			)
		));
		$data_asli = str_replace('"', '', $data);
		if (!empty($data_asli)) {
			if (empty($no)) {
				$no = 0;
			}
			$no++;
			update_option('siks_cronjob', $no);
			update_option('siks_cronjob_error', 0);
			die('Sukses run ke ' . $no);
		} else {
			if (empty($no_error)) {
				$no_error = 0;
			}
			$no_error++;
			update_option('siks_cronjob_error', $no_error);
			die('Error get data ke server. RUN sukses ke ' . $no . ' dan RUN error ke ' . $no_error);
		}
	}

	public function refresh_token_lama()
	{
		$current_cookie = get_option('_crb_siks_cookie');
		$opts = array('https' => array('header' => 'Cookie: ' . $current_cookie));
		$context = stream_context_create($opts);
		file_get_contents('https://siks.kemensos.go.id/kemsos/beranda/landing', false, $context);
		$last_cookie = get_option('siks_last_cookie');
		$no = get_option('siks_cronjob');
		if (empty($no) || $current_cookie != $last_cookie) {
			$no = 0;
			update_option('siks_last_cookie', $current_cookie);
		}
		$no++;
		update_option('siks_cronjob', $no);
	}

	public function proses_captcha()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil memproses captcha!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			update_option('siks_captcha_decrypt', $_POST['captcha']);
			$this->send_message(true, 'login_captcha');
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function set_token()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil set token!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			update_option('_crb_siks_cookie', $_POST['token']);
			// update cronjob error jadi 0 agar cronjob berjalan lagi dan get captcha tidak dilanjutkan
			update_option('siks_cronjob_error', 0);
			$message = "Berhasil update SIKS authorization / token / login session!";
			$ret['tg'] = $this->functions->send_tg(array('message' => $message));
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function send_message($ret = false, $message = false)
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil send message!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$pusher_cluster = get_option('_crb_siks_pusher_cluster');
			$pusher_id = get_option('_crb_siks_pusher_id');
			$pusher_key = get_option('_crb_siks_pusher_key');
			$pusher_secret = get_option('_crb_siks_pusher_secret');
			$options = array(
				'cluster' => $pusher_cluster,
				'useTLS' => true
			);
			$pusher = new Pusher\Pusher(
				$pusher_key,
				$pusher_secret,
				$pusher_id,
				$options
			);

			$data = array();
			if (!empty($_POST['action_pusher'])) {
				if ($_POST['action_pusher'] == 'send_otp') {
					$data['otp'] = $_POST['otp'];
					$data['pesan'] = $_POST['pesan'];
				}
				$data['action'] = $_POST['action_pusher'];
			} else if (empty($message)) {
				// update cronjob error jadi 10 agar cronjob tidak aktif dan penanda kalau harus get token
				update_option('siks_cronjob_error', 10);
				$data['action'] = 'require_login';
			} else {
				$data['action'] = $message;
				$data['captcha'] = get_option('siks_captcha_decrypt');
				$data['key'] = get_option('siks_captcha_key');
			}
			$pusher->trigger('my-channel', 'my-event', $data);
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		if (!empty($ret)) {
			return $ret;
		} else {
			die(json_encode($ret));
		}
	}

	public function set_captcha()
	{
		global $wpdb;
		$ret = array(
			'action'	=> $_POST['action'],
			'status'	=> 'success',
			'message'	=> 'Berhasil set captcha!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			update_option('siks_captcha', str_replace("'", "", $wpdb->prepare('%s', $_POST['captcha'])));
			update_option('siks_captcha_key', str_replace("'", "", $wpdb->prepare('%s', $_POST['key'])));
			update_option('siks_captcha_decrypt', '');
			$message = "Set captcha login SIKS!";
			$this->functions->send_tg(array('message' => $message));
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_captcha()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get captcha!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$ret['captcha'] = get_option('siks_captcha');
			$error = get_option('siks_cronjob_error');
			// cek jika cronjob error sama dengan 0 maka get captcha tidak dilanjutkan
			if ($error == 0) {
				$ret['captcha'] = '';
			}
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_data_dtks()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get captcha!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$data = $wpdb->get_results($wpdb->prepare("
				SELECT
					*
				FROM data_dtks
				WHERE kecamatan=%s
					AND desa_kelurahan=%s
			", $_POST['kecamatan'], $_POST['desa']));
			$ret['data'] = $data;
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function singkronisasi_dtks()
	{
		global $wpdb;
		$ret = array(
			'action'	=> 'singkronisasi_dtks',
			'status'	=> 'success',
			'message'	=> 'Berhasil backup data DTKS!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$data = json_decode(stripslashes(html_entity_decode($_POST['data'])), true);
			if ($data['page'] == 0) {
				$wpdb->update("data_dtks", array('active' => 0), array(
					'id_desa' => $data['meta']['id_desa']
				));
			}
			foreach ($data['data'] as $orang) {
				$cek_id = $wpdb->get_var($wpdb->prepare("
					SELECT
						id
					FROM data_dtks
					WHERE id_desa = %s
						AND Nama = %s
						AND verifyid = %s
				", $data['meta']['id_desa'], $orang['Nama'], $orang['verifyid']));

				$opsi = array(
					'provinsi' => $data['meta']['provinsi'], // baru
					'kabupaten' => $data['meta']['kabupaten'], // baru
					'kecamatan' => $data['meta']['kecamatan'],
					'desa_kelurahan' => $data['meta']['desa_kelurahan'],
					'prop_capil' => $data['meta']['prop_capil'], // baru
					'kab_capil' => $data['meta']['kab_capil'], // baru
					'id_kec' => $data['meta']['id_kec'],
					'id_desa' => $data['meta']['id_desa'],
					'ATENSI' => $orang['ATENSI'], // baru
					'Alamat' => $orang['Alamat'],
					'BLT' => $orang['BLT'],
					'BLT_BBM' => $orang['BLT_BBM'],
					'BNPT_PPKM' => $orang['BNPT_PPKM'],
					'BPNT' => $orang['BPNT'],
					'BST' => $orang['BST'],
					'FIRST_SK' => $orang['FIRST_SK'],
					'NIK' => $orang['NIK'],
					'NOKK' => $orang['NOKK'],
					'Nama' => $orang['Nama'],
					'PBI' => $orang['PBI'],
					'PENA' => $orang['PENA'], // baru
					'PERMAKANAN' => $orang['PERMAKANAN'], // baru
					'PKH' => $orang['PKH'],
					'RUTILAHU' => $orang['RUTILAHU'],
					'SEMBAKO_ADAPTIF' => $orang['SEMBAKO_ADAPTIF'],
					'YAPI' => $orang['YAPI'], // baru
					'aktorLabel' => $orang['aktorLabel'], // baru
					'checkBtnHamil' => $orang['checkBtnHamil'],
					'checkBtnVerifMeninggal' => $orang['checkBtnVerifMeninggal'],
					'counter' => $orang['counter'],
					'deleted_label' => $orang['deleted_label'],
					'idsemesta' => $orang['idsemesta'],
					'isAktifHamil' => $orang['isAktifHamil'],
					'is_btn_dapodik' => $orang['is_btn_dapodik'],
					'is_btn_hidupkan' => $orang['is_btn_hidupkan'],
					'is_btn_padankan' => $orang['is_btn_padankan'],
					'is_nonaktif' => $orang['is_nonaktif'],
					'keterangan_disabilitas' => json_encode($orang['keterangan_disabilitas']),
					'keterangan_meninggal' => $orang['keterangan_meninggal'],
					'masih_hidup_label' => $orang['masih_hidup_label'],
					'padankan_at' => $orang['padankan_at'],
					'pendampingShow' => $orang['pendampingShow'],
					'periode_blt' => $orang['periode_blt'],
					'periode_blt_bbm' => $orang['periode_blt_bbm'],
					'periode_bpnt' => $orang['periode_bpnt'],
					'periode_bpnt_ppkm' => $orang['periode_bpnt_ppkm'],
					'periode_bst' => $orang['periode_bst'],
					'periode_pbi' => $orang['periode_pbi'],
					'periode_pena' => $orang['periode_pena'], // baru
					'periode_permakanan' => $orang['periode_permakanan'], // baru
					'periode_pkh' => $orang['periode_pkh'],
					'periode_rutilahu' => $orang['periode_rutilahu'],
					'periode_sembako_adaptif' => $orang['periode_sembako_adaptif'],
					'periode_yapi' => $orang['periode_yapi'], // baru
					'verifyid' => $orang['verifyid'],
					'update_at' => date('Y-m-d H:i:s'),
					'active' => 1
				);
				if (empty($cek_id)) {
					$wpdb->insert('data_dtks', $opsi);
				} else {
					$wpdb->update('data_dtks', $opsi, array(
						'id' => $cek_id
					));
				}
			}
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function my_cron_schedules($schedules)
	{
		if (!isset($schedules["custom_min"])) {
			$schedules["custom_min"] = array(
				'interval' => 0.5 * 60,
				'display' => __('Once every 1 minutes')
			);
		}
		if (!isset($schedules["5min"])) {
			$schedules["5min"] = array(
				'interval' => 5 * 60,
				'display' => __('Once every 5 minutes')
			);
		}
		if (!isset($schedules["30min"])) {
			$schedules["30min"] = array(
				'interval' => 30 * 60,
				'display' => __('Once every 30 minutes')
			);
		}
		return $schedules;
	}

	public function get_center()
	{
		$center_map_default = get_option('_crb_google_map_center_siks');
		$ret = array(
			'lat' => 0,
			'lng' => 0
		);
		if (!empty($center_map_default)) {
			$center_map_default = explode(',', $center_map_default);
			$ret['lat'] = $center_map_default[0];
			$ret['lng'] = $center_map_default[1];
		}
		return $ret;
	}

	function get_polygon($options = array('type' => 'desa'))
	{
		global $wpdb;

		$default_color = get_option('_crb_warna_p3ke_siks');
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if ($options['type'] == 'desa') {
			if (!empty($kab)) {
				$where .= " and kab_kot='$kab'";
			}
			$data = $wpdb->get_results("
				SELECT 
					* 
				FROM data_batas_desa_siks 
				WHERE $where
				ORDER BY provinsi, kab_kot, kecamatan, desa
			", ARRAY_A);
		} else if ($options['type'] == 'kecamatan') {
			if (!empty($kab)) {
				$where .= " and kabkot='$kab'";
			}
			$data = $wpdb->get_results("
				SELECT 
					* 
				FROM data_batas_kecamatan_siks 
				WHERE $where
				ORDER BY provinsi, kabkot, kecamatan
			", ARRAY_A);
		}
		$new_data = array();
		foreach ($data as $k => $val) {
			$coordinate = json_decode($val['polygon'], true);
			if (!empty($coordinate)) {
				unset($val['polygon']);
				$new_data[] = array(
					'index' => $k,
					'coor' => $coordinate,
					'data' => $val,
					'html' => json_encode($val),
					'color' => $default_color
				);
			}
		}

		// SELECT * FROM data_batas_desa WHERE provinsi='JAWA TIMUR' and kab_kot='MAGETAN' and desa IN ('KAUMAN','PATIHAN', 'ALASTUWO') order by desa;
		return $new_data;
	}

	function get_dtks()
	{
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$where .= " and kabupaten='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT 
				provinsi,
				MAX(update_at) as last_update,
				kabupaten, 
				kecamatan, 
				desa_kelurahan,
				BLT, 
				BLT_BBM, 
				BPNT, 
				PKH, 
				PBI,
				COUNT(BLT) as jml
			FROM data_dtks 
			WHERE $where
				AND (
					is_nonaktif is null
					OR is_nonaktif = ''
				)
				AND active=1
			GROUP BY provinsi, kabupaten, kecamatan, desa_kelurahan, BLT, BLT_BBM, BPNT, PKH, PBI
			ORDER BY provinsi, kabupaten, kecamatan, desa_kelurahan
		", ARRAY_A);

		return $data;
	}

	function getSearchLocation($data = array())
	{
		$text = '';
		if (!empty($data['desa'])) {
			$text .= ' ' . $data['desa'];
		}
		if (!empty($data['kecamatan'])) {
			if (
				empty($data['desa'])
				|| (
					!empty($data['desa'])
					&& $data['kecamatan'] != $data['desa']
				)
			) {
				$text .= ' ' . $data['kecamatan'];
			}
		}
		if (!empty($data['kab_kot'])) {
			if (
				empty($data['kecamatan'])
				|| (
					!empty($data['kecamatan'])
					&& $data['kab_kot'] != $data['kecamatan']
				)
			) {
				$text .= ' ' . $data['kab_kot'];
			}
		}
		if (!empty($data['kabkot'])) {
			if (
				empty($data['kecamatan'])
				|| (
					!empty($data['kecamatan'])
					&& $data['kabkot'] != $data['kecamatan']
				)
			) {
				$text .= ' ' . $data['kabkot'];
			}
		}
		if (!empty($data['provinsi'])) {
			$text .= ' ' . $data['provinsi'];
		}
		return $text;
	}

	public function getNamaDaerah($value = '')
	{
		$prov = get_option('_crb_siks_prop');
		$ret = "Provinsi $prov";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$ret = "Kabupaten $kab<br>$ret";
		}
		return $ret;
	}

	public function number_format($number)
	{
		return number_format($number, 0, ",", ".");
	}

	function get_siks_map_url()
	{
		$api_googlemap = get_option('_crb_google_api_siks');
		$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMapSiks&libraries=places&libraries=drawing";
		return $api_googlemap;
	}

	public function crb_get_gmaps_api_key_siks($value = '')
	{
		return get_option('_crb_google_api_siks');
	}

	public function get_data_disabilitas_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_disabilitas_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_disabilitas_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update('data_disabilitas_siks', array('active' => 0), array(
					'id' => $_POST['id']
				));
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_disabilitas()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error' && empty($_POST['nama'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['gender'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Gender tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tempat_lahir'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tempat Lahir tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tanggal_lahir'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tanggal Lahir tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['status'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Status tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nik'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'NIK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nomor_kk'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nomor KK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rt'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'RT tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rw'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'RW tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['desa'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Desa tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kecamatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kecamatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kabkot'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kabupaten / Kota tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['provinsi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Provinsi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['no_hp'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nomor HP tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun_anggaran'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tahun Anggaran tidak boleh kosong!';
				}
				if (empty($_POST['id_data'])) {
					if ($ret['status'] != 'error' && !empty($_FILES['lampiran'])) {
						$lampiran = $_FILES['lampiran'];
					} elseif ($ret['status'] != 'error') {
						$ret['status'] = 'error';
						$ret['message'] = 'Lampiran tidak boleh kosong!';
					}
				}
				if ($ret['status'] != 'error') {
					$nama = $_POST['nama'];
					$gender = $_POST['gender'];
					$tempat_lahir = $_POST['tempat_lahir'];
					$tanggal_lahir = $_POST['tanggal_lahir'];
					$status = $_POST['status'];
					$dokumen_kewarganegaraan = $_POST['dokumen_kewarganegaraan'];
					$nik = $_POST['nik'];
					$nomor_kk = $_POST['nomor_kk'];
					$rt = $_POST['rt'];
					$rw = $_POST['rw'];
					$desa = $_POST['desa'];
					$kecamatan = $_POST['kecamatan'];
					$kabkot = $_POST['kabkot'];
					$provinsi = $_POST['provinsi'];
					$no_hp = $_POST['no_hp'];
					$pendidikan_terakhir = $_POST['pendidikan_terakhir'];
					$nama_sekolah = $_POST['nama_sekolah'];
					$keterangan_lulus = $_POST['keterangan_lulus'];
					$jenis_disabilitas = $_POST['jenis_disabilitas'];
					$keterangan_disabilitas = $_POST['keterangan_disabilitas'];
					$sebab_disabilitas = $_POST['sebab_disabilitas'];
					$diagnosa_medis = $_POST['diagnosa_medis'];
					$penyakit_lain = $_POST['penyakit_lain'];
					$tempat_pengobatan = $_POST['tempat_pengobatan'];
					$perawat = $_POST['perawat'];
					$aktivitas = $_POST['aktivitas'];
					$aktivitas_bantuan = $_POST['aktivitas_bantuan'];
					$perlu_bantu = $_POST['perlu_bantu'];
					$alat_bantu = $_POST['alat_bantu'];
					$alat_yang_dimiliki = $_POST['alat_yang_dimiliki'];
					$kondisi_alat = $_POST['kondisi_alat'];
					$jaminan_kesehatan = $_POST['jaminan_kesehatan'];
					$cara_menggunakan_jamkes = $_POST['cara_menggunakan_jamkes'];
					$jaminan_sosial = $_POST['jaminan_sosial'];
					$pekerjaan = $_POST['pekerjaan'];
					$lokasi_bekerja = $_POST['lokasi_bekerja'];
					$alasan_tidak_bekerja = $_POST['alasan_tidak_bekerja'];
					$pendapatan_bulan = $_POST['pendapatan_bulan'];
					$pengeluaran_bulan = $_POST['pengeluaran_bulan'];
					$pendapatan_lain = $_POST['pendapatan_lain'];
					$minat_kerja = $_POST['minat_kerja'];
					$keterampilan = $_POST['keterampilan'];
					$pelatihan_yang_diikuti = $_POST['pelatihan_yang_diikuti'];
					$pelatihan_yang_diminat = $_POST['pelatihan_yang_diminat'];
					$status_rumah = $_POST['status_rumah'];
					$lantai = $_POST['lantai'];
					$kamar_mandi = $_POST['kamar_mandi'];
					$wc = $_POST['wc'];
					$akses_ke_lingkungan = $_POST['akses_ke_lingkungan'];
					$dinding = $_POST['dinding'];
					$sarana_air = $_POST['sarana_air'];
					$penerangan = $_POST['penerangan'];
					$desa_paud = $_POST['desa_paud'];
					$tk_di_desa = $_POST['tk_di_desa'];
					$kecamatan_slb = $_POST['kecamatan_slb'];
					$sd_menerima_abk = $_POST['sd_menerima_abk'];
					$smp_menerima_abk = $_POST['smp_menerima_abk'];
					$jumlah_posyandu = $_POST['jumlah_posyandu'];
					$kader_posyandu = $_POST['kader_posyandu'];
					$layanan_kesehatan = $_POST['layanan_kesehatan'];
					$sosialitas_ke_tetangga = $_POST['sosialitas_ke_tetangga'];
					$keterlibatan_berorganisasi = $_POST['keterlibatan_berorganisasi'];
					$kegiatan_kemasyarakatan = $_POST['kegiatan_kemasyarakatan'];
					$keterlibatan_musrembang = $_POST['keterlibatan_musrembang'];
					$alat_bantu_bantuan = $_POST['alat_bantu_bantuan'];
					$asal_alat_bantu = $_POST['asal_alat_bantu'];
					$tahun_pemberian = $_POST['tahun_pemberian'];
					$bantuan_uep = $_POST['bantuan_uep'];
					$asal_uep = $_POST['asal_uep'];
					$tahun = $_POST['tahun'];
					$lainnya = $_POST['lainnya'];
					$rehabilitas = $_POST['rehabilitas'];
					$lokasi_rehabilitas = $_POST['lokasi_rehabilitas'];
					$tahun_rehabilitas = $_POST['tahun_rehabilitas'];
					$keahlian_khusus = $_POST['keahlian_khusus'];
					$prestasi = $_POST['prestasi'];
					$nama_perawat_wali = $_POST['nama_perawat_wali'];
					$hubungan_dengan_pd = $_POST['hubungan_dengan_pd'];
					$nomor_hp = $_POST['nomor_hp'];
					$kelayakan = $_POST['kelayakan'];
					$tahun_anggaran = $_POST['tahun_anggaran'];
					$latitude = $_POST['lat'];
					$longitude = $_POST['lng'];
					$data = array(
						'lng' => $longitude,
						'lat' => $latitude,
						'nama' => $nama,
						'gender' => $gender,
						'tempat_lahir' => $tempat_lahir,
						'tanggal_lahir' => $tanggal_lahir,
						'status' => $status,
						'dokumen_kewarganegaraan' => $dokumen_kewarganegaraan,
						'nik' => $nik,
						'nomor_kk' => $nomor_kk,
						'rt' => $rt,
						'rw' => $rw,
						'desa' => $desa,
						'kecamatan' => $kecamatan,
						'kabkot' => $kabkot,
						'provinsi' => $provinsi,
						'no_hp' => $no_hp,
						'pendidikan_terakhir' => $pendidikan_terakhir,
						'nama_sekolah' => $nama_sekolah,
						'keterangan_lulus' => $keterangan_lulus,
						'jenis_disabilitas' => $jenis_disabilitas,
						'keterangan_disabilitas' => $keterangan_disabilitas,
						'sebab_disabilitas' => $sebab_disabilitas,
						'diagnosa_medis' => $diagnosa_medis,
						'penyakit_lain' => $penyakit_lain,
						'tempat_pengobatan' => $tempat_pengobatan,
						'perawat' => $perawat,
						'aktivitas' => $aktivitas,
						'aktivitas_bantuan' => $aktivitas_bantuan,
						'perlu_bantu' => $perlu_bantu,
						'alat_bantu' => $alat_bantu,
						'alat_yang_dimiliki' => $alat_yang_dimiliki,
						'kondisi_alat' => $kondisi_alat,
						'jaminan_kesehatan' => $jaminan_kesehatan,
						'cara_menggunakan_jamkes' => $cara_menggunakan_jamkes,
						'jaminan_sosial' => $jaminan_sosial,
						'pekerjaan' => $pekerjaan,
						'lokasi_bekerja' => $lokasi_bekerja,
						'alasan_tidak_bekerja' => $alasan_tidak_bekerja,
						'pendapatan_bulan' => $pendapatan_bulan,
						'pengeluaran_bulan' => $pengeluaran_bulan,
						'pendapatan_lain' => $pendapatan_lain,
						'minat_kerja' => $minat_kerja,
						'keterampilan' => $keterampilan,
						'pelatihan_yang_diikuti' => $pelatihan_yang_diikuti,
						'pelatihan_yang_diminat' => $pelatihan_yang_diminat,
						'status_rumah' => $status_rumah,
						'lantai' => $lantai,
						'kamar_mandi' => $kamar_mandi,
						'wc' => $wc,
						'akses_ke_lingkungan' => $akses_ke_lingkungan,
						'dinding' => $dinding,
						'sarana_air' => $sarana_air,
						'penerangan' => $penerangan,
						'desa_paud' => $desa_paud,
						'tk_di_desa' => $tk_di_desa,
						'kecamatan_slb' => $kecamatan_slb,
						'sd_menerima_abk' => $sd_menerima_abk,
						'smp_menerima_abk' => $smp_menerima_abk,
						'jumlah_posyandu' => $jumlah_posyandu,
						'kader_posyandu' => $kader_posyandu,
						'layanan_kesehatan' => $layanan_kesehatan,
						'sosialitas_ke_tetangga' => $sosialitas_ke_tetangga,
						'keterlibatan_berorganisasi' => $keterlibatan_berorganisasi,
						'kegiatan_kemasyarakatan' => $kegiatan_kemasyarakatan,
						'keterlibatan_musrembang' => $keterlibatan_musrembang,
						'alat_bantu_bantuan' => $alat_bantu_bantuan,
						'asal_alat_bantu' => $asal_alat_bantu,
						'tahun_pemberian' => $tahun_pemberian,
						'bantuan_uep' => $bantuan_uep,
						'asal_uep' => $asal_uep,
						'tahun' => $tahun,
						'lainnya' => $lainnya,
						'rehabilitas' => $rehabilitas,
						'lokasi_rehabilitas' => $lokasi_rehabilitas,
						'tahun_rehabilitas' => $tahun_rehabilitas,
						'keahlian_khusus' => $keahlian_khusus,
						'prestasi' => $prestasi,
						'nama_perawat_wali' => $nama_perawat_wali,
						'hubungan_dengan_pd' => $hubungan_dengan_pd,
						'nomor_hp' => $nomor_hp,
						'kelayakan' => $kelayakan,
						'tahun_anggaran' => $tahun_anggaran,
						'active' => 1,
						'update_at' => current_time('mysql')
					);

					$path = SIKS_PLUGIN_PATH . 'public/media/disabilitas/';

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					if ($ret['status'] == 'error') {
						// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
						foreach ($cek_file as $newfile) {
							if (is_file($path . $newfile)) {
								unlink($path . $newfile);
							}
						}
					}

					if ($ret['status'] != 'error') {
						if (!empty($_POST['id_data'])) {
							$file_lama = $wpdb->get_row($wpdb->prepare('
                                SELECT
                                    file_lampiran
                                FROM data_disabilitas_siks
                                WHERE id=%d
                            ', $_POST['id_data']), ARRAY_A);
							if (
								$file_lama['file_lampiran'] != $data['file_lampiran']
								&& is_file($path . $file_lama['file_lampiran'])
							) {
								unlink($path . $file_lama['file_lampiran']);
							}
							// print_r($file_lama); die($wpdb->last_query);
							$wpdb->update('data_disabilitas_siks', $data, array(
								'id' => $_POST['id_data']
							));
							$ret['message'] = 'Berhasil update data!';
						} else {
							$wpdb->insert('data_disabilitas_siks', $data);
						}
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function get_datatable_disabilitas()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data disabilitas!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$params = $columns = $totalRecords = $data = array();
			$params = $_REQUEST;
			$columns = array(
				0 => 'nik',
				1 => 'nomor_kk',
				2 => 'nama',
				3 => 'provinsi',
				4 => 'kabkot',
				5 => 'kecamatan',
				6 => 'desa',
				7 => 'rt',
				8 => 'rw',
				9 => 'tempat_lahir',
				10 => 'tanggal_lahir',
				11 => 'gender',
				12 => 'status',
				13 => 'dokumen_kewarganegaraan',
				14 => 'no_hp',
				15 => 'pendidikan_terakhir',
				16 => 'nama_sekolah',
				17 => 'keterangan_lulus',
				18 => 'jenis_disabilitas',
				19 => 'keterangan_disabilitas',
				20 => 'sebab_disabilitas',
				21 => 'diagnosa_medis',
				22 => 'penyakit_lain',
				23 => 'tempat_pengobatan',
				24 => 'perawat',
				25 => 'aktivitas',
				26 => 'aktivitas_bantuan',
				27 => 'perlu_bantu',
				28 => 'alat_bantu',
				29 => 'alat_yang_dimiliki',
				30 => 'kondisi_alat',
				31 => 'jaminan_kesehatan',
				32 => 'cara_menggunakan_jamkes',
				33 => 'jaminan_sosial',
				34 => 'pekerjaan',
				35 => 'lokasi_bekerja',
				36 => 'alasan_tidak_bekerja',
				37 => 'pendapatan_bulan',
				38 => 'pengeluaran_bulan',
				39 => 'pendapatan_lain',
				40 => 'minat_kerja',
				41 => 'keterampilan',
				42 => 'pelatihan_yang_diikuti',
				43 => 'pelatihan_yang_diminat',
				44 => 'status_rumah',
				45 => 'lantai',
				46 => 'kamar_mandi',
				47 => 'wc',
				48 => 'akses_ke_lingkungan',
				49 => 'dinding',
				50 => 'sarana_air',
				51 => 'penerangan',
				52 => 'desa_paud',
				53 => 'tk_di_desa',
				54 => 'kecamatan_slb',
				55 => 'sd_menerima_abk',
				56 => 'smp_menerima_abk',
				57 => 'jumlah_posyandu',
				58 => 'kader_posyandu',
				59 => 'layanan_kesehatan',
				60 => 'sosialitas_ke_tetangga',
				61 => 'keterlibatan_berorganisasi',
				62 => 'kegiatan_kemasyarakatan',
				63 => 'keterlibatan_musrembang',
				64 => 'alat_bantu_bantuan',
				65 => 'asal_alat_bantu',
				66 => 'tahun_pemberian',
				67 => 'bantuan_uep',
				68 => 'asal_uep',
				69 => 'tahun',
				70 => 'lainnya',
				71 => 'rehabilitas',
				72 => 'lokasi_rehabilitas',
				73 => 'tahun_rehabilitas',
				74 => 'keahlian_khusus',
				75 => 'prestasi',
				76 => 'nama_perawat_wali',
				77 => 'hubungan_dengan_pd',
				78 => 'nomor_hp',
				79 => 'kelayakan',
				80 => 'file_lampiran',
				81 => 'tahun_anggaran',
				82 => 'lat',
				83 => 'lng',
				84 => 'id'
			);
			$where = $sqlTot = $sqlRec = "";

			if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $_POST['desa']);
				$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$where .= " AND ( nik LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nomor_kk LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nama LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( provinsi LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kabkot LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kecamatan LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( desa LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
			}

			// getting total number records without any search
			$sql_tot = "SELECT count(id) as jml FROM `data_disabilitas_siks`";
			$sql = "SELECT " . implode(', ', $columns) . " FROM `data_disabilitas_siks`";
			$where_first = " WHERE 1=1 AND active = 1";
			$sqlTot .= $sql_tot . $where_first;
			$sqlRec .= $sql . $where_first;
			if (isset($where) && $where != '') {
				$sqlTot .= $where;
				$sqlRec .= $where;
			}

			$limit = '';
			if ($params['length'] != -1) {
				$limit = "  LIMIT " . $wpdb->prepare('%d', $params['start']) . " ," . $wpdb->prepare('%d', $params['length']);
			}
			$sqlRec .= " ORDER BY update_at DESC" . $limit;

			$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
			$totalRecords = $queryTot[0]['jml'];
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			foreach ($queryRecords as $recKey => $recVal) {
				if (empty($params['desa'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$recKey]['aksi'] = $btn;
				$queryRecords[$recKey]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/disabilitas/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = array(
				"draw"            => intval($params['draw']),
				"recordsTotal"    => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data"            => $queryRecords,
				"sql"             => $sqlRec
			);

			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_data_lansia_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_lansia_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_lansia_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update('data_lansia_siks', array('active' => 0), array(
					'id' => $_POST['id']
				));
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_lansia()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error' && empty($_POST['nama'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Nama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['alamat'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Alamat tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tanggal_lahir'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Tanggal Lahir tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['provinsi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Provinsi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kabkot'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Kabupaten / Kota tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kecamatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Kecamatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['desa'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Desa tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['usia'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Usia tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nik'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data NIK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun_anggaran'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Keterangan Lainnya Lama tidak boleh kosong!';
				}
				if (empty($_POST['id_data'])) {
					if ($ret['status'] != 'error' && !empty($_FILES['lampiran'])) {
						$lampiran = $_FILES['lampiran'];
					} elseif ($ret['status'] != 'error') {
						$ret['status'] = 'error';
						$ret['message'] = 'Lampiran tidak boleh kosong!';
					}
				}
				if ($ret['status'] != 'error') {
					$nama = $_POST['nama'];
					$alamat = $_POST['alamat'];
					$tanggal_lahir = $_POST['tanggal_lahir'];
					$provinsi = $_POST['provinsi'];
					$kabkot = $_POST['kabkot'];
					$kecamatan = $_POST['kecamatan'];
					$desa = $_POST['desa'];
					$usia = $_POST['usia'];
					$nik = $_POST['nik'];
					$dokumen_kependudukan = $_POST['dokumen_kependudukan'];
					$status_tempat_tinggal = $_POST['status_tempat_tinggal'];
					$status_pemenuhan_kebutuhan = $_POST['status_pemenuhan_kebutuhan'];
					$status_kehidupan_rumah_tangga = $_POST['status_kehidupan_rumah_tangga'];
					$status_dtks = $_POST['status_dtks'];
					$status_kepersertaan_program_bansos = $_POST['status_kepersertaan_program_bansos'];
					$rekomendasi_pendata_lama = $_POST['rekomendasi_pendata_lama'];
					$keterangan_lainnya_lama = $_POST['keterangan_lainnya_lama'];
					$rekomendasi_pendata = $_POST['rekomendasi_pendata'];
					$keterangan_lainnya = $_POST['keterangan_lainnya'];
					$tahun_anggaran = $_POST['tahun_anggaran'];

					$latitude = $_POST['lat'];
					$longitude = $_POST['lng'];
					$data = array(
						'lng' => $longitude,
						'lat' => $latitude,
						'nama' => $nama,
						'alamat' => $alamat,
						'desa' => $desa,
						'provinsi' => $provinsi,
						'kabkot' => $kabkot,
						'kecamatan' => $kecamatan,
						'nik' => $nik,
						'tanggal_lahir' => $tanggal_lahir,
						'usia' => $usia,
						'dokumen_kependudukan' => $dokumen_kependudukan,
						'status_tempat_tinggal' => $status_tempat_tinggal,
						'status_pemenuhan_kebutuhan' => $status_pemenuhan_kebutuhan,
						'status_kehidupan_rumah_tangga' => $status_kehidupan_rumah_tangga,
						'status_dtks' => $status_dtks,
						'status_kepersertaan_program_bansos' => $status_kepersertaan_program_bansos,
						'rekomendasi_pendata_lama' => $rekomendasi_pendata_lama,
						'keterangan_lainnya_lama' => $keterangan_lainnya_lama,
						'rekomendasi_pendata' => $rekomendasi_pendata,
						'keterangan_lainnya' => $keterangan_lainnya,
						'tahun_anggaran' => $tahun_anggaran,
						'active' => 1,
						'update_at' => current_time('mysql')
					);
					$path = SIKS_PLUGIN_PATH . 'public/media/lansia/';

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					if ($ret['status'] == 'error') {
						// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
						foreach ($cek_file as $newfile) {
							if (is_file($path . $newfile)) {
								unlink($path . $newfile);
							}
						}
					}

					if ($ret['status'] != 'error') {
						if (!empty($_POST['id_data'])) {
							$file_lama = $wpdb->get_row($wpdb->prepare('
                                SELECT
                                    file_lampiran
                                FROM data_lansia_siks
                                WHERE id=%d
                            ', $_POST['id_data']), ARRAY_A);
							if (
								$file_lama['file_lampiran'] != $data['file_lampiran']
								&& is_file($path . $file_lama['file_lampiran'])
							) {
								unlink($path . $file_lama['file_lampiran']);
							}
							// print_r($file_lama); die($wpdb->last_query);
							$wpdb->update('data_lansia_siks', $data, array(
								'id' => $_POST['id_data']
							));
							$ret['message'] = 'Berhasil update data!';
						} else {
							$wpdb->insert('data_lansia_siks', $data);
						}
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function get_datatable_lansia()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data lansia!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$params = $columns = $totalRecords = $data = array();
			$params = $_REQUEST;
			$columns = array(
				0 => 'nik',
				1 => 'nama',
				2 => 'provinsi',
				3 => 'kabkot',
				4 => 'kecamatan',
				5 => 'desa',
				6 => 'alamat',
				7 => 'tanggal_lahir',
				8 => 'usia',
				9 => 'dokumen_kependudukan',
				10 => 'status_tempat_tinggal',
				11 => 'status_pemenuhan_kebutuhan',
				12 => 'status_kehidupan_rumah_tangga',
				13 => 'status_dtks',
				14 => 'status_kepersertaan_program_bansos',
				15 => 'rekomendasi_pendata_lama',
				16 => 'keterangan_lainnya_lama',
				17 => 'rekomendasi_pendata',
				18 => 'keterangan_lainnya',
				19 => 'file_lampiran',
				20 => 'tahun_anggaran',
				21 => 'lat',
				22 => 'lng',
				23 => 'id'
			);
			$where = $sqlTot = $sqlRec = "";

			if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $_POST['desa']);
				$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$where .= " AND ( nik LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nama LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( provinsi LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kabkot LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kecamatan LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( desa LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
			}

			// getting total number records without any search
			$sql_tot = "SELECT count(id) as jml FROM `data_lansia_siks`";
			$sql = "SELECT " . implode(', ', $columns) . " FROM `data_lansia_siks`";
			$where_first = " WHERE 1=1 AND active = 1";
			$sqlTot .= $sql_tot . $where_first;
			$sqlRec .= $sql . $where_first;
			if (isset($where) && $where != '') {
				$sqlTot .= $where;
				$sqlRec .= $where;
			}

			$limit = '';
			if ($params['length'] != -1) {
				$limit = "  LIMIT " . $wpdb->prepare('%d', $params['start']) . " ," . $wpdb->prepare('%d', $params['length']);
			}
			$sqlRec .= " ORDER BY update_at DESC" . $limit;

			$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
			$totalRecords = $queryTot[0]['jml'];
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			foreach ($queryRecords as $recKey => $recVal) {
				if (empty($params['desa'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$recKey]['aksi'] = $btn;
				$queryRecords[$recKey]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/lansia/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = array(
				"draw"            => intval($params['draw']),
				"recordsTotal"    => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data"            => $queryRecords,
				"sql"             => $sqlRec
			);

			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_data_bunda_kasih_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_bunda_kasih_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_bunda_kasih_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update('data_bunda_kasih_siks', array('active' => 0), array(
					'id' => $_POST['id']
				));
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_bunda_kasih()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error' && empty($_POST['nama'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['provinsi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Provinsi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kabkot'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kabupaten / Kota tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kecamatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kecamatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['desa'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Desa tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rt_rw'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'RT / RW tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nik'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'NIK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kk'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'KK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun_anggaran'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tahun Anggaran tidak boleh kosong!';
				}
				if (empty($_POST['id_data'])) {
					if ($ret['status'] != 'error' && !empty($_FILES['lampiran'])) {
						$lampiran = $_FILES['lampiran'];
					} elseif ($ret['status'] != 'error') {
						$ret['status'] = 'error';
						$ret['message'] = 'Lampiran tidak boleh kosong!';
					}
				}

				if ($ret['status'] != 'error') {
					$provinsi = $_POST['provinsi'];
					$kabkot = $_POST['kabkot'];
					$kecamatan = $_POST['kecamatan'];
					$desa = $_POST['desa'];
					$rt_rw = $_POST['rt_rw'];
					$nik = $_POST['nik'];
					$kk = $_POST['kk'];
					$tahun_anggaran = $_POST['tahun_anggaran'];
					$nama = $_POST['nama'];
					$latitude = $_POST['lat'];
					$longitude = $_POST['lng'];
					$data = array(
						'lng' => $longitude,
						'lat' => $latitude,
						'nama' => $nama,
						'provinsi' => $provinsi,
						'desa' => $desa,
						'kecamatan' => $kecamatan,
						'nik' => $nik,
						'kabkot' => $kabkot,
						'rt_rw' => $rt_rw,
						'kk' => $kk,
						'tahun_anggaran' => $tahun_anggaran,
						'active' => 1,
						'update_at' => current_time('mysql')
					);

					$path = SIKS_PLUGIN_PATH . 'public/media/bunda_kasih/';

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					if ($ret['status'] == 'error') {
						// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
						foreach ($cek_file as $newfile) {
							if (is_file($path . $newfile)) {
								unlink($path . $newfile);
							}
						}
					}

					if ($ret['status'] != 'error') {
						if (!empty($_POST['id_data'])) {
							$file_lama = $wpdb->get_row($wpdb->prepare('
	                            SELECT
	                                file_lampiran
	                            FROM data_bunda_kasih_siks
	                            WHERE id=%d
	                        ', $_POST['id_data']), ARRAY_A);

							if (
								$file_lama['file_lampiran'] != $data['file_lampiran']
								&& is_file($path . $file_lama['file_lampiran'])
							) {
								unlink($path . $file_lama['file_lampiran']);
							}
							// print_r($file_lama); die($wpdb->last_query);
							$wpdb->update('data_bunda_kasih_siks', $data, array(
								'id' => $_POST['id_data']
							));
							$ret['message'] = 'Berhasil update data!';
						} else {
							$wpdb->insert('data_bunda_kasih_siks', $data);
						}
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function get_datatable_bunda_kasih()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data bunda_kasih!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$params = $columns = $totalRecords = $data = array();
			$params = $_REQUEST;
			$columns = array(
				0 => 'nik',
				1 => 'kk',
				2 => 'nama',
				3 => 'provinsi',
				4 => 'kabkot',
				5 => 'kecamatan',
				6 => 'desa',
				7 => 'rt_rw',
				8  => 'file_lampiran',
				9  => 'tahun_anggaran',
				10  => 'lat',
				11  => 'lng',
				12  => 'id'
			);
			$where = $sqlTot = $sqlRec = "";

			if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $_POST['desa']);
				$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$where .= " AND ( nik LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kk LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nama LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( provinsi LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kabkot LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kecamatan LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( desa LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
			}

			// getting total number records without any search
			$sql_tot = "SELECT count(id) as jml FROM `data_bunda_kasih_siks`";
			$sql = "SELECT " . implode(', ', $columns) . " FROM `data_bunda_kasih_siks`";
			$where_first = " WHERE 1=1 AND active = 1";
			$sqlTot .= $sql_tot . $where_first;
			$sqlRec .= $sql . $where_first;
			if (isset($where) && $where != '') {
				$sqlTot .= $where;
				$sqlRec .= $where;
			}

			$limit = '';
			if ($params['length'] != -1) {
				$limit = "  LIMIT " . $wpdb->prepare('%d', $params['start']) . " ," . $wpdb->prepare('%d', $params['length']);
			}
			$sqlRec .= " ORDER BY update_at DESC" . $limit;

			$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
			$totalRecords = $queryTot[0]['jml'];
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			foreach ($queryRecords as $recKey => $recVal) {
				if (empty($params['desa'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a style="margin-left: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$recKey]['aksi'] = $btn;
				$queryRecords[$recKey]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/bunda_kasih/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = array(
				"draw"            => intval($params['draw']),
				"recordsTotal"    => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data"            => $queryRecords,
				"sql"             => $sqlRec
			);

			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_data_odgj_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_odgj_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_anak_terlantar_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_anak_terlantar_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_lksa_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_lksa_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_odgj_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update('data_odgj_siks', array('active' => 0), array(
					'id' => $_POST['id']
				));
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_odgj()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error' && empty($_POST['nama'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['provinsi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Provinsi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kabkot'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kabupaten / Kota tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kecamatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kecamatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['desa'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Desa tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rt'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'RT / RW tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rw'])) {
					$ret['status'] = 'error';
					$ret['message'] = ' RW tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nik'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'NIK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kk'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'KK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun_anggaran'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tahun Anggaran tidak boleh kosong!';
				}
				if (empty($_POST['id_data'])) {
					if ($ret['status'] != 'error' && !empty($_FILES['lampiran'])) {
						$lampiran = $_FILES['lampiran'];
					} elseif ($ret['status'] != 'error') {
						$ret['status'] = 'error';
						$ret['message'] = 'Lampiran tidak boleh kosong!';
					}
				}
				if ($ret['status'] != 'error') {
					$provinsi = $_POST['provinsi'];
					$kabkot = $_POST['kabkot'];
					$kecamatan = $_POST['kecamatan'];
					$desa = $_POST['desa'];
					$nik = $_POST['nik'];
					$kk = $_POST['kk'];
					$rt = $_POST['rt'];
					$rw = $_POST['rw'];
					$jenis_kelamin = $_POST['jenis_kelamin'];
					$usia = $_POST['usia'];
					$nama_ortu = $_POST['nama_ortu'];
					$pengobatan = $_POST['pengobatan'];
					$keterangan = $_POST['keterangan'];
					$tahun_anggaran = $_POST['tahun_anggaran'];
					$nama = $_POST['nama'];
					$latitude = $_POST['lat'];
					$longitude = $_POST['lng'];
					$data = array(
						'lng' => $longitude,
						'lat' => $latitude,
						'nama' => $nama,
						'provinsi' => $provinsi,
						'desa' => $desa,
						'kecamatan' => $kecamatan,
						'nik' => $nik,
						'kk' => $kk,
						'kabkot' => $kabkot,
						'rt' => $rt,
						'rw' => $rw,
						'jenis_kelamin' => $jenis_kelamin,
						'usia' => $usia,
						'nama_ortu' => $nama_ortu,
						'pengobatan' => $pengobatan,
						'keterangan' => $keterangan,
						'tahun_anggaran' => $tahun_anggaran,
						'active' => 1,
						'update_at' => current_time('mysql')
					);
					$path = SIKS_PLUGIN_PATH . 'public/media/odgj/';

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					if ($ret['status'] == 'error') {
						// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
						foreach ($cek_file as $newfile) {
							if (is_file($path . $newfile)) {
								unlink($path . $newfile);
							}
						}
					}

					if ($ret['status'] != 'error') {
						if (!empty($_POST['id_data'])) {
							$file_lama = $wpdb->get_row($wpdb->prepare('
                                SELECT
                                    file_lampiran
                                FROM data_odgj_siks
                                WHERE id=%d
                            ', $_POST['id_data']), ARRAY_A);
							if (
								$file_lama['file_lampiran'] != $data['file_lampiran']
								&& is_file($path . $file_lama['file_lampiran'])
							) {
								unlink($path . $file_lama['file_lampiran']);
							}
							// print_r($file_lama); die($wpdb->last_query);
							$wpdb->update('data_odgj_siks', $data, array(
								'id' => $_POST['id_data']
							));
							$ret['message'] = 'Berhasil update data!';
						} else {
							$wpdb->insert('data_odgj_siks', $data);
						}
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function get_datatable_odgj()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data odgj!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$params = $columns = $totalRecords = $data = array();
			$params = $_REQUEST;
			$columns = array(
				0 => 'nik',
				1 => 'kk',
				2 => 'nama',
				3 => 'provinsi',
				4 => 'kabkot',
				5 => 'kecamatan',
				6 => 'desa',
				7 => 'rt',
				8 => 'rw',
				9 => 'jenis_kelamin',
				10 => 'usia',
				11 => 'nama_ortu',
				12 => 'pengobatan',
				13 => 'keterangan',
				14 => 'file_lampiran',
				15 => 'tahun_anggaran',
				16 => 'lat',
				17 => 'lng',
				18 => 'id'
			);
			$where = $sqlTot = $sqlRec = "";

			if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $_POST['desa']);
				$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$where .= " AND ( nik LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kk LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nama LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( provinsi LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kabkot LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kecamatan LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( desa LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
			}

			// getting total number records without any search
			$sql_tot = "SELECT count(id) as jml FROM `data_odgj_siks`";
			$sql = "SELECT " . implode(', ', $columns) . " FROM `data_odgj_siks`";
			$where_first = " WHERE 1=1 AND active = 1";
			$sqlTot .= $sql_tot . $where_first;
			$sqlRec .= $sql . $where_first;
			if (isset($where) && $where != '') {
				$sqlTot .= $where;
				$sqlRec .= $where;
			}

			$limit = '';
			if ($params['length'] != -1) {
				$limit = "  LIMIT " . $wpdb->prepare('%d', $params['start']) . " ," . $wpdb->prepare('%d', $params['length']);
			}
			$sqlRec .= " ORDER BY update_at DESC" . $limit;
			$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
			$totalRecords = $queryTot[0]['jml'];
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			foreach ($queryRecords as $recKey => $recVal) {
				if (empty($params['desa'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$recKey]['aksi'] = $btn;
				$queryRecords[$recKey]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/odgj/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = array(
				"draw"            => intval($params['draw']),
				"recordsTotal"    => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data"            => $queryRecords,
				"sql"             => $sqlRec
			);

			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_lansia()
	{
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT  
				provinsi,
				MAX(update_at) as last_update,
				kabkot,
				kecamatan,
				desa,
				count(id) as jml
			FROM data_lansia_siks 
			WHERE $where
				AND active=1
			GROUP BY provinsi, kabkot, kecamatan, desa
			ORDER BY  provinsi, kabkot, kecamatan, desa
		", ARRAY_A);

		return $data;
	}

	function get_anak_terlantar()
	{
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT  
				provinsi,
				MAX(update_at) as last_update,
				kabkot,
				kecamatan,
				desa_kelurahan,
				count(id) as jml
			FROM data_anak_terlantar_siks
			WHERE $where
				AND active=1
			GROUP BY provinsi, kabkot, kecamatan, desa_kelurahan
			ORDER BY  provinsi, kabkot, kecamatan, desa_kelurahan
		", ARRAY_A);

		return $data;
	}

	function get_anak_terlantar_luar_magetan()
	{
		global $wpdb;
		$kab = get_option('_crb_siks_kab');
		$where = "kabkot != '$kab'";
		$data = $wpdb->get_results("
			SELECT  
				provinsi,
				kabkot,
				MAX(update_at) as last_update,
				kecamatan,
				desa_kelurahan,
				count(id) as jml
			FROM data_anak_terlantar_siks
			WHERE $where
				AND active=1
			GROUP BY provinsi, kabkot, kecamatan, desa_kelurahan
			ORDER BY  provinsi, kabkot, kecamatan, desa_kelurahan
		", ARRAY_A);

		return $data;
	}

	function get_lksa()
	{
		global $wpdb;
		$data = $wpdb->get_results("
			SELECT  
				nama,
				kabkot,
				MAX(update_at) as last_update,
				alamat,
				anak_dalam_lksa,
				anak_luar_lksa,
				total_anak,
				count(id) as jml
			FROM data_lksa_siks
			WHERE active=1
			GROUP BY nama, kabkot, alamat, anak_dalam_lksa, anak_luar_lksa, total_anak
			ORDER BY  kabkot, nama, alamat, anak_dalam_lksa, anak_luar_lksa, total_anak
		", ARRAY_A);

		return $data;
	}

	function get_disabilitas()
	{
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT  
				provinsi,
				kabkot,
				MAX(update_at) as last_update,
				kecamatan,
				desa,
				jenis_disabilitas,
				count(id) as jml
			FROM data_disabilitas_siks 
			WHERE $where
				AND active=1
			GROUP BY provinsi, kabkot, kecamatan, desa, jenis_disabilitas
			ORDER BY  provinsi, kabkot, kecamatan, desa
		", ARRAY_A);
		// print_r($data); die($wpdb->last_query);

		return $data;
	}

	function get_bunda_kasih()
	{
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT  
				provinsi,
				kabkot,
				MAX(update_at) as last_update,
				kecamatan,
				desa,
				count(id) as jml
			FROM data_bunda_kasih_siks 
			WHERE $where
				AND active=1
			GROUP BY provinsi, kabkot, kecamatan, desa
			ORDER BY  provinsi, kabkot, kecamatan, desa
		", ARRAY_A);
		return $data;
	}

	function get_wrse()
	{
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT  
				provinsi,
				kabkot,
				kecamatan,
				desa_kelurahan,
				MAX(update_at) as last_update,
				count(id) as jml
			FROM data_wrse_siks 
			WHERE $where
			  AND active = 1
			GROUP BY provinsi, kabkot, kecamatan, desa_kelurahan
			ORDER BY  provinsi, kabkot, kecamatan, desa_kelurahan
		", ARRAY_A);
		return $data;
	}

	function get_odgj()
	{
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT  
				provinsi,
				kabkot,
				kecamatan,
				desa,
				MAX(update_at) as last_update,
				count(id) as jml
			FROM data_odgj_siks 
			WHERE $where
			  AND active = 1
			GROUP BY provinsi, kabkot, kecamatan, desa
			ORDER BY  provinsi, kabkot, kecamatan, desa
		", ARRAY_A);
		return $data;
	}

	function get_hibah()
	{
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT  
				provinsi,
				kabkot,
				MAX(update_at) as last_update,
				kecamatan,
				desa_kelurahan,
				count(id) as jml
			FROM data_hibah_siks 
			WHERE $where
				AND active=1
			GROUP BY provinsi, kabkot, kecamatan, desa_kelurahan
			ORDER BY  provinsi, kabkot, kecamatan, desa_kelurahan
		", ARRAY_A);
		return $data;
	}

	function get_p3ke()
	{
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if (!empty($kab)) {
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT  
				provinsi,
				kabkot,
				MAX(update_at) as last_update,
				kecamatan,
				desa,
				count(id) as jml
			FROM data_p3ke_siks 
			WHERE $where
				AND active=1
			GROUP BY provinsi, kabkot, kecamatan, desa
			ORDER BY  provinsi, kabkot, kecamatan, desa
		", ARRAY_A);
		// print_r($data); die($wpdb->last_query);

		return $data;
	}

	function get_datatable_lksa()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data lksa!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$params = $columns = $totalRecords = $data = array();
			$params = $_REQUEST;
			$columns = array(
				0 => 'nama',
				1 => 'kabkot',
				2 => 'alamat',
				3 => 'ketua',
				4 => 'no_hp',
				5 => 'akreditasi',
				6 => 'anak_dalam_lksa',
				7 => 'anak_luar_lksa',
				8 => 'total_anak',
				9 => 'file_lampiran',
				10 => 'tahun_anggaran',
				11 => 'lat',
				12 => 'lng',
				13 => 'id'
			);
			$where = $sqlTot = $sqlRec = "";

			if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $_POST['desa']);
				$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$where .= " OR ( nama LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kabkot LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
			}

			// getting total number records without any search
			$sql_tot = "SELECT count(id) as jml FROM `data_lksa_siks`";
			$sql = "SELECT " . implode(', ', $columns) . " FROM `data_lksa_siks`";
			$where_first = " WHERE 1=1 AND active = 1";
			$sqlTot .= $sql_tot . $where_first;
			$sqlRec .= $sql . $where_first;
			if (isset($where) && $where != '') {
				$sqlTot .= $where;
				$sqlRec .= $where;
			}

			$limit = '';
			if ($params['length'] != -1) {
				$limit = "  LIMIT " . $wpdb->prepare('%d', $params['start']) . " ," . $wpdb->prepare('%d', $params['length']);
			}
			$sqlRec .= " ORDER BY update_at DESC" . $limit;

			$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
			$totalRecords = $queryTot[0]['jml'];
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			foreach ($queryRecords as $recKey => $recVal) {
				if (empty($params['nama'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$recKey]['aksi'] = $btn;
				$queryRecords[$recKey]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/lksa/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = array(
				"draw"            => intval($params['draw']),
				"recordsTotal"    => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data"            => $queryRecords,
				"sql"             => $sqlRec
			);

			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function hapus_lksa_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update('data_lksa_siks', array('active' => 0), array(
					'id' => $_POST['id']
				));
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function get_lksa_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_lksa_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_lksa()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error' && empty($_POST['nama'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['alamat'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kabkot'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kabupaten / Kota tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['ketua'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Ketua tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['no_hp'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'No HP tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['akreditasi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'akreditasi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun_anggaran'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tahun Anggaran tidak boleh kosong!';
				}
				if (empty($_POST['id_data'])) {
					if ($ret['status'] != 'error' && !empty($_FILES['lampiran'])) {
						$lampiran = $_FILES['lampiran'];
					}
				}
				if ($ret['status'] != 'error') {
					$alamat = $_POST['alamat'];
					$kabkot = $_POST['kabkot'];
					$ketua = $_POST['ketua'];
					$no_hp = $_POST['no_hp'];
					$akreditasi = $_POST['akreditasi'];
					$anak_dalam_lksa = $_POST['anak_dalam_lksa'];
					$anak_luar_lksa = $_POST['anak_luar_lksa'];
					$total_anak = $_POST['total_anak'];
					$tahun_anggaran = $_POST['tahun_anggaran'];
					$nama = $_POST['nama'];
					$latitude = $_POST['lat'];
					$longitude = $_POST['lng'];
					$data = array(
						'lng' => $longitude,
						'lat' => $latitude,
						'nama' => $nama,
						'alamat' => $alamat,
						'no_hp' => $no_hp,
						'ketua' => $ketua,
						'akreditasi' => $akreditasi,
						'kabkot' => $kabkot,
						'anak_dalam_lksa' => $anak_dalam_lksa,
						'anak_luar_lksa' => $anak_luar_lksa,
						'total_anak' => $total_anak,
						'tahun_anggaran' => $tahun_anggaran,
						'active' => 1,
						'update_at' => current_time('mysql')
					);
					$path = SIKS_PLUGIN_PATH . 'public/media/lksa/';

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					if ($ret['status'] == 'error') {
						// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
						foreach ($cek_file as $newfile) {
							if (is_file($path . $newfile)) {
								unlink($path . $newfile);
							}
						}
					}

					if ($ret['status'] != 'error') {
						if (!empty($_POST['id_data'])) {
							$file_lama = $wpdb->get_row($wpdb->prepare('
                                SELECT
                                    file_lampiran
                                FROM data_lksa_siks
                                WHERE id=%d
                            ', $_POST['id_data']), ARRAY_A);
							if (
								$file_lama['file_lampiran'] != $data['file_lampiran']
								&& is_file($path . $file_lama['file_lampiran'])
							) {
								unlink($path . $file_lama['file_lampiran']);
							}
							// print_r($file_lama); die($wpdb->last_query);
							$wpdb->update('data_lksa_siks', $data, array(
								'id' => $_POST['id_data']
							));
							$ret['message'] = 'Berhasil update data!';
						} else {
							$wpdb->SKDJKFDSJLDKSFJKDS('data_lksa_siks', $data);
						}
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function get_datatable_anak_terlantar()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$params = $columns = $totalRecords = $data = array();
			$params = $_REQUEST;
			$columns = array(
				1 => 'id',
				2 => 'nama',
				3 => 'kk',
				4 => 'nik',
				5 => 'jenis_kelamin',
				6 => 'tanggal_lahir',
				7 => 'usia',
				8 => 'pendidikan',
				9 => 'provinsi',
				10 => 'kabkot',
				11 => 'kecamatan',
				12 => 'desa_kelurahan',
				13 => 'alamat',
				14 => 'file_lampiran',
				15 => 'tahun_anggaran',
				16 => 'lat',
				17 => 'lng',
			);
			$where = $sqlTot = $sqlRec = "";

			if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $_POST['desa']);
				$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$where .= " AND ( nik LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kk LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nama LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( desa_kelurahan LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
			}

			// getting total number records without any search
			$sql_tot = "SELECT count(id) as jml FROM `data_anak_terlantar_siks`";
			$sql = "SELECT " . implode(', ', $columns) . " FROM `data_anak_terlantar_siks`";
			$where_first = " WHERE 1=1 AND active = 1";
			$sqlTot .= $sql_tot . $where_first;
			$sqlRec .= $sql . $where_first;
			if (isset($where) && $where != '') {
				$sqlTot .= $where;
				$sqlRec .= $where;
			}

			$limit = '';
			if ($params['length'] != -1) {
				$limit = "  LIMIT " . $wpdb->prepare('%d', $params['start']) . " ," . $wpdb->prepare('%d', $params['length']);
			}
			$sqlRec .= " ORDER BY update_at DESC" . $limit;

			$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
			$totalRecords = $queryTot[0]['jml'];
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			foreach ($queryRecords as $recKey => $recVal) {
				if (empty($params['desa_kelurahan'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$recKey]['aksi'] = $btn;
				$queryRecords[$recKey]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/anak_terlantar/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = array(
				"draw"            => intval($params['draw']),
				"recordsTotal"    => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data"            => $queryRecords,
				"sql"             => $sqlRec
			);

			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function hapus_anak_terlantar_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update('data_anak_terlantar_siks', array('active' => 0), array(
					'id' => $_POST['id']
				));
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function get_anak_terlantar_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_anak_terlantar_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_anak_terlantar()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error' && empty($_POST['nama'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['provinsi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Provinsi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kabkot'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kabupaten / Kota tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kecamatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kecamatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['desa_kelurahan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Desa tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nik'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'NIK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kk'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'KK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun_anggaran'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tahun Anggaran tidak boleh kosong!';
				}
				if (empty($_POST['id_data'])) {
					if ($ret['status'] != 'error' && !empty($_FILES['lampiran'])) {
						$lampiran = $_FILES['lampiran'];
					} elseif ($ret['status'] != 'error') {
						$ret['status'] = 'error';
						$ret['message'] = 'Lampiran tidak boleh kosong!';
					}
				}
				if ($ret['status'] != 'error') {
					$provinsi = $_POST['provinsi'];
					$kabkot = $_POST['kabkot'];
					$kecamatan = $_POST['kecamatan'];
					$desa_kelurahan = $_POST['desa_kelurahan'];
					$nik = $_POST['nik'];
					$kk = $_POST['kk'];
					$jenisKelamin = $_POST['jenis_kelamin'];
					$usia = $_POST['usia'];
					$tahun_anggaran = $_POST['tahun_anggaran'];
					$nama = $_POST['nama'];
					$pendidikan = $_POST['pendidikan'];
					$tanggal_lahir = $_POST['tanggal_lahir'];
					$status_lembaga = $_POST['kelembagaan'];
					$alamat = $_POST['alamat'];
					$latitude = $_POST['lat'];
					$longitude = $_POST['lng'];
					$data = array(
						'lng' => $longitude,
						'lat' => $latitude,
						'nama' => $nama,
						'provinsi' => $provinsi,
						'desa_kelurahan' => $desa_kelurahan,
						'kecamatan' => $kecamatan,
						'nik' => $nik,
						'kk' => $kk,
						'kabkot' => $kabkot,
						'alamat' => $alamat,
						'tanggal_lahir' => $tanggal_lahir,
						'jenis_kelamin' => $jenisKelamin,
						'usia' => $usia,
						'pendidikan' => $pendidikan,
						'kelembagaan' => $status_lembaga,
						'tahun_anggaran' => $tahun_anggaran,
						'active' => 1,
						'update_at' => current_time('mysql')
					);
					$path = SIKS_PLUGIN_PATH . 'public/media/anak_terlantar/';

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					if ($ret['status'] == 'error') {
						// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
						foreach ($cek_file as $newfile) {
							if (is_file($path . $newfile)) {
								unlink($path . $newfile);
							}
						}
					}

					if ($ret['status'] != 'error') {
						if (!empty($_POST['id_data'])) {
							$file_lama = $wpdb->get_row($wpdb->prepare('
                                SELECT
                                    file_lampiran
                                FROM data_anak_terlantar_siks
                                WHERE id=%d
                            ', $_POST['id_data']), ARRAY_A);
							if (
								$file_lama['file_lampiran'] != $data['file_lampiran']
								&& is_file($path . $file_lama['file_lampiran'])
							) {
								unlink($path . $file_lama['file_lampiran']);
							}
							// print_r($file_lama); die($wpdb->last_query);
							$wpdb->update('data_anak_terlantar_siks', $data, array(
								'id' => $_POST['id_data']
							));
							$ret['message'] = 'Berhasil update data!';
						} else {
							$wpdb->insert('data_anak_terlantar_siks', $data);
						}
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_p3ke_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_p3ke_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_p3ke_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update('data_p3ke_siks', array('active' => 0), array(
					'id' => $_POST['id']
				));
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_p3ke()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error' && empty($_POST['nama'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['provinsi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Provinsi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kabkot'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kabupaten / Kota tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kecamatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kecamatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['desa'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Desa tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rt'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'RT / RW tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rw'])) {
					$ret['status'] = 'error';
					$ret['message'] = ' RW tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nik'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'NIK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kk'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'KK tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun_anggaran'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tahun Anggaran tidak boleh kosong!';
				}
				if (empty($_POST['id_data'])) {
					if ($ret['status'] != 'error' && !empty($_FILES['lampiran'])) {
						$lampiran = $_FILES['lampiran'];
					} elseif ($ret['status'] != 'error') {
						$ret['status'] = 'error';
						$ret['message'] = 'Lampiran tidak boleh kosong!';
					}
				}
				if ($ret['status'] != 'error') {
					$nama = $_POST['nama'];
					$provinsi = $_POST['provinsi'];
					$kabkot = $_POST['kabkot'];
					$kecamatan = $_POST['kecamatan'];
					$desa = $_POST['desa'];
					$rt = $_POST['rt'];
					$nik = $_POST['nik'];
					$kk = $_POST['kk'];
					$rw = $_POST['rw'];
					$pekerjaan = $_POST['pekerjaan'];
					$alamat = $_POST['alamat'];
					$program = $_POST['program'];
					$penghasilan = $_POST['penghasilan'];
					$keterangan = $_POST['keterangan'];
					$tahun_anggaran = $_POST['tahun_anggaran'];
					$latitude = $_POST['lat'];
					$longitude = $_POST['lng'];
					$data = array(
						'lng' => $longitude,
						'lat' => $latitude,
						'nama' => $nama,
						'provinsi' => $provinsi,
						'desa' => $desa,
						'kecamatan' => $kecamatan,
						'nik' => $nik,
						'kk' => $kk,
						'kabkot' => $kabkot,
						'rt' => $rt,
						'rw' => $rw,
						'alamat' => $alamat,
						'pekerjaan' => $pekerjaan,
						'program' => $program,
						'penghasilan' => $penghasilan,
						'keterangan' => $keterangan,
						'tahun_anggaran' => $tahun_anggaran,
						'active' => 1,
						'update_at' => current_time('mysql')
					);
					$path = SIKS_PLUGIN_PATH . 'public/media/p3ke/';

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					$cek_file = array();
					if (
						$ret['status'] != 'error'
						&& !empty($_FILES['lampiran'])
					) {
						$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
						if ($upload['status'] == true) {
							$data['file_lampiran'] = $upload['filename'];
							$cek_file['file_lampiran'] = $data['file_lampiran'];
						} else {
							$ret['status'] = 'error';
							$ret['message'] = $upload['message'];
						}
					}

					if ($ret['status'] == 'error') {
						// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
						foreach ($cek_file as $newfile) {
							if (is_file($path . $newfile)) {
								unlink($path . $newfile);
							}
						}
					}

					if ($ret['status'] != 'error') {
						if (!empty($_POST['id_data'])) {
							$file_lama = $wpdb->get_row($wpdb->prepare('
                                SELECT
                                    file_lampiran
                                FROM data_p3ke_siks
                                WHERE id=%d
                            ', $_POST['id_data']), ARRAY_A);
							if (
								$file_lama['file_lampiran'] != $data['file_lampiran']
								&& is_file($path . $file_lama['file_lampiran'])
							) {
								unlink($path . $file_lama['file_lampiran']);
							}
							// print_r($file_lama); die($wpdb->last_query);
							$wpdb->update('data_p3ke_siks', $data, array(
								'id' => $_POST['id_data']
							));
							$ret['message'] = 'Berhasil update data!';
						} else {
							$wpdb->insert('data_p3ke_siks', $data);
						}
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function get_datatable_p3ke()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data p3ke!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$params = $columns = $totalRecords = $data = array();
			$params = $_REQUEST;
			$columns = array(
				0 => 'nik',
				1 => 'kk',
				2 => 'nama',
				3 => 'provinsi',
				4 => 'kabkot',
				5 => 'kecamatan',
				6 => 'desa',
				7 => 'rt',
				8 => 'rw',
				9 => 'alamat',
				10 => 'pekerjaan',
				11 => 'program',
				12 => 'penghasilan',
				13 => 'keterangan',
				14 => 'file_lampiran',
				15 => 'tahun_anggaran',
				16 => 'lat',
				17 => 'lng',
				18 => 'id'
			);
			$where = $sqlTot = $sqlRec = "";

			if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $_POST['desa']);
				$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$where .= " AND ( nik LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kk LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nama LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( provinsi LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kabkot LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kecamatan LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( desa LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( rt LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( rw LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
			}

			// getting total number records without any search
			$sql_tot = "SELECT count(id) as jml FROM `data_p3ke_siks`";
			$sql = "SELECT " . implode(', ', $columns) . " FROM `data_p3ke_siks`";
			$where_first = " WHERE 1=1 AND active = 1";
			$sqlTot .= $sql_tot . $where_first;
			$sqlRec .= $sql . $where_first;
			if (isset($where) && $where != '') {
				$sqlTot .= $where;
				$sqlRec .= $where;
			}

			$limit = '';
			if ($params['length'] != -1) {
				$limit = "  LIMIT " . $wpdb->prepare('%d', $params['start']) . " ," . $wpdb->prepare('%d', $params['length']);
			}
			$sqlRec .= " ORDER BY update_at DESC" . $limit;

			$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
			$totalRecords = $queryTot[0]['jml'];
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			foreach ($queryRecords as $recKey => $recVal) {
				if (empty($params['desa'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$recKey]['aksi'] = $btn;
				$queryRecords[$recKey]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/p3ke/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = array(
				"draw"            => intval($params['draw']),
				"recordsTotal"    => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data"            => $queryRecords,
				"sql"             => $sqlRec
			);

			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}


	function get_datatable_calon_p3ke()
	{
		global $wpdb;
		$ret = array(
			'status'    => 'success',
			'message'   => 'Berhasil get data calon p3ke!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$params = $columns = $totalRecords = $data = array();
			$params = $_REQUEST;
			$columns = array(
				'data_p3ke_siks.nik as nik_p3ke',
				'data_calon_p3ke_siks.nik_kk',
				'data_calon_p3ke_siks.nik_pkk',
				'data_calon_p3ke_siks.nama_kk',
				'data_calon_p3ke_siks.nama_pkk',
				'data_calon_p3ke_siks.nama_anak',
				'data_calon_p3ke_siks.nik_anak',
				'data_calon_p3ke_siks.alamat',
				'data_calon_p3ke_siks.nama_rt',
				'data_calon_p3ke_siks.nama_rw',
				'data_calon_p3ke_siks.desa_kelurahan',
				'data_calon_p3ke_siks.kecamatan',
				'data_calon_p3ke_siks.kabkot',
				'data_calon_p3ke_siks.district',
				'data_calon_p3ke_siks.sumber',
				'data_calon_p3ke_siks.desil_p3ke',
				'data_calon_p3ke_siks.lat',
				'data_calon_p3ke_siks.lng',
				'data_calon_p3ke_siks.tahun_anggaran',
				'data_calon_p3ke_siks.id',
				'data_calon_p3ke_siks.id_kpm'
			);
			$where = $sqlTot = $sqlRec = "";

			// check search value exist
			if (!empty($params['search']['value'])) {
				$where .= " AND ( nama_kk LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nama_pkk LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nama_anak LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nik_anak LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( nik_p3ke LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( id_kpm LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kabkot LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( kecamatan LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ( desa_kelurahan LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
			}

			if (!empty($params['desa'])) {
				$where .= $wpdb->prepare(' AND desa_kelurahan=%s', $params['desa']);
			}

			//not exist table p3ke_siks
			$sqlTot = "SELECT COUNT(data_calon_p3ke_siks.id) as jml FROM `data_calon_p3ke_siks`";
			$sqlTot .= " WHERE 1=1 AND data_calon_p3ke_siks.active = 1" . $where;
			$sqlRec = "
				SELECT 
					" . implode(', ', $columns) . " 
				FROM `data_calon_p3ke_siks`
				LEFT JOIN data_p3ke_siks on data_calon_p3ke_siks.nik_kk = data_p3ke_siks.nik
					AND data_p3ke_siks.active=1
			";
			$sqlRec .= " WHERE 1=1 AND data_calon_p3ke_siks.active = 1" . $where;
			$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
			$totalRecords = $queryTot[0]['jml'];

			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = $params['order'][0]['dir'];
				if (
					strtolower($orderByDirection) == 'asc'
					|| strtolower($orderByDirection) == 'desc'
				) {
					if ($orderByColumnIndex == 0) {
						$orderBy = "ORDER BY data_p3ke_siks.nik $orderByDirection";
					} else {
						$orderByColumn = $columns[$orderByColumnIndex];
						$orderBy = "ORDER BY $orderByColumn $orderByDirection";
					}
				}
			}

			$limit = '';
			if ($params['length'] != -1) {
				$limit = "LIMIT " . $wpdb->prepare('%d', $params['start']) . ", " . $wpdb->prepare('%d', $params['length']);
			}

			$sqlRec .= " $orderBy";
			$sqlRec .= " $limit";
			$totalRecords = $queryTot[0]['jml'];
			$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			foreach ($queryRecords as $recKey => $recVal) {
				if (empty($params['desa'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$recKey]['status_p3ke'] = '<span class="btn btn-warning btn-sm">Belum Terdaftar</span>';
				if (!empty($recVal['nik_p3ke'])) {
					$queryRecords[$recKey]['status_p3ke'] = '<span class="btn btn-success btn-sm">Terdaftar</span>';
				}
				$queryRecords[$recKey]['aksi'] = $btn;
			}

			$json_data = array(
				"draw"            => intval($params['draw']),
				"recordsTotal"    => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data"            => $queryRecords,
				"sql"             => $sqlRec
			);
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_wrse()
	{
		global $wpdb;

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				'nama',
				'usia',
				'alamat',
				'provinsi',
				'kabkot',
				'desa_kelurahan',
				'kecamatan',
				'status_dtks',
				'status_pernikahan',
				'mempunyai_usaha',
				'keterangan',
				'jenis_data',
				'tahun_anggaran',
				'create_at',
				'update_at',
				'id'
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
				$where .= $wpdb->prepare(' AND desa_kelurahan=%s', $_POST['desa']);
				$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (nama LIKE %s OR alamat LIKE %s OR desa_kelurahan LIKE %s OR kecamatan LIKE %s OR status_dtks LIKE %s OR status_pernikahan LIKE %s OR mempunyai_usaha LIKE %s OR keterangan LIKE %s OR jenis_data LIKE %s)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_wrse_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_wrse_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				if (empty($_POST['desa'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$record]['aksi'] = $btn;
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_usulan_wrse()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				'nama',
				'usia',
				'alamat',
				'provinsi',
				'kabkot',
				'desa_kelurahan',
				'kecamatan',
				'status_dtks',
				'status_pernikahan',
				'mempunyai_usaha',
				'keterangan',
				'jenis_data',
				'tahun_anggaran',
				'status_data',
				'keterangan_verifikasi',
				'create_at',
				'update_at',
				'id'
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			//filter by desa kec
			if (!empty($_POST['id_desa'])) {
				$where .= $wpdb->prepare(' AND id_desa_kel=%d', $_POST['id_desa']);
			}

			//filter by role
			if (in_array('administrator', $user_data->roles)) {
				$where .= $wpdb->prepare(' AND status_data != 0');
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (nama LIKE %s OR alamat LIKE %s OR desa_kelurahan LIKE %s OR kecamatan LIKE %s OR status_dtks LIKE %s OR status_pernikahan LIKE %s OR mempunyai_usaha LIKE %s OR keterangan LIKE %s OR jenis_data LIKE %s)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_usulan_wrse_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_usulan_wrse_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				$btn = '';
				$keterangan_verify = '';
				switch ($recVal['status_data']) {
					case 1: // Menunggu Persetujuan
						$labelVerify = '<span class="badge badge-pill badge-warning">Menunggu Persetujuan</span>';

						// Only admin can verify, no edit or delete for both roles
						if (in_array('administrator', $user_data->roles)) {
							$btn .= '<a class="btn btn-sm m-1 btn-success" onclick="showModalVerifikasi(\'' . $recVal['id'] . '\'); return false;" href="#" title="Verify Data"><span class="dashicons dashicons-yes"></span></a>';
						}
						break;

					case 2: // Disetujui
						$labelVerify = '<span class="badge badge-pill badge-success">Disetujui</span>';

						// No actions allowed for admin or desa
						break;

					case 3: // Ditolak
						$labelVerify = '<span class="badge badge-pill badge-danger">Ditolak</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can resubmit if status is rejected
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Ulang"><span class="dashicons dashicons-controls-repeat"></span></a>';
						}
						break;

					case 0: // Draft
						$labelVerify = '<span class="badge badge-pill badge-info">Draft</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can submit draft data
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Data"><span class="dashicons dashicons-upload"></span></a>';
						}
						break;

					default:
						$labelVerify = 'not valid';
						break;
				}

				// Basic Edit & Delete buttons (allowed only if status is not Menunggu Persetujuan or Disetujui)	
				if (!in_array($recVal['status_data'], [1, 2])) {
					if (in_array('desa', $user_data->roles)) {
						$btn .= '<a class="btn btn-sm m-1 btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><span class="dashicons dashicons-edit"></span></a>';
						$btn .= '<a class="btn btn-sm m-1 btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><span class="dashicons dashicons-trash"></span></a>';
					}
				}
				// Keterangan Label (allowed only if status is Ditolak or Disetujui)	
				if (in_array($recVal['status_data'], [2, 3])) {
					if (!empty($recVal['keterangan_verifikasi'])) {
						$keterangan_verify = '<br><small class="text-left text-muted">Keterangan : </small>' . '<small class="text-justify text-muted">' . $recVal['keterangan_verifikasi'] . '</small>';
					}
				}

				// Update queryRecords with label and action buttons
				$queryRecords[$record]['status_data'] = $labelVerify . $keterangan_verify;
				$queryRecords[$record]['aksi'] = $btn;

				$queryRecords[$record]['create_at'] = $this->formatTanggal($recVal['create_at']);
				$queryRecords[$record]['update_at'] = $this->formatTanggal($recVal['update_at']);
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_usulan_dtks()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				'id',
				'provinsi',
				'kabupaten',
				'kecamatan',
				'desa_kelurahan',
				'prop_capil',
				'kab_capil',
				'id_kec',
				'id_desa_kel',
				'ATENSI',
				'Alamat',
				'BLT',
				'BLT_BBM',
				'BNPT_PPKM',
				'BPNT',
				'BST',
				'FIRST_SK',
				'NIK',
				'NOKK',
				'Nama',
				'PBI',
				'PENA',
				'PERMAKANAN',
				'PKH',
				'RUTILAHU',
				'SEMBAKO_ADAPTIF',
				'YAPI',
				'aktorLabel',
				'checkBtnHamil',
				'checkBtnVerifMeninggal',
				'counter',
				'deleted_label',
				'idsemesta',
				'isAktifHamil',
				'is_btn_dapodik',
				'is_btn_hidupkan',
				'is_btn_padankan',
				'is_nonaktif',
				'keterangan_disabilitas',
				'keterangan_meninggal',
				'masih_hidup_label',
				'padankan_at',
				'pendampingShow',
				'periode_blt',
				'periode_blt_bbm',
				'periode_bpnt',
				'periode_bpnt_ppkm',
				'periode_bst',
				'periode_pbi',
				'periode_pena',
				'periode_permakanan',
				'periode_pkh',
				'periode_rutilahu',
				'periode_sembako_adaptif',
				'periode_yapi',
				'verifyid',
				'active',
				'status_data',
				'keterangan_verifikasi',
				'create_at',
				'update_at'
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			//filter by desa kec
			if (!empty($_POST['id_desa'])) {
				$where .= $wpdb->prepare(' AND id_desa=%d', $_POST['id_desa']);
			}

			//filter by role
			if (in_array('administrator', $user_data->roles)) {
				$where .= $wpdb->prepare(' AND status_data != 0');
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (Nama LIKE %s OR NIK LIKE %s OR NOKK LIKE %s)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_usulan_dtks_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_usulan_dtks_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				$btn = '';
				$keterangan_verify = '';
				switch ($recVal['status_data']) {
					case 1: // Menunggu Persetujuan
						$labelVerify = '<span class="badge badge-pill badge-warning">Menunggu Persetujuan</span>';

						// Only admin can verify, no edit or delete for both roles
						if (in_array('administrator', $user_data->roles)) {
							$btn .= '<a class="btn btn-sm m-1 btn-success" onclick="showModalVerifikasi(\'' . $recVal['id'] . '\'); return false;" href="#" title="Verify Data"><span class="dashicons dashicons-yes"></span></a>';
						}
						break;

					case 2: // Disetujui
						$labelVerify = '<span class="badge badge-pill badge-success">Disetujui</span>';

						// No actions allowed for admin or desa
						break;

					case 3: // Ditolak
						$labelVerify = '<span class="badge badge-pill badge-danger">Ditolak</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can resubmit if status is rejected
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Ulang"><span class="dashicons dashicons-controls-repeat"></span></a>';
						}
						break;

					case 0: // Draft
						$labelVerify = '<span class="badge badge-pill badge-info">Draft</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can submit draft data
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Data"><span class="dashicons dashicons-upload"></span></a>';
						}
						break;

					default:
						$labelVerify = 'not valid';
						break;
				}

				// Basic Edit & Delete buttons (allowed only if status is not Menunggu Persetujuan or Disetujui)	
				if (!in_array($recVal['status_data'], [1, 2])) {
					if (in_array('desa', $user_data->roles)) {
						$btn .= '<a class="btn btn-sm m-1 btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><span class="dashicons dashicons-edit"></span></a>';
						$btn .= '<a class="btn btn-sm m-1 btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><span class="dashicons dashicons-trash"></span></a>';
					}
				}
				// Keterangan Label (allowed only if status is Ditolak or Disetujui)	
				if (in_array($recVal['status_data'], [2, 3])) {
					if (!empty($recVal['keterangan_verifikasi'])) {
						$keterangan_verify = '<br><small class="text-left text-muted">Keterangan : </small>' . '<small class="text-justify text-muted">' . $recVal['keterangan_verifikasi'] . '</small>';
					}
				}

				// Update queryRecords with label and action buttons
				$queryRecords[$record]['status_data'] = $labelVerify . $keterangan_verify;
				$queryRecords[$record]['aksi'] = $btn;

				$queryRecords[$record]['create_at'] = $this->formatTanggal($recVal['create_at']);
				$queryRecords[$record]['update_at'] = $this->formatTanggal($recVal['update_at']);
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_usulan_odgj()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				'id',
				'nama',
				'kk',
				'nik',
				'jenis_kelamin',
				'usia',
				'provinsi',
				'kabkot',
				'id_kec',
				'kecamatan',
				'id_desa_kel',
				'desa',
				'rt',
				'rw',
				'nama_ortu',
				'keterangan',
				'pengobatan',
				'file_lampiran',
				'lat',
				'lng',
				'tahun_anggaran',
				'status_data',
				'keterangan_verifikasi',
				'active',
				'create_at',
				'update_at'
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			//filter by desa kec
			if (!empty($_POST['id_desa'])) {
				$where .= $wpdb->prepare(' AND id_desa_kel=%d', $_POST['id_desa']);
			}

			//filter by role
			if (in_array('administrator', $user_data->roles)) {
				$where .= $wpdb->prepare(' AND status_data != 0');
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (nama LIKE %s OR nama_ortu LIKE %s OR pengobatan LIKE %s OR keterangan LIKE %s)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_usulan_odgj_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_usulan_odgj_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				$btn = '';
				$keterangan_verify = '';
				switch ($recVal['status_data']) {
					case 1: // Menunggu Persetujuan
						$labelVerify = '<span class="badge badge-pill badge-warning">Menunggu Persetujuan</span>';

						// Only admin can verify, no edit or delete for both roles
						if (in_array('administrator', $user_data->roles)) {
							$btn .= '<a class="btn btn-sm m-1 btn-success" onclick="showModalVerifikasi(\'' . $recVal['id'] . '\'); return false;" href="#" title="Verify Data"><span class="dashicons dashicons-yes"></span></a>';
						}
						break;

					case 2: // Disetujui
						$labelVerify = '<span class="badge badge-pill badge-success">Disetujui</span>';

						// No actions allowed for admin or desa
						break;

					case 3: // Ditolak
						$labelVerify = '<span class="badge badge-pill badge-danger">Ditolak</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can resubmit if status is rejected
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Ulang"><span class="dashicons dashicons-controls-repeat"></span></a>';
						}
						break;

					case 0: // Draft
						$labelVerify = '<span class="badge badge-pill badge-info">Draft</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can submit draft data
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Data"><span class="dashicons dashicons-upload"></span></a>';
						}
						break;

					default:
						$labelVerify = 'not valid';
						break;
				}

				// Basic Edit & Delete buttons (allowed only if status is not Menunggu Persetujuan or Disetujui)	
				if (!in_array($recVal['status_data'], [1, 2])) {
					if (in_array('desa', $user_data->roles)) {
						$btn .= '<a class="btn btn-sm m-1 btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><span class="dashicons dashicons-edit"></span></a>';
						$btn .= '<a class="btn btn-sm m-1 btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><span class="dashicons dashicons-trash"></span></a>';
					}
				}
				// Keterangan Label (allowed only if status is Ditolak or Disetujui)	
				if (in_array($recVal['status_data'], [2, 3])) {
					if (!empty($recVal['keterangan_verifikasi'])) {
						$keterangan_verify = '<br><small class="text-left text-muted">Keterangan : </small>' . '<small class="text-justify text-muted">' . $recVal['keterangan_verifikasi'] . '</small>';
					}
				}

				// Update queryRecords with label and action buttons
				$queryRecords[$record]['status_data'] = $labelVerify . $keterangan_verify;
				$queryRecords[$record]['aksi'] = $btn;

				$queryRecords[$record]['create_at'] = $this->formatTanggal($recVal['create_at']);
				$queryRecords[$record]['update_at'] = $this->formatTanggal($recVal['update_at']);

				$queryRecords[$record]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/odgj/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_usulan_p3ke()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				'id',
				'kk',
				'nik',
				'nama',
				'provinsi',
				'kabkot',
				'id_kec',
				'kecamatan',
				'id_desa_kel',
				'desa',
				'rt',
				'rw',
				'kode_anggota',
				'pekerjaan',
				'program',
				'penghasilan',
				'keterangan',
				'alamat',
				'file_lampiran',
				'lat',
				'lng',
				'tahun_anggaran',
				'status_data',
				'keterangan_verifikasi',
				'active',
				'create_at',
				'update_at'
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			//filter by desa kec
			if (!empty($_POST['id_desa'])) {
				$where .= $wpdb->prepare(' AND id_desa_kel=%d', $_POST['id_desa']);
			}

			//filter by role
			if (in_array('administrator', $user_data->roles)) {
				$where .= $wpdb->prepare(' AND status_data != 0');
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (nama LIKE %s OR nik LIKE %s OR kk LIKE %s )",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_usulan_p3ke_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_usulan_p3ke_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				$btn = '';
				$keterangan_verify = '';
				switch ($recVal['status_data']) {
					case 1: // Menunggu Persetujuan
						$labelVerify = '<span class="badge badge-pill badge-warning">Menunggu Persetujuan</span>';

						// Only admin can verify, no edit or delete for both roles
						if (in_array('administrator', $user_data->roles)) {
							$btn .= '<a class="btn btn-sm m-1 btn-success" onclick="showModalVerifikasi(\'' . $recVal['id'] . '\'); return false;" href="#" title="Verify Data"><span class="dashicons dashicons-yes"></span></a>';
						}
						break;

					case 2: // Disetujui
						$labelVerify = '<span class="badge badge-pill badge-success">Disetujui</span>';

						// No actions allowed for admin or desa
						break;

					case 3: // Ditolak
						$labelVerify = '<span class="badge badge-pill badge-danger">Ditolak</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can resubmit if status is rejected
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Ulang"><span class="dashicons dashicons-controls-repeat"></span></a>';
						}
						break;

					case 0: // Draft
						$labelVerify = '<span class="badge badge-pill badge-info">Draft</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can submit draft data
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Data"><span class="dashicons dashicons-upload"></span></a>';
						}
						break;

					default:
						$labelVerify = 'not valid';
						break;
				}

				// Basic Edit & Delete buttons (allowed only if status is not Menunggu Persetujuan or Disetujui)	
				if (!in_array($recVal['status_data'], [1, 2])) {
					if (in_array('desa', $user_data->roles)) {
						$btn .= '<a class="btn btn-sm m-1 btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><span class="dashicons dashicons-edit"></span></a>';
						$btn .= '<a class="btn btn-sm m-1 btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><span class="dashicons dashicons-trash"></span></a>';
					}
				}
				// Keterangan Label (allowed only if status is Ditolak or Disetujui)	
				if (in_array($recVal['status_data'], [2, 3])) {
					if (!empty($recVal['keterangan_verifikasi'])) {
						$keterangan_verify = '<br><small class="text-left text-muted">Keterangan : </small>' . '<small class="text-justify text-muted">' . $recVal['keterangan_verifikasi'] . '</small>';
					}
				}

				// Update queryRecords with label and action buttons
				$queryRecords[$record]['status_data'] = $labelVerify . $keterangan_verify;
				$queryRecords[$record]['aksi'] = $btn;

				$queryRecords[$record]['create_at'] = $this->formatTanggal($recVal['create_at']);
				$queryRecords[$record]['update_at'] = $this->formatTanggal($recVal['update_at']);

				$queryRecords[$record]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/p3ke/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_usulan_bunda_kasih()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				"id",
				"provinsi",
				"kabkot",
				"id_kec",
				"kecamatan",
				"id_desa_kel",
				"desa",
				"nama",
				"nik",
				"kk",
				"rt_rw",
				"file_lampiran",
				"lat",
				"lng",
				"tahun_anggaran",
				"status_data",
				"keterangan_verifikasi",
				"active",
				"create_at",
				"update_at"
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			//filter by desa kec
			if (!empty($_POST['id_desa'])) {
				$where .= $wpdb->prepare(' AND id_desa_kel=%d', $_POST['id_desa']);
			}

			//filter by role
			if (in_array('administrator', $user_data->roles)) {
				$where .= $wpdb->prepare(' AND status_data != 0');
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (nama LIKE %s OR nik LIKE %s OR kk LIKE %s)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_usulan_bunda_kasih_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_usulan_bunda_kasih_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				$btn = '';
				$keterangan_verify = '';
				switch ($recVal['status_data']) {
					case 1: // Menunggu Persetujuan
						$labelVerify = '<span class="badge badge-pill badge-warning">Menunggu Persetujuan</span>';

						// Only admin can verify, no edit or delete for both roles
						if (in_array('administrator', $user_data->roles)) {
							$btn .= '<a class="btn btn-sm m-1 btn-success" onclick="showModalVerifikasi(\'' . $recVal['id'] . '\'); return false;" href="#" title="Verify Data"><span class="dashicons dashicons-yes"></span></a>';
						}
						break;

					case 2: // Disetujui
						$labelVerify = '<span class="badge badge-pill badge-success">Disetujui</span>';

						// No actions allowed for admin or desa
						break;

					case 3: // Ditolak
						$labelVerify = '<span class="badge badge-pill badge-danger">Ditolak</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can resubmit if status is rejected
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Ulang"><span class="dashicons dashicons-controls-repeat"></span></a>';
						}
						break;

					case 0: // Draft
						$labelVerify = '<span class="badge badge-pill badge-info">Draft</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can submit draft data
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Data"><span class="dashicons dashicons-upload"></span></a>';
						}
						break;

					default:
						$labelVerify = 'not valid';
						break;
				}

				// Basic Edit & Delete buttons (allowed only if status is not Menunggu Persetujuan or Disetujui)	
				if (!in_array($recVal['status_data'], [1, 2])) {
					if (in_array('desa', $user_data->roles)) {
						$btn .= '<a class="btn btn-sm m-1 btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><span class="dashicons dashicons-edit"></span></a>';
						$btn .= '<a class="btn btn-sm m-1 btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><span class="dashicons dashicons-trash"></span></a>';
					}
				}
				// Keterangan Label (allowed only if status is Ditolak or Disetujui)	
				if (in_array($recVal['status_data'], [2, 3])) {
					if (!empty($recVal['keterangan_verifikasi'])) {
						$keterangan_verify = '<br><small class="text-left text-muted">Keterangan : </small>' . '<small class="text-justify text-muted">' . $recVal['keterangan_verifikasi'] . '</small>';
					}
				}

				// Update queryRecords with label and action buttons
				$queryRecords[$record]['status_data'] = $labelVerify . $keterangan_verify;
				$queryRecords[$record]['aksi'] = $btn;

				$queryRecords[$record]['create_at'] = $this->formatTanggal($recVal['create_at']);
				$queryRecords[$record]['update_at'] = $this->formatTanggal($recVal['update_at']);

				$queryRecords[$record]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/bunda_kasih/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_usulan_lansia()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				"id",
				"provinsi",
				"kabkot",
				"nama",
				"alamat",
				"id_desa_kel",
				"desa",
				"id_kec",
				"kecamatan",
				"nik",
				"tanggal_lahir",
				"usia",
				"dokumen_kependudukan",
				"status_tempat_tinggal",
				"status_pemenuhan_kebutuhan",
				"status_kehidupan_rumah_tangga",
				"status_dtks",
				"status_kepersertaan_program_bansos",
				"rekomendasi_pendata_lama",
				"keterangan_lainnya_lama",
				"rekomendasi_pendata",
				"keterangan_lainnya",
				"file_lampiran",
				"lat",
				"lng",
				"tahun_anggaran",
				"status_data",
				"keterangan_verifikasi",
				"active",
				"create_at",
				"update_at"
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			//filter by desa kec
			if (!empty($_POST['id_desa'])) {
				$where .= $wpdb->prepare(' AND id_desa_kel=%d', $_POST['id_desa']);
			}

			//filter by role
			if (in_array('administrator', $user_data->roles)) {
				$where .= $wpdb->prepare(' AND status_data != 0');
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (nama LIKE %s OR alamat LIKE %s OR nik LIKE %s)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_usulan_lansia_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_usulan_lansia_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				$btn = '';
				$keterangan_verify = '';
				switch ($recVal['status_data']) {
					case 1: // Menunggu Persetujuan
						$labelVerify = '<span class="badge badge-pill badge-warning">Menunggu Persetujuan</span>';

						// Only admin can verify, no edit or delete for both roles
						if (in_array('administrator', $user_data->roles)) {
							$btn .= '<a class="btn btn-sm m-1 btn-success" onclick="showModalVerifikasi(\'' . $recVal['id'] . '\'); return false;" href="#" title="Verify Data"><span class="dashicons dashicons-yes"></span></a>';
						}
						break;

					case 2: // Disetujui
						$labelVerify = '<span class="badge badge-pill badge-success">Disetujui</span>';

						// No actions allowed for admin or desa
						break;

					case 3: // Ditolak
						$labelVerify = '<span class="badge badge-pill badge-danger">Ditolak</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can resubmit if status is rejected
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Ulang"><span class="dashicons dashicons-controls-repeat"></span></a>';
						}
						break;

					case 0: // Draft
						$labelVerify = '<span class="badge badge-pill badge-info">Draft</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can submit draft data
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Data"><span class="dashicons dashicons-upload"></span></a>';
						}
						break;

					default:
						$labelVerify = 'not valid';
						break;
				}

				// Basic Edit & Delete buttons (allowed only if status is not Menunggu Persetujuan or Disetujui)	
				if (!in_array($recVal['status_data'], [1, 2])) {
					if (in_array('desa', $user_data->roles)) {
						$btn .= '<a class="btn btn-sm m-1 btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><span class="dashicons dashicons-edit"></span></a>';
						$btn .= '<a class="btn btn-sm m-1 btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><span class="dashicons dashicons-trash"></span></a>';
					}
				}
				// Keterangan Label (allowed only if status is Ditolak or Disetujui)	
				if (in_array($recVal['status_data'], [2, 3])) {
					if (!empty($recVal['keterangan_verifikasi'])) {
						$keterangan_verify = '<br><small class="text-left text-muted">Keterangan : </small>' . '<small class="text-justify text-muted">' . $recVal['keterangan_verifikasi'] . '</small>';
					}
				}

				// Update queryRecords with label and action buttons
				$queryRecords[$record]['status_data'] = $labelVerify . $keterangan_verify;
				$queryRecords[$record]['aksi'] = $btn;

				$queryRecords[$record]['create_at'] = $this->formatTanggal($recVal['create_at']);
				$queryRecords[$record]['update_at'] = $this->formatTanggal($recVal['update_at']);

				$queryRecords[$record]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/lansia/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_usulan_anak_terlantar()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				'id',
				'nama',
				'kk',
				'nik',
				'jenis_kelamin',
				'tanggal_lahir',
				'usia',
				'id_desa_kel',
				'id_kec',
				'pendidikan',
				'provinsi',
				'kabkot',
				'kecamatan',
				'desa_kelurahan',
				'alamat',
				'file_lampiran',
				'tahun_anggaran',
				'lat',
				'lng',
				'status_data',
				'keterangan_verifikasi',
				'create_at',
				'update_at',
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			//filter by desa kec
			if (!empty($_POST['id_desa'])) {
				$where .= $wpdb->prepare(' AND id_desa_kel=%d', $_POST['id_desa']);
			}

			//filter by role
			if (in_array('administrator', $user_data->roles)) {
				$where .= $wpdb->prepare(' AND status_data != 0');
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (nama LIKE %s OR alamat LIKE %s OR desa_kelurahan LIKE %s OR kecamatan LIKE %s OR keterangan LIKE %s OR kk LIKE %d OR nik LIKE %d)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_usulan_anak_terlantar_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_usulan_anak_terlantar_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				$btn = '';
				$keterangan_verify = '';
				switch ($recVal['status_data']) {
					case 1: // Menunggu Persetujuan
						$labelVerify = '<span class="badge badge-pill badge-warning">Menunggu Persetujuan</span>';

						// Only admin can verify, no edit or delete for both roles
						if (in_array('administrator', $user_data->roles)) {
							$btn .= '<a class="btn btn-sm m-1 btn-success" onclick="showModalVerifikasi(\'' . $recVal['id'] . '\'); return false;" href="#" title="Verify Data"><span class="dashicons dashicons-yes"></span></a>';
						}
						break;

					case 2: // Disetujui
						$labelVerify = '<span class="badge badge-pill badge-success">Disetujui</span>';

						// No actions allowed for admin or desa
						break;

					case 3: // Ditolak
						$labelVerify = '<span class="badge badge-pill badge-danger">Ditolak</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can resubmit if status is rejected
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Ulang"><span class="dashicons dashicons-controls-repeat"></span></a>';
						}
						break;

					case 0: // Draft
						$labelVerify = '<span class="badge badge-pill badge-info">Draft</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can submit draft data
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Data"><span class="dashicons dashicons-upload"></span></a>';
						}
						break;

					default:
						$labelVerify = 'not valid';
						break;
				}

				// Basic Edit & Delete buttons (allowed only if status is not Menunggu Persetujuan or Disetujui)	
				if (!in_array($recVal['status_data'], [1, 2])) {
					if (in_array('desa', $user_data->roles)) {
						$btn .= '<a class="btn btn-sm m-1 btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><span class="dashicons dashicons-edit"></span></a>';
						$btn .= '<a class="btn btn-sm m-1 btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><span class="dashicons dashicons-trash"></span></a>';
					}
				}
				// Keterangan Label (allowed only if status is Ditolak or Disetujui)	
				if (in_array($recVal['status_data'], [2, 3])) {
					if (!empty($recVal['keterangan_verifikasi'])) {
						$keterangan_verify = '<br><small class="text-left text-muted">Keterangan : </small>' . '<small class="text-justify text-muted">' . $recVal['keterangan_verifikasi'] . '</small>';
					}
				}

				// Update queryRecords with label and action buttons
				$queryRecords[$record]['status_data'] = $labelVerify . $keterangan_verify;
				$queryRecords[$record]['aksi'] = $btn;

				$queryRecords[$record]['create_at'] = $this->formatTanggal($recVal['create_at']);
				$queryRecords[$record]['update_at'] = $this->formatTanggal($recVal['update_at']);
				$queryRecords[$record]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/anak_terlantar/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_usulan_hibah()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				'kode',
				'penerima',
				'alamat',
				'provinsi',
				'kabkot',
				'kecamatan',
				'id_desa_kel',
				'id_kec',
				'desa_kelurahan',
				'desa_kelurahan',
				'nama_nik_ketua',
				'anggaran',
				'status_realisasi',
				'status_data',
				'keterangan_verifikasi',
				'keterangan',
				'no_nphd',
				'tgl_nphd',
				'no_spm',
				'tgl_spm',
				'no_sp2d',
				'tgl_sp2d',
				'peruntukan',
				'jenis_data',
				'tahun_anggaran',
				'create_at',
				'update_at',
				'id'
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			//filter by desa kec
			if (!empty($_POST['id_desa'])) {
				$where .= $wpdb->prepare(' AND id_desa_kel=%d', $_POST['id_desa']);
			}

			//filter by role
			if (in_array('administrator', $user_data->roles)) {
				$where .= $wpdb->prepare(' AND status_data != 0');
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (nama_nik_ketua LIKE %s OR alamat LIKE %s OR desa_kelurahan LIKE %s OR kecamatan LIKE %s OR penerima LIKE %s)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_usulan_hibah_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_usulan_hibah_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				$btn = '';
				$keterangan_verify = '';
				switch ($recVal['status_data']) {
					case 1: // Menunggu Persetujuan
						$labelVerify = '<span class="badge badge-pill badge-warning">Menunggu Persetujuan</span>';

						// Only admin can verify, no edit or delete for both roles
						if (in_array('administrator', $user_data->roles)) {
							$btn .= '<a class="btn btn-sm m-1 btn-success" onclick="showModalVerifikasi(\'' . $recVal['id'] . '\'); return false;" href="#" title="Verify Data"><span class="dashicons dashicons-yes"></span></a>';
						}
						break;

					case 2: // Disetujui
						$labelVerify = '<span class="badge badge-pill badge-success">Disetujui</span>';

						// No actions allowed for admin or desa
						break;

					case 3: // Ditolak
						$labelVerify = '<span class="badge badge-pill badge-danger">Ditolak</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can resubmit if status is rejected
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Ulang"><span class="dashicons dashicons-controls-repeat"></span></a>';
						}
						break;

					case 0: // Draft
						$labelVerify = '<span class="badge badge-pill badge-info">Draft</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can submit draft data
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Data"><span class="dashicons dashicons-upload"></span></a>';
						}
						break;

					default:
						$labelVerify = 'not valid';
						break;
				}

				// Basic Edit & Delete buttons (allowed only if status is not Menunggu Persetujuan or Disetujui)	
				if (!in_array($recVal['status_data'], [1, 2])) {
					if (in_array('desa', $user_data->roles)) {
						$btn .= '<a class="btn btn-sm m-1 btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><span class="dashicons dashicons-edit"></span></a>';
						$btn .= '<a class="btn btn-sm m-1 btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><span class="dashicons dashicons-trash"></span></a>';
					}
				}
				// Keterangan Label (allowed only if status is Ditolak or Disetujui)	
				if (in_array($recVal['status_data'], [2, 3])) {
					if (!empty($recVal['keterangan_verifikasi'])) {
						$keterangan_verify = '<br><small class="text-left text-muted">Keterangan : </small>' . '<small class="text-justify text-muted">' . $recVal['keterangan_verifikasi'] . '</small>';
					}
				}

				// Update queryRecords with label and action buttons
				$queryRecords[$record]['status_data'] = $labelVerify . $keterangan_verify;
				$queryRecords[$record]['aksi'] = $btn;

				$queryRecords[$record]['create_at'] = $this->formatTanggal($recVal['create_at']);
				$queryRecords[$record]['update_at'] = $this->formatTanggal($recVal['update_at']);
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_usulan_disabilitas()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				'id_desa_kel',
				'id_kec',
				'status_data',
				'keterangan_verifikasi',
				'nik',
				'nomor_kk',
				'nama',
				'provinsi',
				'kabkot',
				'kecamatan',
				'desa',
				'rt',
				'rw',
				'tempat_lahir',
				'tanggal_lahir',
				'gender',
				'status',
				'dokumen_kewarganegaraan',
				'no_hp',
				'pendidikan_terakhir',
				'nama_sekolah',
				'keterangan_lulus',
				'jenis_disabilitas',
				'keterangan_disabilitas',
				'sebab_disabilitas',
				'diagnosa_medis',
				'penyakit_lain',
				'tempat_pengobatan',
				'perawat',
				'aktivitas',
				'aktivitas_bantuan',
				'perlu_bantu',
				'alat_bantu',
				'alat_yang_dimiliki',
				'kondisi_alat',
				'jaminan_kesehatan',
				'cara_menggunakan_jamkes',
				'jaminan_sosial',
				'pekerjaan',
				'lokasi_bekerja',
				'alasan_tidak_bekerja',
				'pendapatan_bulan',
				'pengeluaran_bulan',
				'pendapatan_lain',
				'minat_kerja',
				'keterampilan',
				'pelatihan_yang_diikuti',
				'pelatihan_yang_diminat',
				'status_rumah',
				'lantai',
				'kamar_mandi',
				'wc',
				'akses_ke_lingkungan',
				'dinding',
				'sarana_air',
				'penerangan',
				'desa_paud',
				'tk_di_desa',
				'kecamatan_slb',
				'sd_menerima_abk',
				'smp_menerima_abk',
				'jumlah_posyandu',
				'kader_posyandu',
				'layanan_kesehatan',
				'sosialitas_ke_tetangga',
				'keterlibatan_berorganisasi',
				'kegiatan_kemasyarakatan',
				'keterlibatan_musrembang',
				'alat_bantu_bantuan',
				'asal_alat_bantu',
				'tahun_pemberian',
				'bantuan_uep',
				'asal_uep',
				'tahun',
				'lainnya',
				'rehabilitas',
				'lokasi_rehabilitas',
				'tahun_rehabilitas',
				'keahlian_khusus',
				'prestasi',
				'nama_perawat_wali',
				'hubungan_dengan_pd',
				'nomor_hp',
				'kelayakan',
				'file_lampiran',
				'tahun_anggaran',
				'lat',
				'lng',
				'id'
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			//filter by desa kec
			if (!empty($_POST['id_desa'])) {
				$where .= $wpdb->prepare(' AND id_desa_kel=%d', $_POST['id_desa']);
			}

			//filter by role
			if (in_array('administrator', $user_data->roles)) {
				$where .= $wpdb->prepare(' AND status_data != 0');
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (kk LIKE %s OR nik LIKE %s OR desa LIKE %s OR jenis_disabilitas LIKE %s OR nama LIKE %s)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_usulan_disabilitas_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_usulan_disabilitas_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				$btn = '';
				$keterangan_verify = '';
				switch ($recVal['status_data']) {
					case 1: // Menunggu Persetujuan
						$labelVerify = '<span class="badge badge-pill badge-warning">Menunggu Persetujuan</span>';

						// Only admin can verify, no edit or delete for both roles
						if (in_array('administrator', $user_data->roles)) {
							$btn .= '<a class="btn btn-sm m-1 btn-success" onclick="showModalVerifikasi(\'' . $recVal['id'] . '\'); return false;" href="#" title="Verify Data"><span class="dashicons dashicons-yes"></span></a>';
						}
						break;

					case 2: // Disetujui
						$labelVerify = '<span class="badge badge-pill badge-success">Disetujui</span>';

						// No actions allowed for admin or desa
						break;

					case 3: // Ditolak
						$labelVerify = '<span class="badge badge-pill badge-danger">Ditolak</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can resubmit if status is rejected
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Ulang"><span class="dashicons dashicons-controls-repeat"></span></a>';
						}
						break;

					case 0: // Draft
						$labelVerify = '<span class="badge badge-pill badge-info">Draft</span>';

						if (in_array('desa', $user_data->roles)) {
							// Desa can submit draft data
							$btn .= '<a class="btn btn-sm m-1 btn-info" onclick="submitUsulan(\'' . $recVal['id'] . '\'); return false;" href="#" title="Submit Data"><span class="dashicons dashicons-upload"></span></a>';
						}
						break;

					default:
						$labelVerify = 'not valid';
						break;
				}

				// Basic Edit & Delete buttons (allowed only if status is not Menunggu Persetujuan or Disetujui)	
				if (!in_array($recVal['status_data'], [1, 2])) {
					if (in_array('desa', $user_data->roles)) {
						$btn .= '<a class="btn btn-sm m-1 btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><span class="dashicons dashicons-edit"></span></a>';
						$btn .= '<a class="btn btn-sm m-1 btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><span class="dashicons dashicons-trash"></span></a>';
					}
				}
				// Keterangan Label (allowed only if status is Ditolak or Disetujui)	
				if (in_array($recVal['status_data'], [2, 3])) {
					if (!empty($recVal['keterangan_verifikasi'])) {
						$keterangan_verify = '<br><small class="text-left text-muted">Keterangan : </small>' . '<small class="text-justify text-muted">' . $recVal['keterangan_verifikasi'] . '</small>';
					}
				}

				// Update queryRecords with label and action buttons
				$queryRecords[$record]['status_data'] = $labelVerify . $keterangan_verify;
				$queryRecords[$record]['aksi'] = $btn;

				$queryRecords[$record]['create_at'] = $this->formatTanggal($recVal['create_at']);
				$queryRecords[$record]['update_at'] = $this->formatTanggal($recVal['update_at']);
				$queryRecords[$record]['file_lampiran'] = '<a href="' . SIKS_PLUGIN_URL . 'public/media/disabilitas/' . $recVal['file_lampiran'] . '" target="_blank">' . $recVal['file_lampiran'] . '</a>';
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_datatable_data_hibah()
	{
		global $wpdb;

		$ret = [
			'status' => 'success',
			'message' => 'Berhasil get data!'
		];

		if (!empty($_POST['api_key']) && $_POST['api_key'] === get_option(SIKS_APIKEY)) {
			$params = $_REQUEST;

			// Define columns
			$columns = [
				'kode',
				'penerima',
				'alamat',
				'provinsi',
				'kabkot',
				'kecamatan',
				'desa_kelurahan',
				'nama_nik_ketua',
				'anggaran',
				'status_realisasi',
				'keterangan',
				'no_nphd',
				'tgl_nphd',
				'no_spm',
				'tgl_spm',
				'no_sp2d',
				'tgl_sp2d',
				'peruntukan',
				'jenis_data',
				'tahun_anggaran',
				'create_at',
				'update_at',
				'id'
			];

			$where = 'WHERE 1=1 AND active = 1';
			$searchValue = !empty($params['search']['value']) ? $params['search']['value'] : '';

			if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
				$where .= $wpdb->prepare(' AND desa_kelurahan=%s', $_POST['desa']);
				$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
			}

			// Search filter
			if ($searchValue) {
				$where .= $wpdb->prepare(
					" AND (penerima LIKE %s OR alamat LIKE %s OR kecamatan LIKE %s)",
					"%$searchValue%",
					"%$searchValue%",
					"%$searchValue%"
				);
			}

			// Total records
			$sqlTot = "SELECT COUNT(id) as jml FROM data_hibah_siks $where";
			$totalRecords = $wpdb->get_var($sqlTot);

			// Sorting
			$orderBy = '';
			if (!empty($params['order'])) {
				$orderByColumnIndex = $params['order'][0]['column'];
				$orderByDirection = strtoupper($params['order'][0]['dir']);
				if ($orderByDirection === 'ASC' || $orderByDirection === 'DESC') {
					$orderByColumn = $columns[$orderByColumnIndex] ?? 'id';
					$orderBy = "ORDER BY $orderByColumn $orderByDirection";
				}
			}

			// Pagination
			$limit = '';
			if ($params['length'] != -1) {
				$limit = $wpdb->prepare(
					"LIMIT %d, %d",
					$params['start'],
					$params['length']
				);
			}

			// Query records
			$sqlRec = "SELECT " . implode(', ', $columns) . " FROM data_hibah_siks $where $orderBy $limit";
			$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

			// Format data
			foreach ($queryRecords as $record => $recVal) {
				if (empty($params['desa'])) {
					$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
					$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Delete Data"><i class="dashicons dashicons-trash"></i></a>';
				} else {
					$btn = '-';
					if (!empty($recVal['lat'])) {
						$btn = '<td class="text-center"><a style="margin-bottom: 5px;" onclick="setCenterSiks(\'' . $recVal['lat'] . '\', \'' . $recVal['lng'] . '\', true, \'' . htmlentities(json_encode($recVal)) . '\'); return false;" href="#" class="btn btn-danger">Map</a></td>';
					}
				}
				$queryRecords[$record]['aksi'] = $btn;
			}

			$json_data = [
				"draw" => intval($params['draw']),
				"recordsTotal" => intval($totalRecords),
				"recordsFiltered" => intval($totalRecords),
				"data" => $queryRecords
			];
			die(json_encode($json_data));
		} else {
			$ret = [
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			];
		}
		die(json_encode($ret));
	}


	public function tambah_data_calon_p3ke()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error') {
					$id_data = !empty($_POST['id_data']) ? sanitize_text_field($_POST['id_data']) : null;
					$nik_kk = sanitize_text_field($_POST['nik_kk']);
					$nik_pkk = sanitize_text_field($_POST['nik_pkk']);
					$nama_kk = sanitize_text_field($_POST['nama_kk']);
					$nama_pkk = sanitize_text_field($_POST['nama_pkk']);
					$nama_anak = sanitize_text_field($_POST['nama_anak']);
					$nik_anak = sanitize_text_field($_POST['nik_anak']);
					$alamat = sanitize_text_field($_POST['alamat']);
					$nama_rt = sanitize_text_field($_POST['nama_rt']);
					$nama_rw = sanitize_text_field($_POST['nama_rw']);
					$desa_kelurahan = sanitize_text_field($_POST['desa_kelurahan']);
					$kecamatan = sanitize_text_field($_POST['kecamatan']);
					$kabkot = sanitize_text_field($_POST['kabkot']);
					$district = sanitize_text_field($_POST['district']);
					$sumber = sanitize_text_field($_POST['sumber']);
					$desil_p3ke = sanitize_text_field($_POST['desil_p3ke']);
					$lat = $_POST['lat'];
					$lng = $_POST['lng'];
					$tahun_anggaran = sanitize_text_field($_POST['tahun_anggaran']);

					$data = array(
						'nik_kk' => $nik_kk,
						'nik_pkk' => $nik_pkk,
						'nama_kk' => $nama_kk,
						'nama_pkk' => $nama_pkk,
						'nama_anak' => $nama_anak,
						'nik_anak' => $nik_anak,
						'alamat' => $alamat,
						'nama_rt' => $nama_rt,
						'nama_rw' => $nama_rw,
						'desa_kelurahan' => $desa_kelurahan,
						'kecamatan' => $kecamatan,
						'kabkot' => $kabkot,
						'district' => $district,
						'sumber' => $sumber,
						'desil_p3ke' => $desil_p3ke,
						'lat' => $lat,
						'lng' => $lng,
						'tahun_anggaran' => $tahun_anggaran,
						'active' => 1,
						'update_at' => current_time('mysql')
					);

					if ($id_data) {
						$wpdb->update(
							'data_calon_p3ke_siks',
							$data,
							array('id' => $id_data)
						);
						$ret['message'] = 'Berhasil update data!';
					} else {
						$wpdb->insert(
							'data_calon_p3ke_siks',
							$data
						);
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_wrse()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'data' => array()
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error') {
					// Mengambil data dari form
					$id_data = !empty($_POST['id_data']) ? sanitize_text_field($_POST['id_data']) : null;
					$tahun_anggaran = sanitize_text_field($_POST['tahunAnggaran']);
					$nama = sanitize_text_field($_POST['nama']);
					$usia = sanitize_text_field($_POST['usia']);
					$alamat = sanitize_text_field($_POST['alamat']);
					$provinsi = sanitize_text_field($_POST['provinsi']);
					$kabKot = sanitize_text_field($_POST['kabKot']);
					$desa = sanitize_text_field($_POST['desaKel']);
					$kecamatan = sanitize_text_field($_POST['kecamatan']);
					$statusDtks = sanitize_text_field($_POST['statusDtks']);
					$statusPernikahan = sanitize_text_field($_POST['statusPernikahan']);
					$statusUsaha = sanitize_text_field($_POST['statusUsaha']);
					$keterangan = sanitize_text_field($_POST['keterangan']);
					$jenisData = sanitize_text_field($_POST['jenisData']);
					$lat = sanitize_textarea_field($_POST['latitude']);
					$long = sanitize_textarea_field($_POST['longitude']);

					// Data yang akan disimpan atau diperbarui
					$data = array(
						'tahun_anggaran' => $tahun_anggaran,
						'nama' => $nama,
						'lat' => $lat,
						'lng' => $long,
						'usia' => $usia,
						'alamat' => $alamat,
						'provinsi' => $provinsi,
						'kabkot' => $kabKot,
						'desa_kelurahan' => $desa,
						'kecamatan' => $kecamatan,
						'status_dtks' => $statusDtks,
						'status_pernikahan' => $statusPernikahan,
						'mempunyai_usaha' => $statusUsaha,
						'keterangan' => $keterangan,
						'jenis_data' => $jenisData,
						'active' => 1
					);

					// Jika `id_data` ada, lakukan pembaruan data, jika tidak, tambahkan data baru
					if ($id_data) {
						$wpdb->update(
							'data_wrse_siks',
							$data,
							array('id' => $id_data)
						);
						$ret['message'] = 'Berhasil update data!';
					} else {
						$wpdb->insert(
							'data_wrse_siks',
							$data
						);
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_usulan_wrse()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data usulan!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'tahunAnggaran' 	=> 'required|numeric',
					'nama' 				=> 'required|string|max:255',
					'usia' 				=> 'required|numeric',
					'alamat' 			=> 'max:500',
					'id_desa' 			=> 'required',
					'statusDtks' 		=> 'in:Terdaftar,Tidak Terdaftar',
					'statusPernikahan' 	=> 'in:Belum Menikah,Menikah,Janda',
					'statusUsaha' 		=> 'in:Ya,Tidak',
					'jenisData' 		=> 'in:Induk,PAK',
					'latitude' 			=> 'nullable',
					'longitude' 		=> 'nullable'
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				//auto input alamat
				$provinsi 	= get_option(SIKS_PROV);
				$kabkot		= get_option(SIKS_KABKOT);
				$get_desa	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							id_desa,
							nama
						FROM data_alamat_siks
						WHERE id_desa = %d
                	', $postData['id_desa']),
					ARRAY_A
				);
				$get_kec	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND active = 1
                	', $get_desa['id_kec']),
					ARRAY_A
				);

				if (
					empty($provinsi)
					|| empty($kabkot)
					|| empty($get_kec)
					|| empty($get_desa)
				) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat Tidak Lengkap!';
					die(json_encode($ret));
				}

				// Data to be saved
				$id_data = !empty($postData['id_data']) ? sanitize_text_field($postData['id_data']) : null;

				$data = array(
					'tahun_anggaran' 	=> sanitize_text_field($postData['tahunAnggaran']),
					'nama' 				=> sanitize_text_field($postData['nama']),
					'usia' 				=> sanitize_text_field($postData['usia']),
					'alamat' 			=> sanitize_text_field($postData['alamat']),
					'provinsi' 			=> $provinsi,
					'kabkot' 			=> $kabkot,
					'id_kec' 			=> $get_kec['id_kec'],
					'kecamatan' 		=> strtoupper($get_kec['nama']),
					'id_desa_kel' 		=> $get_desa['id_desa'],
					'desa_kelurahan' 	=> strtoupper($get_desa['nama']),
					'status_dtks' 		=> sanitize_text_field($postData['statusDtks']),
					'status_pernikahan' => sanitize_text_field($postData['statusPernikahan']),
					'mempunyai_usaha' 	=> sanitize_text_field($postData['statusUsaha']),
					'status_data' 		=> 0,
					'keterangan' 		=> sanitize_textarea_field($postData['keterangan']),
					'jenis_data' 		=> sanitize_text_field($postData['jenisData']),
					'lat' 				=> sanitize_textarea_field($postData['latitude']),
					'lng' 				=> sanitize_textarea_field($postData['longitude']),
					'active' 			=> 1
				);

				// Update or insert
				if ($id_data) {
					$wpdb->update(
						'data_usulan_wrse_siks',
						$data,
						array('id' => $id_data)
					);
					$ret['message'] = 'Berhasil update data!';
				} else {
					$wpdb->insert(
						'data_usulan_wrse_siks',
						$data
					);
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_usulan_odgj()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data usulan!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'nik'			=> 'required',
					'kk'			=> 'required',
					'nama'			=> 'required',
					'rt'			=> 'required',
					'rw'			=> 'required',
					'jenisKelamin'	=> 'required',
					'usia'			=> 'required',
					'namaOrtu'		=> 'required',
					'pengobatan'	=> 'required',
					'keterangan'	=> 'required',
					'tahunAnggaran'	=> 'required',
					'latitude'		=> 'required',
					'longitude'		=> 'required'
					//name : message
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				//auto input alamat
				$provinsi 	= get_option(SIKS_PROV);
				$kabkot		= get_option(SIKS_KABKOT);
				$get_desa	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							id_desa,
							nama
						FROM data_alamat_siks
						WHERE id_desa = %d
                	', $postData['id_desa']),
					ARRAY_A
				);
				$get_kec	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND active = 1
                	', $get_desa['id_kec']),
					ARRAY_A
				);

				if (
					empty($provinsi)
					|| empty($kabkot)
					|| empty($get_kec)
					|| empty($get_desa)
				) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat Tidak Lengkap!';
					die(json_encode($ret));
				}

				// Data to be saved
				$id_data = !empty($postData['id_data']) ? sanitize_text_field($postData['id_data']) : null;

				$data = array(
					'tahun_anggaran' 	=> sanitize_text_field($postData['tahunAnggaran']),
					'nama' 				=> sanitize_text_field($postData['nama']),
					'kk'				=> sanitize_text_field($postData['kk']),
					'nik' 				=> sanitize_text_field($postData['nik']),
					'jenis_kelamin' 	=> sanitize_text_field($postData['jenisKelamin']),
					'usia' 				=> sanitize_text_field($postData['usia']),
					'rt' 				=> sanitize_text_field($postData['rt']),
					'rw' 				=> sanitize_text_field($postData['rw']),
					'nama_ortu' 		=> sanitize_text_field($postData['namaOrtu']),
					'keterangan' 		=> sanitize_text_field($postData['keterangan']),
					'pengobatan' 		=> sanitize_text_field($postData['pengobatan']),
					'lat' 				=> sanitize_textarea_field($postData['latitude']),
					'lng' 				=> sanitize_textarea_field($postData['longitude']),

					'provinsi' 			=> $provinsi,
					'kabkot' 			=> $kabkot,
					'id_kec' 			=> $get_kec['id_kec'],
					'kecamatan' 		=> strtoupper($get_kec['nama']),
					'id_desa_kel' 		=> $get_desa['id_desa'],
					'desa' 				=> strtoupper($get_desa['nama']),
				);

				$path = SIKS_PLUGIN_PATH . 'public/media/odgj/';

				$cek_file = array();
				if (
					!empty($_FILES['lampiran'])
				) {
					$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
					if ($upload['status'] == true) {
						$data['file_lampiran'] = $upload['filename'];
						$cek_file['file_lampiran'] = $data['file_lampiran'];
					} else {
						$ret['status'] = 'error';
						$ret['message'] = $upload['message'];
					}
				}

				if ($ret['status'] == 'error') {
					// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
					foreach ($cek_file as $newfile) {
						if (is_file($path . $newfile)) {
							unlink($path . $newfile);
						}
					}
				}

				// Update or insert
				if ($ret['status'] != 'error') {
					$file_lama = $wpdb->get_row(
						$wpdb->prepare('
							SELECT
								file_lampiran
							FROM data_usulan_odgj_siks
							WHERE id = %d
						', $_POST['id_data']),
						ARRAY_A
					);
					if (
						$file_lama['file_lampiran'] != $data['file_lampiran']
						&& is_file($path . $file_lama['file_lampiran'])
					) {
						unlink($path . $file_lama['file_lampiran']);
					}
					if ($id_data) {
						$wpdb->update(
							'data_usulan_odgj_siks',
							$data,
							array('id' => $id_data)
						);
						$ret['message'] = 'Berhasil update data!';
					} else {
						$wpdb->insert(
							'data_usulan_odgj_siks',
							$data
						);
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_usulan_p3ke()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data usulan!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'nama' 			=> 'required',
					'nik' 			=> 'required|numeric|max:16',
					'kk' 			=> 'required|numeric|max:16',
					'rt' 			=> 'required|numeric',
					'rw' 			=> 'required|numeric',
					'alamat' 		=> 'required',
					'pekerjaan' 	=> 'required',
					'program' 		=> 'required',
					'penghasilan' 	=> 'required|numeric',
					'keterangan' 	=> 'required',
					'tahunAnggaran' => 'required|numeric|max:4',
					'latitude'		=> 'required',
					'longitude'		=> 'required'
					//name : message
				];

				// die(print_r($postData));

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				//auto input alamat
				$provinsi 	= get_option(SIKS_PROV);
				$kabkot		= get_option(SIKS_KABKOT);
				$get_desa	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							id_desa,
							nama
						FROM data_alamat_siks
						WHERE id_desa = %d
                	', $postData['id_desa']),
					ARRAY_A
				);
				$get_kec	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND active = 1
                	', $get_desa['id_kec']),
					ARRAY_A
				);

				if (
					empty($provinsi)
					|| empty($kabkot)
					|| empty($get_kec)
					|| empty($get_desa)
				) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat Tidak Lengkap!';
					die(json_encode($ret));
				}

				// Data to be saved
				$id_data = !empty($postData['id_data']) ? sanitize_text_field($postData['id_data']) : null;

				$data = array(
					'tahun_anggaran' 	=> sanitize_text_field($postData['tahunAnggaran']),
					'kk' 				=> sanitize_text_field($postData['kk']),
					'nik' 				=> sanitize_text_field($postData['nik']),
					'nama' 				=> sanitize_text_field($postData['nama']),
					'rt' 				=> sanitize_text_field($postData['rt']),
					'rw' 				=> sanitize_text_field($postData['rw']),
					'pekerjaan' 		=> sanitize_text_field($postData['pekerjaan']),
					'program' 			=> sanitize_text_field($postData['program']),
					'penghasilan' 		=> sanitize_text_field($postData['penghasilan']),
					'keterangan' 		=> sanitize_text_field($postData['keterangan']),
					'alamat' 			=> sanitize_text_field($postData['alamat']),
					'lat' 				=> sanitize_text_field($postData['latitude']),
					'lng' 				=> sanitize_text_field($postData['longitude']),
					'status_data' 		=> 0,

					'provinsi' 			=> $provinsi,
					'kabkot' 			=> $kabkot,
					'id_kec' 			=> $get_kec['id_kec'],
					'kecamatan' 		=> strtoupper($get_kec['nama']),
					'id_desa_kel' 		=> $get_desa['id_desa'],
					'desa' 				=> strtoupper($get_desa['nama']),
				);

				$path = SIKS_PLUGIN_PATH . 'public/media/p3ke/';

				$cek_file = array();
				if (
					!empty($_FILES['lampiran'])
				) {
					$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
					if ($upload['status'] == true) {
						$data['file_lampiran'] = $upload['filename'];
						$cek_file['file_lampiran'] = $data['file_lampiran'];
					} else {
						$ret['status'] = 'error';
						$ret['message'] = $upload['message'];
					}
				}

				if ($ret['status'] == 'error') {
					// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
					foreach ($cek_file as $newfile) {
						if (is_file($path . $newfile)) {
							unlink($path . $newfile);
						}
					}
				}

				// Update or insert
				if ($ret['status'] != 'error') {
					$file_lama = $wpdb->get_row(
						$wpdb->prepare('
							SELECT
								file_lampiran
							FROM data_usulan_p3ke_siks
							WHERE id = %d
						', $_POST['id_data']),
						ARRAY_A
					);
					if (
						$file_lama['file_lampiran'] != $data['file_lampiran']
						&& is_file($path . $file_lama['file_lampiran'])
					) {
						unlink($path . $file_lama['file_lampiran']);
					}
					if ($id_data) {
						$wpdb->update(
							'data_usulan_p3ke_siks',
							$data,
							array('id' => $id_data)
						);
						$ret['message'] = 'Berhasil update data!';
					} else {
						$wpdb->insert(
							'data_usulan_p3ke_siks',
							$data
						);
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_usulan_disabilitas()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data usulan!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'tahunAnggaran'              => 'required',
					'dokumenKewarganegaraan'     => 'required',
					'nik'                        => 'required',
					'nomorKK'                    => 'required',
					'nama'                       => 'required',
					'rt'                         => 'required',
					'rw'                         => 'required',
					'tempatLahir'                => 'required',
					'tanggalLahir'               => 'required',
					'gender'                     => 'required',
					'status'                     => 'required',
					'noHp'                       => 'required',
					'pendidikanTerakhir'         => 'required',
					'namaSekolah'                => 'required',
					'keteranganLulus'            => 'required',
					'jenisDisabilitas'           => 'required',
					'keteranganDisabilitas'      => 'required',
					'sebabDisabilitas'           => 'required',
					'diagnosaMedis'              => 'required',
					'penyakitLain'               => 'required',
					'tempatPengobatan'           => 'required',
					'perawat'                    => 'required',
					'aktivitas'                  => 'required',
					'aktivitasBantuan'           => 'required',
					'perluBantu'                 => 'required',
					'alatBantu'                  => 'required',
					'alatYangDimiliki'           => 'required',
					'kondisiAlat'                => 'required',
					'jaminanKesehatan'           => 'required',
					'caraMenggunakanJamkes'      => 'required',
					'jaminanSosial'              => 'required',
					'pelatihanYangDiikuti'       => 'required',
					'pelatihanYangDiminat'       => 'required',
					'statusRumah'                => 'required',
					'lantai'                     => 'required',
					'kamarMandi'                 => 'required',
					'wc'                         => 'required',
					'aksesKeLingkungan'          => 'required',
					'dinding'                    => 'required',
					'saranaAir'                  => 'required',
					'penerangan'                 => 'required',
					'desaPaud'                   => 'required',
					'tkDiDesa'                   => 'required',
					'kecamatanSlb'               => 'required',
					'sdMenerimaAbk'              => 'required',
					'smpMenerimaAbk'             => 'required',
					'jumlahPosyandu'             => 'required',
					'kaderPosyandu'              => 'required',
					'sosialitasKeTetangga'       => 'required',
					'keterlibatanBerorganisasi'  => 'required',
					'kegiatanKemasyarakatan'     => 'required',
					'keterlibatanMusrembang'     => 'required',
					'alatBantuBantuan'           => 'required',
					'asalAlatBantu'              => 'required',
					'tahunPemberian'             => 'required',
					'bantuanUep'                 => 'required',
					'rehabilitas'                => 'required',
					'lokasiRehabilitas'          => 'required',
					'tahunRehabilitas'           => 'required',
					'keahlianKhusus'             => 'required',
					'prestasi'                   => 'required',
					'namaPerawatWali'            => 'required',
					'hubunganDenganPD'           => 'required',
					'nomorHpPd'                  => 'required',
					'kelayakan'                  => 'required',
					'latitude'                   => 'required',
					'longitude'                  => 'required',
					'pekerjaan'					 => 'required',
					'lokasiBekerja'				 => 'required',
					'alasanTidakBekerja'		 => 'required',
					'pendapatanBulan'			 => 'required',
					'pengeluaranBulan'			 => 'required',
					'pendapatanLain'			 => 'required',
					'minatKerja'				 => 'required',
					'keterampilan'				 => 'required',
					'tahunUep'					 => 'required',
					'asalUep'				 	 => 'required',
					'lainnyaUep'				 => 'required'
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				//auto input alamat
				$provinsi 	= get_option(SIKS_PROV);
				$kabkot		= get_option(SIKS_KABKOT);
				$get_desa	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							id_desa,
							nama
						FROM data_alamat_siks
						WHERE id_desa = %d
                	', $postData['id_desa']),
					ARRAY_A
				);
				$get_kec	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND active = 1
                	', $get_desa['id_kec']),
					ARRAY_A
				);

				if (
					empty($provinsi)
					|| empty($kabkot)
					|| empty($get_kec)
					|| empty($get_desa)
				) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat Tidak Lengkap!';
					die(json_encode($ret));
				}

				// Data to be saved
				$id_data = !empty($postData['id_data']) ? sanitize_text_field($postData['id_data']) : null;

				$data = array(
					'tahun_anggaran'             		=> sanitize_text_field($postData['tahunAnggaran']),
					'nama'                       		=> sanitize_textarea_field($postData['nama']),
					'gender'                     		=> sanitize_text_field($postData['gender']),
					'tempat_lahir'              		=> sanitize_text_field($postData['tempatLahir']),
					'tanggal_lahir'             		=> sanitize_text_field($postData['tanggalLahir']),
					'status'                     		=> sanitize_text_field($postData['status']),
					'dokumen_kewarganegaraan'   		=> sanitize_text_field($postData['dokumenKewarganegaraan']),
					'nik'                        		=> sanitize_text_field($postData['nik']),
					'nomor_kk'                   		=> sanitize_text_field($postData['nomorKK']),
					'rt'                         		=> sanitize_text_field($postData['rt']),
					'rw'                         		=> sanitize_text_field($postData['rw']),

					'provinsi' 							=> $provinsi,
					'kabkot' 							=> $kabkot,
					'id_kec' 							=> $get_kec['id_kec'],
					'kecamatan' 						=> strtoupper($get_kec['nama']),
					'id_desa_kel' 						=> $get_desa['id_desa'],
					'desa'								=> strtoupper($get_desa['nama']),
					'status_data'						=> 0,

					'no_hp'                      		=> sanitize_text_field($postData['noHp']),
					'pendidikan_terakhir'       		=> sanitize_text_field($postData['pendidikanTerakhir']),
					'nama_sekolah'              		=> sanitize_text_field($postData['namaSekolah']),
					'keterangan_lulus'          		=> sanitize_text_field($postData['keteranganLulus']),
					'jenis_disabilitas'         		=> sanitize_text_field($postData['jenisDisabilitas']),
					'keterangan_disabilitas'    		=> sanitize_text_field($postData['keteranganDisabilitas']),
					'sebab_disabilitas'         		=> sanitize_text_field($postData['sebabDisabilitas']),
					'diagnosa_medis'            		=> sanitize_text_field($postData['diagnosaMedis']),
					'penyakit_lain'             		=> sanitize_text_field($postData['penyakitLain']),
					'tempat_pengobatan'         		=> sanitize_text_field($postData['tempatPengobatan']),
					'perawat'                   		=> sanitize_text_field($postData['perawat']),
					'aktivitas'                 		=> sanitize_text_field($postData['aktivitas']),
					'aktivitas_bantuan'         		=> sanitize_text_field($postData['aktivitasBantuan']),
					'perlu_bantu'               		=> sanitize_text_field($postData['perluBantu']),
					'alat_bantu'                		=> sanitize_text_field($postData['alatBantu']),
					'alat_yang_dimiliki'        		=> sanitize_text_field($postData['alatYangDimiliki']),
					'kondisi_alat'              		=> sanitize_text_field($postData['kondisiAlat']),
					'jaminan_kesehatan'         		=> sanitize_text_field($postData['jaminanKesehatan']),
					'cara_menggunakan_jamkes'   		=> sanitize_text_field($postData['caraMenggunakanJamkes']),
					'jaminan_sosial'            		=> sanitize_text_field($postData['jaminanSosial']),
					'pekerjaan'                 		=> sanitize_text_field($postData['pekerjaan']),
					'lokasi_bekerja'            		=> sanitize_text_field($postData['lokasiBekerja']),
					'alasan_tidak_bekerja'      		=> sanitize_text_field($postData['alasanTidakBekerja']),
					'pendapatan_bulan'          		=> sanitize_text_field($postData['pendapatanBulan']),
					'pengeluaran_bulan'         		=> sanitize_text_field($postData['pengeluaranBulan']),
					'pendapatan_lain'           		=> sanitize_text_field($postData['pendapatanLain']),
					'minat_kerja'               		=> sanitize_text_field($postData['minatKerja']),
					'keterampilan'              		=> sanitize_text_field($postData['keterampilan']),
					'pelatihan_yang_diikuti'    		=> sanitize_text_field($postData['pelatihanYangDiikuti']),
					'pelatihan_yang_diminat'    		=> sanitize_text_field($postData['pelatihanYangDiminat']),
					'status_rumah'              		=> sanitize_text_field($postData['statusRumah']),
					'lantai'                    		=> sanitize_text_field($postData['lantai']),
					'kamar_mandi'               		=> sanitize_text_field($postData['kamarMandi']),
					'wc'                        		=> sanitize_text_field($postData['wc']),
					'akses_ke_lingkungan'       		=> sanitize_text_field($postData['aksesKeLingkungan']),
					'dinding'                   		=> sanitize_text_field($postData['dinding']),
					'sarana_air'                		=> sanitize_text_field($postData['saranaAir']),
					'penerangan'                		=> sanitize_text_field($postData['penerangan']),
					'desa_paud'                 		=> sanitize_text_field($postData['desaPaud']),
					'tk_di_desa'                		=> sanitize_text_field($postData['tkDiDesa']),
					'kecamatan_slb'             		=> sanitize_text_field($postData['kecamatanSlb']),
					'sd_menerima_abk'          			=> sanitize_text_field($postData['sdMenerimaAbk']),
					'smp_menerima_abk'         			=> sanitize_text_field($postData['smpMenerimaAbk']),
					'jumlah_posyandu'          			=> sanitize_text_field($postData['jumlahPosyandu']),
					'kader_posyandu'           			=> sanitize_text_field($postData['kaderPosyandu']),
					'layanan_kesehatan'        			=> sanitize_text_field($postData['layananKesehatan']),
					'sosialitas_ke_tetangga'   			=> sanitize_text_field($postData['sosialitasKeTetangga']),
					'keterlibatan_berorganisasi'		=> sanitize_text_field($postData['keterlibatanBerorganisasi']),
					'kegiatan_kemasyarakatan'   		=> sanitize_text_field($postData['kegiatanKemasyarakatan']),
					'keterlibatan_musrembang'   		=> sanitize_text_field($postData['keterlibatanMusrembang']),
					'alat_bantu_bantuan'        		=> sanitize_text_field($postData['alatBantuBantuan']),
					'asal_alat_bantu'           		=> sanitize_text_field($postData['asalAlatBantu']),
					'tahun_pemberian'           		=> sanitize_text_field($postData['tahunPemberian']),
					'bantuan_uep'               		=> sanitize_text_field($postData['bantuanUep']),
					'asal_uep'                  		=> sanitize_text_field($postData['asalUep']),
					'tahun'                     		=> sanitize_text_field($postData['tahunUep']),
					'lainnya'                   		=> sanitize_text_field($postData['lainnyaUep']),
					'rehabilitas'               		=> sanitize_text_field($postData['rehabilitas']),
					'lokasi_rehabilitas'        		=> sanitize_text_field($postData['lokasiRehabilitas']),
					'tahun_rehabilitas'         		=> sanitize_text_field($postData['tahunRehabilitas']),
					'keahlian_khusus'           		=> sanitize_text_field($postData['keahlianKhusus']),
					'prestasi'                  		=> sanitize_text_field($postData['prestasi']),
					'nama_perawat_wali'         		=> sanitize_text_field($postData['namaPerawatWali']),
					'hubungan_dengan_pd'        		=> sanitize_text_field($postData['hubunganDenganPD']),
					'nomor_hp'                  		=> sanitize_text_field($postData['nomorHpPd']),
					'kelayakan'                 		=> sanitize_text_field($postData['kelayakan']),
					'lat'                        		=> sanitize_text_field($postData['latitude']),
					'lng'                        		=> sanitize_text_field($postData['longitude']),
					'active'                     		=> 1
				);

				$path = SIKS_PLUGIN_PATH . 'public/media/disabilitas/';

				$cek_file = array();
				if (
					!empty($_FILES['lampiran'])
				) {
					$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
					if ($upload['status'] == true) {
						$data['file_lampiran'] = $upload['filename'];
						$cek_file['file_lampiran'] = $data['file_lampiran'];
					} else {
						$ret['status'] = 'error';
						$ret['message'] = $upload['message'];
					}
				}

				if ($ret['status'] == 'error') {
					// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
					foreach ($cek_file as $newfile) {
						if (is_file($path . $newfile)) {
							unlink($path . $newfile);
						}
					}
				}

				// Update or insert
				if ($ret['status'] != 'error') {
					if ($id_data) {
						$file_lama = $wpdb->get_row(
							$wpdb->prepare('
								SELECT
									file_lampiran
								FROM data_usulan_disabilitas_siks
								WHERE id = %d
							', $_POST['id_data']),
							ARRAY_A
						);
						if (
							$file_lama['file_lampiran'] != $data['file_lampiran']
							&& is_file($path . $file_lama['file_lampiran'])
						) {
							unlink($path . $file_lama['file_lampiran']);
						}

						$wpdb->update(
							'data_usulan_disabilitas_siks',
							$data,
							array('id' => $id_data)
						);
						$ret['message'] = 'Berhasil update data!';
					} else {
						$wpdb->insert(
							'data_usulan_disabilitas_siks',
							$data
						);
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_usulan_lansia()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data usulan!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'latitude'                    	  => 'required',
					'longitude'                   	  => 'required',
					'nik'                         	  => 'required',
					'nama'                        	  => 'required',
					'tanggalLahir'                	  => 'required',
					'usia'                        	  => 'required',
					'alamat'                      	  => 'required',
					'dokumenKependudukan'         	  => 'required',
					'statusTempatTinggal'         	  => 'required',
					'statusPemenuhanKebutuhan'    	  => 'required',
					'tahunAnggaran'    	  			  => 'required',
					'statusKehidupanRumahTangga'  	  => 'required',
					'statusDtks'                  	  => 'required',
					'rekomendasiPendata'          	  => 'required',
					'keteranganLainnya'           	  => 'required',
					'statusKepersertaanProgramBansos' => 'required',
					'rekomendasiPendataLama' 		  => 'required',
					'keteranganLainnyaLama' 		  => 'required'
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				//auto input alamat
				$provinsi 	= get_option(SIKS_PROV);
				$kabkot		= get_option(SIKS_KABKOT);
				$get_desa	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							id_desa,
							nama
						FROM data_alamat_siks
						WHERE id_desa = %d
                	', $postData['id_desa']),
					ARRAY_A
				);
				$get_kec	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND active = 1
                	', $get_desa['id_kec']),
					ARRAY_A
				);

				if (
					empty($provinsi)
					|| empty($kabkot)
					|| empty($get_kec)
					|| empty($get_desa)
				) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat Tidak Lengkap!';
					die(json_encode($ret));
				}

				// Data to be saved
				$id_data = !empty($postData['id_data']) ? sanitize_text_field($postData['id_data']) : null;
				$data = array(
					'lng'                         	     => sanitize_text_field($postData['longitude']),
					'lat'                         	     => sanitize_text_field($postData['latitude']),
					'nik'                         	     => sanitize_text_field($postData['nik']),
					'nama'                        	     => sanitize_text_field($postData['nama']),
					'tahun_anggaran'                        	     => sanitize_text_field($postData['tahunAnggaran']),
					'tanggal_lahir'               	     => sanitize_text_field($postData['tanggalLahir']),
					'usia'                        	     => sanitize_text_field($postData['usia']),
					'provinsi' 					  	     => $provinsi,
					'kabkot' 					  	     => $kabkot,
					'id_kec' 					  	     => $get_kec['id_kec'],
					'kecamatan' 				  	     => strtoupper($get_kec['nama']),
					'id_desa_kel' 				  	     => $get_desa['id_desa'],
					'desa'						  	     => strtoupper($get_desa['nama']),
					'status_data'				  	     => 0,
					'alamat'                      	     => sanitize_text_field($postData['alamat']),
					'dokumen_kependudukan'        	     => sanitize_text_field($postData['dokumenKependudukan']),
					'status_tempat_tinggal'       	     => sanitize_text_field($postData['statusTempatTinggal']),
					'status_pemenuhan_kebutuhan'  	     => sanitize_text_field($postData['statusPemenuhanKebutuhan']),
					'status_kehidupan_rumah_tangga'      => sanitize_text_field($postData['statusKehidupanRumahTangga']),
					'status_dtks'                 	     => sanitize_text_field($postData['statusDtks']),
					'rekomendasi_pendata'         	     => sanitize_text_field($postData['rekomendasiPendata']),
					'status_kepersertaan_program_bansos' => sanitize_text_field($postData['statusKepersertaanProgramBansos']),
					'rekomendasi_pendata_lama' 		     => sanitize_text_field($postData['rekomendasiPendataLama']),
					'keterangan_lainnya_lama' 		     => sanitize_text_field($postData['keteranganLainnyaLama']),
					'keterangan_lainnya'          	     => sanitize_text_field($postData['keteranganLainnya']),
					'active'                     	     => 1
				);


				$path = SIKS_PLUGIN_PATH . 'public/media/lansia/';

				$cek_file = array();
				if (
					!empty($_FILES['lampiran'])
				) {
					$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
					if ($upload['status'] == true) {
						$data['file_lampiran'] = $upload['filename'];
						$cek_file['file_lampiran'] = $data['file_lampiran'];
					} else {
						$ret['status'] = 'error';
						$ret['message'] = $upload['message'];
					}
				}

				if ($ret['status'] == 'error') {
					// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
					foreach ($cek_file as $newfile) {
						if (is_file($path . $newfile)) {
							unlink($path . $newfile);
						}
					}
				}

				// Update or insert
				if ($ret['status'] != 'error') {
					if ($id_data) {
						$file_lama = $wpdb->get_row(
							$wpdb->prepare('
								SELECT
									file_lampiran
								FROM data_usulan_lansia_siks
								WHERE id = %d
							', $_POST['id_data']),
							ARRAY_A
						);
						if (
							$file_lama['file_lampiran'] != $data['file_lampiran']
							&& is_file($path . $file_lama['file_lampiran'])
						) {
							unlink($path . $file_lama['file_lampiran']);
						}

						$wpdb->update(
							'data_usulan_lansia_siks',
							$data,
							array('id' => $id_data)
						);
						$ret['message'] = 'Berhasil update data!';
					} else {
						$wpdb->insert(
							'data_usulan_lansia_siks',
							$data
						);
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_usulan_bunda_kasih()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data usulan!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'tahunAnggaran' => 'required|numeric|max:4',
					'latitude'      => 'required',
					'longitude'     => 'required',
					'nik'			=> 'required|numeric|max:16',
					'kk'			=> 'required|numeric|max:16',
					'rtRw'			=> 'required',
					'nama'			=> 'required'

				];
				// die(print_r($postData));

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				//auto input alamat
				$provinsi 	= get_option(SIKS_PROV);
				$kabkot		= get_option(SIKS_KABKOT);
				$get_desa	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							id_desa,
							nama
						FROM data_alamat_siks
						WHERE id_desa = %d
                	', $postData['id_desa']),
					ARRAY_A
				);
				$get_kec	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND active = 1
                	', $get_desa['id_kec']),
					ARRAY_A
				);

				if (
					empty($provinsi)
					|| empty($kabkot)
					|| empty($get_kec)
					|| empty($get_desa)
				) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat Tidak Lengkap!';
					die(json_encode($ret));
				}

				// Data to be saved
				$id_data = !empty($postData['id_data']) ? sanitize_text_field($postData['id_data']) : null;

				$data = array(
					'tahun_anggaran'             		=> sanitize_text_field($postData['tahunAnggaran']),
					'provinsi' 							=> $provinsi,
					'kabkot' 							=> $kabkot,
					'id_kec' 							=> $get_kec['id_kec'],
					'kecamatan' 						=> strtoupper($get_kec['nama']),
					'id_desa_kel' 						=> $get_desa['id_desa'],
					'desa'								=> strtoupper($get_desa['nama']),
					'status_data'						=> 0,
					'lat'                        		=> sanitize_text_field($postData['latitude']),
					'lng'                        		=> sanitize_text_field($postData['longitude']),
					'nik'                        		=> sanitize_text_field($postData['nik']),
					'kk'                        		=> sanitize_text_field($postData['kk']),
					'rt_rw'                        		=> sanitize_text_field($postData['rtRw']),
					'nama'                        		=> sanitize_text_field($postData['nama']),
					'active'                     		=> 1
				);

				$path = SIKS_PLUGIN_PATH . 'public/media/bunda_kasih/';

				$cek_file = array();
				if (
					!empty($_FILES['lampiran'])
				) {
					$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
					if ($upload['status'] == true) {
						$data['file_lampiran'] = $upload['filename'];
						$cek_file['file_lampiran'] = $data['file_lampiran'];
					} else {
						$ret['status'] = 'error';
						$ret['message'] = $upload['message'];
					}
				}

				if ($ret['status'] == 'error') {
					// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
					foreach ($cek_file as $newfile) {
						if (is_file($path . $newfile)) {
							unlink($path . $newfile);
						}
					}
				}

				// Update or insert
				if ($ret['status'] != 'error') {
					if ($id_data) {
						$file_lama = $wpdb->get_row(
							$wpdb->prepare('
								SELECT
									file_lampiran
								FROM data_usulan_bunda_kasih_siks
								WHERE id = %d
							', $_POST['id_data']),
							ARRAY_A
						);
						if (
							$file_lama['file_lampiran'] != $data['file_lampiran']
							&& is_file($path . $file_lama['file_lampiran'])
						) {
							unlink($path . $file_lama['file_lampiran']);
						}

						$wpdb->update(
							'data_usulan_bunda_kasih_siks',
							$data,
							array('id' => $id_data)
						);
						$ret['message'] = 'Berhasil update data usulan!';
					} else {
						$wpdb->insert(
							'data_usulan_bunda_kasih_siks',
							$data
						);
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_usulan_hibah()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data usulan!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules based on the JS validationRules
				$validationRules = [
					'tahunAnggaran'    => 'required|numeric',
					'jenisData'        => 'required|in:Induk,PAK',
					'statusRealisasi'  => 'required|in:Realisasi,Tidak Realisasi,Proses',
					'anggaran'         => 'required|numeric',
					'penerima'         => 'required',
					'nama_nik_ketua'   => 'required',
					'alamat'           => 'required',
					'id_desa'          => 'required',
					'nphd'             => 'required',
					'spm'              => 'required',
					'sp2d'             => 'required',
					'tglNphd'          => 'required|date',
					'tglSpm'           => 'required|date',
					'tglSp2d'          => 'required|date',
					'keterangan'       => 'required',
					'peruntukan'       => 'required',
					'longitude'        => 'required|numeric',
					'latitude'         => 'required|numeric',
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				//auto input alamat
				$provinsi 	= get_option(SIKS_PROV);
				$kabkot		= get_option(SIKS_KABKOT);
				$get_desa	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							id_desa,
							nama
						FROM data_alamat_siks
						WHERE id_desa = %d
                	', $postData['id_desa']),
					ARRAY_A
				);
				$get_kec	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND active = 1
                	', $get_desa['id_kec']),
					ARRAY_A
				);

				if (
					empty($provinsi)
					|| empty($kabkot)
					|| empty($get_kec)
					|| empty($get_desa)
				) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat Tidak Lengkap!';
					die(json_encode($ret));
				}

				// Data to be saved
				$id_data = !empty($postData['id_data']) ? sanitize_text_field($postData['id_data']) : null;

				// Sanitize and prepare data
				$data = [
					'tahun_anggaran'    => sanitize_text_field($postData['tahunAnggaran']),
					'jenis_data'        => sanitize_text_field($postData['jenisData']),
					'status_realisasi'  => sanitize_text_field($postData['statusRealisasi']),
					'anggaran'          => sanitize_text_field($postData['anggaran']),
					'penerima'          => sanitize_text_field($postData['penerima']),
					'nama_nik_ketua'    => sanitize_text_field($postData['nama_nik_ketua']),
					'alamat'            => sanitize_text_field($postData['alamat']),
					'keterangan'        => sanitize_text_field($postData['keterangan']),
					'provinsi' 			=> $provinsi,
					'kabkot' 			=> $kabkot,
					'id_kec' 			=> $get_kec['id_kec'],
					'kecamatan' 		=> strtoupper($get_kec['nama']),
					'id_desa_kel' 		=> $get_desa['id_desa'],
					'desa_kelurahan' 	=> strtoupper($get_desa['nama']),
					'status_data' 		=> 0,
					'kode' 				=> '-',
					'no_nphd'           => sanitize_text_field($postData['nphd']),
					'no_spm'            => sanitize_text_field($postData['spm']),
					'no_sp2d'           => sanitize_text_field($postData['sp2d']),
					'tgl_nphd'          => sanitize_text_field($postData['tglNphd']),
					'tgl_spm'           => sanitize_text_field($postData['tglSpm']),
					'tgl_sp2d'          => sanitize_text_field($postData['tglSp2d']),
					'peruntukan'        => sanitize_textarea_field($postData['peruntukan']),
					'lat'               => sanitize_text_field($postData['latitude']),
					'lng'               => sanitize_text_field($postData['longitude']),
					'active'            => 1 // Default to active
				];

				// Update or insert
				if ($id_data) {
					$wpdb->update(
						'data_usulan_hibah_siks',
						$data,
						array('id' => $id_data)
					);
					$ret['message'] = 'Berhasil update data!';
				} else {
					$wpdb->insert(
						'data_usulan_hibah_siks',
						$data
					);
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_usulan_dtks()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data usulan!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules based on the JS validationRules
				$validationRules = [
					'nama'			=> 'required',
					'nik'			=> 'required',
					'noKk'			=> 'required',
					'alamat'		=> 'required',
					'atensi'		=> 'required',
					'blt'			=> 'required',
					'bltBbm'		=> 'required',
					'bnptPpkm'		=> 'required',
					'bpnt'			=> 'required',
					'bst'			=> 'required',
					'pbi'			=> 'required',
					'pena'			=> 'required',
					'permakanan'	=> 'required',
					'rutilahu'		=> 'required',
					'sembakoAdaptif'=> 'required',
					'yapi'			=> 'required',
					'pkh'			=> 'required',
					'firstSK'		=> 'required'
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				//auto input alamat
				$provinsi 	= get_option(SIKS_PROV);
				$kabkot		= get_option(SIKS_KABKOT);
				$get_desa	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							id_desa,
							nama
						FROM data_alamat_siks
						WHERE id_desa = %d
                	', $postData['id_desa']),
					ARRAY_A
				);
				$get_kec	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND active = 1
                	', $get_desa['id_kec']),
					ARRAY_A
				);

				if (
					empty($provinsi)
					|| empty($kabkot)
					|| empty($get_kec)
					|| empty($get_desa)
				) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat Tidak Lengkap!';
					die(json_encode($ret));
				}

				// Data to be saved
				$id_data = !empty($postData['id_data']) ? sanitize_text_field($postData['id_data']) : null;

				// prepare data
				$data = [
					'provinsi'            => $provinsi,
					'kabupaten'           => $kabkot,
					'id_kec'              => $get_kec['id_kec'],
					'kecamatan'           => strtoupper($get_kec['nama']),
					'id_desa_kel'         => $get_desa['id_desa'],
					'desa_kelurahan'      => strtoupper($get_desa['nama']),
					'status_data'         => 0,
					'Nama'                => sanitize_text_field($postData['nama']),
					'NIK'                 => sanitize_text_field($postData['nik']), 
					'NOKK'                => sanitize_text_field($postData['noKk']),
					'Alamat'              => sanitize_textarea_field($postData['alamat']),
					'ATENSI'              => sanitize_text_field($postData['atensi']),
					'BLT'                 => sanitize_text_field($postData['blt']),
					'BLT_BBM'             => sanitize_text_field($postData['bltBbm']),
					'BNPT_PPKM'           => sanitize_text_field($postData['bnptPpkm']),
					'BPNT'                => sanitize_text_field($postData['bpnt']),
					'BST'                 => sanitize_text_field($postData['bst']),
					'PBI'                 => sanitize_text_field($postData['pbi']),
					'PENA'                => sanitize_text_field($postData['pena']),
					'PERMAKANAN'          => sanitize_text_field($postData['permakanan']),
					'RUTILAHU'            => sanitize_text_field($postData['rutilahu']),
					'YAPI'                => sanitize_text_field($postData['yapi']),
					'SEMBAKO_ADAPTIF'     => sanitize_text_field($postData['sembakoAdaptif']),
					'PKH'                 => sanitize_text_field($postData['pkh']),
					'FIRST_SK'            => sanitize_text_field($postData['firstSK'])
				];

				// Update or insert
				if ($id_data) {
					$wpdb->update(
						'data_usulan_dtks_siks',
						$data,
						array('id' => $id_data)
					);
					$ret['message'] = 'Berhasil update data!';
				} else {
					$wpdb->insert(
						'data_usulan_dtks_siks',
						$data
					);
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_usulan_anak_terlantar()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data usulan!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'nik' 			   => 'required|numeric|max:16',
					'kk' 			   => 'required|numeric|max:16',
					'jenisKelamin'     => 'required|in:Laki-Laki,Perempuan',
					'nama' 			   => 'required',
					'id_desa' 		   => 'required',
					'usia' 			   => 'required|numeric',
					'tanggalLahir'     => 'required',
					'statusLembaga'    => 'required|in:0,1',
					'alamat' 		   => 'required',
					'pendidikan' 	   => 'required',
					'tahunAnggaran'    => 'required|numeric',
					'longitude' 	   => 'nullable',
					'latitude' 		   => 'nullable'
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				//auto input alamat
				$provinsi 	= get_option(SIKS_PROV);
				$kabkot		= get_option(SIKS_KABKOT);
				$get_desa	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							id_desa,
							nama
						FROM data_alamat_siks
						WHERE id_desa = %d
                	', $postData['id_desa']),
					ARRAY_A
				);
				$get_kec	= $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							id_kec,
							nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND active = 1
                	', $get_desa['id_kec']),
					ARRAY_A
				);

				if (
					empty($provinsi)
					|| empty($kabkot)
					|| empty($get_kec)
					|| empty($get_desa)
				) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat Tidak Lengkap!';
					die(json_encode($ret));
				}

				// Data to be saved
				$id_data = !empty($postData['id_data']) ? sanitize_text_field($postData['id_data']) : null;

				$data = array(
					'tahun_anggaran' 	=> sanitize_text_field($postData['tahunAnggaran']),
					'nama' 				=> sanitize_text_field($postData['nama']),
					'usia' 				=> sanitize_text_field($postData['usia']),
					'nik' 				=> sanitize_text_field($postData['nik']),
					'kk' 				=> sanitize_text_field($postData['kk']),
					'alamat' 			=> sanitize_text_field($postData['alamat']),
					'tanggal_lahir' 	=> sanitize_text_field($postData['tanggalLahir']),
					'pendidikan' 		=> sanitize_text_field($postData['pendidikan']),
					'kelembagaan' 		=> sanitize_text_field($postData['statusLembaga']),
					'jenis_kelamin' 	=> sanitize_text_field($postData['jenisKelamin']),
					'provinsi' 			=> $provinsi,
					'kabkot' 			=> $kabkot,
					'id_kec' 			=> $get_kec['id_kec'],
					'kecamatan' 		=> strtoupper($get_kec['nama']),
					'id_desa_kel' 		=> $get_desa['id_desa'],
					'desa_kelurahan' 	=> strtoupper($get_desa['nama']),
					'status_data' 		=> 0,
					'lat' 				=> sanitize_text_field($postData['latitude']),
					'lng' 				=> sanitize_text_field($postData['longitude']),
					'active' 			=> 1
				);

				$path = SIKS_PLUGIN_PATH . 'public/media/lansia/';

				$cek_file = array();
				if (
					!empty($_FILES['lampiran'])
				) {
					$upload = CustomTraitSiks::uploadFileSiks($_POST['api_key'], $path, $_FILES['lampiran'], ['jpg', 'jpeg', 'png', 'pdf']);
					if ($upload['status'] == true) {
						$data['file_lampiran'] = $upload['filename'];
						$cek_file['file_lampiran'] = $data['file_lampiran'];
					} else {
						$ret['status'] = 'error';
						$ret['message'] = $upload['message'];
					}
				}

				if ($ret['status'] == 'error') {
					// hapus file yang sudah terlanjur upload karena ada file yg gagal upload!
					foreach ($cek_file as $newfile) {
						if (is_file($path . $newfile)) {
							unlink($path . $newfile);
						}
					}
				}

				// Update or insert
				if ($ret['status'] != 'error') {
					if ($id_data) {
						$file_lama = $wpdb->get_row(
							$wpdb->prepare('
								SELECT
									file_lampiran
								FROM data_bunda_kasih_siks
								WHERE id = %d
							', $_POST['id_data']),
							ARRAY_A
						);
						if (
							$file_lama['file_lampiran'] != $data['file_lampiran']
							&& is_file($path . $file_lama['file_lampiran'])
						) {
							unlink($path . $file_lama['file_lampiran']);
						}
						$wpdb->update(
							'data_usulan_anak_terlantar_siks',
							$data,
							array('id' => $id_data)
						);
						$ret['message'] = 'Berhasil update data!';
					} else {
						$wpdb->insert(
							'data_usulan_anak_terlantar_siks',
							$data
						);
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function tambah_data_hibah()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil simpan data!',
			'data' => array()
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error') {
					// Mengambil data dari form
					$id_data = !empty($_POST['id_data']) ? sanitize_text_field($_POST['id_data']) : null;
					$tahun_anggaran = sanitize_text_field($_POST['tahunAnggaran']);
					$jenis_data = sanitize_text_field($_POST['jenisData']);
					$anggaran = sanitize_text_field($_POST['anggaran']);
					$status_realisasi = sanitize_text_field($_POST['statusRealisasi']);
					$penerima = sanitize_text_field($_POST['penerima']);
					$nama_nik_ketua = sanitize_text_field($_POST['nama_nik_ketua']);
					$alamat = sanitize_text_field($_POST['alamat']);
					$kecamatan = sanitize_text_field($_POST['kecamatan']);
					$keterangan = sanitize_text_field($_POST['keterangan']);
					$no_nphd = sanitize_text_field($_POST['nphd']);
					$tgl_nphd = sanitize_text_field($_POST['tglNphd']);
					$no_spm = sanitize_text_field($_POST['spm']);
					$tgl_spm = sanitize_text_field($_POST['tglSpm']);
					$no_sp2d = sanitize_text_field($_POST['sp2d']);
					$tgl_sp2d = sanitize_text_field($_POST['tglSp2d']);
					$peruntukan = sanitize_textarea_field($_POST['peruntukan']);
					$lat = sanitize_textarea_field($_POST['latitude']);
					$long = sanitize_textarea_field($_POST['longitude']);

					// Data yang akan disimpan atau diperbarui
					$data = array(
						'tahun_anggaran' => $tahun_anggaran,
						'jenis_data' => $jenis_data,
						'anggaran' => $anggaran,
						'status_realisasi' => $status_realisasi,
						'penerima' => $penerima,
						'nama_nik_ketua' => $nama_nik_ketua,
						'alamat' => $alamat,
						'kecamatan' => $kecamatan,
						'no_nphd' => $no_nphd,
						'keterangan' => $keterangan,
						'tgl_nphd' => $tgl_nphd,
						'no_spm' => $no_spm,
						'tgl_spm' => $tgl_spm,
						'no_sp2d' => $no_sp2d,
						'tgl_sp2d' => $tgl_sp2d,
						'peruntukan' => $peruntukan,
						'lat' => $lat,
						'lng' => $long,
						'kode' => '-',
						'create_at' => current_time('mysql'),
						'update_at' => current_time('mysql'),
						'active' => 1
					);

					// Jika `id_data` ada, lakukan pembaruan data, jika tidak, tambahkan data baru
					if ($id_data) {
						$wpdb->update(
							'data_hibah_siks',
							$data,
							array('id' => $id_data)
						);
						$ret['message'] = 'Berhasil update data!';
					} else {
						$wpdb->insert(
							'data_hibah_siks',
							$data
						);
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}


	public function get_data_calon_p3ke_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_calon_p3ke_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_wrse_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_wrse_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_usulan_wrse_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_usulan_wrse_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_usulan_p3ke_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_usulan_p3ke_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_usulan_dtks_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_usulan_dtks_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_usulan_odgj_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_usulan_odgj_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_usulan_anak_terlantar_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_usulan_anak_terlantar_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_usulan_disabilitas_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_usulan_disabilitas_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_usulan_hibah_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_usulan_hibah_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_usulan_lansia_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_usulan_lansia_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_usulan_bunda_kasih_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_usulan_bunda_kasih_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function get_data_hibah_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT 
							*
						FROM data_hibah_siks
						WHERE id=%d
                	', $_POST['id']),
					ARRAY_A
				);
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_calon_p3ke_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update('data_calon_p3ke_siks', array('active' => 0), array(
					'id' => $_POST['id']
				));
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_wrse_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update(
					'data_wrse_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_usulan_wrse_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$ret['data'] = $wpdb->update(
					'data_usulan_wrse_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_usulan_p3ke_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$ret['data'] = $wpdb->update(
					'data_usulan_p3ke_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_usulan_lansia_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$ret['data'] = $wpdb->update(
					'data_usulan_lansia_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_usulan_bunda_kasih_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$ret['data'] = $wpdb->update(
					'data_usulan_bunda_kasih_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_usulan_anak_terlantar_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$ret['data'] = $wpdb->update(
					'data_usulan_anak_terlantar_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_usulan_hibah_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$ret['data'] = $wpdb->update(
					'data_usulan_hibah_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_usulan_disabilitas_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$ret['data'] = $wpdb->update(
					'data_usulan_disabilitas_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_usulan_dtks_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$ret['data'] = $wpdb->update(
					'data_usulan_dtks_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_usulan_odgj_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$ret['data'] = $wpdb->update(
					'data_usulan_odgj_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	public function hapus_data_hibah_by_id()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil hapus data!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$ret['data'] = $wpdb->update(
					'data_hibah_siks',
					array('active' => 0),
					array(
						'id' => $_POST['id']
					)
				);
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function cek_nik_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-cek-nik.php';
	}

	function cari_nik_siks()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if (strlen($_POST['nik']) >= 3) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$data_p3ke = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_p3ke_siks
					WHERE nik like %s OR
							nama like %s OR
							kk like %s
				", '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%'));

				$data_anak_terlantar = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_anak_terlantar_siks

					WHERE nik like %s OR
							nama like %s OR
							kk like %s
				", '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%'));

				$data_bunda_kasih = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_bunda_kasih_siks

					WHERE nik like %s OR
							nama like %s OR
							kk like %s
				", '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%'));

				$data_disabilitas = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_disabilitas_siks
					WHERE nik like %s OR
							nama like %s OR
							nomor_kk like %s
				", '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%'));

				$data_lansia = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_lansia_siks
					WHERE nik like %s OR
							nama like %s
				", '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%'));

				$data_odgj = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_odgj_siks
					WHERE nik like %s OR
							nama like %s OR
							kk like %s
				", '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%', '%' . $_POST['nik'] . '%'));

				$ret['data']['p3ke'] = $data_p3ke;
				$ret['data']['anak_terlantar'] = $data_anak_terlantar;
				$ret['data']['bunda_kasih'] = $data_bunda_kasih;
				$ret['data']['disabilitas'] = $data_disabilitas;
				$ret['data']['lansia'] = $data_lansia;
				$ret['data']['odgj'] = $data_odgj;
			} else {
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function menu_siks()
	{
		global $wpdb;
		$user_data = wp_get_current_user();

		if (in_array('desa', $user_data->roles)) {
			$id_kecamatan = substr($user_data->user_login, 0, 6);
			$id_desa = $user_data->user_login;
			$data_desa = $wpdb->get_results(
				$wpdb->prepare('
					SELECT 
						is_kel,
						id as id_data,
						id_desa,
						nama
					FROM data_alamat_siks
					WHERE id_desa = %d
					  AND active = 1
				', $id_desa),
				ARRAY_A
			);
		} else if (in_array('kecamatan', $user_data->roles)) {
			$id_kecamatan = $user_data->user_login;
			$data_desa = $wpdb->get_results(
				$wpdb->prepare('
					SELECT
						is_kel,
						id as id_data,
						id_desa,
						nama
					FROM data_alamat_siks
					WHERE id_kec = %d
					  AND id_desa IS NOT NULL
					  AND active = 1
				', $id_kecamatan),
				ARRAY_A
			);
		} else if (in_array('administrator', $user_data->roles)) {
			$datas = array(
				'DTKS' => array(
					'Data DTKS SIKS' => '[data_dtks_siks]',
				),
				'Bunda Kasih' => array(
					'Data Bunda Kasih SIKS' => '[data_bunda_kasih_siks]',
				),
				'Anak Terlantar' => array(
					'Data Anak Terlantar SIKS' => '[data_anak_terlantar_siks]',
				),
				'Gepeng' => array(
					'Data Gepeng SIKS' => '[data_gepeng_siks]',
				),
				'Hibah' => array(
					'Data Hibah SIKS' => '[data_hibah_siks]',
				),
				'P3KE' => array(
					'Data P3KE SIKS' => '[data_p3ke_siks]',
				),
				'WRSE' => array(
					'Data WRSE SIKS' => '[data_wrse_siks]',
				),
				'Disabilitas' => array(
					'Data Disabilitas SIKS' => '[data_disabilitas_siks]',
				),
				'Lansia' => array(
					'Data Lansia SIKS' => '[data_lansia_siks]',
				),
				'ODGJ' => array(
					'Data ODGJ SIKS' => '[data_odgj_siks]',
				),
				//just add, if wanted to add more card for admin page
			);
			$return = '<div class="row">';

			foreach ($datas as $jenis_data => $pages) {
				$return .= '
					<div class="col-md-4 mb-4">
						<div class="card shadow-sm border-0 rounded-lg text-dark bg-light">
							<div class="card-body d-flex flex-column shadow-lg">
								<h5 class="card-title"><span class="dashicons dashicons-admin-page"></span> ' . $jenis_data . '</h5>
								<div class="d-flex justify-content-between">';
				foreach ($pages as $nama_page => $shortcode) {
					$page_verify = $this->functions->generatePage(array(
						'nama_page' => 'Halaman Verifikasi Data Usulan',
						'content' => '[list_verifikasi_usulan]',
						'show_header' => 1,
						'no_key' => 1,
						'post_status' => 'publish'
					));
					$params = '?jenis=' . urlencode($jenis_data);
					$page_url = $page_verify['url'] . $params;

					$return .= '
						<a href="' . $page_url . '" target="_blank" class="btn btn-warning">
							<span class="dashicons dashicons-yes-alt"></span>
							Verifikasi
						</a>';

					$page_view_data = $this->functions->generatePage(array(
						'nama_page' => $nama_page,
						'content' => $shortcode,
						'show_header' => 1,
						'no_key' => 1,
						'post_status' => 'publish'
					));

					$return .= '
						<a href="' . $page_view_data['url'] . '" target="_blank" class="btn btn-primary">
							<span class="dashicons dashicons-arrow-right-alt"></span>
							Lihat Data
						</a>';
				}
				$return .= '
							</div>
						</div>
					</div>
				</div>
			';
			}

			$return .= '</div>';
			return $return;
		} else {
			$return = '<h2 class="text-center">Anda tidak memiliki akses untuk halaman ini!.</h2>';
			return $return;
		}

		if (!empty($data_desa)) {
			$nama_kecamatan = $wpdb->get_var(
				$wpdb->prepare('
					SELECT 
						nama
					FROM data_alamat_siks
					WHERE id_kec = %d
					  AND id_desa IS NULL
					  AND active = 1
				', $id_kecamatan)
			);

			$pages = array(
				'DTKS' => array(
					'Usulan DTKS'    => '[usulan_dtks]',
					'DTKS Per Desa'  => '[dtks_per_desa]',
				),
				'Bunda Kasih' => array(
					'Usulan Bunda Kasih'    => '[usulan_bunda_kasih]',
					'Bunda Kasih Per Desa'  => '[bunda_kasih_per_desa]',
				),
				'Anak Terlantar' => array(
					'Usulan Anak Terlantar'    => '[usulan_anak_terlantar]',
					'Anak Terlantar Per Desa'  => '[anak_terlantar_per_desa]',
				),
				'Gepeng' => array(
					'Usulan Gepeng'    => '[usulan_gepeng]',
					'Gepeng Per Desa'  => '[gepeng_per_desa]',
				),
				'Hibah' => array(
					'Usulan Hibah'    => '[usulan_hibah]',
					'Hibah Per Desa'  => '[hibah_per_desa]',
				),
				'P3KE' => array(
					'Usulan P3KE'    => '[usulan_p3ke]',
					'P3KE Per Desa'  => '[p3ke_per_desa]',
				),
				'WRSE' => array(
					'Usulan WRSE'    => '[usulan_wrse]',
					'WRSE Per Desa'  => '[wrse_per_desa]',
				),
				'Disabilitas' => array(
					'Usulan Disabilitas'    => '[usulan_disabilitas]',
					'Disabilitas Per Desa'  => '[disabilitas_per_desa]',
				),
				'Lansia' => array(
					'Usulan Lansia'    => '[usulan_lansia]',
					'Lansia Per Desa'  => '[lansia_per_desa]',
				),
				'ODGJ' => array(
					'Usulan ODGJ'    => '[usulan_odgj]',
					'ODGJ Per Desa'  => '[odgj_per_desa]',
				),
				//just add, if wanted to add more card
			);


			$return = '<div id="desaAccordion" class="accordion">';
			foreach ($data_desa as $index => $desa) {
				$statusDesa = $desa['is_kel'];
				if ($statusDesa == 0) {
					$statusDesa = 'Desa';
				} else if ($statusDesa == 1) {
					$statusDesa = 'Kelurahan';
				}

				$collapseId = 'collapse' . $index;
				$headingId = 'heading' . $index;

				$return .= '
					<div class="card">
						<div class="card-header" id="' . $headingId . '">
							<h2 class="mb-0">
								<a class="accordion-toggle d-flex justify-content-between text-dark" data-toggle="collapse" href="#' . $collapseId . '" aria-expanded="false" aria-controls="' . $collapseId . '">
									' . $statusDesa . ' ' . $desa['nama'] . '
								<span class="dashicons dashicons-arrow-down-alt2"></span>
								</a>
							</h2>
						</div>

						<div id="' . $collapseId . '" class="collapse" aria-labelledby="' . $headingId . '" data-parent="#desaAccordion">
							<div class="card-body">
								<div class="d-flex justify-content-center mb-4">
									<button type="button" id="settingDesaBtn" class="btn btn-info" data-toggle="modal" data-target="#settingModal' . $index . '"><span class="dashicons dashicons-admin-generic"></span> Pengaturan</button>
								</div>
								<div class="row">
				';

				foreach ($pages as $jenis_data => $page) {
					$return .= '
					<div class="col-md-4  mb-3">
						<div class="card shadow-sm border-0 rounded-lg text-dark bg-light">
							<div class="card-body d-flex flex-column shadow-lg">
								<h5 class="card-title"><span class="dashicons dashicons-admin-page"></span> ' . $jenis_data . '</h5>
								<div class="d-flex justify-content-between">
					';

					foreach ($page as $nama_page => $shortcode) {
						// Tambahkan id_desa ke dalam shortcode
						$shortcode_with_id_desa = str_replace(
							']',
							' id_desa=' . $desa['id_desa'] . ']',
							$shortcode
						);

						$gen_page = $this->functions->generatePage(array(
							'nama_page' => $nama_page . ' | ' . $desa['nama'],
							'content' => $shortcode_with_id_desa,
							'show_header' => 1,
							'no_key' => 1,
							'post_status' => 'publish'
						));

						if (in_array('desa', $user_data->roles) && strpos(strtolower($nama_page), 'usulan') !== false) {
							$return .= '
							<a href="' . $gen_page['url'] . '" target="_blank" class="btn btn-warning">
								<span class="dashicons dashicons-insert"></span> Usulkan Data
							</a>
							';
						}

						if (strpos(strtolower($nama_page), 'per desa') !== false) {
							$return .= '
							<a href="' . $gen_page['url'] . '" target="_blank" class="btn btn-primary ml-auto">
								<span class="dashicons dashicons-arrow-right-alt"></span> Lihat Data
							</a>
							';
						}
					}

					$return .= '
								</div>
							</div>
						</div>
					</div>
					';
				}


				$return .= '
                    </div> 
                </div>
            </div>
        </div>

       <!-- Modal untuk Setting -->
		<div class="modal fade" id="settingModal' . $index . '" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel' . $index . '" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="settingModalLabel' . $index . '">Pengaturan ' . $desa['nama'] . '</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<input type="hidden" name="idDesa" value="' . $desa['id_desa'] . '">
								<label for="radioOption">Pilih Kategori</label><br>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="desaKelStatus" id="desaRadio" value="0">
									<label class="form-check-label" for="desaRadio">
										Desa
									</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="desaKelStatus" id="kelurahanRadio" value="1">
									<label class="form-check-label" for="kelurahanRadio">
										Kelurahan
									</label>
								</div>
							</div>
							<div class="form-group">
								<label for="currentName">Nama Sekarang</label>
								<input type="text" class="form-control" name="currentName" id="currentName" value="' . $desa['nama'] . '" disabled>
							</div>

							<div class="form-group">
								<label for="newName">Nama Baru</label>
								<input type="text" name="newName" class="form-control" id="newName">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="button" class="btn btn-primary" onclick="editDataDesaKel()">Simpan perubahan</button>
					</div>
				</div>
			</div>
		</div>

    ';
			}

			$return .= '</div>';
		} else {
			$return = '<h2 class="text-center">Data Desa tidak ditemukan!.</h2>';
		}
		return '
			<h2 class="text-center"> Kecamatan ' . $nama_kecamatan . '</h2>
			<div>' . $return . '</div>
		';
	}

	function user_authorization($id_desa = '', $page_type = 'desa')
	{
		// Check if user is logged in
		if (!is_user_logged_in()) {
			return array(
				'status'  => 'error',
				'message' => 'Anda belum login!'
			);
		} else {
			global $wpdb;
			$user_data = wp_get_current_user();
		}

		//jika user selain admin mencoba akses list usulan desa
		if (!empty($page_type) && $page_type != 'desa' && !in_array('administrator', $user_data->roles)) {
			return array(
				'status'  => 'error',
				'message' => 'You have no access to this page!'
			);
		}
		// Role-based authorization logic
		switch (true) {
			case in_array('administrator', $user_data->roles):
				// list page
				if (!empty($page_type) && $page_type != 'desa') {
					$jenis_page = [
						'WRSE',
						'Anak Terlantar',
						'Bunda Kasih',
						'Hibah',
						'Gepeng',
						'DTKS',
						'Disabilitas',
						'Lansia',
						'P3KE',
						'ODGJ'
						//add more if needed
					];
					if (!in_array($page_type, $jenis_page)) {
						return array(
							'status'  => 'error',
							'message' => 'Jenis page tidak diketahui.'
						);
					} else {
						return array(
							'status'  	 => 'success',
							'message' 	 => 'User administrator has access to the list page.',
							'jenis_page' => $page_type
						);
					}
				}

				$get_desa = $wpdb->get_row(
					$wpdb->prepare('
						SELECT *
						FROM data_alamat_siks
						WHERE id_desa = %d
						  AND active = 1
					', $id_desa),
					ARRAY_A
				);

				$get_kec = $wpdb->get_var(
					$wpdb->prepare('
						SELECT nama
						FROM data_alamat_siks
						WHERE id_kec = %d
						  AND id_desa IS NULL
						  AND active = 1
					', $get_desa['id_kec'])
				);

				return array(
					'status'  	=> 'success',
					'message' 	=> 'User administrator!',
					'desa' 		=> $get_desa['nama'],
					'kecamatan' => $get_kec,
					'roles' 	=> $user_data->roles[0]
				);

			case in_array('kecamatan', $user_data->roles):
				// Authorization for kecamatan roles
				$id_kecamatan = $user_data->user_login;

				$all_desa_by_kecamatan = $wpdb->get_col(
					$wpdb->prepare('
						SELECT LOWER(nama) 
						FROM data_alamat_siks 
						WHERE id_kec = %d 
						  AND id_desa IS NOT NULL 
						  AND active = 1
					', $id_kecamatan)
				);

				$get_desa = $wpdb->get_col(
					$wpdb->prepare('
						SELECT LOWER(nama)
						FROM data_alamat_siks
						WHERE id_desa = %d
						  AND active = 1
					', $id_desa)
				);

				if (!in_array($get_desa, $all_desa_by_kecamatan)) {
					return array(
						'status'  	=> 'error',
						'message' 	=> 'User kecamatan tidak valid! Desa tidak sesuai.'
					);
				} else {
					return array(
						'status'   	=> 'success',
						'message'  	=> 'User Valid!',
						'desa'     	=> $get_desa,
						'kecamatan' => $user_data->display_name,
						'roles' 	=> $user_data->roles[0]
					);
				}
				break;

			case in_array('desa', $user_data->roles):
				// Authorization for desa roles
				$id_kecamatan = substr($user_data->user_login, 0, 6);

				$get_desa = $wpdb->get_var(
					$wpdb->prepare('
						SELECT LOWER(nama) 
						FROM data_alamat_siks 
						WHERE id_kec = %d 
						  AND id_desa = %d 
						  AND active = 1
					', $id_kecamatan, $id_desa)
				);
				$get_kecamatan = $wpdb->get_var(
					$wpdb->prepare('
						SELECT nama 
						FROM data_alamat_siks 
						WHERE id_kec = %d 
						  AND id_desa IS NULL 
						  AND active = 1
					', $id_kecamatan)
				);

				if (empty($get_desa)) {
					return array(
						'status'  => 'error',
						'message' => 'User desa tidak valid! Kecamatan atau desa tidak sesuai.'
					);
				} else {
					return array(
						'status'   => 'success',
						'message'  => 'User Valid!',
						'desa'     	=> $get_desa,
						'kecamatan' => $get_kecamatan,
						'roles' 	=> $user_data->roles[0]
					);
				}
				break;

			default:
				return array(
					'status'  => 'error',
					'message' => 'Role user tidak valid!'
				);
		}

		return $ret;
	}


	function edit_data_desa_kel()
	{
		global $wpdb;

		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil update data!',
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				if ($ret['status'] != 'error') {
					$postData = $_POST;

					$validationRules = [
						'idDesa' => 'required',
						'newName' => 'required|string',
						'desaKelStatus' => 'required|in:0,1|numeric'
					];

					// Validate data
					$errors = $this->validate($postData, $validationRules);

					if (!empty($errors)) {
						$ret['status'] = 'error';
						$ret['message'] = implode(" \n ", $errors);
						die(json_encode($ret));
					}

					$data = array(
						'nama'	 	=> $postData['newName'],
						'is_kel' 	=> $postData['desaKelStatus'],
						'update_at' => current_time('mysql')
					);

					$cek_id = $wpdb->get_var(
						$wpdb->prepare('
							SELECT 
								id
							FROM data_alamat_siks
							WHERE id_desa = %d
							  AND active = 1
						', $postData['idDesa'])
					);

					if (empty($cek_id)) {
						$ret['status'] = 'error';
						$ret['message'] = 'Gagal, data tidak ditemukan!.';
						die(json_encode($ret));
					}

					$result = $wpdb->update(
						'data_alamat_siks',
						$data,
						array(
							'id' => $cek_id
						)
					);
					if ($result === false) {
						$ret['status'] = 'error';
						$ret['message'] = 'Update data gagal! Silakan coba lagi.';
						die(json_encode($ret));
					}
				}
			} else {
				$ret['status']  = 'error';
				$ret['message'] = 'Api key tidak ditemukan!';
			}
		} else {
			$ret['status']  = 'error';
			$ret['message'] = 'Format Salah!';
		}

		die(json_encode($ret));
	}

	function get_table_list_usulan()
	{
		global $wpdb;
		$res = array(
			'status' => 'success',
			'message' => 'Berhasil get table!',
			'data' => array()
		);

		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
				$postData = $_POST;
				// Define validation rules
				$validationRules = [
					'jenis_data' => 'required'
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				$shortcode_slug = strtolower(str_replace(' ', '_', $postData['jenis_data']));

				// Get kecamatan data
				$data_kecamatan = $wpdb->get_results(
					$wpdb->prepare('
						SELECT *		
						FROM data_alamat_siks
						WHERE id_desa IS NULL
						  AND active = %d
                ', 1),
					ARRAY_A
				);

				$jenis_data = strtolower($postData['jenis_data']);
				switch ($jenis_data) {
					case 'wrse':
						$table = 'data_usulan_wrse_siks';
						break;
					case 'dtks':
						$table = 'data_usulan_dtks_siks';
						break;
					case 'bunda kasih':
						$table = 'data_usulan_bunda_kasih_siks';
						break;
					case 'anak terlantar':
						$table = 'data_usulan_anak_terlantar_siks';
						break;
					case 'gepeng':
						$table = 'data_usulan_gepeng_siks';
						break;
					case 'hibah':
						$table = 'data_usulan_hibah_siks';
						break;
					case 'p3ke':
						$table = 'data_usulan_p3ke_siks';
						break;
					case 'disabilitas':
						$table = 'data_usulan_disabilitas_siks';
						break;
					case 'lansia':
						$table = 'data_usulan_lansia_siks';
						break;
					case 'odgj':
						$table = 'data_usulan_odgj_siks';
						break;
					default:
						$ret['status'] = 'error';
						$ret['message'] = 'Jenis data tidak diketahui!';
						die(json_encode($ret));
				}

				$tbody = '';
				$counterKec = 0;
				if (!empty($data_kecamatan)) {
					foreach ($data_kecamatan as $kecamatan) {
						$counterKec++;
						$tbody .= "<tr>";
						$tbody .= "<td class='text-center font-weight-bold bg-light'>" . $counterKec . "</td>";
						$tbody .= "<td colspan='6' class='font-weight-bold text-uppercase bg-light text-left'>" . $kecamatan['nama'] . "</td>";
						$tbody .= "</tr>";

						$data_desa = $wpdb->get_results(
							$wpdb->prepare('
								SELECT *			
								FROM data_alamat_siks
								WHERE id_kec = %d
								  AND id_desa IS NOT NULL
								  AND active = 1
                        ', $kecamatan['id_kec']),
							ARRAY_A
						);

						$counterDesa = 0;
						if (!empty($data_desa)) {
							foreach ($data_desa as $desa) {
								$gen_page = $this->functions->generatePage(array(
									'nama_page' => 'Usulan ' . $postData['jenis_data'] . ' | ' . $desa['nama'],
									'content' => '[usulan_' . $shortcode_slug . ' id_desa=' . $desa['id_desa'] . ']',
									'show_header' => 1,
									'no_key' => 1,
									'post_status' => 'publish'
								));

								$count_menunggu_verif = $wpdb->get_var(
									$wpdb->prepare('
										SELECT COUNT(*)			
										FROM ' . $table . '
										WHERE id_desa_kel = %d
										  AND status_data = 1
										  AND active = 1
									', $desa['id_desa'])
								);

								$count_setuju = $wpdb->get_var(
									$wpdb->prepare('
										SELECT COUNT(*)			
										FROM ' . $table . '
										WHERE id_desa_kel = %d
										  AND status_data = 2
										  AND active = 1
									', $desa['id_desa'])
								);

								$count_tolak = $wpdb->get_var(
									$wpdb->prepare('
										SELECT COUNT(*)			
										FROM ' . $table . '
										WHERE id_desa_kel = %d
										  AND status_data = 3
										  AND active = 1
									', $desa['id_desa'])
								);

								$total_count = $count_tolak + $count_setuju + $count_menunggu_verif;

								$counterDesa++;
								$tbody .= "<tr>";
								$tbody .= "<td></td>";
								$tbody .= "<td class='text-center'>" . $counterDesa . "</td>";
								$tbody .= "<td class='text-capitalize text-left'>" . $desa['nama'] . "</td>";
								$tbody .= "<td class='text-center'>" . $count_menunggu_verif . "</td>"; // menunggu persetujuan count
								$tbody .= "<td class='text-center'>" . $count_setuju . "</td>"; // disetujui count
								$tbody .= "<td class='text-center'>" . $count_tolak . "</td>"; // ditolak count
								$tbody .= "<td class='text-center'>" . $total_count . "</td>"; // total count

								// Action buttons for each desa
								$btn = '<div class="d-flex justify-content-center">';
								$btn .= "<button class='btn btn-primary' onclick='toDetailUrl(\"" . $gen_page['url'] . "\");' title='ke halaman verifikasi per desa'><span class='dashicons dashicons-arrow-right-alt'></span></button>";
								$btn .= '</div>';

								$tbody .= "<td>" . $btn . "</td>";
								$tbody .= "</tr>";
							}
						} else {
							$tbody .= "<tr><td colspan='6' class='text-center'>Tidak ada data desa tersedia di kecamatan ini.</td></tr>";
						}
					}

					$res['data'] = $tbody;
				} else {
					$res['data'] = "<tr><td colspan='6' class='text-center'>Tidak ada data tersedia.</td></tr>";
				}
			} else {
				$res = array(
					'status' => 'error',
					'message'   => 'Api Key tidak sesuai!'
				);
			}
		} else {
			$res = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}

		die(json_encode($res));
	}

	function validate($data, $rules)
	{
		$errors = [];

		foreach ($rules as $field => $ruleSet) {
			$rulesArray = explode('|', $ruleSet);

			foreach ($rulesArray as $rule) {
				if ($rule == 'required' && (!isset($data[$field]))) {
					$errors[] = "$field is required";
				}

				if ($rule == 'string' && isset($data[$field]) && !is_string($data[$field])) {
					$errors[] = "$field must be a string";
				}

				if ($rule == 'numeric' && isset($data[$field]) && !is_numeric($data[$field])) {
					$errors[] = "$field must be numeric";
				}

				if (strpos($rule, 'min:') === 0) {
					$min = (int)explode(':', $rule)[1];
					if (isset($data[$field]) && strlen($data[$field]) < $min) {
						$errors[] = "$field must be at least $min characters";
					}
				}

				if (strpos($rule, 'max:') === 0) {
					$max = (int)explode(':', $rule)[1];
					if (isset($data[$field]) && strlen($data[$field]) > $max) {
						$errors[] = "$field cannot exceed $max characters";
					}
				}

				if (strpos($rule, 'in:') === 0) {
					$allowed = explode(',', explode(':', $rule)[1]);
					if (isset($data[$field]) && !in_array($data[$field], $allowed)) {
						$errors[] = "$field must be one of: " . implode(', ', $allowed);
					}
				}
			}
		}

		return $errors;
	}

	function submit_verifikasi_usulan()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil verifikasi data!',
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('administrator', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'idDataVerifikasi' 		=> 'required',
					'verifikasiStatus' 		=> 'required',
					'keteranganVerifikasi' 	=> 'required',
					'jenis_data' 			=> 'required'
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				$data = [
					'status_data' 			=> $postData['verifikasiStatus'],
					'keterangan_verifikasi' => $postData['keteranganVerifikasi'],
					'update_at' 			=> current_time('mysql')
				];

				switch ($postData['jenis_data']) {
					case 'wrse':
						$table = 'data_usulan_wrse_siks';
						break;
					case 'dtks':
						$table = 'data_usulan_dtks_siks';
						break;
					case 'bunda kasih':
						$table = 'data_usulan_bunda_kasih_siks';
						break;
					case 'anak terlantar':
						$table = 'data_usulan_anak_terlantar_siks';
						break;
					case 'gepeng':
						$table = 'data_usulan_gepeng_siks';
						break;
					case 'hibah':
						$table = 'data_usulan_hibah_siks';
						break;
					case 'p3ke':
						$table = 'data_usulan_p3ke_siks';
						break;
					case 'disabilitas':
						$table = 'data_usulan_disabilitas_siks';
						break;
					case 'lansia':
						$table = 'data_usulan_lansia_siks';
						break;
					case 'odgj':
						$table = 'data_usulan_odgj_siks';
						break;
					default:
						$ret['status'] = 'error';
						$ret['message'] = 'Jenis data tidak diketahui!';
						die(json_encode($ret));
				}

				$cek_id = $wpdb->get_var(
					$wpdb->prepare('
						SELECT 
							id
						FROM ' . $table . '
						WHERE id = %d
						  AND active = 1
					', $postData['idDataVerifikasi'])
				);
				if (empty($cek_id)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Gagal, data tidak ditemukan!.';
					die(json_encode($ret));
				}

				$result = $wpdb->update(
					$table,
					$data,
					array(
						'id' => $cek_id
					)
				);
				if ($result === false) {
					$ret['status'] = 'error';
					$ret['message'] = 'Update data gagal! Silakan coba lagi.';
					die(json_encode($ret));
				}
			} else {
				$ret = array(
					'status' => 'error',
					'message'   => 'Api Key tidak sesuai!'
				);
			}
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function submit_usulan()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil submit data!',
			'data' => '',
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('desa', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}

				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'idDataVerifikasi' 		=> 'required',
					'jenis_data' 			=> 'required'
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				$data = [
					'status_data' 	=> 1,
				];

				switch ($postData['jenis_data']) {
					case 'wrse':
						$table = 'data_usulan_wrse_siks';
						break;
					case 'dtks':
						$table = 'data_usulan_dtks_siks';
						break;
					case 'bunda kasih':
						$table = 'data_usulan_bunda_kasih_siks';
						break;
					case 'anak terlantar':
						$table = 'data_usulan_anak_terlantar_siks';
						break;
					case 'gepeng':
						$table = 'data_usulan_gepeng_siks';
						break;
					case 'hibah':
						$table = 'data_usulan_hibah_siks';
						break;
					case 'p3ke':
						$table = 'data_usulan_p3ke_siks';
						break;
					case 'disabilitas':
						$table = 'data_usulan_disabilitas_siks';
						break;
					case 'lansia':
						$table = 'data_usulan_lansia_siks';
						break;
					case 'odgj':
						$table = 'data_usulan_odgj_siks';
						break;
					default:
						$ret['status'] = 'error';
						$ret['message'] = 'Jenis data tidak diketahui!';
						die(json_encode($ret));
				}

				$cek_id = $wpdb->get_var(
					$wpdb->prepare('
						SELECT 
							id
						FROM ' . $table . '
						WHERE id = %d
						  AND active = 1
					', $postData['idDataVerifikasi'])
				);
				if (empty($cek_id)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Gagal, data tidak ditemukan!.';
					die(json_encode($ret));
				}

				$result = $wpdb->update(
					$table,
					$data,
					array(
						'id' => $cek_id
					)
				);
				$ret['data'] = $wpdb->last_query;
				if ($result === false) {
					$ret['status'] = 'error';
					$ret['message'] = 'Update data gagal! Silakan coba lagi.';
					die(json_encode($ret));
				}
			} else {
				$ret = array(
					'status' => 'error',
					'message'   => 'Api Key tidak sesuai!'
				);
			}
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function get_status_verifikasi_usulan()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data verifikasi!',
			'data' => array()
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

				$user_data = wp_get_current_user();
				if (!in_array('administrator', $user_data->roles)) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aksi ditolak, hanya user tertentu yang dapat mengakses fitur ini!';
					die(json_encode($ret));
				}
				$postData = $_POST;

				// Define validation rules
				$validationRules = [
					'id' => 'required',
					'jenis_data' => 'required'
				];

				// Validate data
				$errors = $this->validate($postData, $validationRules);

				if (!empty($errors)) {
					$ret['status'] = 'error';
					$ret['message'] = implode(" \n ", $errors);
					die(json_encode($ret));
				}

				switch ($postData['jenis_data']) {
					case 'wrse':
						$table = 'data_usulan_wrse_siks';
						break;
					case 'dtks':
						$table = 'data_usulan_dtks_siks';
						break;
					case 'bunda kasih':
						$table = 'data_usulan_bunda_kasih_siks';
						break;
					case 'anak terlantar':
						$table = 'data_usulan_anak_terlantar_siks';
						break;
					case 'gepeng':
						$table = 'data_usulan_gepeng_siks';
						break;
					case 'hibah':
						$table = 'data_usulan_hibah_siks';
						break;
					case 'p3ke':
						$table = 'data_usulan_p3ke_siks';
						break;
					case 'disabilitas':
						$table = 'data_usulan_disabilitas_siks';
						break;
					case 'lansia':
						$table = 'data_usulan_lansia_siks';
						break;
					case 'odgj':
						$table = 'data_usulan_odgj_siks';
						break;
					default:
						$ret['status'] = 'error';
						$ret['message'] = 'Jenis data tidak diketahui!';
						die(json_encode($ret));
				}

				$ret['data'] = $wpdb->get_row(
					$wpdb->prepare('
						SELECT
							*
						FROM ' . $table . '
						WHERE id = %d
						  AND active = 1
					', $postData['id'])
				);

				if (empty($ret['data'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data tidak ditemukan!';
					die(json_encode($ret));
				}
			} else {
				$ret = array(
					'status' => 'error',
					'message'   => 'Api Key tidak sesuai!'
				);
			}
		} else {
			$ret = array(
				'status' => 'error',
				'message'   => 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	function formatTanggal($datetime)
	{
		$hariInggris = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
		$hariIndonesia = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');

		$bulanInggris = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$bulanIndonesia = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

		$timestamp = strtotime($datetime);

		$hari = str_replace($hariInggris, $hariIndonesia, date('l', $timestamp));

		$bulan = str_replace($bulanInggris, $bulanIndonesia, date('F', $timestamp));

		$tanggal = date('d', $timestamp) . ' ' . $bulan . ' ' . date('Y', $timestamp);
		$jam = date('H:i:s', $timestamp);

		return "$hari, $tanggal ($jam)";
	}
}
