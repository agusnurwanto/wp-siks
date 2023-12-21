<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Siks
 * @subpackage Wp_Siks/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Siks
 * @subpackage Wp_Siks/admin
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class Wp_Siks_Admin {

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
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-siks-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wp_Siks_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Siks_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'xlsx', plugin_dir_url( __FILE__ ) . 'js/xlsx.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-siks-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function crb_attach_siks_options(){
		global $wpdb;

		$cek_bansos = $this->functions->generatePage(array(
			'nama_page' => 'Cek Data Terpadu Kesejahteraan Sosial (DTKS)', 
			'content' => '[cek_bansos]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));

		$peta_batas_desa = $this->functions->generatePage(array(
			'nama_page' => 'Peta Batas Desa', 
			'content' => '[peta_desa_siks]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));

		$peta_batas_kecamatan = $this->functions->generatePage(array(
			'nama_page' => 'Peta Batas Kecamatan', 
			'content' => '[peta_kecamatan_siks]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));

		$data_dtks = $this->functions->generatePage(array(
			'nama_page' => 'Data DTKS SIKS', 
			'content' => '[data_dtks_siks]',
        	'show_header' => 1,
        	'no_key' => 1,
			'post_status' => 'publish'
		));

		$management_data_lansia = $this->functions->generatePage(array(
			'nama_page' => 'Management Data Lansia',
			'content' => '[management_data_lansia]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));

		$basic_options_container = Container::make( 'theme_options', __( 'SIKS Options' ) )
			->set_page_menu_position( 4 )
	        ->add_fields( array(
				Field::make( 'html', 'crb_siks_halaman_terkait' )
		        	->set_html( '
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="'.$cek_bansos['url'].'">'.$cek_bansos['title'].'</a></li>
	            		<li>Untuk melakukan refresh session login. Gunakan cronjob dengan interval per 5 menit mengakses <b>'.site_url().'/wp-admin/admin-ajax.php?action=refresh_token</b>. Saat ini cronjob sudah dilakukan sebanyak <b>'.get_option('siks_cronjob').'</b> kali.</li>
	            		<li><span class="button button-primary" onclick="sql_migrate_siks(); return false;">SQL Migrate</span> (Tombol untuk memperbaiki struktur database WP-SIKS)</li>
	            		<li><a target="_blank" href="'.$peta_batas_desa['url'].'">'.$peta_batas_desa['title'].'</a></li>
	            		<li><a target="_blank" href="'.$peta_batas_kecamatan['url'].'">'.$peta_batas_kecamatan['title'].'</a></li>
	            		<li><a target="_blank" href="'.$data_dtks['url'].'">'.$data_dtks['title'].'</a></li>
	            	</ol>' ),
	            Field::make( 'text', 'crb_apikey_siks', 'API KEY' )
	            	->set_default_value($this->functions->generateRandomString())
	            	->set_help_text('Wajib diisi. API KEY digunakan untuk integrasi data.'),
	            Field::make( 'text', 'crb_siks_captcha_public', 'Recaptcha public key' )
	            	->set_help_text('Bisa dilihat di <a href="https://www.google.com/recaptcha/admin/site/" target="_blank">https://www.google.com/recaptcha/admin/site/</a>.'),
	            Field::make( 'text', 'crb_siks_captcha_private', 'Recaptcha private key' )
	            	->set_help_text('Bisa dilihat di <a href="https://www.google.com/recaptcha/admin/site/" target="_blank">https://www.google.com/recaptcha/admin/site/</a>.'),
	            Field::make( 'radio', 'crb_siks_auto_login', 'Auto Login' )
	            	->add_options( array(
				        '1' => __( 'Ya' ),
				        '2' => __( 'Tidak' )
				    ) )
	            	->set_default_value('2')
	            	->set_help_text('Auto login ketika session habis.'),
	            Field::make( 'text', 'crb_siks_cookie', 'SIKS authorization' )
	            	->set_help_text('Nilai authorization setelah berhasil login ke aplikasi <a href="https://siks.kemensos.go.id/" target="_blank">siks.kemensos.go.id</a>.'),
	            Field::make( 'text', 'crb_siks_param_encrypt', 'SIKS param encrypt' )
	            	->set_help_text('Nilai parameter yang dikirim ke server SIKS untuk menjaga session cookie tetap hidup.'),
	            Field::make( 'text', 'crb_siks_key', 'SIKS key encrypt' )
	            	->set_help_text('Nilai kunci yang dipakai untuk mengencrypt data yang akan dikirim ke server SIKS. Bisa dilihat di <a href="https://siks.kemensos.go.id/static/js/main.4d679ac9.js" target="_blank">https://siks.kemensos.go.id/static/js/main.4d679ac9.js</a>.'),
	            Field::make( 'text', 'crb_siks_prop', 'Nama Provinsi' )
	            	->set_help_text('Bisa dilihat di <a href="https://cekbansos.kemensos.go.id/" target="_blank">cekbansos.kemensos.go.id</a>.'),
	            Field::make( 'text', 'crb_siks_kab', 'Nama Kabupaten/Kota' )
	            	->set_help_text('Bisa dilihat di <a href="https://cekbansos.kemensos.go.id/" target="_blank">cekbansos.kemensos.go.id</a>.'),
	            Field::make( 'text', 'crb_siks_pusher_cluster', 'PUSHER APP CLUSTER' )
	            	->set_help_text('Bisa dilihat di <a href="https://dashboard.pusher.com/apps" target="_blank">https://dashboard.pusher.com/apps</a>.'),
	            Field::make( 'text', 'crb_siks_bot_tg', 'Telegram bot API' )
	            	->set_help_text('Bot Father <a href="Bot Father https://t.me/BotFather" target="_blank">https://t.me/BotFather</a> (tambahkan kata <b>bot</b> di depan token bot). Referensi: https://www.ruangdeveloper.com/blog/membuat-bot-telegram-sederhana-menggunakan-php/'),
	            Field::make( 'text', 'crb_siks_akun_tg', 'ID akun telegram' )
	            	->set_help_text('ID telegram admin yang akan dikirim notifikasi. Bisa lebih dari satu dengan dipisah tanda koma (,). Untuk mendapatkan ID akun bisa melakuan chat dengan akun <a href="https://t.me/SIKSotpBot" target="_blank">https://t.me/SIKSotpBot</a>.'),
	            Field::make( 'text', 'crb_siks_pusher_id', 'PUSHER APP ID' )
	            	->set_help_text('Bisa dilihat di <a href="https://dashboard.pusher.com/apps" target="_blank">https://dashboard.pusher.com/apps</a>.'),
	            Field::make( 'text', 'crb_siks_pusher_key', 'PUSHER APP KEY' )
	            	->set_help_text('Bisa dilihat di <a href="https://dashboard.pusher.com/apps" target="_blank">https://dashboard.pusher.com/apps</a>.'),
	            Field::make( 'text', 'crb_siks_pusher_secret', 'PUSHER APP SECRET' )
	            	->set_help_text('Bisa dilihat di <a href="https://dashboard.pusher.com/apps" target="_blank">https://dashboard.pusher.com/apps</a>.')
	        ) );

		Container::make( 'theme_options', __( 'Google Maps' ) )
			->set_page_parent( $basic_options_container )
			->add_fields( array(
	        	Field::make( 'map', 'crb_google_map_center_siks', 'Lokasi default Google Maps' ),
	        	Field::make( 'text', 'crb_google_map_id', 'ID google map' )
	        		->set_default_value('118b4b0052053d3a')
	        		->set_help_text('Referensi untuk untuk membuat ID Google Maps <a href="https://youtu.be/tAR63GBwk90" target="blank">https://youtu.be/tAR63GBwk90</a>'),
	        	Field::make( 'text', 'crb_google_api_siks', 'Google Maps APIKEY' )
	        		->set_default_value('AIzaSyDBrDSUIMFDIleLOFUUXf1wFVum9ae3lJ0')
	        		->set_help_text('Referensi untuk menampilkan google map <a href="https://developers.google.com/maps/documentation/javascript/examples/map-simple" target="blank">https://developers.google.com/maps/documentation/javascript/examples/map-simple</a>. Referensi untuk manajemen layer di Google Maps <a href="https://youtu.be/tAR63GBwk90" target="blank">https://youtu.be/tAR63GBwk90</a>'),
	        	Field::make( 'color', 'crb_warna_p3ke_siks', 'Warna garis P3KE' )
	        		->set_default_value('#00cc00'),
	        	Field::make( 'image', 'crb_icon_p3ke_siks', 'Icon keluarga P3KE' )
	        		->set_value_type('url')
        			->set_default_value(SIKS_PLUGIN_URL.'public/images/lokasi.png'),
	        	Field::make( 'color', 'crb_warna_stanting_siks', 'Warna garis stanting' )
	        		->set_default_value('#CC0003'),
	        	Field::make( 'image', 'crb_icon_stanting_siks', 'Icon anak stanting' )
	        		->set_value_type('url')
        			->set_default_value(SIKS_PLUGIN_URL.'public/images/lokasi.png'),
	        	Field::make( 'color', 'crb_warna_dtks_siks', 'Warna garis DTKS' )
	        		->set_default_value('#005ACC'),
	        	Field::make( 'image', 'crb_icon_dtks_siks', 'Icon dtks' )
	        		->set_value_type('url')
        			->set_default_value(SIKS_PLUGIN_URL.'public/images/lokasi.png'),
	        	Field::make( 'image', 'crb_icon_desa_siks', 'Icon desa' )
	        		->set_value_type('url')
        			->set_default_value(SIKS_PLUGIN_URL.'public/images/lokasi.png'),
	        	Field::make( 'image', 'crb_icon_kecamatan_siks', 'Icon kecamatan' )
	        		->set_value_type('url')
        			->set_default_value(SIKS_PLUGIN_URL.'public/images/lokasi.png')
	        ) );

	    Container::make( 'theme_options', __( 'Data Lansia' ) )
			->set_page_parent( $basic_options_container )
			->add_fields( array(
		    	Field::make( 'html', 'crb_lansia_hide_sidebar' )
		        	->set_html( '
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	' ), 
				Field::make( 'html', 'crb_siks_halaman_terkait_lansia' )
		        	->set_html( '
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="'.$management_data_lansia['url'].'">'.$management_data_lansia['title'].'</a></li>
	            	</ol>
		        	' ),
		        Field::make( 'html', 'crb_lansia_upload_html' )
	            	->set_html( '<h3>Import EXCEL data Lansia</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSiks(event);"><br>
	            		Contoh format file excel untuk <b>Lansia</b> bisa <a target="_blank" href="'.SIKS_PLUGIN_URL. 'excel/contoh_lansia.xlsx">download di sini</a>.<br>
	            		Data yang di-import adalah <b>data yang sudah dilakukan verval.</b><br>
	            		Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.<br>' ),
	            Field::make( 'html', 'crb_lansia_siks' )
	            	->set_html( 'Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>' ),
		        Field::make( 'html', 'crb_lansia_save_button' )
	            	->set_html( '<a onclick="import_excel_lansia(); return false" href="javascript:void(0);" class="button button-primary">Import Lansia</a>' )
	        ) );
	}

	function sql_migrate_siks(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil menjalankan SQL migrate!'
		);
		$file = 'table.sql';
		$ret['value'] = $file.' (tgl: '.date('Y-m-d H:i:s').')';
		$path = SIKS_PLUGIN_PATH.'/'.$file;
		if(file_exists($path)){
			$sql = file_get_contents($path);
			$ret['sql'] = $sql;
			if($file == 'table.sql'){
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				$wpdb->hide_errors();
				$rows_affected = dbDelta($sql);
				if(empty($rows_affected)){
					$ret['status'] = 'error';
					$ret['message'] = $wpdb->last_error;
				}else{
					$ret['message'] = implode(' | ', $rows_affected);
				}
			}else{
				$wpdb->hide_errors();
				$res = $wpdb->query($sql);
				if(empty($res)){
					$ret['status'] = 'error';
					$ret['message'] = $wpdb->last_error;
				}else{
					$ret['message'] = $res;
				}
			}
			if($ret['status'] == 'success'){
				$ret['version'] = $this->version;
				update_option('_last_update_sql_migrate_siks', $ret['value']);
				update_option('_wp_sipd_db_version_siks', $this->version);
			}
		}else{
			$ret['status'] = 'error';
			$ret['message'] = 'File '.$path.' tidak ditemukan!';
		}
		die(json_encode($ret));
	}

	function import_excel_lansia(){
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {
			
			$table_data = 'data_lansia_siks';

			if(
				!empty($_POST['update_active']) 
				&& $_POST['page'] == 1
			){
				$wpdb->query($wpdb->prepare("UPDATE $table_data SET active=0, update_at='".date('Y-m-d H:i:s')."'"));
			}
			
			$ret['data'] = array(
				'insert' => 0, 
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {
				
				$newData = array();
				
				foreach($data as $kk => $vv){
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'nama' => $newData['nama'],
				    'alamat' => $newData['alamat'],
				    'desa' => $newData['desa'],
				    'kecamatan' => $newData['kecamatan'],
				    'nik' => $newData['nik'],
				    'tanggal_lahir' => $newData['tanggal_lahir'],
				    'usia' => $newData['usia'],
				    'dokumen_kependudukan' => $newData['dokumen_kependudukan'],
				    'status_tempat_tinggal' => $newData['status_tempat_tinggal'],
				    'status_pemenuhan_kebutuhan' => $newData['status_pemenuhan_kebutuhan'],
				    'status_kehidupan_rumah_tangga' => $newData['status_kehidupan_rumah_tangga'],
				    'status_dtks' => $newData['status_dtks'],
				    'status_kepersertaan_program_bansos' => $newData['status_kepersertaan_program_bansos'],
				    'rekomendasi_pendata_lama' => $newData['rekomendasi_pendata_lama'],
				    'keterangan_lainnya_lama' => $newData['keterangan_lainnya_lama'],
				    'rekomendasi_pendata' => $newData['rekomendasi_pendata'],
				    'keterangan_lainnya' => $newData['keterangan_lainnya'],
				    'tahun_anggaran' => $newData['tahun'],
				    'active' => 1,
				    'update_at' => current_time('mysql')
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var($wpdb->prepare("
					SELECT 
						id 
					FROM $table_data 
					WHERE tahun_anggaran=%d
						AND nik=%s"
					, $newData['tahun_anggaran'], $newData['nik']));

				if(empty($cek_id)){
					$wpdb->insert($table_data, $data_db);
					$ret['data']['insert']++;
				}else{
					$wpdb->update($table_data, $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}

				if(!empty($wpdb->last_error)){
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}
}
