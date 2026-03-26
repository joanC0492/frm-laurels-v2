<?php

get_header();

$ID = intval(get_the_ID());

?>

<main class="article">
    <section class="article_header">
        <div class="container">
            <div class="article_header-box">
                <a href="<?php echo esc_url(home_url('insights')); ?>" title="Back To Insights">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                        <path d="M15 8L0.999999 8M0.999999 8L8 15M0.999999 8L8 1" stroke="black" />
                    </svg>
                    <p>Back To Insights</p>
                </a>
                <?php if (!empty(get_field('title_post'))): ?>
                    <h1><?php echo get_field('title_post'); ?><span>.</span></h1>
                <?php else: ?>
                    <h1>Article Heading here, spanning across a few lines here<span>.</span></h1>
                <?php endif; ?>

                <?php if (!empty(get_field('min_read'))): ?>
                    <p><?php echo get_the_date('d.m.y'); ?> • <?php echo get_field('min_read'); ?> min read</p>
                <?php else: ?>
                    <p><?php echo get_the_date('d.m.y'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="article_description">
        <div class="container">
            <div class="article_description-grid">
                <?php if (!empty(get_field('title_description'))): ?>
                    <div class="article_description-title">
                        <h2><?php echo get_field('title_description'); ?></h2>
                    </div>
                <?php else: ?>
                    <div class="article_description-title">
                        <h2>Lorem ipsum dolor sit amet consectetur. Pellentesque volutpat mauris nec nunc sit. Faucibus elementum id dis elementum potenti hendrerit.</h2>
                    </div>
                <?php endif; ?>

                <div class="article_description-content">
                    <?php if (!empty(get_field('content_description'))): ?>
                        <p><?php echo get_field('content_description'); ?></p>
                    <?php endif; ?>

                    <?php if (!empty(get_field('link_section1'))): ?>
                        <a href="<?php echo get_field('link_section1')['url']; ?>" title="<?php echo get_field('link_section1')['title']; ?>">
                            <?php echo get_field('link_section1')['title']; ?>
                        </a>
                    <?php else: ?>
                        <a title="Button Text">Button Text</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <div class="article_thumbnail container">
        <?php if (!empty(get_field('image_thumb'))): ?>
            <img
                src="<?php echo get_field('image_thumb')['url'] ?>"
                title="<?php echo get_field('image_thumb')['title'] ?>"
                alt="<?php echo get_field('image_thumb')['alt'] ?>"
                width="<?php echo get_field('image_thumb')['width'] ?>"
                height="<?php echo get_field('image_thumb')['height'] ?>"
                loading="lazy">
        <?php else: ?>
            <img src="<?php echo IMG; ?>/rectangle.png">
        <?php endif; ?>

        <div class="article_thumbnail-info">
            <?php if (!empty(get_field('image_caption'))): ?>
                <p><?php echo get_field('image_caption'); ?></p>
            <?php else: ?>
                <p>Image Caption goes here • Lorem Ipsum</p>
            <?php endif; ?>

            <?php if (!empty(get_field('link_section2'))): ?>
                <a href="<?php echo get_field('link_section2')['url']; ?>" title="<?php echo get_field('link_section2')['title']; ?>">
                    <?php echo get_field('link_section2')['title']; ?>
                </a>
            <?php else: ?>
                <a title="Button Text">Button Text</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (have_rows('content_feature')): ?>
        <section class="article_information">
            <div class="container">

                <?php while (have_rows('content_feature')): the_row(); ?>
                    <div class="article_information-grid">
                        <div class="article_information-content">
                            <h3><?php echo get_sub_field('title_feature') ?? ''; ?></h3>
                            <div class="description">
                                <p><?php echo get_sub_field('description_feature') ?? ''; ?></p>
                            </div>

                            <?php if (!empty(get_sub_field('link_feature'))): ?>
                                <a href="<?php echo get_sub_field('link_feature')['url']; ?>" title="<?php echo get_sub_field('link_feature')['title']; ?>">
                                    <?php echo get_sub_field('link_feature')['title']; ?>
                                </a>
                            <?php else: ?>
                                <a title="Button Text">Button Text</a>
                            <?php endif; ?>
                        </div>
                        <div class="article_information-image">
                            <?php if (!empty(get_sub_field('image_feature'))): ?>
                                <img
                                    src="<?php echo get_sub_field('image_feature')['url'] ?>"
                                    title="<?php echo get_sub_field('image_feature')['title'] ?>"
                                    alt="<?php echo get_sub_field('image_feature')['alt'] ?>"
                                    width="<?php echo get_sub_field('image_feature')['width'] ?>"
                                    height="<?php echo get_sub_field('image_feature')['height'] ?>"
                                    loading="lazy">
                            <?php else: ?>
                                <img src="<?php echo IMG; ?>/7.png">
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>

                <div class="article_information-grid">
                    <div class="article_information-title">
                        <?php if (!empty(get_field('title_in_bottom'))): ?>
                            <h4><?php echo get_field('title_in_bottom'); ?></h4>
                        <?php else: ?>
                            <h4>Lorem ipsum dolor sit amet consectetur. Pellentesque volutpat mauris nec nunc sit. Faucibus elementum id dis elementum potenti hendrerit.</h4>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

</main>

<?php
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'post__not_in' => array($ID),
);

$query = new WP_Query($args);
?>

<?php if ($query->have_posts()) : ?>
    <section class="discover">
        <div class="container">
            <div class="animation_title">
                <h3>Discover more<span class="let">.</span></h3>
            </div>
        </div>
        <div class="discover_slider">
            <div class="splide" role="group" id="teammates">

                <div class="splide__arrows">
                    <button class="splide__arrow splide__arrow--prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                            <path d="M0 10.5H20M20 10.5L10 0.5M20 10.5L10 20.5" stroke="white" />
                        </svg>
                    </button>
                    <button class="splide__arrow splide__arrow--next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                            <path d="M0 10.5H20M20 10.5L10 0.5M20 10.5L10 20.5" stroke="white" />
                        </svg>
                    </button>
                </div>

                <div class="splide__track">
                    <ul class="splide__list">
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <li class="splide__slide">
                                <?php get_card_article(get_the_ID()); ?>
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

<?php get_template_part('inc/sections/get_valuation'); ?>

<?php get_footer(); ?>