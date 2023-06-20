<?php

/**
*Plugin Name: WJ Events
*Plugin URI: https://wordpress.org/mv-events
*Description: My plugin's description
*Version: 1.0
*Requires at least: 5.6
*Author: Wassim Jelleli
*Author URI: https://www.linkedin.com/in/wassim-jelleli/
*Text Domain: wj-events
*Domain Path: /languages
*/

if ( ! defined ( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'WJ_Events' ) ) {

    class WJ_Events {

        public function __construct() {

            $this->define_constants();
            require_once( WJ_EVENTS_PATH . 'functions/functions.php' );
            add_action( 'admin_menu', array( $this, 'add_menu' ) );
            require_once( WJ_EVENTS_PATH . 'cpt/class.wj-events-cpt.php' );
            $wj_events_cpt = new WJ_Events_Post_Type();
            require_once( WJ_EVENTS_PATH . 'shortcode/class.wj-events-shortcode.php' );
            $wj_events_shortcode = new WJ_Events_Shortcode();
            add_filter( 'archive_template', array( $this, 'load_custom_archive_template' ) );
            add_filter( 'single_template', array( $this, 'load_custom_single_template' ) );
            add_filter( 'page_template', array( $this, 'load_past_events_template' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'wj_register_scripts' ), 999 );
            require_once( WJ_EVENTS_PATH . 'class.wj-events-settings.php' );
            $wj_events_settings = new WJ_Events_Settings();
        }

        public function define_constants() {

            define( 'WJ_EVENTS_PATH', plugin_dir_path( __FILE__ ) );
            define( 'WJ_EVENTS_URL', plugin_dir_url( __FILE__ ) );
            define( 'WJ_EVENTS_VERSION', '1.0.0' );
        }

        public function load_custom_archive_template( $tpl ) {

            if( is_post_type_archive( 'wj-events' ) ) {
                $tpl = WJ_EVENTS_PATH . 'templates/archive-wj-events.php';
            }
            return $tpl;
        }

        public function load_past_events_template( $tpl ) {

            if( is_page( 'past-events' ) ) {
                $tpl = WJ_EVENTS_PATH . 'templates/page-past-events.php';
            }
            return $tpl;
        }

        public function load_custom_single_template( $tpl ) {

            if( is_singular( 'wj-events' ) ) {
                $tpl = WJ_EVENTS_PATH . 'templates/single-wj-events.php';
            }
            return $tpl;
        }

        public function add_menu() {

            add_menu_page(
                'WJ Events Options',
                'WJ Events',
                'manage_options',
                'wj_events_admin',
                array( $this, 'wj_events_settings_page' ),
                'dashicons-calendar-alt',
                100
            );
            add_submenu_page(
                'wj_events_admin',
                'Manage Events',
                'Manage Events',
                'manage_options',
                'edit.php?post_type=wj-events',
                null,
                null
            );
            add_submenu_page(
                'wj_events_admin',
                'Add New Event',
                'Add New Event',
                'manage_options',
                'post-new.php?post_type=wj-events',
                null,
                null
            );
        }

        public function wj_events_settings_page() {

            require( WJ_EVENTS_PATH . 'views/settings-page.php' );
        }

        

        public static function activate() {
            update_option( 'rewrite_rules', '' );
        }

        public static function deactivate() {
            flush_rewrite_rules();
            unregister_post_type( 'wj-events' );
        }

        public static function uninstall() {
            
        }

        public function wj_register_scripts() {

            wp_enqueue_style( 'wj-events-front-css', WJ_EVENTS_URL . 'assets/css/frontend.css', array(), WJ_EVENTS_VERSION, 'all' );
        }

    }
}

if( class_exists( 'WJ_Events' ) ) {

    register_activation_hook( __FILE__, array( 'WJ_Events', 'activate' ) );
    register_deactivation_hook( __FILE__, array( 'WJ_Events', 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( 'WJ_Events', 'uninstall' ) );

    $wj_events = new WJ_Events();
}


