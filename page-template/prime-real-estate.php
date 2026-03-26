<?php
/*
    Template name: prime-real-estate
*/

get_header();

?>

<section class="hero hero_center hero_state">
    <video loop muted autoplay playsinline>
        <source src="<?php echo IMG; ?>/prime_hero.mp4">
    </video>
    <div class="container">
        <div class="hero_title">
            <div class="w-100">
                <h1 class="wow animate__animated animate__fadeInUp"><?php echo get_field('title_hero_state') ?? 'Luxury Property.'; ?></h1>
            </div>
            <div class="hero_description">
                <?php if (!empty(get_field('description_hero_state'))): ?>
                    <p class="wow animate__animated animate__fadeInUp"><?php echo get_field('description_hero_state'); ?></p>
                <?php else: ?>
                    <p class="wow animate__animated animate__fadeInUp">A select approach to high value & super prime homes across London & the Home Counties.</p>
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
                <?php get_title('Prime Team', 'prime_title w-100'); ?>
            </div>
            <div class="content-col">
                <?php if (!empty(get_field('content_textual'))): ?>
                    <?php echo get_field('content_textual'); ?>
                <?php else: ?>
                    <p>
                        Vastly experienced, discreet, and professional, our Prime team specialise in the selling and letting of Prime and Super Prime properties throughout London and the Home Counties.
                        <br><br>
                        With a wealth of knowledge, your single dedicated Director will offer a truly personal service that fits around your schedule, offering unending advice and guidance.
                    </p>
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
                <div class="w-100 animation_title title1">
                    <?php if (!empty(get_field('title_cont'))): ?>
                        <h2><?php echo get_field('title_cont'); ?><span class="let">.</span></h2>
                    <?php else: ?>
                        <h2>Elite Property Consultancy<span class="let">.</span></h2>
                    <?php endif; ?>
                </div>
            </div>
            <div class="content-col">
                <?php if (!empty(get_field('description_cont'))): ?>
                    <p><?php echo get_field('description_cont'); ?></p>
                <?php else: ?>
                    <p>Our experienced Directors have long standing relationships with a wealth of HNW and UHNW clients, international brokers, buying agents and investors which provides an unparalleled international network ensuring maximum exposure for our clients’ homes.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="about_digital about_prime">
    <video loop muted autoplay playsinline>
        <source src="<?php echo IMG; ?>/primebg.mp4">
    </video>
    <div class="container about_digital-box">
        <div class="overflow about_digital-title">
            <h2>After an <b>on-site consultation</b> with our marketing team, we create a <b>bespoke marketing strategy</b> <br>that <b>shares</b> your property’s <b>defining features.</b></h2>
        </div>
        <div class="about_digital-description">
            <div class="overflow">
                <ul>
                    <li>Professional photography with state-of-the-art equipment to express your home’s unique charm</li>
                    <li>Drone photography and video footage to capture your home’s footprint, grounds, and surrounding environment.</li>
                    <li>Meticulous Room staging</li>
                    <li>Accurate RICS certified floorplans</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<div class="spacing"></div>

<section class="cta">
    <div class="container">
        <div class="cta_content">
            <div class="cta_title">
                <h3>Your home’s marketing campaign will be <b>fully edited</b> by <br><b>skilled post-production professionals</b> and developed with <b>multiple marketing channels</b> in mind for a campaign that will <b>captivate</b> your target buyer.</h3>
            </div>
            <div class="cta_description">
                <?php if (!empty(get_field('description_cta'))): ?>
                    <p><?php echo get_field('description_cta'); ?></p>
                <?php else: ?>
                    <p>To find out more about our Exclusive service, get in touch for a discreet, no obligation conversation about selling or letting your property.</p>
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