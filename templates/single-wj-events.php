<?php get_header(); ?>
<div class="wj-events-single">
    <header class="entry-header">
        <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
    </header>
    <div class="wj-events">
        <ul class="events">
            <?php
                while( have_posts() ) : the_post();
                $date = get_post_meta( get_the_ID(), 'wj_events_date', true );
                $place = get_post_meta( get_the_ID(), 'wj_events_place', true );
                $ticket = get_post_meta( get_the_ID(), 'wj_events_ticket_url', true );
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
                <div class="wje-container">
                    <div class="event-description">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'full' ); endif; ?>
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
            </article>
            <?php endwhile; ?>
        </ul>
    </div>

<?php get_footer(); ?>