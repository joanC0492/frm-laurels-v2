<?php
/*
    Template name: insights
*/

get_header();

?>

<?php

$published_posts_count = wp_count_posts()->publish;

global $paged, $query;
$actualPage = $paged ? $paged : 1;

if (isset($_GET['posts_per_page']) && !empty($_GET['posts_per_page'])) {
    $post_per_page = $_GET['posts_per_page'];
} else {
    $post_per_page = 9;
}

$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $post_per_page,
    'orderby' => 'date',
    'order' => 'DESC',
    'paged' => $paged
);

$query = new WP_Query($args);
$maximumPage = $query->max_num_pages;

?>

<section class="insights">
    <div class="container">
        <?php get_title('Insights', 'insights_title'); ?>
        <?php if ($query->have_posts()) : ?>
            <div class="insights-list">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php get_card_article(get_the_ID()); ?>
                <?php endwhile; ?>
                <?php wp_reset_postdata();
                wp_reset_query(); ?>
            </div>

            <?php if ($maximumPage > 1) : ?>
                <div class="pagination insights-pagination">
                    <div class="pagination-nav">
                        <?php if ($actualPage != 1) : ?>
                            <a class="pagination-prev" href="<?php echo get_pagenum_link(($actualPage - 1 > 0 ? $actualPage - 1 : 1)) ?>" title="Prev">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M9 15L2 8M2 8L9 1M2 8H16" stroke="#47412E" stroke-width="1.5" />
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $maximumPage; $i++) : ?>
                            <a class="<?php echo ($i == $actualPage ? 'active ' : '') ?> pagination-button" href="<?php echo get_pagenum_link($i) ?>" title="Page <?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($actualPage != $maximumPage) : ?>
                            <a class="pagination-next" href="<?php echo get_pagenum_link(($actualPage + 1 <= $maximumPage ? $actualPage + 1 : $maximumPage)) ?>" title="Next">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M7 1L14 8M14 8L7 15M14 8L-6.11959e-07 8" stroke="#47412E" stroke-width="1.5" />
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="pagination-showing">
                        <p>
                            Showing
                            <select id="nav_posts" style="color:#400040">
                                <?php
                                // Opción mínima de $n
                                $post_per_page_options = [];

                                // Agrega los múltiplos de $n entre $n y $published_posts_count
                                for ($i = 9; $i <= $published_posts_count; $i += 9) {
                                    $post_per_page_options[] = $i;
                                }

                                // Itera sobre las opciones y genera el HTML
                                foreach ($post_per_page_options as $option_value) {
                                ?>
                                    <option style="color:#400040" value="<?php echo $option_value; ?>" <?php if ($post_per_page == $option_value) {
                                                                                                            echo 'selected';
                                                                                                        } ?>>
                                        <?php echo $option_value; ?>
                                    </option>
                                <?php
                                }
                                ?>
                                <!-- Agregar opción que muestre todos los posts -->
                                <option style="color:#400040" value="<?php echo $published_posts_count; ?>" <?php if ($post_per_page == $published_posts_count) {
                                                                                                                echo 'selected';
                                                                                                            } ?>>
                                    <?php echo $published_posts_count; ?>
                                </option>
                            </select>
                            items out of <?php echo $published_posts_count; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>

        <?php endif; ?>
    </div>
</section>

<?php get_template_part('inc/sections/get_valuation'); ?>

<?php get_footer(); ?>