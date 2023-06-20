<?php

if( ! class_exists( 'WJ_Events_Settings' ) ) {

    class WJ_Events_Settings{

        public static $options;

        public function __construct() {

            self::$options = get_option( 'wj_events_options' );
            add_action( 'admin_init', array( $this, 'admin_init' ) );
        }

        public function admin_init() {

            register_setting( 'wj_events_group', 'wj_events_options' );
            
            add_settings_section(
                'wj_events_main_section',
                'How does it work?',
                null,
                'wj_events_page1'
            );
            
            add_settings_field(
                'wj_events_shortcode',
                'Shortcode',
                array( $this, 'wj_shortcode_callback' ),
                'wj_events_page1',
                'wj_events_main_section',
            );
        }

        public function wj_shortcode_callback() {
            ?>
                <span>Use the shortcode [wj_events] to display events in any page/post/widget</span>
            <?php
        }
    }

}



?>