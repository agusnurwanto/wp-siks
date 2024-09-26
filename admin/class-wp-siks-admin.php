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

class Wp_Siks_Admin
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
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-siks-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->plugin_name . 'jszip', plugin_dir_url(__FILE__) . 'js/jszip.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name . 'xlsx', plugin_dir_url(__FILE__) . 'js/xlsx.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-siks-admin.js', array('jquery'), $this->version, false);
		wp_localize_script($this->plugin_name, 'ajax', array(
			'url' => admin_url('admin-ajax.php'),
			'apikey' => get_option(SIKS_APIKEY)
		));
	}

	public function crb_attach_siks_options()
	{
		global $wpdb;

		$cek_bansos = $this->functions->generatePage(array(
			'nama_page' => 'Cek Data Terpadu Kesejahteraan Sosial (DTKS)',
			'content' => '[cek_bansos]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$cek_nik_siks = $this->functions->generatePage(array(
			'nama_page' => 'Cek NIK SIKS',
			'content' => '[cek_nik_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$peta_desa_siks = $this->functions->generatePage(array(
			'nama_page' => 'Peta Batas Desa SIKS',
			'content' => '[peta_desa_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$peta_data_terpadu_siks = $this->functions->generatePage(array(
			'nama_page' => 'Peta Data Terpadu SIKS',
			'content' => '[peta_data_terpadu_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$peta_kecamatan_siks = $this->functions->generatePage(array(
			'nama_page' => 'Peta Batas Kecamatan SIKS',
			'content' => '[peta_kecamatan_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$data_calon_p3ke = $this->functions->generatePage(array(
			'nama_page' => 'Calon Penerima P3KE',
			'content' => '[data_calon_p3ke]',
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

		$data_lansia = $this->functions->generatePage(array(
			'nama_page' => 'Data Lansia SIKS',
			'content' => '[data_lansia_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$data_disabilitas = $this->functions->generatePage(array(
			'nama_page' => 'Data Disabilitas SIKS',
			'content' => '[data_disabilitas_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$data_bunda_kasih = $this->functions->generatePage(array(
			'nama_page' => 'Data Bunda Kasih SIKS',
			'content' => '[data_bunda_kasih_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$data_anak_terlantar = $this->functions->generatePage(array(
			'nama_page' => 'Data Anak Terlantar SIKS',
			'content' => '[data_anak_terlantar_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$data_gepeng = $this->functions->generatePage(array(
			'nama_page' => 'Data Gepeng SIKS',
			'content' => '[data_gepeng_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$data_p3ke = $this->functions->generatePage(array(
			'nama_page' => 'Data P3KE SIKS',
			'content' => '[data_p3ke_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$data_wrse = $this->functions->generatePage(array(
			'nama_page' => 'Data WRSE SIKS',
			'content' => '[data_wrse_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$data_hibah = $this->functions->generatePage(array(
			'nama_page' => 'Data Hibah SIKS',
			'content' => '[data_hibah_siks]',
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

		$management_data_disabilitas = $this->functions->generatePage(array(
			'nama_page' => 'Management Data Disabilitas',
			'content' => '[management_data_disabilitas]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));

		$management_data_bunda_kasih = $this->functions->generatePage(array(
			'nama_page' => 'Management Data Bunda Kasih',
			'content' => '[management_data_bunda_kasih]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));

		$management_data_anak_terlantar = $this->functions->generatePage(array(
			'nama_page' => 'Management Data Anak Terlantar',
			'content' => '[management_data_anak_terlantar]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));


		$management_data_lksa = $this->functions->generatePage(array(
			'nama_page' => 'Management Data Lembaga Kesejahteraan Sosial Anak (LKSA)',
			'content' => '[management_data_lksa]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));

		$management_data_odgj = $this->functions->generatePage(array(
			'nama_page' => 'Management Data Orang Dengan Gangguan Jiwa ( ODGJ )',
			'content' => '[management_data_odgj]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));

		$management_data_dtks_siks = $this->functions->generatePage(array(
			'nama_page' => 'Management Data DTKS SIKS',
			'content' => '[management_data_dtks_siks]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));

		$management_data_p3ke = $this->functions->generatePage(array(
			'nama_page' => 'Management Data P3KE SIKS',
			'content' => '[management_data_p3ke]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'private'
		));

		$management_wrse = $this->functions->generatePage(array(
			'nama_page' => 'Manajemen WRSE',
			'content' => '[management_wrse]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$management_hibah = $this->functions->generatePage(array(
			'nama_page' => 'Manajemen Hibah',
			'content' => '[management_hibah]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$management_calon_p3ke = $this->functions->generatePage(array(
			'nama_page' => 'Manajemen Calon Penerima P3KE',
			'content' => '[management_calon_p3ke]',
			'show_header' => 1,
			'no_key' => 1,
			'post_status' => 'publish'
		));

		$basic_options_container = Container::make('theme_options', __('SIKS Options'))
			->set_page_menu_position(4)
			->add_fields(array(
				Field::make('html', 'crb_siks_halaman_terkait')
					->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $cek_bansos['url'] . '">' . $cek_bansos['title'] . '</a></li>
	            		<li>Untuk melakukan refresh session login. Gunakan cronjob dengan interval per 5 menit mengakses <b>' . site_url() . '/wp-admin/admin-ajax.php?action=refresh_token</b>. Saat ini cronjob sudah dilakukan sebanyak <b>' . get_option('siks_cronjob') . '</b> kali.</li>
	            		<li><span class="button button-primary" onclick="sql_migrate_siks(); return false;">SQL Migrate</span> (Tombol untuk memperbaiki struktur database WP-SIKS)</li>
	            		<li><a target="_blank" href="' . $peta_data_terpadu_siks['url'] . '">' . $peta_data_terpadu_siks['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $peta_desa_siks['url'] . '">' . $peta_desa_siks['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $peta_kecamatan_siks['url'] . '">' . $peta_kecamatan_siks['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_dtks['url'] . '">' . $data_dtks['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_lansia['url'] . '">' . $data_lansia['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_disabilitas['url'] . '">' . $data_disabilitas['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_anak_terlantar['url'] . '">' . $data_anak_terlantar['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_gepeng['url'] . '">' . $data_gepeng['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_bunda_kasih['url'] . '">' . $data_bunda_kasih['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_p3ke['url'] . '">' . $data_p3ke['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_calon_p3ke['url'] . '">' . $data_calon_p3ke['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_wrse['url'] . '">' . $data_wrse['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $data_hibah['url'] . '">' . $data_hibah['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $cek_nik_siks['url'] . '">' . $cek_nik_siks['title'] . '</a></li>
	            	</ol>'),
				Field::make('text', 'crb_apikey_siks', 'API KEY')
					->set_default_value($this->functions->generateRandomString())
					->set_help_text('Wajib diisi. API KEY digunakan untuk integrasi data.'),
				Field::make('text', 'crb_siks_captcha_public', 'Recaptcha public key')
					->set_help_text('Bisa dilihat di <a href="https://www.google.com/recaptcha/admin/site/" target="_blank">https://www.google.com/recaptcha/admin/site/</a>.'),
				Field::make('text', 'crb_siks_captcha_private', 'Recaptcha private key')
					->set_help_text('Bisa dilihat di <a href="https://www.google.com/recaptcha/admin/site/" target="_blank">https://www.google.com/recaptcha/admin/site/</a>.'),
				Field::make('radio', 'crb_siks_auto_login', 'Auto Login')
					->add_options(array(
						'1' => __('Ya'),
						'2' => __('Tidak')
					))
					->set_default_value('2')
					->set_help_text('Auto login ketika session habis.'),
				Field::make('text', 'crb_siks_cookie', 'SIKS authorization')
					->set_help_text('Nilai authorization setelah berhasil login ke aplikasi <a href="https://siks.kemensos.go.id/" target="_blank">siks.kemensos.go.id</a>.'),
				Field::make('text', 'crb_siks_param_encrypt', 'SIKS param encrypt')
					->set_help_text('Nilai parameter yang dikirim ke server SIKS untuk menjaga session cookie tetap hidup.'),
				Field::make('text', 'crb_siks_key', 'SIKS key encrypt')
					->set_help_text('Nilai kunci yang dipakai untuk mengencrypt data yang akan dikirim ke server SIKS. Bisa dilihat di <a href="https://siks.kemensos.go.id/static/js/main.4d679ac9.js" target="_blank">https://siks.kemensos.go.id/static/js/main.4d679ac9.js</a>.'),
				Field::make('text', 'crb_siks_prop', 'Nama Provinsi')
					->set_help_text('Bisa dilihat di <a href="https://cekbansos.kemensos.go.id/" target="_blank">cekbansos.kemensos.go.id</a>.'),
				Field::make('text', 'crb_siks_kab', 'Nama Kabupaten/Kota')
					->set_help_text('Bisa dilihat di <a href="https://cekbansos.kemensos.go.id/" target="_blank">cekbansos.kemensos.go.id</a>.'),
				Field::make('text', 'crb_siks_pusher_cluster', 'PUSHER APP CLUSTER')
					->set_help_text('Bisa dilihat di <a href="https://dashboard.pusher.com/apps" target="_blank">https://dashboard.pusher.com/apps</a>.'),
				Field::make('text', 'crb_siks_bot_tg', 'Telegram bot API')
					->set_help_text('Bot Father <a href="Bot Father https://t.me/BotFather" target="_blank">https://t.me/BotFather</a> (tambahkan kata <b>bot</b> di depan token bot). Referensi: https://www.ruangdeveloper.com/blog/membuat-bot-telegram-sederhana-menggunakan-php/'),
				Field::make('text', 'crb_siks_akun_tg', 'ID akun telegram')
					->set_help_text('ID telegram admin yang akan dikirim notifikasi. Bisa lebih dari satu dengan dipisah tanda koma (,). Untuk mendapatkan ID akun bisa melakuan chat dengan akun <a href="https://t.me/SIKSotpBot" target="_blank">https://t.me/SIKSotpBot</a>.'),
				Field::make('text', 'crb_siks_pusher_id', 'PUSHER APP ID')
					->set_help_text('Bisa dilihat di <a href="https://dashboard.pusher.com/apps" target="_blank">https://dashboard.pusher.com/apps</a>.'),
				Field::make('text', 'crb_siks_pusher_key', 'PUSHER APP KEY')
					->set_help_text('Bisa dilihat di <a href="https://dashboard.pusher.com/apps" target="_blank">https://dashboard.pusher.com/apps</a>.'),
				Field::make('text', 'crb_siks_pusher_secret', 'PUSHER APP SECRET')
					->set_help_text('Bisa dilihat di <a href="https://dashboard.pusher.com/apps" target="_blank">https://dashboard.pusher.com/apps</a>.')
			));

		Container::make('theme_options', __('Pengaturan User Desa & Kecamatan'))
			->set_page_parent($basic_options_container)
			->add_fields(array(
				Field::make('html', 'crb_html_data_dtks_siks')
					->set_html('<a href="#" class="button button-primary" onclick="get_data_alamat_dtks_siks(); return false;">Tarik Data Master User</a>')
					->set_help_text('Tombol untuk menarik data master user Desa dan Kecamatan dari tabel data_dtks'),
				Field::make('html', 'crb_generate_user_siks')
					->set_html('<a id="generate_user_siks" onclick="return false;" href="#" class="button button-primary button-large">Generate User Desa & Kecamatan</a>')
					->set_help_text('Data user aktif yang ada di table data_alamat_siks akan digenerate menjadi user wordpress.'),
			));

		Container::make('theme_options', __('Google Maps'))
			->set_page_parent($basic_options_container)
			->add_fields(array(
				Field::make('map', 'crb_google_map_center_siks', 'Lokasi default Google Maps'),
				Field::make('text', 'crb_google_map_id_siks', 'ID google map')
					->set_default_value('118b4b0052053d3a')
					->set_help_text('Referensi untuk untuk membuat ID Google Maps <a href="https://youtu.be/tAR63GBwk90" target="blank">https://youtu.be/tAR63GBwk90</a>'),
				Field::make('text', 'crb_google_api_siks', 'Google Maps APIKEY')
					->set_default_value('AIzaSyDBrDSUIMFDIleLOFUUXf1wFVum9ae3lJ0')
					->set_help_text('Referensi untuk menampilkan google map <a href="https://developers.google.com/maps/documentation/javascript/examples/map-simple" target="blank">https://developers.google.com/maps/documentation/javascript/examples/map-simple</a>. Referensi untuk manajemen layer di Google Maps <a href="https://youtu.be/tAR63GBwk90" target="blank">https://youtu.be/tAR63GBwk90</a>'),
				Field::make('image', 'crb_icon_disabilitas_siks', 'Icon Disabilitas')
					->set_value_type('url')
					->set_default_value(SIKS_PLUGIN_URL . 'public/images/lokasi.png'),
				Field::make('image', 'crb_icon_lansia_siks', 'Icon Lansia')
					->set_value_type('url')
					->set_default_value(SIKS_PLUGIN_URL . 'public/images/lokasi.png'),
				Field::make('image', 'crb_icon_anak_terlantar_siks', 'Icon Anak Terlantar')
					->set_value_type('url')
					->set_default_value(SIKS_PLUGIN_URL . 'public/images/lokasi.png'),
				Field::make('image', 'crb_icon_anak_gepeng_siks', 'Icon Gelandangan dan Pengamen (GEPENG)')
					->set_value_type('url')
					->set_default_value(SIKS_PLUGIN_URL . 'public/images/lokasi.png'),
				Field::make('image', 'crb_icon_dtks_siks', 'Icon dtks')
					->set_value_type('url')
					->set_default_value(SIKS_PLUGIN_URL . 'public/images/lokasi.png'),
				Field::make('image', 'crb_icon_kecamatan_siks', 'Icon kecamatan')
					->set_value_type('url')
					->set_default_value(SIKS_PLUGIN_URL . 'public/images/lokasi.png')
			));

		Container::make('theme_options', __('Data DTKS'))
			->set_page_parent($basic_options_container)
			->add_fields(array(
				Field::make('html', 'crb_dtks_siks_hide_sidebar')
					->set_html('
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	'),
				Field::make('html', 'crb_siks_halaman_terkait_dtks')
					->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $management_data_dtks_siks['url'] . '">' . $management_data_dtks_siks['title'] . '</a></li>
	            	</ol>
		        	')
			));

		Container::make('theme_options', __('Data Lansia'))
			->set_page_parent($basic_options_container)
			->add_fields(array(
				Field::make('html', 'crb_lansia_hide_sidebar')
					->set_html('
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	'),
				Field::make('html', 'crb_siks_halaman_terkait_lansia')
					->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $management_data_lansia['url'] . '">' . $management_data_lansia['title'] . '</a></li>
	            	</ol>
		        	'),
				Field::make('html', 'crb_lansia_upload_html')
					->set_html('<h3>Import EXCEL data Lansia</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSiks(event);"><br>
	            		Contoh format file excel untuk <b>Lansia</b> bisa <a target="_blank" href="' . SIKS_PLUGIN_URL . 'excel/contoh_lansia.xlsx">download di sini</a>.<br>
	            		Data yang di-import adalah <b>data yang sudah dilakukan verval.</b><br>
	            		Kolom dengan isian berupa tanggal wajib di ubah dari <b>date</b> ke <b>text</b><br>
	            		Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.<br>'),
				Field::make('html', 'crb_lansia_siks')
					->set_html('Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>'),
				Field::make('html', 'crb_lansia_save_button')
					->set_html('<a onclick="import_excel_lansia(); return false" href="javascript:void(0);" class="button button-primary">Import Lansia</a>')
			));

		Container::make('theme_options', __('Data Disabilitas'))
			->set_page_parent($basic_options_container)
			->add_fields(array(
				Field::make('html', 'crb_disabilitas_hide_sidebar')
					->set_html('
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	'),
				Field::make('html', 'crb_siks_halaman_terkait_disabilitas')
					->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $management_data_disabilitas['url'] . '">' . $management_data_disabilitas['title'] . '</a></li>
	            		<li><a target="_blank" href="' . $management_data_odgj['url'] . '">' . $management_data_odgj['title'] . '</a></li>
	            	</ol>
		        	'),
				Field::make('html', 'crb_disabilitas_upload_html')
					->set_html('<h3>Import EXCEL data Disabilitas</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSiks(event);"><br>
	            		Contoh format file excel untuk <b>Disabilitas</b> bisa <a target="_blank" href="' . SIKS_PLUGIN_URL . 'excel/contoh_disabilitas.xlsx">download di sini</a>.<br>
	            		Contoh format file excel untuk <b>ODGJ</b> bisa <a target="_blank" href="' . SIKS_PLUGIN_URL . 'excel/contoh_odgj.xlsx">download di sini</a>.<br>
	            		Data yang di-import adalah <b>data yang sudah dilakukan verval.</b><br>
	            		Kolom dengan isian berupa tanggal wajib di ubah dari <b>date</b> ke <b>text</b><br>
	            		Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.<br>'),
				Field::make('radio', 'crb_jenis_disabilitas', ('Pilih Jenis Data Excel'))
					->add_options(array(
						'import_excel_disabilitas' => 'Import Data Disabilitas',
						'import_excel_odgj' => 'Import Data ODGJ'
					))
					->set_help_text('Pilih jenis data yang ingin diimpor.'),
				Field::make('html', 'crb_disabilitas_siks')
					->set_html('Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>'),
				Field::make('html', 'crb_lansia_save_button')
					->set_html('<a onclick="import_excel_disabilitas(); return false" href="javascript:void(0);" class="button button-primary">Import</a>')
			));

		Container::make('theme_options', __('Data Bunda Kasih'))
			->set_page_parent($basic_options_container)
			->add_fields(array(
				Field::make('html', 'crb_bunda_kasih_hide_sidebar')
					->set_html('
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	'),
				Field::make('html', 'crb_siks_halaman_terkait_bunda_kasih')
					->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $management_data_bunda_kasih['url'] . '">' . $management_data_bunda_kasih['title'] . '</a></li>
	            	</ol>
		        	'),
				Field::make('html', 'crb_bunda_kasih_upload_html')
					->set_html('<h3>Import EXCEL data Bunda Kasih</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSiks(event);"><br>
	            		Contoh format file excel untuk <b>Bunda Kasih</b> bisa <a target="_blank" href="' . SIKS_PLUGIN_URL . 'excel/contoh_bunda_kasih.xlsx">download di sini</a>.<br>
	            		Data yang di-import adalah <b>data yang sudah dilakukan verval.</b><br>
	            		Kolom dengan isian berupa tanggal wajib di ubah dari <b>date</b> ke <b>text</b><br>
	            		Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.<br>'),
				Field::make('html', 'crb_bunda_kasih_siks')
					->set_html('Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>'),
				Field::make('html', 'crb_lansia_save_button')
					->set_html('<a onclick="import_excel_bunda_kasih(); return false" href="javascript:void(0);" class="button button-primary">Import Bunda Kasih</a>')
			));

		Container::make('theme_options', __('Data Anak Terlantar'))
			->set_page_parent($basic_options_container)
			->add_fields(array(
				Field::make('html', 'crb_anak_terlantar_hide_sidebar')
					->set_html('
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	'),
				Field::make('html', 'crb_siks_halaman_terkait_anak_terlantar')
					->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $management_data_anak_terlantar['url'] . '">' . $management_data_anak_terlantar['title'] . '</a></li>
						<li><a target="_blank" href="' . $management_data_lksa['url'] . '">' . $management_data_lksa['title'] . '</a></li>
	            	</ol>
		        	'),
				Field::make('html', 'crb_anak_terlantar_upload_html')
					->set_html('<h3>Import EXCEL data Anak Terlantar</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSiks(event);"><br>
	            		Contoh format file excel untuk <b>Anak Terlantar dan LKSA</b> bisa <a target="_blank" href="' . SIKS_PLUGIN_URL . 'excel/contoh_anak_terlantar_lksa.xlsx">download di sini</a>.<br>
	            		Data yang di-import adalah <b>data yang sudah dilakukan verval.</b><br>
	            		Kolom dengan isian berupa tanggal wajib di ubah dari <b>date</b> ke <b>text</b><br>
	            		Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.<br>'),
				Field::make('radio', 'crb_jenis_anak_terlantar', ('Pilih Jenis Data Excel'))
					->add_options(array(
						'import_excel_anak_terlantar' => 'Import Data Anak Terlantar',
						'import_excel_lksa' => 'Import Data LKSA'
					))
					->set_help_text('Pilih jenis data yang ingin diimpor.'),
				Field::make('html', 'crb_anak_terlantar_siks')
					->set_html('Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>'),
				Field::make('html', 'crb_anak_terlantar_save_button')
					->set_html('<a style="margin-inline-end : 5px;"onclick="import_excel_anak_terlantar(); return false" href="javascript:void(0);" class="button button-primary">Import Excel</a>')
			));

		Container::make('theme_options', __('Data P3KE'))
			->set_page_parent($basic_options_container)
			->add_fields(array(
				Field::make('html', 'crb_p3ke_hide_sidebar')
					->set_html('
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	'),
				Field::make('html', 'crb_siks_halaman_terkait_p3ke')
					->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $management_data_p3ke['url'] . '">' . $management_data_p3ke['title'] . '</a></li>
	            	</ol>
		        	'),
				Field::make('html', 'crb_p3ke_upload_html')
					->set_html('<h3>Import EXCEL data P3KE</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSiks(event);"><br>
	            		Contoh format file excel untuk <b>P3KE</b> bisa <a target="_blank" href="' . SIKS_PLUGIN_URL . 'excel/contoh_p3ke.xlsx">download di sini</a>.<br>
	            		Data yang di-import adalah <b>data yang sudah dilakukan verval.</b><br>
	            		Kolom dengan isian berupa tanggal wajib di ubah dari <b>date</b> ke <b>text</b><br>
	            		Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.<br>'),
				Field::make('html', 'crb_p3ke_siks')
					->set_html('Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>'),
				Field::make('html', 'crb_p3ke_save_button')
					->set_html('<a onclick="import_excel_p3ke_siks(); return false" href="javascript:void(0);" class="button button-primary">Import P3KE</a>')
			));

		Container::make('theme_options', __('Data Calon Penerima P3KE'))
			->set_page_parent($basic_options_container)
			->add_fields(array(
				Field::make('html', 'crb_p3ke_hide_sidebar')
					->set_html('
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	'),
				Field::make('html', 'crb_siks_halaman_terkait_calon_p3ke')
					->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $management_calon_p3ke['url'] . '">' . $management_calon_p3ke['title'] . '</a></li>
	            	</ol>
		        	'),
				Field::make('html', 'crb_calon_p3ke_upload_html')
					->set_html('<h3>Import EXCEL data Calon Penerima P3KE</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSiks(event);"><br>
	            		Contoh format file excel untuk <b>Calon Penerima P3KE</b> bisa <a target="_blank" href="' . SIKS_PLUGIN_URL . 'excel/contoh_calon_penerima_p3ke.xlsx">download di sini</a>.<br>
	            		Data yang di-import adalah <b>data yang sudah dilakukan verval.</b><br>
	            		Kolom dengan isian berupa tanggal wajib di ubah dari <b>date</b> ke <b>text</b><br>
	            		Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.<br>'),
				Field::make('html', 'crb_calon_p3ke_siks')
					->set_html('Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>'),
				Field::make('html', 'crb_calon_p3ke_save_button')
					->set_html('<a onclick="import_excel_calon_penerima_p3ke_siks(); return false" href="javascript:void(0);" class="button button-primary">Import Calon P3KE</a>')
			));

		Container::make('theme_options', __('Data WRSE'))
			->set_page_parent($basic_options_container)
			->add_fields(
				array(
					Field::make('html', 'crb_wrse_hide_sidebar')
						->set_html('
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	'),
					Field::make('html', 'crb_siks_halaman_terkait_wrse')
						->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $management_wrse['url'] . '">' . $management_wrse['title'] . '</a></li>
	            	</ol>
		        	'),
					Field::make('html', 'crb_wrse_upload_html')
						->set_html('<h3>Import EXCEL data WRSE ( Wanita Rawan Sosial Ekonomi )</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSiks(event);"><br>
	            		Contoh format file excel untuk <b>WRSE</b> bisa <a target="_blank" href="' . SIKS_PLUGIN_URL . 'excel/contoh_data_wrse.xlsx">download di sini</a>.<br>
	            		Data yang di-import adalah <b>data yang sudah dilakukan verval.</b><br>
	            		Kolom dengan isian berupa tanggal wajib di ubah dari <b>date</b> ke <b>text</b><br>
	            		Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.<br>'),
					Field::make('html', 'crb_wrse_siks')
						->set_html('Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>'),
					Field::make('html', 'crb_wrse_save_button')
						->set_html('<a onclick="import_excel_wrse_siks(); return false" href="javascript:void(0);" class="button button-primary">Import WRSE</a>')
				)
			);

		Container::make('theme_options', __('Data Hibah'))
			->set_page_parent($basic_options_container)
			->add_fields(
				array(
					Field::make('html', 'crb_hibah_hide_sidebar')
						->set_html('
		        		<style>
		        			.postbox-container { display: none; }
		        			#poststuff #post-body.columns-2 { margin: 0 !important; }
		        		</style>
		        	'),
					Field::make('html', 'crb_siks_halaman_terkait_hibah')
						->set_html('
					<h5>HALAMAN TERKAIT</h5>
	            	<ol>
	            		<li><a target="_blank" href="' . $management_hibah['url'] . '">' . $management_hibah['title'] . '</a></li>
	            	</ol>
		        	'),
					Field::make('html', 'crb_hibah_upload_html')
						->set_html('<h3>Import EXCEL data Hibah</h3>Pilih file excel .xlsx : <input type="file" id="file-excel" onchange="filePickedSiks(event);"><br>
	            		Contoh format file excel untuk <b>Hibah</b> bisa <a target="_blank" href="' . SIKS_PLUGIN_URL . 'excel/contoh_data_hibah.xlsx">download di sini</a>.<br>
	            		Data yang di-import adalah <b>data yang sudah dilakukan verval.</b><br>
	            		Kolom dengan isian berupa tanggal wajib di ubah dari <b>date</b> ke <b>text</b><br>
	            		Sheet file excel yang akan diimport harus diberi nama <b>data</b>. Untuk kolom nilai angka ditulis tanpa tanda titik.<br>'),
					Field::make('html', 'crb_hibah_siks')
						->set_html('Data JSON : <textarea id="data-excel" class="cf-select__input"></textarea>'),
					Field::make('html', 'crb_hibah_save_button')
						->set_html('<a onclick="import_excel_hibah_siks(); return false" href="javascript:void(0);" class="button button-primary">Import Hibah</a>')
				)
			);
	}

	function sql_migrate_siks()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil menjalankan SQL migrate!'
		);
		$file = 'table.sql';
		$ret['value'] = $file . ' (tgl: ' . date('Y-m-d H:i:s') . ')';
		$path = SIKS_PLUGIN_PATH . '/' . $file;
		if (file_exists($path)) {
			$sql = file_get_contents($path);
			$ret['sql'] = $sql;
			if ($file == 'table.sql') {
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				$wpdb->hide_errors();
				$rows_affected = dbDelta($sql);
				if (empty($rows_affected)) {
					$ret['status'] = 'error';
					$ret['message'] = $wpdb->last_error;
				} else {
					$ret['message'] = implode(' | ', $rows_affected);
				}
			} else {
				$wpdb->hide_errors();
				$res = $wpdb->query($sql);
				if (empty($res)) {
					$ret['status'] = 'error';
					$ret['message'] = $wpdb->last_error;
				} else {
					$ret['message'] = $res;
				}
			}
			if ($ret['status'] == 'success') {
				$ret['version'] = $this->version;
				update_option('_last_update_sql_migrate_siks', $ret['value']);
				update_option('_wp_sipd_db_version_siks', $this->version);
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'File ' . $path . ' tidak ditemukan!';
		}
		die(json_encode($ret));
	}

	function import_excel_lansia()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_lansia_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query($wpdb->prepare("UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"));
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'nama' => $newData['nama'],
					'alamat' => $newData['alamat'],
					'desa' => $newData['desa'],
					'kecamatan' => $newData['kecamatan'],
					'kabupaten' => $newData['kabupaten'],
					'provinsi' => $newData['provinsi'],
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
					'tahun_anggaran' => $newData['tahun_anggaran'],
					'active' => 1,
					'update_at' => current_time('mysql')
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var($wpdb->prepare(
					"
					SELECT 
						id 
					FROM $table_data 
					WHERE tahun_anggaran=%d
						AND nik=%s",
					$newData['tahun_anggaran'],
					$newData['nik']
				));

				if (empty($cek_id)) {
					$wpdb->insert($table_data, $data_db);
					$ret['data']['insert']++;
				} else {
					$wpdb->update($table_data, $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function import_excel_disabilitas()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_disabilitas_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query($wpdb->prepare("UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"));
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'nama' => $newData['nama'],
					'gender' => $newData['gender'],
					'tempat_lahir' => $newData['tempat_lahir'],
					'tanggal_lahir' => $newData['tanggal_lahir'],
					'status' => $newData['status'],
					'dokumen_kewarganegaraan' => $newData['dokumen_kewarganegaraan'],
					'nik' => $newData['nik'],
					'nomor_kk' => $newData['nomor_kk'],
					'rt' => $newData['rt'],
					'rw' => $newData['rw'],
					'desa' => $newData['desa'],
					'kecamatan' => $newData['kecamatan'],
					'kabupaten' => $newData['kabupaten'],
					'provinsi' => $newData['provinsi'],
					'no_hp' => $newData['no_hp'],
					'pendidikan_terakhir' => $newData['pendidikan_terakhir'],
					'nama_sekolah' => $newData['nama_sekolah'],
					'keterangan_lulus' => $newData['keterangan_lulus'],
					'jenis_disabilitas' => $newData['jenis_disabilitas'],
					'keterangan_disabilitas' => $newData['keterangan_disabilitas'],
					'sebab_disabilitas' => $newData['sebab_disabilitas'],
					'diagnosa_medis' => $newData['diagnosa_medis'],
					'penyakit_lain' => $newData['penyakit_lain'],
					'tempat_pengobatan' => $newData['tempat_pengobatan'],
					'perawat' => $newData['perawat'],
					'aktivitas' => $newData['aktivitas'],
					'aktivitas_bantuan' => $newData['aktivitas_bantuan'],
					'perlu_bantu' => $newData['perlu_bantu'],
					'alat_bantu' => $newData['alat_bantu'],
					'alat_yang_dimiliki' => $newData['alat_yang_dimiliki'],
					'kondisi_alat' => $newData['kondisi_alat'],
					'jaminan_kesehatan' => $newData['jaminan_kesehatan'],
					'cara_menggunakan_jamkes' => $newData['cara_menggunakan_jamkes'],
					'jaminan_sosial' => $newData['jaminan_sosial'],
					'pekerjaan' => $newData['pekerjaan'],
					'lokasi_bekerja' => $newData['lokasi_bekerja'],
					'alasan_tidak_bekerja' => $newData['alasan_tidak_bekerja'],
					'pendapatan_bulan' => $newData['pendapatan_bulan'],
					'pengeluaran_bulan' => $newData['pengeluaran_bulan'],
					'pendapatan_lain' => $newData['pendapatan_lain'],
					'minat_kerja' => $newData['minat_kerja'],
					'keterampilan' => $newData['keterampilan'],
					'pelatihan_yang_diikuti' => $newData['pelatihan_yang_diikuti'],
					'pelatihan_yang_diminat' => $newData['pelatihan_yang_diminat'],
					'status_rumah' => $newData['status_rumah'],
					'lantai' => $newData['lantai'],
					'kamar_mandi' => $newData['kamar_mandi'],
					'wc' => $newData['wc'],
					'akses_ke_lingkungan' => $newData['akses_ke_lingkungan'],
					'dinding' => $newData['dinding'],
					'sarana_air' => $newData['sarana_air'],
					'penerangan' => $newData['penerangan'],
					'desa_paud' => $newData['desa_paud'],
					'tk_di_desa' => $newData['tk_di_desa'],
					'kecamatan_slb' => $newData['kecamatan_slb'],
					'sd_menerima_abk' => $newData['sd_menerima_abk'],
					'smp_menerima_abk' => $newData['smp_menerima_abk'],
					'jumlah_posyandu' => $newData['jumlah_posyandu'],
					'kader_posyandu' => $newData['kader_posyandu'],
					'layanan_kesehatan' => $newData['layanan_kesehatan'],
					'sosialitas_ke_tetangga' => $newData['sosialitas_ke_tetangga'],
					'keterlibatan_berorganisasi' => $newData['keterlibatan_berorganisasi'],
					'kegiatan_kemasyarakatan' => $newData['kegiatan_kemasyarakatan'],
					'keterlibatan_musrembang' => $newData['keterlibatan_musrembang'],
					'alat_bantu_bantuan' => $newData['alat_bantu_bantuan'],
					'asal_alat_bantu' => $newData['asal_alat_bantu'],
					'tahun_pemberian' => $newData['tahun_pemberian'],
					'bantuan_uep'   => $newData['bantuan_uep'],
					'asal_uep'   => $newData['asal_uep'],
					'tahun'   => $newData['tahun'],
					'lainnya'  => $newData['lainnya'],
					'rehabilitas'   => $newData['rehabilitas'],
					'lokasi_rehabilitas'   => $newData['lokasi_rehabilitas'],
					'tahun_rehabilitas'   => $newData['tahun_rehabilitas'],
					'keahlian_khusus'  => $newData['keahlian_khusus'],
					'prestasi'   => $newData['prestasi'],
					'nama_perawat_wali'   => $newData['nama_perawat_wali'],
					'hubungan_dengan_pd'   => $newData['hubungan_dengan_pd'],
					'nomor_hp'   => $newData['nomor_hp'],
					'kelayakan'   => $newData['kelayakan'],
					'tahun_anggaran' => $newData['tahun_anggaran'],
					'active' => 1,
					'update_at' => current_time('mysql')
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var($wpdb->prepare(
					"
					SELECT 
						id 
					FROM $table_data 
					WHERE tahun_anggaran=%d
						AND nik=%s",
					$newData['tahun_anggaran'],
					$newData['nik']
				));

				if (empty($cek_id)) {
					$wpdb->insert($table_data, $data_db);
					$ret['data']['insert']++;
				} else {
					$wpdb->update($table_data, $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function import_excel_bunda_kasih()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_bunda_kasih_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query($wpdb->prepare("UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"));
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'nama' => $newData['nama'],
					'kab_kot' => $newData['kab_kot'],
					'alamat' => $newData['alamat'],
					'ketua_lembaga' => $newData['ketua_lembaga'],
					'no_hp' => $newData['no_hp'],
					'akreditasi' => $newData['akreditasi'],
					'kabkot' => $newData['kabupaten'],
					'provinsi' => $newData['provinsi'],
					'tahun_anggaran' => $newData['tahun_anggaran'],
					'active' => 1,
					'update_at' => current_time('mysql')
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var($wpdb->prepare(
					"
					SELECT 
						id 
					FROM $table_data 
					WHERE tahun_anggaran=%d
						AND nik=%s",
					$newData['tahun_anggaran'],
					$newData['nik']
				));

				if (empty($cek_id)) {
					$wpdb->insert($table_data, $data_db);
					$ret['data']['insert']++;
				} else {
					$wpdb->update($table_data, $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function import_excel_anak_terlantar()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_anak_terlantar_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query($wpdb->prepare("UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"));
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'nama' => $newData['nama'],
					'kk' => $newData['kk'],
					'nik' => $newData['nik'],
					'jenis_kelamin' => $newData['jenis_kelamin'],
					'tanggal_lahir' => $newData['tanggal_lahir'],
					'usia' => $newData['usia'],
					'pendidikan' => $newData['pendidikan'],
					'alamat' => $newData['alamat'],
					'provinsi' => $newData['provinsi'],
					'kabkot' => $newData['kabkot'],
					'kecamatan' => $newData['kecamatan'],
					'desa_kelurahan' => $newData['desa_kelurahan'],
					'kelembagaan' => $newData['kelembagaan'],
					'active' => 1,
					'update_at' => current_time('mysql')
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var($wpdb->prepare(
					"
					SELECT 
						id 
					FROM $table_data 
					WHERE tahun_anggaran=%d
						AND nik=%s",
					$newData['tahun_anggaran'],
					$newData['nik']
				));

				if (empty($cek_id)) {
					$wpdb->insert($table_data, $data_db);
					$ret['data']['insert']++;
				} else {
					$wpdb->update($table_data, $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function import_excel_lksa()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_lksa_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query($wpdb->prepare("UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"));
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'nama' => $newData['nama'],
					'kabkot' => $newData['kabkot'],
					'alamat' => $newData['alamat'],
					'ketua' => $newData['ketua'],
					'no_hp' => $newData['no_hp'],
					'akreditasi' => $newData['akreditasi'],
					'anak_dalam_lksa' => $newData['anak_dalam_lksa'],
					'anak_luar_lksa' => $newData['anak_luar_lksa'],
					'total_anak' => $newData['total_anak'],
					'tahun_anggaran' => $newData['tahun_anggaran'],
					'active' => 1,
					'update_at' => current_time('mysql')
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var($wpdb->prepare(
					"
					SELECT 
						id 
					FROM $table_data 
					WHERE tahun_anggaran=%d
						AND nama=%s",
					$newData['tahun_anggaran'],
					$newData['nama']
				));

				if (empty($cek_id)) {
					$wpdb->insert($table_data, $data_db);
					$ret['data']['insert']++;
				} else {
					$wpdb->update($table_data, $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function import_excel_odgj()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_odgj_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query($wpdb->prepare("UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"));
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'nik' => $newData['nik'],
					'kk' => $newData['kk'],
					'nama' => $newData['nama'],
					'provinsi' => $newData['provinsi'],
					'kecamatan' => $newData['kecamatan'],
					'kabkot' => $newData['kabkot'],
					'desa' => $newData['desa'],
					'rt' => $newData['rt'],
					'rw' => $newData['rw'],
					'jenis_kelamin' => $newData['jenis_kelamin'],
					'usia' => $newData['usia'],
					'nama_ortu' => $newData['nama_ortu'],
					'pengobatan' => $newData['pengobatan'],
					'keterangan' => $newData['keterangan'],
					'tahun_anggaran' => $newData['tahun_anggaran'],
					'active' => 1,
					'update_at' => current_time('mysql')
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var($wpdb->prepare(
					"
					SELECT 
						id 
					FROM $table_data 
					WHERE tahun_anggaran=%d
						AND nik=%s",
					$newData['tahun_anggaran'],
					$newData['nik']
				));

				if (empty($cek_id)) {
					$wpdb->insert($table_data, $data_db);
					$ret['data']['insert']++;
				} else {
					$wpdb->update($table_data, $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function import_excel_p3ke_siks()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_p3ke_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query($wpdb->prepare("UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"));
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'nama' => $newData['nama'],
					'alamat' => $newData['alamat'],
					'desa' => $newData['desa'],
					'kecamatan' => $newData['kecamatan'],
					'kabkot' => $newData['kabkot'],
					'provinsi' => $newData['provinsi'],
					'nik' => $newData['nik'],
					'kk' => $newData['kk'],
					'kode_anggota' => $newData['kode_anggota'],
					'pekerjaan' => $newData['pekerjaan'],
					'program' => $newData['program'],
					'penghasilan' => $newData['penghasilan'],
					'keterangan' => $newData['keterangan'],
					'rt' => $newData['rt'],
					'rw' => $newData['rw'],
					'tahun_anggaran' => $newData['tahun_anggaran'],
					'active' => 1,
					'update_at' => current_time('mysql')
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var($wpdb->prepare(
					"
					SELECT 
						id 
					FROM $table_data 
					WHERE tahun_anggaran=%d
						AND nik=%s",
					$newData['tahun_anggaran'],
					$newData['nik']
				));

				if (empty($cek_id)) {
					$wpdb->insert($table_data, $data_db);
					$ret['data']['insert']++;
				} else {
					$wpdb->update($table_data, $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function import_excel_calon_p3ke_siks()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_calon_p3ke_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query($wpdb->prepare("UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"));
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'id_kpm' => $newData['id_kpm'],
					'nik_kk' => $newData['nik_kk'],
					'nik_pkk' => $newData['nik_pkk'],
					'nama_kk' => $newData['nama_kk'],
					'nama_pkk' => $newData['nama_pkk'],
					'nama_anak' => $newData['nama_anak'],
					'nik_anak' => $newData['nik_anak'],
					'alamat' => $newData['alamat'],
					'nama_rt' => $newData['nama_rt'],
					'nama_rw' => $newData['nama_rw'],
					'desa_kelurahan' => $newData['desa_kelurahan'],
					'kecamatan' => $newData['kecamatan'],
					'kabkot' => $newData['kabkot'],
					'district' => $newData['district'],
					'sumber' => $newData['sumber'],
					'desil_p3ke' => $newData['desil_p3ke'],
					'lat' => $newData['lat'],
					'lng' => $newData['lng'],
					'tahun_anggaran' => $newData['tahun_anggaran'],
					'active' => 1,
					'update_at' => current_time('mysql')
				);


				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var($wpdb->prepare(
					"
					SELECT 
						id 
					FROM $table_data 
					WHERE tahun_anggaran=%d
						AND nik_kk=%s",
					$newData['tahun_anggaran'],
					$newData['nik_kk']
				));

				if (empty($cek_id)) {
					$wpdb->insert($table_data, $data_db);
					$ret['data']['insert']++;
				} else {
					$wpdb->update($table_data, $data_db, array(
						"id" => $cek_id
					));
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array($wpdb->last_error, $data_db);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function import_excel_data_wrse_siks()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_wrse_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query(
					$wpdb->prepare(
						"UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"
					)
				);
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'nama' => $newData['nama'],
					'usia' => $newData['usia'],
					'provinsi' => $newData['provinsi'],
					'kabkot' => $newData['kabkot'],
					'kecamatan' => $newData['kecamatan'],
					'desa_kelurahan' => $newData['desa_kelurahan'],
					'alamat' => $newData['alamat'],
					'status_dtks' => $newData['status_dtks'],
					'status_pernikahan' => $newData['status_pernikahan'],
					'mempunyai_usaha' => $newData['mempunyai_usaha'],
					'keterangan' => $newData['keterangan'],
					'jenis_data' => $newData['jenis_data'],
					'tahun_anggaran' => $newData['tahun_anggaran'],
					'create_at' => current_time('mysql'),
					'update_at' => current_time('mysql'),
					'active' => 1
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var(
					$wpdb->prepare("
						SELECT 
							id 
						FROM $table_data 
						WHERE tahun_anggaran=%d
						  AND nama=%s
						  AND usia=%d
						  AND desa_kelurahan=%s
						  AND alamat=%s
						  AND keterangan=%s
						", $newData['tahun_anggaran'], $newData['nama'], $newData['usia'], $newData['desa_kelurahan'], $newData['alamat'], $newData['keterangan'])
				);

				if (empty($cek_id)) {
					$wpdb->insert(
						$table_data,
						$data_db
					);
					$ret['data']['insert']++;
				} else {
					$wpdb->update(
						$table_data,
						$data_db,
						array(
							"id" => $cek_id
						)
					);
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array(
						$wpdb->last_error,
						$data_db
					);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function import_excel_data_hibah_siks()
	{
		global $wpdb;
		$ret = array(
			'status'	=> 'success',
			'message'	=> 'Berhasil import excel!'
		);

		if (!empty($_POST)) {

			$table_data = 'data_hibah_siks';

			if (
				!empty($_POST['update_active'])
				&& $_POST['page'] == 1
			) {
				$wpdb->query(
					$wpdb->prepare(
						"UPDATE $table_data SET active=0, update_at='" . date('Y-m-d H:i:s') . "'"
					)
				);
			}

			$ret['data'] = array(
				'insert' => 0,
				'update' => 0,
				'error' => array()
			);

			foreach ($_POST['data'] as $k => $data) {

				$newData = array();

				foreach ($data as $kk => $vv) {
					$newData[trim(preg_replace('/\s+/', ' ', $kk))] = trim(preg_replace('/\s+/', ' ', $vv));
				}

				$data_db = array(
					'kode' => $newData['kode'],
					'penerima' => $newData['penerima'],
					'provinsi' => $newData['provinsi'],
					'kabkot' => $newData['kabkot'],
					'kecamatan' => $newData['kecamatan'],
					'desa_kelurahan' => $newData['desa_kelurahan'],
					'nama_nik_ketua' => $newData['nama_nik_ketua'],
					'alamat' => $newData['alamat'],
					'anggaran' => $newData['anggaran'],
					'status_realisasi' => $newData['status_realisasi'],
					'no_nphd' => $newData['no_nphd'],
					'tgl_nphd' => $newData['tgl_nphd'],
					'no_spm' => $newData['no_spm'],
					'tgl_spm' => $newData['tgl_spm'],
					'no_sp2d' => $newData['no_sp2d'],
					'tgl_sp2d' => $newData['tgl_sp2d'],
					'jenis_data' => $newData['jenis_data'],
					'peruntukan' => $newData['peruntukan'],
					'tahun_anggaran' => $newData['tahun_anggaran'],
					'keterangan' => $newData['keterangan'],
					'create_at' => current_time('mysql'),
					'update_at' => current_time('mysql'),
					'active' => 1
				);

				$wpdb->last_error = "";

				$cek_id = $wpdb->get_var(
					$wpdb->prepare("
						SELECT 
							id 
						FROM $table_data 
						WHERE tahun_anggaran=%d
						  AND penerima=%s
						  AND nama_nik_ketua=%s
						  AND desa_kelurahan=%s
						  AND anggaran=%d
						", $newData['tahun_anggaran'], $newData['penerima'], $newData['nama_nik_ketua'], $newData['desa_kelurahan'], $newData['anggaran'])
				);

				if (empty($cek_id)) {
					$wpdb->insert(
						$table_data,
						$data_db
					);
					$ret['data']['insert']++;
				} else {
					$wpdb->update(
						$table_data,
						$data_db,
						array(
							"id" => $cek_id
						)
					);
					$ret['data']['update']++;
				}

				if (!empty($wpdb->last_error)) {
					$ret['data']['error'][] = array(
						$wpdb->last_error,
						$data_db
					);
				};
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function management_data_dtks_siks()
	{
		if (!empty($_GET) && !empty($_GET['post'])) {
			return '';
		}
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/wp-siks-data-dtks.php';
	}

	function get_data_dtks_siks()
	{
		global $wpdb;

		try {
			if (!empty($_POST)) {
				if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

					$params = $columns = $totalRecords = $data = array();
					$params = $_REQUEST;
					$columns = array(
						0 => 'Nama',
						1 => 'NIK',
						2 => 'NOKK',
						3 => 'Alamat',
						4 => 'provinsi',
						5 => 'kabkot',
						6 => 'kecamatan',
						7 => 'desa_kelurahan',
						8 => 'ATENSI',
						9 => 'BLT',
						10 => 'BLT_BBM',
						11 => 'BNPT_PPKM',
						12 => 'BPNT',
						13 => 'BST',
						14 => 'FIRST_SK',
						15 => 'PBI',
						16 => 'PENA',
						17 => 'PERMAKANAN',
						18 => 'RUTILAHU',
						19 => 'SEMBAKO_ADAPTIF',
						20 => 'YAPI',
						21 => 'PKH',
						22 => 'update_at',
					);
					$where = $sqlTot = $sqlRec = "";

					if (!empty($_POST['desa']) && !empty($_POST['kecamatan'])) {
						$where .= $wpdb->prepare(' AND desa_kelurahan=%s', $_POST['desa']);
						$where .= $wpdb->prepare(' AND kecamatan=%s', $_POST['kecamatan']);
					}

					if (!empty($params['search']['value'])) {
						$where .= " AND (";
						$where .= " NIK LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
						$where .= " OR Nama LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
						$where .= " OR Alamat LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
						$where .= " OR NOKK LIKE " . $wpdb->prepare('%s', "%" . $params['search']['value'] . "%");
						$where .= ")";
					}

					if (!empty($params['columns'][1]['search']['value']) && $params['columns'][1]['search']['value'] == 'kk_kosong') {
						$where .= " AND NOKK = '' ";
					}

					if (!empty($params['columns'][1]['search']['value']) && $params['columns'][1]['search']['value'] == 'nik_atau_kk_kosong') {
						$where .= " AND ( NIK = '' OR NOKK = '' )";
					}

					if (!empty($params['columns'][2]['search']['value']) && $params['columns'][2]['search']['value'] == 'nik_kosong') {
						$where .= " AND NIK = '' ";
					}

					if (!empty($params['columns'][7]['search']['value'])) {
						$where .= " AND kecamatan LIKE '" . $params['columns'][7]['search']['value'] . "%' ";
					}

					if (!empty($params['columns'][8]['search']['value'])) {
						$where .= " AND desa_kelurahan LIKE '" . $params['columns'][8]['search']['value'] . "%' ";
					}

					$sql_tot = "SELECT count(id) as jml FROM `data_dtks`";
					$sql = "SELECT " . implode(', ', $columns) . " FROM `data_dtks`";
					$where_first = " WHERE 1=1 AND is_nonaktif = 1";
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
					$sqlRec .=  " ORDER BY " . $columns[$params['order'][0]['column']] . "   " . $params['order'][0]['dir'] . $limit;

					$queryTot = $wpdb->get_results($sqlTot, ARRAY_A);
					$totalRecords = $queryTot[0]['jml'];
					$queryRecords = $wpdb->get_results($sqlRec, ARRAY_A);

					exit(json_encode(array(
						"draw"            => intval($params['draw']),
						"recordsTotal"    => intval($totalRecords),
						"recordsFiltered" => intval($totalRecords),
						"data"            => $queryRecords,
						"sql"             => $sqlRec
					)));
				} else {
					throw new Exception('Api key tidak sesuai');
				}
			} else {
				throw new Exception('Format tidak sesuai');
			}
		} catch (Exception $e) {
			echo json_encode([
				'status' => false,
				'message' => $e->getMessage()
			]);
			exit;
		}
	}

	function export_excel_data_dtks_siks()
	{
		global $wpdb;

		try {
			if (!empty($_POST)) {
				if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

					$where = '';
					if (!empty($_POST['search_value'])) {
						$where .= " AND (";
						$where .= " NIK LIKE " . $wpdb->prepare('%s', "%" . $_POST['search_value'] . "%");
						$where .= " OR Nama LIKE " . $wpdb->prepare('%s', "%" . $_POST['search_value'] . "%");
						$where .= " OR Alamat LIKE " . $wpdb->prepare('%s', "%" . $_POST['search_value'] . "%");
						$where .= " OR NOKK LIKE " . $wpdb->prepare('%s', "%" . $_POST['search_value'] . "%");
						$where .= ")";
					}

					if (!empty($_POST['filter_kriteria'] == 'nik_kosong')) {
						$where .= " AND NIK = ''";
					}

					if (!empty($_POST['filter_kriteria'] == 'kk_kosong')) {
						$where .= " AND NOKK = ''";
					}

					if (!empty($_POST['filter_kriteria'] == 'nik_atau_kk_kosong')) {
						$where .= " AND ( NIK = '' OR NOKK = '' )";
					}

					if (!empty($_POST['filter_kecamatan'])) {
						$where .= " AND kecamatan LIKE '" . $_POST['filter_kecamatan'] . "%' ";
					}

					if (!empty($_POST['filter_desa'])) {
						$where .= " AND desa_kelurahan LIKE '" . $_POST['filter_desa'] . "%' ";
					}

					$data = $wpdb->get_results($wpdb->prepare("SELECT * FROM data_dtks WHERE 1=1 AND is_nonaktif = 1" . $where . " ORDER BY id"), ARRAY_A);

					$html = '<table><thead>
		 						<tr>
		 							<th>Nama</th>
		 							<th>NIK</th>
		 							<th>NO KK</th>
		 							<th>Alamat</th>
		 							<th>Provinsi</th>
		 							<th>Kabupaten/Kota</th>
		 							<th>Kecamatan</th>
		 							<th>Desa/Kelurahan</th>
		 							<th>Atensi</th>
		 							<th>BLT</th>
		 							<th>BLT BBM</th>
		 							<th>BNPT PPKM</th>
		 							<th>BPNT</th>
		 							<th>BST</th>
		 							<th>FIRST SK</th>
		 							<th>PBI</th>
		 							<th>PENA</th>
		 							<th>PERMAKANAN</th>
		 							<th>PKH</th>
		 							<th>RUTILAHU</th>
		 							<th>SEMBAKO ADAPTIF</th>
		 							<th>YAPI</th>
		 						</tr>
		 					</thead>
		 					<tbody>';

					foreach ($data as $key => $value) {
						$nik = !empty($value['NIK']) ? "`" . $value['NIK'] : '';
						$nokk = !empty($value['NOKK']) ? "`" . $value['NOKK'] : '';
						$html .= '<tr>
		 							<td>' . $value['Nama'] . '</td>
		 							<td>' . $nik . '</td>
		 							<td>' . $nokk . '</td>
		 							<td>' . $value['Alamat'] . '</td>
		 							<td>' . $value['provinsi'] . '</td>
		 							<td>' . $value['kabupaten'] . '</td>
		 							<td>' . $value['kecamatan'] . '</td>
		 							<td>' . $value['desa_kelurahan'] . '</td>
		 							<td>' . $value['ATENSI'] . '</td>
		 							<td>' . $value['BLT'] . '</td>
		 							<td>' . $value['BLT_BBM'] . '</td>
		 							<td>' . $value['BNPT_PPKM'] . '</td>
		 							<td>' . $value['BPNT'] . '</td>
		 							<td>' . $value['BST'] . '</td>
		 							<td>' . $value['FIRST_SK'] . '</td>
		 							<td>' . $value['PBI'] . '</td>
		 							<td>' . $value['PENA'] . '</td>
		 							<td>' . $value['PERMAKANAN'] . '</td>
		 							<td>' . $value['PKH'] . '</td>
		 							<td>' . $value['RUTILAHU'] . '</td>
		 							<td>' . $value['SEMBAKO_ADAPTIF'] . '</td>
		 							<td>' . $value['YAPI'] . '</td>
		 						</tr>';
					}
					$html .= '</tbody></table>';

					$this->generateExcel($html);
				} else {
					throw new Exception('Api key tidak sesuai');
				}
			} else {
				throw new Exception('Format tidak sesuai');
			}
		} catch (Exception $e) {
			echo json_encode([
				'status' => false,
				'message' => $e->getMessage()
			]);
			exit;
		}
	}

	function generateExcel($html = '')
	{
		header("Content-Disposition: attachment;");
		header("Content-Type: application/vnd.ms-excel");

		die($html);
	}

	function get_data_kecamatan_siks()
	{
		global $wpdb;

		try {
			if (!empty($_POST)) {
				if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

					$data = $wpdb->get_results(
						$wpdb->prepare("
							SELECT DISTINCT 
								kecno, 
								kecamatan 
							FROM `data_batas_kecamatan_siks` 
							ORDER BY kecno
						"),
						ARRAY_A
					);

					exit(json_encode(
						array(
							"status"	=> true,
							"data"		=> $data
						)
					));
				} else {
					throw new Exception('Api key tidak sesuai');
				}
			} else {
				throw new Exception('Format tidak sesuai');
			}
		} catch (Exception $e) {
			echo json_encode([
				'status' => false,
				'message' => $e->getMessage()
			]);
			exit;
		}
	}

	function get_data_desa_siks()
	{
		global $wpdb;
		try {
			if (!empty($_POST)) {
				if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option(SIKS_APIKEY)) {

					$data = $wpdb->get_results(
						$wpdb->prepare("
							SELECT 
								desa 
							FROM `data_batas_desa_siks` 
							WHERE kecamatan LIKE %s 
							ORDER BY kecno
							", $_POST['kecamatan'] . "%"),
						ARRAY_A
					);

					exit(json_encode(
						array(
							"status"	=> true,
							"data"		=> $data
						)
					));
				} else {
					throw new Exception('Api key tidak sesuai');
				}
			} else {
				throw new Exception('Format tidak sesuai');
			}
		} catch (Exception $e) {
			echo json_encode([
				'status' => false,
				'message' => $e->getMessage()
			]);
			exit;
		}
	}

	function generate_user_siks()
	{
		global $wpdb;
		$ret = array(
			'status' => 'success',
			'message' => 'Berhasil Generate User Wordpress dari DB Lokal'
		);
		if (!empty($_POST)) {
			if (!empty($_POST['api_key']) && $_POST['api_key'] == get_option('_crb_apikey_siks')) {
				$data_kecamatan = $wpdb->get_results(
					$wpdb->prepare("
						SELECT 
							*
						FROM data_alamat_siks 
						WHERE id_desa IS NULL
						  AND active = 1
					"),
					ARRAY_A
				);
				$data_desa_kel = $wpdb->get_results(
					$wpdb->prepare("
						SELECT 
							*
						FROM data_alamat_siks 
						WHERE id_desa IS NOT NULL
						  AND active = 1
					"),
					ARRAY_A
				);

				$update_pass = false;
				if (
					!empty($_POST['update_pass'])
					&& $_POST['update_pass'] == 'true'
				) {
					$update_pass = true;
				}

				if (!empty($data_kecamatan)) {
					foreach ($data_kecamatan as $k => $user) {
						$user['pass'] 			= $_POST['pass'];
						$user['loginname'] 		= $user['id_kec'];
						$user['nama'] 			= $user['nama'];
						$user['id_kecamatan'] 	= $user['id_kec'];
						$user['jabatan'] 		= 'Kecamatan';
						$this->gen_user_siks($user, $update_pass);
					}
				}

				if (!empty($data_desa_kel)) {
					foreach ($data_desa_kel as $k => $user) {
						$user['pass'] 			= $_POST['pass'];
						$user['loginname'] 		= $user['id_desa'];
						$user['nama'] 			= $user['nama'];
						$user['id_desa'] 		= $user['id_desa'];
						$user['jabatan'] 		= 'Desa';
						$this->gen_user_siks($user, $update_pass);
					}
				}
			} else {
				$ret['status'] = 'error';
				$ret['message'] = 'APIKEY tidak sesuai!';
			}
		} else {
			$ret['status'] = 'error';
			$ret['message'] = 'Format Salah!';
		}
		die(json_encode($ret));
	}

	function get_data_alamat_dtks_siks()
	{
		global $wpdb;
		$ret = array(
			'status'  => 'success',
			'message' => 'Berhasil tarik data master user!'
		);

		$data_kecamatan = $wpdb->get_results(
			$wpdb->prepare("
				SELECT 
					id_kec,
					kecamatan
				FROM data_dtks
				WHERE active = %d
				GROUP BY id_kec
			", 1),
			ARRAY_A
		);

		$data_desa_kel = $wpdb->get_results(
			$wpdb->prepare("
				SELECT 
					id_kec,
					id_desa,
					desa_kelurahan
				FROM data_dtks
				WHERE active = %d
				GROUP BY id_desa
		", 1),
			ARRAY_A
		);

		foreach ($data_kecamatan as $kecamatan) {
			$kecamatans = array(
				'id_kec'    => $kecamatan['id_kec'],
				'nama'      => $kecamatan['kecamatan'],
				'update_at' => current_time('mysql'),
				'active'    => 1
			);

			$cek_kecamatan = $wpdb->get_var(
				$wpdb->prepare("
					SELECT id
					FROM data_alamat_siks 
					WHERE id_kec = %d
				", $kecamatan['id_kec'])
			);

			if (empty($cek_kecamatan)) {
				$wpdb->insert(
					'data_alamat_siks',
					$kecamatans
				);
			} else {
				$wpdb->update(
					'data_alamat_siks',
					$kecamatans,
					array('id' => $cek_kecamatan)
				);
			}
		}

		foreach ($data_desa_kel as $desa) {
			$desas = array(
				'id_kec'    => $desa['id_kec'],
				'id_desa'   => $desa['id_desa'],
				'nama'      => $desa['desa_kelurahan'],
				'update_at' => current_time('mysql'),
				'active'    => 1
			);

			$cek_desa = $wpdb->get_var(
				$wpdb->prepare("
					SELECT id
					FROM data_alamat_siks 
					WHERE id_desa = %d
				", $desa['id_desa'])
			);

			if (empty($cek_desa)) {
				$wpdb->insert(
					'data_alamat_siks',
					$desas
				);
			} else {
				$desas_without_nama = array(
					'id_kec'    => $desa['id_kec'],
					'id_desa'   => $desa['id_desa'],
					'update_at' => current_time('mysql'),
					'active'    => 1
				);
				$wpdb->update(
					'data_alamat_siks',
					$desas_without_nama,
					array('id' => $cek_desa)
				);
			}
		}

		die(json_encode($ret));
	}



	function gen_user_siks($user = array(), $update_pass = false)
	{
		if (empty($user)) {
			return;
		}

		$username = $user['loginname'];
		$email = $user['emailteks'] ?? $username . '@sikslocal.com';
		$jabatan = strtolower($user['jabatan']);

		get_role($jabatan) ?: add_role($jabatan, $jabatan, array(
			'read' 			=> true,
			'edit_posts' 	=> false,
			'delete_posts' 	=> false,
		));

		$user_id = username_exists($username);
		if (!$user_id) {
			$user_data = array(
				'user_login' 	=> $username,
				'user_pass' 	=> $user['pass'],
				'user_email' 	=> $email,
				'first_name' 	=> $user['nama'],
				'display_name' 	=> $user['nama'],
				'role' 			=> $jabatan
			);
			$user_insert = wp_insert_user($user_data);

			if (is_wp_error($user_insert)) {
				return $user_insert;
			}
		} else {
			$user_data = array(
				'ID'          	=> $user_id,
				'user_email'  	=> $email,
				'first_name'  	=> $user['nama'],
				'display_name'	=> $user['nama']
			);
			$user_update = wp_update_user($user_data);

			if (is_wp_error($user_update)) {
				return $user_update;
			}

			$user_meta = get_userdata($user_id);
			if (!in_array($jabatan, $user_meta->roles)) {
				$user_meta->add_role($jabatan);
			}
		}

		if ($update_pass) {
			wp_set_password($user['pass'], $user_id);
		}

		$meta = array_filter(array(
			'description' => 'User dibuat dari generate sistem aplikasi WP-SIKS'
		));

		foreach ($meta as $key => $val) {
			update_user_meta($user_id, $key, $val);
		}
	}
}
