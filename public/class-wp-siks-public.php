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
class Wp_Siks_Public {

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
	public function __construct( $plugin_name, $version, $functions ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->functions = $functions;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-siks-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-siks-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ajax', array(
		    'url' => admin_url( 'admin-ajax.php' )
		));

	}

	public function cek_bansos(){
		// untuk disable render shortcode di halaman edit page/post
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-cek-bansos.php';
	}

	public function peta_siks_desa(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		echo 'SIKS Desa';
	}

	public function peta_siks_kecamatan(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		echo 'SIKS Kacamatan';
	}

	public function data_dtks_siks(){
		if(!empty($_GET) && !empty($_GET['post'])){
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/wp-siks-dtks.php';
	}

	public function get_data_bansos_lama(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data bansos!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {

		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_data_bansos(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get data bansos!'
		);
		if (!empty($_POST)) {
			if(isset($_POST['g-recaptcha-response'])){
	          	$captcha=$_POST['g-recaptcha-response'];
	        }
	        if(!$captcha){
	        	$ret['status'] = 'error';
	        }
	        $secretKey = get_option('_crb_siks_captcha_private');
	        $ip = $_SERVER['REMOTE_ADDR'];
	        // post request to server
	        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
	        $response = file_get_contents($url);
	        $responseKeys = json_decode($response,true);
	        if(empty($responseKeys["success"])) {
	        	$ret['status'] = 'error';
	        	$ret['message'] = 'Harap selesaikan validasi captcha dulu!';
	        }else {
				if(!empty($_POST['nik']) || !empty($_POST['data'])){
					$auto_login = get_option('_crb_siks_auto_login');
					$login = false;
					if(is_user_logged_in()){
					    $current_user = wp_get_current_user();
					    if($this->functions->user_has_role($current_user->ID, 'administrator')){
					        $login = true;
					    }
					}
					
					if($auto_login == 1){
						$param_encrypt = $_POST['data'];
						$options = array(
							'url' => 'https://api.kemensos.go.id/viewbnba/bnba-list',
							'data' => array('data'=> $param_encrypt),
							'header' => array(
								'Authorization: '.get_option('_crb_siks_cookie')
							)
						);
						$data = $this->functions->curl_post($options);
						$data_asli = str_replace('"', '', $data);
						if(empty($data_asli)){
							$ret['status'] = 'error';
							$ret['message'] = 'Tidak bisa terhubung ke server. Coba lagi nanti!';
						}else{
							if(strpos('cURL Error', $data_asli) === true){
								$ret['status'] = 'error';
								$ret['message'] = 'Tidak bisa terhubung ke server. Coba lagi nanti!';
							}
							if($login == false){
								$ret['data'] = $data_asli;
							}else{
								$ret['options'] = $options;
								$ret['data'] = $data_asli;
							}
						}
					}else{
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
						if($login == true){
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
						if($login == true){
							$ret['sql'] = $wpdb->last_query;
						}
					}
				}else{
					$ret['status'] = 'error';
					$ret['message'] = 'NIK tidak boleh kosong!';
				}
			}
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function refresh_token(){
		$no_error = get_option('siks_cronjob_error');
		$no = get_option('siks_cronjob');
		$current_cookie = get_option('_crb_siks_cookie');
		$last_cookie = get_option('siks_last_cookie');
		if($current_cookie != $last_cookie){
			$no = 0;
			$no_error = 0;
			update_option('siks_last_cookie', $current_cookie);
		}
		if($no_error >= 10){
			die('Maksimal error get data ke server. RUN sukses ke '.$no.' dan RUN error ke '.$no_error);
		}
		$param_encrypt = get_option('_crb_siks_param_encrypt');
		$data = $this->functions->curl_post(array(
			'url' => 'https://api.kemensos.go.id/viewbnba/bnba-list',
			'data' => array('data'=> $param_encrypt),
			'header' => array(
				'Authorization: '.$current_cookie
			)
		));
		$data_asli = str_replace('"', '', $data);
		if(!empty($data_asli)){
			if(empty($no)){
				$no = 0;
			}
			$no++;
			update_option('siks_cronjob', $no);
			update_option('siks_cronjob_error', 0);
			die('Sukses run ke '.$no);
		}else{
			if(empty($no_error)){
				$no_error = 0;
			}
			$no_error++;
			update_option('siks_cronjob_error', $no_error);
			die('Error get data ke server. RUN sukses ke '.$no.' dan RUN error ke '.$no_error);
		}
	}

	public function refresh_token_lama(){
		$current_cookie = get_option('_crb_siks_cookie');
		$opts = array('https' => array('header'=> 'Cookie: '.$current_cookie));
		$context = stream_context_create($opts);
		file_get_contents('https://siks.kemensos.go.id/kemsos/beranda/landing', false, $context);
		$last_cookie = get_option('siks_last_cookie');
		$no = get_option('siks_cronjob');
		if(empty($no) || $current_cookie != $last_cookie){
			$no = 0;
			update_option('siks_last_cookie', $current_cookie);
		}
		$no++;
		update_option('siks_cronjob', $no);
	}

	public function proses_captcha(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil memproses captcha!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {
			update_option('siks_captcha_decrypt', $_POST['captcha']);
			$this->send_message(true, 'login_captcha');
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function set_token(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil set token!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {
			update_option('_crb_siks_cookie', $_POST['token']);
			// update cronjob error jadi 0 agar cronjob berjalan lagi dan get captcha tidak dilanjutkan
		  	update_option('siks_cronjob_error', 0);
			$message = "Berhasil update SIKS authorization / token / login session!";
		  	$ret['tg'] = $this->functions->send_tg(array('message' => $message));
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function send_message($ret=false, $message=false){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil send message!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {
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
		  	if(!empty($_POST['action_pusher'])){
		  		if($_POST['action_pusher'] == 'send_otp'){
		  			$data['otp'] = $_POST['otp'];
		  			$data['pesan'] = $_POST['pesan'];
		  		}
		  		$data['action'] = $_POST['action_pusher'];
		  	}else if(empty($message)){
		  		// update cronjob error jadi 10 agar cronjob tidak aktif dan penanda kalau harus get token
		  		update_option('siks_cronjob_error', 10);
		  		$data['action'] = 'require_login';
		  	}else{
		  		$data['action'] = $message;
		  		$data['captcha'] = get_option('siks_captcha_decrypt');
		  		$data['key'] = get_option('siks_captcha_key');
		  	}
		  	$pusher->trigger('my-channel', 'my-event', $data);
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		if(!empty($ret)){
			return $ret;
		}else{
			die(json_encode($ret));
		}
	}

	public function set_captcha(){
		global $wpdb;
		$ret = array(
			'action'	=> $_POST['action'],
			'status'	=> 'success',
			'message'	=> 'Berhasil set captcha!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {
		  	update_option('siks_captcha', str_replace("'", "", $wpdb->prepare('%s', $_POST['captcha'])));
		  	update_option('siks_captcha_key', str_replace("'", "", $wpdb->prepare('%s', $_POST['key'])));
		  	update_option('siks_captcha_decrypt', '');
		  	$message = "Set captcha login SIKS!";
		  	$this->functions->send_tg(array('message' => $message));
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_captcha(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get captcha!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {
		  	$ret['captcha'] = get_option('siks_captcha');
		  	$error = get_option('siks_cronjob_error');
		  	// cek jika cronjob error sama dengan 0 maka get captcha tidak dilanjutkan
		  	if($error == 0){
		  		$ret['captcha'] = '';
		  	}
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function get_data_dtks(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil get captcha!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {
		  	$data = $wpdb->get_results($wpdb->prepare("
				SELECT
					*
				FROM data_dtks
				WHERE kecamatan=%s
					AND desa_kelurahan=%s
			", $_POST['kecamatan'], $_POST['desa']));
			$ret['data'] = $data;
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function singkronisasi_dtks(){
		global $wpdb;
		$ret = array(
			'action'	=> 'singkronisasi_dtks',
			'status'	=> 'success',
			'message'	=> 'Berhasil backup data DTKS!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {
		  	$data = json_decode(stripslashes(html_entity_decode($_POST['data'])), true);
		  	if($data['page'] == 0){
		  		$wpdb->update("data_dtks", array('active' => 0), array(
		  			'id_desa' => $data['meta']['id_desa']
		  		));
		  	}
		  	foreach($data['data'] as $orang){
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
				if(empty($cek_id)){
					$wpdb->insert('data_dtks', $opsi);
				}else{
					$wpdb->update('data_dtks', $opsi, array(
						'id' => $cek_id
					));
				}
		  	}
		}else{
			$ret = array(
				'status' => 'error',
				'message'	=> 'Format tidak sesuai!'
			);
		}
		die(json_encode($ret));
	}

	public function my_cron_schedules($schedules){
	    if(!isset($schedules["custom_min"])){
	        $schedules["custom_min"] = array(
	            'interval' => 0.5*60,
	            'display' => __('Once every 1 minutes'));
	    }
	    if(!isset($schedules["5min"])){
	        $schedules["5min"] = array(
	            'interval' => 5*60,
	            'display' => __('Once every 5 minutes'));
	    }
	    if(!isset($schedules["30min"])){
	        $schedules["30min"] = array(
	            'interval' => 30*60,
	            'display' => __('Once every 30 minutes'));
	    }
	    return $schedules;
	}

	public function get_center(){
		$center_map_default = get_option('_crb_google_map_center_siks');
		$ret = array(
			'lat' => 0,
			'lng' => 0
		);
		if(!empty($center_map_default)){
			$center_map_default = explode(',', $center_map_default);
			$ret['lat'] = $center_map_default[0];
			$ret['lng'] = $center_map_default[1];
		}
		return $ret;
	}

	function get_polygon($options = array( 'type' => 'desa' )){
		global $wpdb;

		$default_color = get_option('_crb_warna_p3ke_siks');
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if($options['type'] == 'desa'){
			if(!empty($kab)){
				$where .= " and kab_kot='$kab'";
			}
			$data = $wpdb->get_results("
				SELECT 
					* 
				FROM data_batas_desa_siks 
				WHERE $where
				ORDER BY provinsi, kab_kot, kecamatan, desa
			", ARRAY_A);
		}else if($options['type'] == 'kecamatan'){
			if(!empty($kab)){
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
		foreach($data as $val){
			$coordinate = json_decode($val['polygon'], true);
			if(!empty($coordinate)){
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

	function get_dtks(){
		global $wpdb;
		$prov = get_option('_crb_siks_prop');
		$where = " provinsi='$prov'";
		$kab = get_option('_crb_siks_kab');
		if(!empty($kab)){
			$where .= " and kabkot='$kab'";
		}
		$data = $wpdb->get_results("
			SELECT 
				provinsi, 
				kabkot, 
				kecamatan, 
				desa,
				BLT, 
				BLT_BBM, 
				BPNT, 
				PKH, 
				PBI,
				COUNT(BLT) as jml
			FROM data_dtks 
			WHERE $where
				AND is_nonaktif is null
				AND active=1
			GROUP BY provinsi, kabkot, kecamatan, desa, BLT, BLT_BBM, BPNT, PKH, PBI
			ORDER BY provinsi, kabkot, kecamatan
		", ARRAY_A);

		return $data;
	}

	function getSearchLocation($data = array()){
		$text = '';
		if(!empty($data['desa'])){
			$text .= ' '.$data['desa'];
		}
		if(!empty($data['kecamatan'])){
			if(
				empty($data['desa'])
				|| (
					!empty($data['desa']) 
					&& $data['kecamatan'] != $data['desa']
				)
			){
				$text .= ' '.$data['kecamatan'];
			}
		}
		if(!empty($data['kab_kot'])){
			if(
				empty($data['kecamatan'])
				|| (
					!empty($data['kecamatan']) 
					&& $data['kab_kot'] != $data['kecamatan']
				)
			){
				$text .= ' '.$data['kab_kot'];
			}
		}
		if(!empty($data['kabkot'])){
			if(
				empty($data['kecamatan'])
				|| (
					!empty($data['kecamatan']) 
					&& $data['kabkot'] != $data['kecamatan']
				)
			){
				$text .= ' '.$data['kabkot'];
			}
		}
		if(!empty($data['provinsi'])){
			$text .= ' '.$data['provinsi'];
		}
		return $text;
	}

	public function getNamaDaerah($value=''){
		$prov = get_option('_crb_siks_prop');
		$ret = "Provinsi $prov";
		$kab = get_option('_crb_siks_kab');
		if(!empty($kab)){
			$ret = "Kabupaten $kab<br>$ret";
		}
		return $ret;
	}

	public function number_format($number){
		return number_format($number, 0,",",".");
	}

	function get_siks_map_url(){
		$api_googlemap = get_option( '_crb_google_api_siks' );
		$api_googlemap = "https://maps.googleapis.com/maps/api/js?key=$api_googlemap&callback=initMap&libraries=places&libraries=drawing";
		return $api_googlemap;
	}

}
