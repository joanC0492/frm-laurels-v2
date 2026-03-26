<?php
/*
    Template name: content
*/

get_header();

?>

<section class="content-terms">
    <div class="container">
        <h1><?php the_title(); ?><span>.</span></h1>
        <div class="content-terms-box">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<?php get_template_part('inc/sections/get_valuation'); ?>

<?php get_footer(); ?>