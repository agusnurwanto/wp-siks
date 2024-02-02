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
			'url' => admin_url('admin-ajax.php')
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

	public function disabilitas_per_desa()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-disabilitas-per-desa.php';
	}

	public function bunda_kasih_per_desa()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-bunda-kasih-per-desa.php';
	}

	public function gepeng_per_desa()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-gepeng-per-desa.php';
	}

	public function dtks_per_desa()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-dtks-per-desa.php';
	}

	public function anak_terlantar_per_desa()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-anak-terlantar-per-desa.php';
	}

	public function p3ke_per_desa()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-p3ke-per-desa.php';
	}

	public function lansia_per_desa()
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

	public function data_calon_p3ke()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-calon-penerima-p3ke.php';
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
		foreach ($data as $val) {
			$coordinate = json_decode($val['polygon'], true);
			if (!empty($coordinate)) {
				unset($val['polygon']);
				$new_data[] = array(
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
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT 
				provinsi,
				MAX(update_at) as last_update,
				kabkot, 
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
			GROUP BY provinsi, kabkot, kecamatan, desa_kelurahan, BLT, BLT_BBM, BPNT, PKH, PBI
			ORDER BY provinsi, kabkot, kecamatan, desa_kelurahan
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
				if ($ret['status'] != 'error' && empty($_POST['dokumen_kewarganegaraan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Dokumen Kewarganegaraan tidak boleh kosong!';
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
				if ($ret['status'] != 'error' && empty($_POST['pendidikan_terakhir'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pendidikan Terakhir tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nama_sekolah'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama Sekolah tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keterangan_lulus'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Keterangan Lulus tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['jenis_disabilitas'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Jenis Disabilitas tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keterangan_disabilitas'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Keterangan Disabilitas tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['sebab_disabilitas'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Sebab Disabilitas tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['diagnosa_medis'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Diagnosa Medis tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['penyakit_lain'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Penyakit Lain tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tempat_pengobatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tempat Pengobatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['perawat'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Perawat tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['aktivitas'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aktivitas tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['aktivitas_bantuan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Aktivitas Bantuan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['perlu_bantu'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Perlu Bantu tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['alat_bantu'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alat Bantu tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['alat_yang_dimiliki'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alat Yang Dimiliki tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kondisi_alat'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kondisi Alat tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['jaminan_kesehatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Jaminan Kesehatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['cara_menggunakan_jamkes'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Cara Menggunakan Jamkes tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['jaminan_sosial'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Jaminan Sosial tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['pekerjaan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pekerjaan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['lokasi_bekerja'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Lokasi Bekerja tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['alasan_tidak_bekerja'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alasan Tidak Bekerja tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['pendapatan_bulan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pendapatan Bulan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['pengeluaran_bulan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pengeluaran Bulan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['pendapatan_lain'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pendapatan Lain tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['minat_kerja'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Minat Kerja tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keterampilan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Keterampilan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['pelatihan_yang_diikuti'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pelatihan Yang Diikuti tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['pelatihan_yang_diminat'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pelatihan Yang Diminat tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['status_rumah'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Status Rumah tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['lantai'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Lantai tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kamar_mandi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kamar Mandi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['wc'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'WC tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['akses_ke_lingkungan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['dinding'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Dinding tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['sarana_air'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Sarana Air tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['penerangan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Penerangan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['desa_paud'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Desa Paud tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tk_di_desa'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'TK Di Desa tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kecamatan_slb'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kecamatan SLB tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['sd_menerima_abk'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'SD Menerima Abk tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['smp_menerima_abk'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'SMP Menerima Abk tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['jumlah_posyandu'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Jumlah Posyandu tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kader_posyandu'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kader Posyandu tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['layanan_kesehatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Layanan Kesehatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['sosialitas_ke_tetangga'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Sosialitas Ke Tetangga tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keterlibatan_berorganisasi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Keterlibatan Berorganisasi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kegiatan_kemasyarakatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kegiatan Kemasyarakatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keterlibatan_musrembang'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Keterlibatan Musrembang tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['alat_bantu_bantuan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alat Bantu Bantuan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['asal_alat_bantu'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Asal Alat Bantu tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun_pemberian'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tahun Pemberian tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['bantuan_uep'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Bantuan UEP tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['asal_uep'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Asal UEP tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tahun tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['lainnya'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Lainnya tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rehabilitas'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Rehabilitas tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['lokasi_rehabilitas'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Lokasi Rehabilitas tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['tahun_rehabilitas'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Tahun Rehabilitas tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keahlian_khusus'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Keahlian Khusus tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['prestasi'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Prestasi tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nama_perawat_wali'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama Perawat Wali tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['hubungan_dengan_pd'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Hubungan Dengan PD tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nomor_hp'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nomor HP tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['kelayakan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Kelayakan tidak boleh kosong!';
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

			if (!empty($params['desa'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $params['desa']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
				$where .= " AND (kecamatan LIKE " . $search_value;
				$where .= " OR nama LIKE " . $search_value;
				$where .= " OR nik LIKE " . $search_value;
				$where .= " OR alamat LIKE " . $search_value . ")";
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
				if ($ret['status'] != 'error' && empty($_POST['dokumen_kependudukan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Dokumen Kependudukan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['status_tempat_tinggal'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Status Tempat Tinggal tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['status_pemenuhan_kebutuhan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Status Pemenuhan Kebutuhan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['status_kehidupan_rumah_tangga'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Status Pemenuhan Kebutuhan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['status_dtks'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Status DTKS tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['status_kepersertaan_program_bansos'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Status Kepersertaan Program Bansos tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rekomendasi_pendata_lama'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Rekomendasi Pendeta Lama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keterangan_lainnya_lama'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Keterangan Lainnya Lama tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['rekomendasi_pendata'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Rekomendasi Pendeta tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keterangan_lainnya'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Data Keterangan Lainnya tidak boleh kosong!';
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

			if (!empty($params['desa'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $params['desa']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
				$where .= " AND (kecamatan LIKE " . $search_value;
				$where .= " OR nama LIKE " . $search_value;
				$where .= " OR nik LIKE " . $search_value;
				$where .= " OR alamat LIKE " . $search_value . ")";
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

			if (!empty($params['desa'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $params['desa']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
				$where .= " AND (kecamatan LIKE " . $search_value;
				$where .= " OR nama LIKE " . $search_value;
				$where .= " OR nik LIKE " . $search_value;
				$where .= " OR alamat LIKE " . $search_value . ")";
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
					$btn .= '<a style="margin-top: 5px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
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
				if ($ret['status'] != 'error' && empty($_POST['jenis_kelamin'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Jenis Kelamin tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['nama_ortu'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Nama Orang Tua tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['pengobatan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pengobatan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['usia'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Usia tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keterangan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Keterangan tidak boleh kosong!';
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

			if (!empty($params['desa'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $params['desa']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
				$where .= " AND (kecamatan LIKE " . $search_value;
				$where .= " OR nama LIKE " . $search_value;
				$where .= " OR nik LIKE " . $search_value;
				$where .= " OR alamat LIKE " . $search_value . ")";
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
		// print_r($data); die($wpdb->last_query);

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
			'message'	=> 'Berhasil get data lansia!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$params = $columns = $totalRecords = $data = array();
			$params = $_REQUEST;
			$columns = array(
				1 => 'id',
				2 => 'nama',
				3 => 'kabkot',
				4 => 'alamat',
				5 => 'ketua',
				6 => 'no_hp',
				7 => 'akreditasi',
				8 => 'anak_dalam_lksa',
				9 => 'anak_luar_lksa',
				10 => 'total_anak',
				11 => 'file_lampiran',
				12 => 'lat',
				13 => 'lng',
			);
			$where = $sqlTot = $sqlRec = "";

			// check search value exist
			if (!empty($params['search']['value'])) {
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
				$where .= " AND ( nama LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR kabkot LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
				$where .= " OR ketua LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%") . ")";
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
				if ($ret['status'] != 'error') {
					$id_data = sanitize_text_field($_POST['id']);
					$tahun_anggaran = sanitize_text_field($_POST['tahun_anggaran']);
					$nama = sanitize_text_field($_POST['nama']);
					$kabkot = sanitize_text_field($_POST['kabkot']);
					$alamat = sanitize_text_field($_POST['alamat']);
					$ketua = sanitize_text_field($_POST['ketua']);
					$no_hp = sanitize_text_field($_POST['no_hp']);
					$akreditasi = sanitize_text_field($_POST['akreditasi']);
					$dalam_lksa = sanitize_text_field($_POST['dalam_lksa']);
					$luar_lksa = sanitize_text_field($_POST['luar_lksa']);
					$total_anak = sanitize_text_field($_POST['total_anak']);

					$latitude = $_POST['lat'];
					$longitude = $_POST['lng'];
					$data = array(
						'lng' => $longitude,
						'lat' => $latitude,
						'tahun_anggaran' => $tahun_anggaran,
						'nama' => $nama,
						'kabkot' => $kabkot,
						'alamat' => $alamat,
						'ketua' => $ketua,
						'no_hp' => $no_hp,
						'akreditasi' => $akreditasi,
						'anak_dalam_lksa' => $dalam_lksa,
						'anak_luar_lksa' => $luar_lksa,
						'total_anak' => $total_anak,
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
							$wpdb->insert('data_lksa_siks', $data);
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
				15 => 'lat',
				16 => 'lng',
			);
			$where = $sqlTot = $sqlRec = "";

			if (!empty($params['desa'])) {
				$where .= $wpdb->prepare(' AND desa_kelurahan=%s', $params['desa']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
				$where .= " AND (kecamatan LIKE " . $search_value;
				$where .= " OR nama LIKE " . $search_value;
				$where .= " OR nik LIKE " . $search_value;
				$where .= " OR alamat LIKE " . $search_value . ")";
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
				if ($ret['status'] != 'error') {
					$id_data = sanitize_text_field($_POST['id']);
					$tahun_anggaran = sanitize_text_field($_POST['tahun_anggaran']);
					$nama = sanitize_text_field($_POST['nama']);
					$kk = sanitize_text_field($_POST['kk']);
					$nik = sanitize_text_field($_POST['nik']);
					$jenis_kelamin = sanitize_text_field($_POST['jenisKelamin']);
					$tanggal_lahir = sanitize_text_field($_POST['tanggal_Lahir']);
					$usia = sanitize_text_field($_POST['usia']);
					$pendidikan = sanitize_text_field($_POST['pendidikan']);
					$provinsi = sanitize_text_field($_POST['provinsi']);
					$kabkot = sanitize_text_field($_POST['kabkot']);
					$kecamatan = sanitize_text_field($_POST['kecamatan']);
					$desa_kelurahan = sanitize_text_field($_POST['desa_kelurahan']);
					$alamat = sanitize_text_field($_POST['alamat']);
					$status_lembaga = sanitize_text_field($_POST['kelembagaan']);

					$latitude = $_POST['lat'];
					$longitude = $_POST['lng'];
					$data = array(
						'lng' => $longitude,
						'lat' => $latitude,
						'tahun_anggaran' => $tahun_anggaran,
						'nama' => $nama,
						'kk' => $kk,
						'nik' => $nik,
						'jenis_kelamin' => $jenis_kelamin,
						'tanggal_lahir' => $tanggal_lahir,
						'usia' => $usia,
						'pendidikan' => $pendidikan,
						'provinsi' => $provinsi,
						'kabkot' => $kabkot,
						'kecamatan' => $kecamatan,
						'desa_kelurahan' => $desa_kelurahan,
						'alamat' => $alamat,
						'kelembagaan' => $status_lembaga,
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
				if ($ret['status'] != 'error' && empty($_POST['pekerjaan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Pekerjaan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['alamat'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Alamat tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['program'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Program tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['penghasilan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Penghasilan tidak boleh kosong!';
				}
				if ($ret['status'] != 'error' && empty($_POST['keterangan'])) {
					$ret['status'] = 'error';
					$ret['message'] = 'Keterangan tidak boleh kosong!';
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

			if (!empty($params['desa'])) {
				$where .= $wpdb->prepare(' AND desa=%s', $params['desa']);
			}
			// check search value exist
			if (!empty($params['search']['value'])) {
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
				$where .= " AND (kecamatan LIKE " . $search_value;
				$where .= " OR nama LIKE " . $search_value;
				$where .= " OR nik LIKE " . $search_value;
				$where .= " OR alamat LIKE " . $search_value . ")";
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
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");

				$where .= " AND (
					data_calon_p3ke_siks.kecamatan LIKE " . $search_value . " OR
					data_calon_p3ke_siks.alamat LIKE " . $search_value . " OR
					data_calon_p3ke_siks.nama_kk LIKE " . $search_value . " OR
					data_calon_p3ke_siks.nama_pkk LIKE " . $search_value . " OR
					data_calon_p3ke_siks.nama_anak LIKE " . $search_value . " OR
					data_calon_p3ke_siks.nik_anak LIKE " . $search_value . " OR
					data_calon_p3ke_siks.desa_kelurahan LIKE " . $search_value . " OR
					data_calon_p3ke_siks.kecamatan LIKE " . $search_value . " OR
					data_calon_p3ke_siks.kabkot LIKE " . $search_value . " OR
					data_calon_p3ke_siks.district LIKE " . $search_value . " OR
					data_calon_p3ke_siks.sumber LIKE " . $search_value . " OR
					data_calon_p3ke_siks.desil_p3ke LIKE " . $search_value . " OR
					data_calon_p3ke_siks.tahun_anggaran LIKE " . $search_value . "
				)";
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

			$limit = '';
			if ($params['length'] != -1) {
				$limit = "  LIMIT " . $wpdb->prepare('%d', $params['start']) . " ," . $wpdb->prepare('%d', $params['length']);
			}
			$sqlRec .= " ORDER BY data_calon_p3ke_siks.update_at DESC" . $limit;

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
				$queryRecords[$recKey]['status_p3ke'] = '-';
				if(!empty($recVal['nik_p3ke'])){
					$queryRecords[$recKey]['status_p3ke'] = 'Terdaftar';
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


	public function tambah_data_calon_p3ke()
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

	function cek_nik_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-cek-nik.php';
	}

	function cari_nik_siks(){
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil get data!',
			'data' => array()
		);
		if(strlen($_POST['nik']) >=3){
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {
				$data_p3ke = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_p3ke_siks
					WHERE nik like %s
				", '%'.$_POST['nik'].'%'));
				$data_anak_terlantar = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_anak_terlantar_siks
					WHERE nik like %s
				", '%' .$_POST['nik'].'%'));
				$data_bunda_kasih = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_bunda_kasih_siks
					WHERE nik like %s
				", '%' .$_POST['nik'].'%'));
				$data_disabilitas = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_disabilitas_siks
					WHERE nik like %s
				", '%' .$_POST['nik'].'%'));
				$data_lansia = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_lansia_siks
					WHERE nik like %s
				", '%' .$_POST['nik'].'%'));
				$data_odgj = $wpdb->get_results($wpdb->prepare("
					SELECT
						*
					FROM data_odgj_siks
					WHERE nik like %s
				", '%' .$_POST['nik'].'%'));

				$ret['data']['p3ke'] = $data_p3ke;
				$ret['data']['anak_terlantar'] = $data_anak_terlantar;
				$ret['data']['bunda_kasih'] = $data_bunda_kasih;
				$ret['data']['disabilitas'] = $data_disabilitas;
				$ret['data']['lansia'] = $data_lansia;
				$ret['data']['odgj'] = $data_odgj;
			}else{
				$ret['status']	= 'error';
				$ret['message']	= 'Api key tidak ditemukan!';
			}
		}else{
			$ret['status']	= 'error';
			$ret['message']	= 'Format Salah!';
		}

		die(json_encode($ret));
	}
	
}
