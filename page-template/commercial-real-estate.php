<?php
/*
    Template name: commercial-real-estate
*/

get_header();

?>

<section class="hero hero_center hero_state">
    <video loop muted autoplay playsinline>
        <source src="<?php echo IMG; ?>/commercial_hero.mp4">
    </video>
    <div class="container">
        <div class="hero_title">
            <div class="w-100">
                <h1 class="wow animate__animated animate__fadeInUp"><?php echo get_field('title_hero_state') ?? 'Commercial Property.'; ?></h1>
            </div>
            <div class="hero_description">
                <?php if (!empty(get_field('description_hero_state'))): ?>
                    <p class="wow animate__animated animate__fadeInUp"><?php echo get_field('description_hero_state'); ?></p>
                <?php else: ?>
                    <p class="wow animate__animated animate__fadeInUp">A dedicated commercial service for property in London & the Home Counties.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="spacing first"></div>

<section class="content prime">
    <div class="container">
        <div class="content_row">
            <div class="content-col">
                <div class="w-100 animation_title no_flex prime_title">
                    <h2>Effortless Commercial Solutions<span class="let">.</span></h2>
                </div>
            </div>
            <div class="content-col">
                <?php if (!empty(get_field('content_textual'))): ?>
                    <?php echo get_field('content_textual'); ?>
                <?php else: ?>
                    <p>
                        With access to high quality properties across London and the Home Counties, we help make the business of finding the perfect office, workplace easier all-round, whether it’s for now or forever.
                        <br><br>
                        Our relocation services include:
                    </p>
                    <ul>
                        <li>Long term corporate tenancies</li>
                        <li>Property purchases</li>
                        <li>Film location contracts</li>
                        <li>Office relocations</li>
                        <li>Bespoke searches</li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php if (have_rows('images_showcases')): ?>
    <section class="showcase">
        <div class="container">
            <div class="showcase_images">
                <?php while (have_rows('images_showcases')): the_row(); ?>
                    <?php if (!empty(get_sub_field('image_show_item'))): ?>
                        <div>
                            <img
                                src="<?php echo get_sub_field('image_show_item')['url'] ?>"
                                title="<?php echo get_sub_field('image_show_item')['title'] ?>"
                                alt="<?php echo get_sub_field('image_show_item')['alt'] ?>"
                                width="<?php echo get_sub_field('image_show_item')['width'] ?>"
                                height="<?php echo get_sub_field('image_show_item')['height'] ?>"
                                loading="lazy">
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="showcase">
        <div class="container">
            <div class="showcase_images">
                <div>
                    <img src="<?php echo IMG; ?>/prime/1.png">
                </div>
                <div>
                    <img src="<?php echo IMG; ?>/prime/2.png">
                </div>
                <div>
                    <img src="<?php echo IMG; ?>/prime/3.png">
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="content prime2">
    <div class="container">
        <div class="content_row">
            <div class="content-col">
                <div class="w-100 animation_title no_flex title1">
                    <?php if (!empty(get_field('title_cont'))): ?>
                        <h2><?php echo get_field('title_cont'); ?><span class="let">.</span></h2>
                    <?php else: ?>
                        <h2>Corporate relocation services<span class="let">.</span></h2>
                    <?php endif; ?>
                </div>
            </div>
            <div class="content-col">
                <?php if (!empty(get_field('description_cont'))): ?>
                    <p><?php echo get_field('description_cont'); ?></p>
                <?php else: ?>
                    <p>Our dedicated corporate relocation service captures service with the highest interest for your talent. Covering sales, lettings and short-lets, we save you and your team valuable time with our whole-market coverage. This means that even if a property isn’t on our books, we can act on your behalf to secure it for you.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="about_digital about_prime">
    <video loop muted autoplay playsinline>
        <source src="<?php echo IMG; ?>/about.mp4">
    </video>
    <div class="container about_digital-box">
        <div class="overflow about_digital-title">
            <h4>A <b>single point</b> of <b>contact</b>.</h4>
        </div>
        <div class="about_digital-description">
            <div class="overflow">
                <p>
                    Having a dedicated contact makes for an easier, more satisfying way to do business. Your contact will work with you to understand your brief and give you market-leading advice along the way. They will present and recommend ideal properties and schedule remote and in-person viewings. They’ll also be on hand to help with negotiation, due diligence and moving arrangements.
                    <br><br>
                    The option for additional relocation services such as removals, furnishing and insurance can also be instructed through our quality vetted and verified network.
                </p>
            </div>
        </div>
    </div>
</section>

<div class="spacing"></div>

<section class="cta">
    <div class="container">
        <div class="cta_content">
            <div class="cta_title">
                <h2>Sellers & Landlords<b>.</b></h2>
            </div>
            <div class="cta_txt">
                <?php if (!empty(get_field('description_cta'))): ?>
                    <p><?php echo get_field('description_cta'); ?></p>
                <?php else: ?>
                    <p>Our relationships with corporate clients around the world give us access to a pool of buyers and tenants looking for quality, long-lets in London and <br>the Home Counties.</p>
                <?php endif; ?>
            </div>
            <div class="cta_actions">
                <a href="<?php echo esc_url(home_url('get-in-touch')) ?>" title="Get In Touch">Get In Touch</a>
            </div>
        </div>
    </div>
</section>

<?php get_template_part('inc/sections/get_valuation'); ?>

<?php get_footer(); ?>