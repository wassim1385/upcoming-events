<?php
$today = date("Y-m-d");
$args = array(
    'post_type' => 'wj-events',
    'post_status' => 'publish',
    'post__in' => $id,
    'meta_key' => 'wj_events_date',
    'orderby' => 'meta_value',
    'meta_type' => 'DATE',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'wj_events_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'DATE'
        )
    )
);

$query = new WP_Query( $args );
?>

<h3>Upcoming Events List</h3>
<div class="wj-events">
        <?php
            if( $query->have_posts() ) :
                while( $query->have_posts() ) : $query->the_post();
                $date = get_post_meta( get_the_ID(), 'wj_events_date', true );
                $place = get_post_meta( get_the_ID(), 'wj_events_place', true );
                $ticket = get_post_meta( get_the_ID(), 'wj_events_ticket_url', true );
        ?>
            <div class="wje-container">
                <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail( array( 200, 200 ) ); endif; ?>
                </a>
                <div class="event-title">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </div>
                <div class="event-description">
                    <div class="description">
                        <?php the_content(); ?>
                    </div>
                    <div class="event-meta">
                        <?php echo esc_html( $date ); ?>
                        <?php echo esc_html( $place ); ?>
                        <a href="<?php echo esc_attr( $ticket ); ?>">Buy A Ticket</a>
                    </div>
                </div>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;?>
        <div class="tc">
            <button><a href="<?php echo get_post_type_archive_link( 'wj-events' ) ?>"><?php esc_html_e( 'All Events', 'wj-events'); ?></a></button>
            <button><a href="<?php echo site_url( '/past-events' ); ?>"><?php esc_html_e( 'Our past events', 'wj-events'); ?></a></button>
        </div>
</div>