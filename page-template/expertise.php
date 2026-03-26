<?php
/*
    Template name: expertise
*/

get_header();

?>

<section class="hero hero_expertise hero_center">
    <video loop muted autoplay playsinline>
        <source src="<?php echo IMG; ?>/expertise_hero.mp4">
    </video>
    <div class="container">
        <div class="hero_title">
            <h1 class="wow animate__animated animate__fadeInUp">Our Expertise.</h1>
        </div>
    </div>
</section>

<div class="spacing first"></div>

<?php if (have_rows('processes')): ?>
    <section class="process">
        <div class="container">
            <h2>Our Process<span>.</span></h2>
            <div class="process_timeline">

                <?php while (have_rows('processes')): the_row(); ?>
                    <div class="process_item">
                        <div></div>
                        <div class="process_item-div">
                            <?php if (!empty(get_sub_field('title_process'))): ?>
                                <div class="process_item-title">
                                    <h3>
                                        <span>0<?php echo get_row_index(); ?></span>
                                        <?php echo get_sub_field('title_process'); ?>
                                    </h3>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty(get_sub_field('title_process'))): ?>
                                <div class="process_item-description">
                                    <p><?php echo get_sub_field('description_process'); ?></p>
                                </div>
                            <?php else: ?>
                                <div class="process_item-description">
                                    <p>Booking a valuation can be daunting as it’s the first step of your selling journey. Whether you’re looking to sell imminently or within the next year, we are here to offer reliable advice and an honest figure. At Laurels, we take this opportunity to get to know you and of course your property. It is important for us to understand your current situation, so we can set you up on your property journey and ensure the process is as smooth as possible.</p>
                                </div>
                            <?php endif; ?>

                            <div class="process_item-actions">
                                <?php if (!empty(get_sub_field('description_in_bottom_process'))): ?>
                                    <p><?php echo get_sub_field('description_in_bottom_process'); ?></p>
                                <?php endif; ?>

                                <?php if (!empty(get_sub_field('button_in_bottom'))): ?>
                                    <a href="<?php echo get_sub_field('button_in_bottom')['url'] ?>" class="btn" title="<?php echo get_sub_field('button_in_bottom')['title'] ?>">
                                        <?php echo get_sub_field('button_in_bottom')['title'] ?>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty(get_sub_field('link_url_in_bottom'))): ?>
                                    <a href="<?php echo get_sub_field('link_url_in_bottom'); ?>" target="_blank">
                                        <?php echo get_sub_field('link_text_in_bottom') ?? 'Text Button'; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="content">
    <div class="container">
        <div class="content_row">
            <div class="content-col">
                <div class="w-100 title1">
                    <?php if (!empty(get_field('title_content_1'))): ?>
                        <h2><?php echo get_field('title_content_1'); ?><span>.</span></h2>
                    <?php else: ?>
                        <h2>Personalised & Proactive Service<span>.</span></h2>
                    <?php endif; ?>
                </div>
            </div>
            <div class="content-col wow animate__animated animate__fadeIn">
                <?php if (!empty(get_field('content_content_1'))): ?>
                    <?php echo get_field('content_content_1'); ?>
                <?php else: ?>
                    <p>There aren’t separate offices between sales and lettings, in fact it’s the same person. With a dedicated point of contact, you’ll have an expert consultant by your side throughout, with comprehensive feedback and support to bring a guiding light into your property journey. Our support encompasses:</p>
                    <ul>
                        <li>Accompanied viewings</li>
                        <li>7-day service, 362 days a year, available weekends, evenings and bank holidays</li>
                        <li>Complete offer negotiations</li>
                        <li>In-house sales progression team</li>
                        <li>No sale, no fee.</li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container">
        <div class="content_row">
            <div class="content-col">
                <div class="w-100 title2">
                    <?php if (!empty(get_field('title_content_2'))): ?>
                        <h2><?php echo get_field('title_content_2'); ?><span>.</span></h2>
                    <?php else: ?>
                        <h2>Contacts You Can Count On<span>.</span></h2>
                    <?php endif; ?>
                </div>
            </div>
            <div class="content-col wow animate__animated animate__fadeIn">
                <?php if (!empty(get_field('content_content_2'))): ?>
                    <?php echo get_field('content_content_2'); ?>
                <?php else: ?>
                    <p>With our curated network of fully verified and vetted suppliers, we can offer you a full package of experts dedicated to each process involved in the home selling journey. We work closely with:</p>
                    <ul>
                        <li>Mortgage advisors</li>
                        <li>Conveyancers</li>
                        <li>Surveyors</li>
                        <li>Removal Firms</li>
                        <li>Home Stylists and Interior Decorators</li>
                    </ul>
                <?php endif; ?>
                <a href="<?php echo esc_url(home_url('get-in-touch')) ?>" title="Talk To Our Experts">Talk To Our Experts</a>
            </div>
        </div>
    </div>
</section>

<section class="our_specialism">
    <div class="container">
        <?php get_title('Our Specialisms', 'our_specialism_title'); ?>
        <div class="our_specialism-grid">
            <a class="our_specialism-item hover_video" href="<?php echo esc_url(home_url('prime-real-estate')) ?>" title="Prime Real Estate">
                <div class="our_specialism-video">
                    <video width="320" height="280" poster="<?php echo IMG; ?>/prime_image.webp" muted playsinline>
                        <source src="<?php echo IMG; ?>/1.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="our_specialism-info">
                    <div class="toUp">
                        <h3>Prime Real Estate</h3>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="22" viewBox="0 0 21 22" fill="none">
                                <path d="M0 11H20M20 11L10 1M20 11L10 21" stroke="white" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            <a class="our_specialism-item hover_video" href="<?php echo esc_url(home_url('commercial-real-estate')) ?>" title="Commercial Real Estate">
                <div class="our_specialism-video">
                    <video width="320" height="280" poster="<?php echo IMG; ?>/commercial_image.webp" muted playsinline>
                        <source src="<?php echo IMG; ?>/2.mp4" type="video/mp4">
                    </video>
                </div>
                <div class="our_specialism-info">
                    <div class="toUp">
                        <h3>Commercial Real Estate</h3>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="22" viewBox="0 0 21 22" fill="none">
                                <path d="M0 11H20M20 11L10 1M20 11L10 21" stroke="white" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<?php get_template_part('inc/sections/get_valuation'); ?>

<?php get_footer(); ?>