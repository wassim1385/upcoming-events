<?php

if( ! class_exists( 'WJ_Events_Post_Type' ) ) {

    class WJ_Events_Post_Type {

        public function __construct() {

            add_action( 'init', array( $this, 'create_post_type' ) );
            add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
            add_action( 'save_post', array( $this, 'save_post' ) );
            add_filter( 'manage_wj-events_posts_columns', array($this, 'wj_events_posts_columns' ) );
            add_action( 'manage_wj-events_posts_custom_column',array( $this, 'wj_events_custom_columns' ), 10, 2 );
            add_filter( 'manage_edit-wj-events_sortable_columns', array( $this, 'wj_events_sortable_columns' ) );
        }

        public function create_post_type() {

            register_post_type(
                'wj-events',
                array(
                    'label' => 'Event',
                    'description'   => 'Events',
                    'labels' => array(
                        'name'  => 'Events',
                        'singular_name' => 'Event'
                    ),
                    'public'    => true,
                    'supports'  => array( 'title', 'editor', 'thumbnail' ),
                    'hierarchical'  => false,
                    'show_ui'   => true,
                    'show_in_menu'  => false,
                    'menu_position' => 5,
                    'show_in_admin_bar' => true,
                    'show_in_nav_menus' => true,
                    'can_export'    => true,
                    'has_archive'   => true,
                    'exclude_from_search'   => false,
                    'publicly_queryable'    => true,
                    'show_in_rest'  => false, //New Gutenberg Editor
                    'menu_icon' => 'dashicons-calendar-alt'
                )
            );
        }

        public function wj_events_posts_columns( $columns ) {

            $columns['wj_events_date'] = esc_html__( 'Event Date', 'wj-events' );
            $columns['wj_events_place'] = esc_html__( 'Event Place', 'wj-events' );
            $columns['wj_events_ticket_url'] = esc_html__( 'Event Ticket Link', 'wj-events' );
            return $columns;
        }

        public function wj_events_custom_columns( $column, $post_id ) {

            switch( $column ){
                case 'wj_events_date':
                    echo esc_html( get_post_meta( $post_id, 'wj_events_date', true ) );
                break;
                case 'wj_events_place':
                    echo esc_html( get_post_meta( $post_id, 'wj_events_place', true ) );
                break;
                case 'wj_events_ticket_url':
                    echo esc_url( get_post_meta( $post_id, 'wj_events_ticket_url', true ) );
                break;             
            }

        }

        public function wj_events_sortable_columns( $columns ) {

            $columns['wj_events_date'] = 'wj_events_date';
            return $columns;
        }

        public function add_meta_boxes() {

            add_meta_box(
                'wj_events_meta_box', // CSS ID for the metabox
                'Events Details', // Title for the metabox
                array( $this, 'add_inner_meta_boxes' ),
                'wj-events',
                'normal', //context
                'high' //priority
            );
        }

        public function add_inner_meta_boxes( $post ) {
            
            require_once( WJ_EVENTS_PATH . 'views/wj-events_metaboxes.php' );
        }

        public function save_post( $post_id ) {

            if( isset( $_POST['wj_events_nonce'] ) ){
                if( ! wp_verify_nonce( $_POST['wj_events_nonce'], 'wj_events_nonce' ) ){
                    return;
                }
            }

            if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
                return;
            }

            if( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'wj-events' ){
                if( ! current_user_can( 'edit_page', $post_id ) ){
                    return;
                }elseif( ! current_user_can( 'edit_post', $post_id ) ){
                    return;
                }
            }

            if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ) {

                $old_events_date = get_post_meta( $post_id, 'wj_events_date', true );
                $new_events_date = sanitize_text_field( $_POST['wj_events_date'] );
                $old_events_place = get_post_meta( $post_id, 'wj_events_place', true );
                $new_events_place = sanitize_text_field( $_POST['wj_events_place'] );
                $old_events_ticket_url = get_post_meta( $post_id, 'wj_events_ticket_url', true );
                $new_events_ticket_url = esc_url_raw( $_POST['wj_events_ticket_url'] );

                if( empty( $new_events_date ) ) {
                    update_post_meta( $post_id, 'wj_events_date', date("Y/m/d") );
                } else {
                    update_post_meta( $post_id, 'wj_events_date', $new_events_date, $old_events_date );
                }

                if( empty( $new_events_place  ) ) {
                    update_post_meta( $post_id, 'wj_events_place', 'Event Place' );
                } else {
                    update_post_meta( $post_id, 'wj_events_place', $new_events_place, $old_events_place );
                }

                if( empty( $new_events_ticket_url  ) ) {
                    update_post_meta( $post_id, 'wj_events_ticket_url', '#' );
                } else {
                    update_post_meta( $post_id, 'wj_events_ticket_url', $new_events_ticket_url, $old_events_ticket_url );
                }                
            }
        }
    }

}