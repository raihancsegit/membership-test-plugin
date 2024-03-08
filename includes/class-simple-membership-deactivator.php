<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://raihan.website
 * @since      1.0.0
 *
 * @package    Simple_Membership
 * @subpackage Simple_Membership/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Simple_Membership
 * @subpackage Simple_Membership/includes
 * @author     Raihan Islam <raihanislam.cse@gmail.com>
 */
class Simple_Membership_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function deactivate() {
        // Call method to delete pages
        $this->delete_pages();
    }

	private function delete_pages() {
        $login_page_id = get_option('member-login_page_id');
        $register_page_id = get_option('member-register_page_id');
        $profile_page_id = get_option('member-profile_page_id');

        if ($login_page_id) {
            wp_delete_post($login_page_id, true);
            delete_option('login_page_id');
        }

        if ($register_page_id) {
            wp_delete_post($register_page_id, true);
            delete_option('register_page_id');
        }

        if ($profile_page_id) {
            wp_delete_post($profile_page_id, true);
            delete_option('profile_page_id');
        }
    }

}