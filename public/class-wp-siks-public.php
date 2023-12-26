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
class Wp_Siks_Public
{

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

	public function management_data_lansia()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-lansia.php';
	}

	public function management_data_disabilitas()
	{
		// untuk disable render shortcode di halaman edit page/post
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-manajemen-disabilitas.php';
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

	public function data_disabilitas_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-disabilitas.php';
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

	function get_siks_map_url(){
		$api_googlemap = get_option( '_crb_google_api_siks' );
		$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMapSiks&libraries=places&libraries=drawing";
		return $api_googlemap;
	}

	public function crb_get_gmaps_api_key_siks($value = '')
	{
		return get_option('_crb_google_api_siks');
	}

	public function get_data_disabilitas_by_id(){
        global $wpdb;
        $ret = array(
            'status' => 'success',
            'message' => 'Berhasil get data!',
            'data' => array()
        );
        if(!empty($_POST)){
            if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
                $ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_disabilitas_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
            }else{
                $ret['status']  = 'error';
                $ret['message'] = 'Api key tidak ditemukan!';
            }
        }else{
            $ret['status']  = 'error';
            $ret['message'] = 'Format Salah!';
        }

        die(json_encode($ret));
    }

public function hapus_data_disabilitas_by_id(){
	global $wpdb;
	$ret = array(
		'status' => 'success',
		'message' => 'Berhasil hapus data!',
		'data' => array()
	);
	if(!empty($_POST)){
		if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$ret['data'] = $wpdb->update('data_disabilitas_siks', array('active' => 0), array(
				'id' => $_POST['id']
			));
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

    public function tambah_data_disabilitas(){
        global $wpdb;
        $ret = array(
            'status' => 'success',
            'message' => 'Berhasil simpan data!',
            'data' => array()
        );
        if(!empty($_POST)){
            if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {                
            	if($ret['status'] != 'error' && !empty($_POST['nama'])){
                    $nama = $_POST['nama'];
                }
                if($ret['status'] != 'error' && !empty($_POST['gender'])){
                    $gender = $_POST['gender'];
                }
                if($ret['status'] != 'error' && !empty($_POST['tempat_lahir'])){
                    $tempat_lahir = $_POST['tempat_lahir'];
                }
                if($ret['status'] != 'error' && !empty($_POST['tanggal_lahir'])){
                    $tanggal_lahir = $_POST['tanggal_lahir'];
                }
                if($ret['status'] != 'error' && !empty($_POST['status'])){
                    $status = $_POST['status'];
                }
                if($ret['status'] != 'error' && !empty($_POST['dokumen_kewarganegaraan'])){
                    $dokumen_kewarganegaraan = $_POST['dokumen_kewarganegaraan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['nik'])){
                    $nik = $_POST['nik'];
                }
                if($ret['status'] != 'error' && !empty($_POST['nomor_kk'])){
                    $nomor_kk = $_POST['nomor_kk'];
                }
                if($ret['status'] != 'error' && !empty($_POST['rt'])){
                    $rt = $_POST['rt'];
                }
                if($ret['status'] != 'error' && !empty($_POST['rw'])){
                    $rw = $_POST['rw'];
                }
                if($ret['status'] != 'error' && !empty($_POST['desa'])){
                    $desa = $_POST['desa'];
                }
                if($ret['status'] != 'error' && !empty($_POST['kecamatan'])){
                    $kecamatan = $_POST['kecamatan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['no_hp'])){
                    $no_hp = $_POST['no_hp'];
                }
                if($ret['status'] != 'error' && !empty($_POST['pendidikan_terakhir'])){
                    $pendidikan_terakhir = $_POST['pendidikan_terakhir'];
                }
                if($ret['status'] != 'error' && !empty($_POST['nama_sekolah'])){
                    $nama_sekolah = $_POST['nama_sekolah'];
                }
                if($ret['status'] != 'error' && !empty($_POST['keterangan_lulus'])){
                    $keterangan_lulus = $_POST['keterangan_lulus'];
                }
                if($ret['status'] != 'error' && !empty($_POST['jenis_disabilitas'])){
                    $jenis_disabilitas = $_POST['jenis_disabilitas'];
                }
                if($ret['status'] != 'error' && !empty($_POST['keterangan_disabilitas'])){
                    $keterangan_disabilitas = $_POST['keterangan_disabilitas'];
                }
                if($ret['status'] != 'error' && !empty($_POST['sebab_disabilitas'])){
                    $sebab_disabilitas = $_POST['sebab_disabilitas'];
                }
                if($ret['status'] != 'error' && !empty($_POST['diagnosa_medis'])){
                    $diagnosa_medis = $_POST['diagnosa_medis'];
                }
                if($ret['status'] != 'error' && !empty($_POST['penyakit_lain'])){
                    $penyakit_lain = $_POST['penyakit_lain'];
                }
                if($ret['status'] != 'error' && !empty($_POST['tempat_pengobatan'])){
                    $tempat_pengobatan = $_POST['tempat_pengobatan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['perawat'])){
                    $perawat = $_POST['perawat'];
                }
                if($ret['status'] != 'error' && !empty($_POST['aktivitas'])){
                    $aktivitas = $_POST['aktivitas'];
                }
                if($ret['status'] != 'error' && !empty($_POST['aktivitas_bantuan'])){
                    $aktivitas_bantuan = $_POST['aktivitas_bantuan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['perlu_bantu'])){
                    $perlu_bantu = $_POST['perlu_bantu'];
                }
                if($ret['status'] != 'error' && !empty($_POST['alat_bantu'])){
                    $alat_bantu = $_POST['alat_bantu'];
                }
                if($ret['status'] != 'error' && !empty($_POST['alat_yang_dimiliki'])){
                    $alat_yang_dimiliki = $_POST['alat_yang_dimiliki'];
                }
                if($ret['status'] != 'error' && !empty($_POST['kondisi_alat'])){
                    $kondisi_alat = $_POST['kondisi_alat'];
                }
                if($ret['status'] != 'error' && !empty($_POST['jaminan_kesehatan'])){
                    $jaminan_kesehatan = $_POST['jaminan_kesehatan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['cara_menggunakan_jamkes'])){
                    $cara_menggunakan_jamkes = $_POST['cara_menggunakan_jamkes'];
                }
                if($ret['status'] != 'error' && !empty($_POST['jaminan_sosial'])){
                    $jaminan_sosial = $_POST['jaminan_sosial'];
                }
                if($ret['status'] != 'error' && !empty($_POST['pekerjaan'])){
                    $pekerjaan = $_POST['pekerjaan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['lokasi_bekerja'])){
                    $lokasi_bekerja = $_POST['lokasi_bekerja'];
                }
                if($ret['status'] != 'error' && !empty($_POST['alasan_tidak_bekerja'])){
                    $alasan_tidak_bekerja = $_POST['alasan_tidak_bekerja'];
                }
                if($ret['status'] != 'error' && !empty($_POST['pendapatan_bulan'])){
                    $pendapatan_bulan = $_POST['pendapatan_bulan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['pengeluaran_bulan'])){
                    $pengeluaran_bulan = $_POST['pengeluaran_bulan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['pendapatan_lain'])){
                    $pendapatan_lain = $_POST['pendapatan_lain'];
                }
                if($ret['status'] != 'error' && !empty($_POST['minat_kerja'])){
                    $minat_kerja = $_POST['minat_kerja'];
                }
                if($ret['status'] != 'error' && !empty($_POST['keterampilan'])){
                    $keterampilan = $_POST['keterampilan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['pelatihan_yang_diikuti'])){
                    $pelatihan_yang_diikuti = $_POST['pelatihan_yang_diikuti'];
                }
                if($ret['status'] != 'error' && !empty($_POST['pelatihan_yang_diminat'])){
                    $pelatihan_yang_diminat = $_POST['pelatihan_yang_diminat'];
                }
                if($ret['status'] != 'error' && !empty($_POST['status_rumah'])){
                    $status_rumah = $_POST['status_rumah'];
                }
                if($ret['status'] != 'error' && !empty($_POST['lantai'])){
                    $lantai = $_POST['lantai'];
                }
                if($ret['status'] != 'error' && !empty($_POST['kamar_mandi'])){
                    $kamar_mandi = $_POST['kamar_mandi'];
                }
                if($ret['status'] != 'error' && !empty($_POST['wc'])){
                    $wc = $_POST['wc'];
                }
                if($ret['status'] != 'error' && !empty($_POST['akses_ke_lingkungan'])){
                    $akses_ke_lingkungan = $_POST['akses_ke_lingkungan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['dinding'])){
                    $dinding = $_POST['dinding'];
                }
                if($ret['status'] != 'error' && !empty($_POST['sarana_air'])){
                    $sarana_air = $_POST['sarana_air'];
                }
                if($ret['status'] != 'error' && !empty($_POST['penerangan'])){
                    $penerangan = $_POST['penerangan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['desa_paud'])){
                    $desa_paud = $_POST['desa_paud'];
                }
                if($ret['status'] != 'error' && !empty($_POST['tk_di_desa'])){
                    $tk_di_desa = $_POST['tk_di_desa'];
                }
                if($ret['status'] != 'error' && !empty($_POST['kecamatan_slb'])){
                    $kecamatan_slb = $_POST['kecamatan_slb'];
                }
                if($ret['status'] != 'error' && !empty($_POST['sd_menerima_abk'])){
                    $sd_menerima_abk = $_POST['sd_menerima_abk'];
                }
                if($ret['status'] != 'error' && !empty($_POST['smp_menerima_abk'])){
                    $smp_menerima_abk = $_POST['smp_menerima_abk'];
                }
                if($ret['status'] != 'error' && !empty($_POST['jumlah_posyandu'])){
                    $jumlah_posyandu = $_POST['jumlah_posyandu'];
                }
                if($ret['status'] != 'error' && !empty($_POST['kader_posyandu'])){
                    $kader_posyandu = $_POST['kader_posyandu'];
                }
                if($ret['status'] != 'error' && !empty($_POST['layanan_kesehatan'])){
                    $layanan_kesehatan = $_POST['layanan_kesehatan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['sosialitas_ke_tetangga'])){
                    $sosialitas_ke_tetangga = $_POST['sosialitas_ke_tetangga'];
                }
                if($ret['status'] != 'error' && !empty($_POST['keterlibatan_berorganisasi'])){
                    $keterlibatan_berorganisasi = $_POST['keterlibatan_berorganisasi'];
                }
                if($ret['status'] != 'error' && !empty($_POST['kegiatan_kemasyarakatan'])){
                    $kegiatan_kemasyarakatan = $_POST['kegiatan_kemasyarakatan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['keterlibatan_musrembang'])){
                    $keterlibatan_musrembang = $_POST['keterlibatan_musrembang'];
                }
                if($ret['status'] != 'error' && !empty($_POST['alat_bantu_bantuan'])){
                    $alat_bantu_bantuan = $_POST['alat_bantu_bantuan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['asal_alat_bantu'])){
                    $asal_alat_bantu = $_POST['asal_alat_bantu'];
                }
                if($ret['status'] != 'error' && !empty($_POST['tahun_pemberian'])){
                    $tahun_pemberian = $_POST['tahun_pemberian'];
                }
                if($ret['status'] != 'error' && !empty($_POST['bantuan_uep'])){
                    $bantuan_uep = $_POST['bantuan_uep'];
                }
                if($ret['status'] != 'error' && !empty($_POST['asal_uep'])){
                    $asal_uep = $_POST['asal_uep'];
                }
                if($ret['status'] != 'error' && !empty($_POST['tahun'])){
                    $tahun = $_POST['tahun'];
                }
                if($ret['status'] != 'error' && !empty($_POST['lainnya'])){
                    $lainnya = $_POST['lainnya'];
                }
                if($ret['status'] != 'error' && !empty($_POST['rehabilitas'])){
                    $rehabilitas = $_POST['rehabilitas'];
                }
                if($ret['status'] != 'error' && !empty($_POST['lokasi_rehabilitas'])){
                    $lokasi_rehabilitas = $_POST['lokasi_rehabilitas'];
                }
                if($ret['status'] != 'error' && !empty($_POST['tahun_rehabilitas'])){
                    $tahun_rehabilitas = $_POST['tahun_rehabilitas'];
                }
                if($ret['status'] != 'error' && !empty($_POST['keahlian_khusus'])){
                    $keahlian_khusus = $_POST['keahlian_khusus'];
                }
                if($ret['status'] != 'error' && !empty($_POST['prestasi'])){
                    $prestasi = $_POST['prestasi'];
                }
                if($ret['status'] != 'error' && !empty($_POST['nama_perawat_wali'])){
                    $nama_perawat_wali = $_POST['nama_perawat_wali'];
                }
                if($ret['status'] != 'error' && !empty($_POST['hubungan_dengan_pd'])){
                    $hubungan_dengan_pd = $_POST['hubungan_dengan_pd'];
                }
                if($ret['status'] != 'error' && !empty($_POST['nomor_hp'])){
                    $nomor_hp = $_POST['nomor_hp'];
                }
                if($ret['status'] != 'error' && !empty($_POST['kelayakan'])){
                    $kelayakan = $_POST['kelayakan'];
                }
                if($ret['status'] != 'error' && !empty($_POST['tahun_anggaran'])){
                    $tahun_anggaran = $_POST['tahun_anggaran'];
                }
                if($ret['status'] != 'error'){
                    $data = array(
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
                    if(!empty($_POST['id_data'])){
                        $wpdb->update('data_disabilitas_siks', $data, array(
                            'id' => $_POST['id_data']
                        ));
                        $ret['message'] = 'Berhasil update data!';
                    }else{
                        $cek_id = $wpdb->get_row($wpdb->prepare('
                            SELECT
                                id,
                                active
                            FROM data_disabilitas_siks
			                WHERE id=%d
			            ', $_POST['id']), ARRAY_A);
                        // print_r($cek_id); die($wpdb->last_query);
                        if(empty($cek_id)){
                            $wpdb->insert('data_disabilitas_siks', $data);
                        }else{
                            if($cek_id['active'] == 0){
                                $wpdb->update('data_disabilitas_siks', $data, array(
                                    'id' => $cek_id['id']
                                ));
                            }
                        }
                    }
                }
            }else{
                $ret['status']  = 'error';
                $ret['message'] = 'Api key tidak ditemukan!';
            }
        }else{
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
				0 => 'nama',
				1 => 'gender',
				2 => 'tempat_lahir',
				3 => 'tanggal_lahir',
				4 => 'status',
				5 => 'dokumen_kewarganegaraan',
				6 => 'nik',
				7 => 'nomor_kk',
				8 => 'rt',
				9 => 'rw',
				10 => 'desa',
				11 => 'kecamatan',
				12 => 'no_hp',
				13 => 'pendidikan_terakhir',
				14 => 'nama_sekolah',
				15 => 'keterangan_lulus',
				16 => 'jenis_disabilitas',
				17 => 'keterangan_disabilitas',
				18 => 'sebab_disabilitas',
				19 => 'diagnosa_medis',
				20 => 'penyakit_lain',
				21 => 'tempat_pengobatan',
				22 => 'perawat',
				23 => 'aktivitas',
				24 => 'aktivitas_bantuan',
				25 => 'perlu_bantu',
				26 => 'alat_bantu',
				27 => 'alat_yang_dimiliki',
				28 => 'kondisi_alat',
				29 => 'jaminan_kesehatan',
				30 => 'cara_menggunakan_jamkes',
				31 => 'jaminan_sosial',
				32 => 'pekerjaan',
				33 => 'lokasi_bekerja',
				34 => 'alasan_tidak_bekerja',
				35 => 'pendapatan_bulan',
				36 => 'pengeluaran_bulan',
				37 => 'pendapatan_lain',
				38 => 'minat_kerja',
				39 => 'keterampilan',
				40 => 'pelatihan_yang_diikuti',
				41 => 'pelatihan_yang_diminat',
				42 => 'status_rumah',
				43 => 'lantai',
				44 => 'kamar_mandi',
				45 => 'wc',
				46 => 'akses_ke_lingkungan',
				47 => 'dinding',
				48 => 'sarana_air',
				49 => 'penerangan',
				50 => 'desa_paud',
				51 => 'tk_di_desa',
				52 => 'kecamatan_slb',
				53 => 'sd_menerima_abk',
				54 => 'smp_menerima_abk',
				55 => 'jumlah_posyandu',
				56 => 'kader_posyandu',
				57 => 'layanan_kesehatan',
				58 => 'sosialitas_ke_tetangga',
				59 => 'keterlibatan_berorganisasi',
				60 => 'kegiatan_kemasyarakatan',
				61 => 'keterlibatan_musrembang',
				62 => 'alat_bantu_bantuan',
				63 => 'asal_alat_bantu',
				64 => 'tahun_pemberian',
				65 => 'bantuan_uep',
				66 => 'asal_uep',
				67 => 'tahun',
				68 => 'lainnya',
				69 => 'rehabilitas',
				70 => 'lokasi_rehabilitas',
				71 => 'tahun_rehabilitas',
				72 => 'keahlian_khusus',
				73 => 'prestasi',
				74 => 'nama_perawat_wali',
				75 => 'hubungan_dengan_pd',
				76 => 'nomor_hp',
				77 => 'kelayakan',
				78 => 'tahun_anggaran',
			   	79 => 'id'
			);
			$where = $sqlTot = $sqlRec = "";

			// check search value exist
			if (!empty($params['search']['value'])) {
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
                $where .=" AND ( nama LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%").")";    
                $where .=" OR nik LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%").")";
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
				$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
				$btn .= '<a class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
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
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

    public function get_data_lansia_by_id(){
        global $wpdb;
        $ret = array(
            'status' => 'success',
            'message' => 'Berhasil get data!',
            'data' => array()
        );
        if(!empty($_POST)){
            if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
                $ret['data'] = $wpdb->get_row($wpdb->prepare('
                    SELECT 
                        *
                    FROM data_lansia_siks
                    WHERE id=%d
                ', $_POST['id']), ARRAY_A);
            }else{
                $ret['status']  = 'error';
                $ret['message'] = 'Api key tidak ditemukan!';
            }
        }else{
            $ret['status']  = 'error';
            $ret['message'] = 'Format Salah!';
        }

        die(json_encode($ret));
    }

public function hapus_data_lansia_by_id(){
	global $wpdb;
	$ret = array(
		'status' => 'success',
		'message' => 'Berhasil hapus data!',
		'data' => array()
	);
	if(!empty($_POST)){
		if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
			$ret['data'] = $wpdb->update('data_lansia_siks', array('active' => 0), array(
				'id' => $_POST['id']
			));
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

    public function tambah_data_lansia(){
        global $wpdb;
        $ret = array(
            'status' => 'success',
            'message' => 'Berhasil simpan data!',
            'data' => array()
        );
        if(!empty($_POST)){
            if(!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {
                if($ret['status'] != 'error' && !empty($_POST['nama'])){
                    $nama = $_POST['nama'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Nama tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['alamat'])){
                    $alamat = $_POST['alamat'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Alamat tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['tanggal_lahir'])){
                    $tanggal_lahir = $_POST['tanggal_lahir'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Tanggal Lahir tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['kecamatan'])){
                    $kecamatan = $_POST['kecamatan'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Kecamatan tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['desa'])){
                    $desa = $_POST['desa'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Desa tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['usia'])){
                    $usia = $_POST['usia'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Usia tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['nik'])){
                    $nik = $_POST['nik'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data NIK tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['dokumen_kependudukan'])){
                    $dokumen_kependudukan = $_POST['dokumen_kependudukan'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Dokumen Kependudukan tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['status_tempat_tinggal'])){
                    $status_tempat_tinggal = $_POST['status_tempat_tinggal'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Status Tempat Tinggal tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['status_pemenuhan_kebutuhan'])){
                    $status_pemenuhan_kebutuhan = $_POST['status_pemenuhan_kebutuhan'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Status Pemenuhan Kebutuhan tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['status_kehidupan_rumah_tangga'])){
                    $status_kehidupan_rumah_tangga = $_POST['status_kehidupan_rumah_tangga'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Status Pemenuhan Kebutuhan tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['status_dtks'])){
                    $status_dtks = $_POST['status_dtks'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Status DTKS tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['status_kepersertaan_program_bansos'])){
                    $status_kepersertaan_program_bansos = $_POST['status_kepersertaan_program_bansos'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Status Kepersertaan Program Bansos tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['rekomendasi_pendata_lama'])){
                    $rekomendasi_pendata_lama = $_POST['rekomendasi_pendata_lama'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Rekomendasi Pendeta Lama tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['keterangan_lainnya_lama'])){
                    $keterangan_lainnya_lama = $_POST['keterangan_lainnya_lama'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Keterangan Lainnya Lama tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['rekomendasi_pendata'])){
                    $rekomendasi_pendata = $_POST['rekomendasi_pendata'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Rekomendasi Pendeta tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['keterangan_lainnya'])){
                    $keterangan_lainnya = $_POST['keterangan_lainnya'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Keterangan Lainnya tidak boleh kosong!';
                }
                if($ret['status'] != 'error' && !empty($_POST['tahun_anggaran'])){
                    $tahun_anggaran = $_POST['tahun_anggaran'];
                // }else{
                //  $ret['status'] = 'error';
                //  $ret['message'] = 'Data Keterangan Lainnya Lama tidak boleh kosong!';
                }
                if($ret['status'] != 'error'){
                    $data = array(
                        'nama' => $nama,
                        'alamat' => $alamat,
                        'desa' => $desa,
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
                    if(!empty($_POST['id_data'])){
                        $wpdb->update('data_lansia_siks', $data, array(
                            'id' => $_POST['id_data']
                        ));
                        $ret['message'] = 'Berhasil update data!';
                    }else{
                        $cek_id = $wpdb->get_row($wpdb->prepare('
                            SELECT
                                id,
                                active
                            FROM data_lansia_siks
			                WHERE id=%d
			            ', $_POST['id']), ARRAY_A);
                        // print_r($cek_id); die($wpdb->last_query);
                        if(empty($cek_id)){
                            $wpdb->insert('data_lansia_siks', $data);
                        }else{
                            if($cek_id['active'] == 0){
                                $wpdb->update('data_lansia_siks', $data, array(
                                    'id' => $cek_id['id']
                                ));
                            }
                        }
                    }
                }
            }else{
                $ret['status']  = 'error';
                $ret['message'] = 'Api key tidak ditemukan!';
            }
        }else{
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
				0 => 'nama',
				1 => 'alamat',
				2 => 'desa',
				3 => 'kecamatan',
				4 => 'nik',
				5 => 'tanggal_lahir',
				6 => 'usia',
                7 => 'dokumen_kependudukan',
                8 => 'status_tempat_tinggal',
                9 => 'status_pemenuhan_kebutuhan',
               10 => 'status_kehidupan_rumah_tangga',
               11 => 'status_dtks',
               12 => 'status_kepersertaan_program_bansos',
               13 => 'rekomendasi_pendata_lama',
               14 => 'keterangan_lainnya_lama',
               15 => 'rekomendasi_pendata',
               16 => 'keterangan_lainnya',
			   17 => 'tahun_anggaran',
			   18 => 'id'
			);
			$where = $sqlTot = $sqlRec = "";

			// check search value exist
			if (!empty($params['search']['value'])) {
				$search_value = $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
                $where .=" AND ( nama LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%").")";    
                $where .=" OR nik LIKE ".$wpdb->prepare('%s', "%".$params['search']['value']."%").")";
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
				$btn = '<a class="btn btn-sm btn-warning" onclick="edit_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-edit"></i></a>';
				$btn .= '<a style="margin-left: 10px;" class="btn btn-sm btn-danger" onclick="hapus_data(\'' . $recVal['id'] . '\'); return false;" href="#" title="Edit Data"><i class="dashicons dashicons-trash"></i></a>';
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
				kecamatan,
				desa,
				count(id) as jml
			FROM data_disabilitas_siks 
			WHERE $where
				AND active=1
			GROUP BY provinsi, kabkot, kecamatan, desa
			ORDER BY  provinsi, kabkot, kecamatan, desa
		", ARRAY_A);
		// print_r($data); die($wpdb->last_query);

		return $data;
	}
}
