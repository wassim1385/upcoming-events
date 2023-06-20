<?php get_header(); ?>
<div class="wj-events-archive">
    <header class="page-header">
        <h1>Past Events List</h1>
    </header>

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
                'compare' => '<',
                'value' => $today,
                'type' => 'numeric'
            )
        )
    );

    $query = new WP_Query( $args );
    ?>

    <div class="wj-events">
            <?php
                if( $query->have_posts() ) :
                    while( $query->have_posts() ) : $query->the_post();
                    $date = get_post_meta( get_the_ID(), 'wj_events_date', true );
                    $place = get_post_meta( get_the_ID(), 'wj_events_place', true );
                    $ticket = get_post_meta( get_the_ID(), 'wj_events_ticket_url', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
                    <div class="wje-container">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( array( 350, 350 ) ); endif; ?>
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
                            </div>
                        </div>
                    </div>
            </article>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;?>
    </div>
</div>
<?php get_footer(); ?>