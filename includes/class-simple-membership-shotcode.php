<?php
class Simple_Membership_Shortcode {

    public function __construct()
    {
        add_shortcode('custom-register',array(&$this,'simple_membership_custom_register'));
        add_shortcode('custom-login',array(&$this,'simple_membership_custom_login'));
        add_shortcode('custom-profile',array(&$this,'simple_membership_custom_profile'));
    }

    public function simple_membership_custom_register(){
        ob_start();
        include 'membership/simple-membership-register.php';
        $register_template = ob_get_clean();
        return $register_template;
    }

    public function simple_membership_custom_login(){
        ob_start();
        include 'membership/simple-membership-login.php';
        $login_template = ob_get_clean();
        return $login_template;
    }

    public function simple_membership_custom_profile(){
        ob_start();
        include 'membership/simple-membership-profile.php';
        $profile_template = ob_get_clean();
        return $profile_template;
    }
}
new Simple_Membership_Shortcode;