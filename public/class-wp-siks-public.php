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
					/*
					$data = $this->functions->curl_post(array(
						'url' => 'https://siks.kemensos.go.id/dinsoskab/view_data_new/ajax_bansos',
						'data' =>array(
							'draw' => 1,
							'columns[0][data]' => 'counter',
							'columns[0][name]' => '',
							'columns[0][searchable]' => true,
							'columns[0][orderable]' => false,
							'columns[0][search][value]' => '',
							'columns[0][search][regex]' => false,
							'columns[1][data]' => 'NOKK',
							'columns[1][name]' => '',
							'columns[1][searchable]' => true,
							'columns[1][orderable]' => false,
							'columns[1][search][value]' => '',
							'columns[1][search][regex]' => false,
							'columns[2][data]' => 'NIK',
							'columns[2][name]' => '',
							'columns[2][searchable]' => true,
							'columns[2][orderable]' => false,
							'columns[2][search][value]' => '',
							'columns[2][search][regex]' => false,
							'columns[3][data]' => 'Nama',
							'columns[3][name]' => '',
							'columns[3][searchable]' => true,
							'columns[3][orderable]' => false,
							'columns[3][search][value]' => '',
							'columns[3][search][regex]' => false,
							'columns[4][data]' => 'Alamat',
							'columns[4][name]' => '',
							'columns[4][searchable]' => true,
							'columns[4][orderable]' => false,
							'columns[4][search][value]' => '',
							'columns[4][search][regex]' => false,
							'columns[5][data]' => 'FIRST_SK',
							'columns[5][name]' => '',
							'columns[5][searchable]' => true,
							'columns[5][orderable]' => false,
							'columns[5][search][value]' => '',
							'columns[5][search][regex]' => false,
							'columns[6][data]' => 'padankan_at',
							'columns[6][name]' => '',
							'columns[6][searchable]' => true,
							'columns[6][orderable]' => false,
							'columns[6][search][value]' => '',
							'columns[6][search][regex]' => false,
							'columns[7][data]' => 'BPNT',
							'columns[7][name]' => '',
							'columns[7][searchable]' => true,
							'columns[7][orderable]' => false,
							'columns[7][search][value]' => '',
							'columns[7][search][regex]' => false,
							'columns[8][data]' => 'BST',
							'columns[8][name]' => '',
							'columns[8][searchable]' => true,
							'columns[8][orderable]' => false,
							'columns[8][search][value]' => '',
							'columns[8][search][regex]' => false,
							'columns[9][data]' => 'PKH',
							'columns[9][name]' => '',
							'columns[9][searchable]' => true,
							'columns[9][orderable]' => false,
							'columns[9][search][value]' => '',
							'columns[9][search][regex]' => false,
							'columns[10][data]' => 'PBI',
							'columns[10][name]' => '',
							'columns[10][searchable]' => true,
							'columns[10][orderable]' => false,
							'columns[10][search][value]' => '',
							'columns[10][search][regex]' => false,
							'columns[11][data]' => 'BNPT_PPKM',
							'columns[11][name]' => '',
							'columns[11][searchable]' => true,
							'columns[11][orderable]' => false,
							'columns[11][search][value]' => '',
							'columns[11][search][regex]' => false,
							'columns[12][data]' => 'BLT',
							'columns[12][name]' => '',
							'columns[12][searchable]' => true,
							'columns[12][orderable]' => false,
							'columns[12][search][value]' => '',
							'columns[12][search][regex]' => false,
							'columns[13][data]' => 'BLT_BBM',
							'columns[13][name]' => '',
							'columns[13][searchable]' => true,
							'columns[13][orderable]' => false,
							'columns[13][search][value]' => '',
							'columns[13][search][regex]' => false,
							'columns[14][data]' => 'RUTILAHU',
							'columns[14][name]' => '',
							'columns[14][searchable]' => true,
							'columns[14][orderable]' => false,
							'columns[14][search][value]' => '',
							'columns[14][search][regex]' => false,
							'columns[15][data]' => 'keterangan_meninggal',
							'columns[15][name]' => '',
							'columns[15][searchable]' => true,
							'columns[15][orderable]' => false,
							'columns[15][search][value]' => '',
							'columns[15][search][regex]' => false,
							'columns[16][data]' => 'keterangan_disabilitas',
							'columns[16][name]' => '',
							'columns[16][searchable]' => true,
							'columns[16][orderable]' => false,
							'columns[16][search][value]' => '',
							'columns[16][search][regex]' => false,
							'columns[17][data]' => 'cetak',
							'columns[17][name]' => '',
							'columns[17][searchable]' => true,
							'columns[17][orderable]' => false,
							'columns[17][search][value]' => '',
							'columns[17][search][regex]' => false,
							'start' => 0,
							'length' => 10,
							'search[value]' => '',
							'search[regex]' => false,
							'no_prop' => get_option('crb_siks_prop'),
							'no_kab' => get_option('crb_siks_kab'),
							'no_kec' => '',
							'no_kel' => '',
							'nik' => $_POST['nik'],
							'NO_KK' => '',
							'psnoka' => '',
							'nama_penerima' => '',
							'is_disabilitas' => 0,
							'filter_meninggal' => 0,
							'bpnt' => false,
							'bst' => false,
							'pkh' => false,
							'bpnt_ppkm' => false,
							'pbi' => false,
							'blt' => false,
							'blt_bbm' => false,
							'rutilahu' => false,
							'filter_gis' => 0
						),
						'header' => array("Cookie: ".get_option('_crb_siks_cookie'))
					));
					$data_asli = json_decode($data);
					*/

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
						$login = false;
						if(is_user_logged_in()){
						    $current_user = wp_get_current_user();
						    if($this->functions->user_has_role($current_user->ID, 'administrator')){
						        $login = true;
						    }
						}
						if($login == false){
							$ret['data'] = $data_asli;
						}else{
							$ret['options'] = $options;
							$ret['data'] = $data_asli;
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
		if($no_error == 10){
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
		$data = $this->functions->curl_post($options);
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

	public function set_token(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil set token!'
		);
		if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option( SIKS_APIKEY )) {
			update_option('_crb_siks_cookie', $_POST['token']);
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

}
