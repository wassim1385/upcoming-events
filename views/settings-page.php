<div class="wrap">
    <h1><?php esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
        <?php
            settings_fields( 'wj_events_group' );
            do_settings_sections( 'wj_events_page1' );
        ?>
    </form>
</div>