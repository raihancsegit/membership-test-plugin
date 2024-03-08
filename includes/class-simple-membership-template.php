<?php
class Simple_Membership_Template {
    public function __construct()
    {
        add_action('template_redirect',array(&$this,'simple_membership_custom_login_redirect'));
        add_action('template_redirect',array(&$this,'simple_membership_custom_profile_redirect'));
        add_action('wp_logout',array(&$this,'simple_membership_custom_logout_redirect'));
        
        add_action('init', array(&$this,'add_subscriber_edit_posts_capability'));

        
    }

    public function simple_membership_custom_login_redirect(){
        if(isset($_POST['user_login'])){
            $username = esc_sql( $_POST['username'] );
            $pass = esc_sql( $_POST['pass'] );
    
            $credentials = array(
                    'user_login' =>  $username,
                    'user_password' =>$pass,
            );
            $user = wp_signon( $credentials);
    
            if(!is_wp_error( $user )){
                if($user->roles[0] == 'adminstrator'){
                    wp_redirect( admin_url() );
                    exit;
                }
                else {
                    wp_redirect( site_url('member-profile') );
                }
                
            }else {
                echo $user->get_error_message();
            }
        }
        
    }

    public function simple_membership_custom_profile_redirect(){
        $is_user_logged_in = is_user_logged_in();
        if($is_user_logged_in && (is_page( 'member-login' ) || is_page( 'member-register' ))){
            wp_redirect( site_url('member-profile') );
            exit;
        }elseif(!$is_user_logged_in && is_page('member-profile')){
            wp_redirect( site_url('member-login') );
            exit;
        }
    }

    public function simple_membership_custom_logout_redirect(){
        wp_redirect(site_url('member-login'));
        exit;
    }

    public function add_subscriber_edit_posts_capability() {
        $subscriber_role = get_role('subscriber');
        $subscriber_role->add_cap('can_edit_posts');
    }

}
new Simple_Membership_Template();