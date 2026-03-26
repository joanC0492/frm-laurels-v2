<?php
$args = array(
    'post_type' => 'successful_property',
    'posts_per_page' => 6,
    'order' => 'ASC'
);
$query = new WP_Query($args);
?>
    
<style>.successes .apartment_card-info{flex-direction:column;}</style>

<?php if ($query->have_posts()) : ?>
    <section class="successes">
        <div class="container">
            <?php get_title('Successes', 'successes_title'); ?>
        </div>
        <div class="successes_box">
            <div class="splide" role="group" id="apartments">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <?php
                                echo '<li class="splide__slide">'; 
                                get_property_card(get_the_ID());
                                echo '</li>'; 
                            ?>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata();
                        wp_reset_query(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>