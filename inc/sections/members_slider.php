<?php
$args = array(
    'post_type' => 'member',
    'posts_per_page' => -1,
    'order' => 'ASC'
);

if (is_page('partners')) {
	$args['meta_query'] = array(
        array(
            'key'     => 'show_in_partners_page',
            'value'   => '1',
            'compare' => '='
        )
    );
}

$query = new WP_Query($args);
?>

<?php if ($query->have_posts()) : ?>
    <section class="our_team <?php if (is_page('partners')){echo 'partners_page';} ?>">
        <div class="container">
            <div class="our_team-title <?php if (is_page('partners')){echo 'for_partners';} ?>">
                <?php
                if (is_page('partners')) {
                    get_title('Our Partners');
                } else {
                    get_title('Our Team');
                }
                ?>

                <div class="our_team-info">
                    <?php 
                    	if (is_page('partners')) {
                        	if (!empty(get_field('description_team_partners'))) {
                            	echo '<p>'.get_field('description_team_partners').'</p>';	
                            }
                        } else {
                        	if (!empty(get_field('description_team'))) {
                            	echo '<p>'.get_field('description_team').'</p>';	
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="our_team-slider relative">

            <a class="our_team-circle" href="<?php echo esc_url(home_url('about')) ?>#team">
                <div class="our_team-circle-front">
                    <p>MEET THE <br>TEAM</p>
                </div>
                <div class="our_team-circle-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="37" height="38" viewBox="0 0 37 38" fill="none">
                        <path d="M0 19H36M36 19L18 1M36 19L18 37" stroke="white" />
                    </svg>
                </div>
            </a>

            <div class="splide" id="teammates">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <li class="splide__slide">
                                <?php get_card_member(get_the_ID()); ?>
                            </li>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata();
                        wp_reset_query(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>