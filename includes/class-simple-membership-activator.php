<?php
/**
 * Fired during plugin activation
 *
 * @link       https://raihan.website
 * @since      1.0.0
 *
 * @package    Simple_Membership
 * @subpackage Simple_Membership/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Simple_Membership
 * @subpackage Simple_Membership/includes
 * @author     Raihan Islam <raihanislam.cse@gmail.com>
 */
class Simple_Membership_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	
    public function activate() {
        // Call method to create pages
        $this->create_pages();
    }

	private function create_pages() {
        // Create login page
        $this->create_page('Member Login', 'member-login', '[custom-login]');

        // Create register page
        $this->create_page('Member Register', 'member-register', '[custom-register]');

        // Create profile page
        $this->create_page('Member Profile', 'member-profile', '[custom-profile]');
    }

	private function create_page($title, $slug, $content) {
        $page = get_page_by_title($title);

        if (!$page) {
            $page_id = wp_insert_post(array(
                'post_title'    => $title,
                'post_content'  => $content,
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $slug,
            ));

            if (!is_wp_error($page_id)) {
                update_option($slug . '_page_id', $page_id);
            }
        }
    }

}