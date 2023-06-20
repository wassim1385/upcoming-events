<?php

if( ! class_exists( 'class WJ_Events_Shortcode ' ) ) {

    class WJ_Events_Shortcode {
    
        public function __construct() {

            add_shortcode( 'wj_events', array( $this, 'add_shortcode' ) );
        }

        public function add_shortcode( $atts = array(), $content = null, $tag ='' ) {

            $atts = array_change_key_case( (array) $atts, CASE_LOWER );
            extract( shortcode_atts(
                array(
                    'id' => ''/* ,
                    'oder_by' => 'date' */
                ),
                $atts,
                $tag
            ) );

            if( !empty( $id ) ){
                $id = array_map( 'absint', explode( ',', $id ) );
            }
            
            ob_start();
            require( WJ_EVENTS_PATH . 'views/wj-events_shortcode.php' );
            return ob_get_clean();
        }
    }

}
