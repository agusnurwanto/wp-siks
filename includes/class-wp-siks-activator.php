<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/agusnurwanto
 * @since      1.0.0
 *
 * @package    Wp_Siks
 * @subpackage Wp_Siks/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Siks
 * @subpackage Wp_Siks/includes
 * @author     Agus Nurwanto <agusnurwantomuslim@gmail.com>
 */
class Wp_Siks_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        if(!wp_next_scheduled('siks_conjob')){
            wp_schedule_event( time(), 'custom_min', 'siks_conjob' );
        }
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $path = SIKS_PLUGIN_PATH.'/tabel.sql';
        $sql = file_get_contents($path);
        dbDelta($sql);
	}

}
