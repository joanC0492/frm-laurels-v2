<?php
/*
    Template name: about
*/

get_header();

?>

<style>
    body,
    html {
        scroll-behavior: smooth;
    }

    .hero_center .hero_title h1 {
        padding-block: 1.1rem;
    }
</style>

<section class="hero hero_about hero_center">
    <video loop muted autoplay playsinline>
        <source src="<?php echo IMG; ?>/about_hero.mp4">
    </video>
    <div class="container">
        <div class="hero_title">
            <h1>It’s never been about accepting the status quo.</h1>
        </div>
    </div>
</section>

<div class="spacing first"></div>

<section class="what_makes_us">
    <div class="container">
        <div class="w-100 overflow">
            <div class="what_makes_us-tag">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="22" viewBox="0 0 12 22" fill="none">
                    <path d="M6.31686 9.48287C6.24508 9.58413 6.09543 9.7472 5.98565 9.84423C5.96032 9.76407 5.93499 9.73032 5.93499 9.69657C5.93499 9.43921 5.92232 9.18184 5.9561 8.9287C6.05321 8.241 6.09543 7.56174 5.90543 6.88248C5.79987 6.50699 5.65209 6.15259 5.42831 5.83195C5.30586 5.65475 5.1792 5.65475 5.0483 5.82351C4.99764 5.89102 4.95964 5.96696 4.92164 6.0429C4.47829 6.89936 4.3094 7.80223 4.48674 8.75994C4.60074 9.38436 4.84141 9.95393 5.19608 10.4771C5.34386 10.6965 5.39876 10.9285 5.28898 11.1817C5.11586 11.574 4.94275 11.9664 4.76119 12.3545C4.71052 12.46 4.62185 12.5444 4.55007 12.6372C4.52896 12.633 4.51207 12.633 4.49096 12.6288C4.44029 12.5106 4.37696 12.3925 4.3474 12.2702C4.12784 11.3546 3.80695 10.4771 3.32983 9.66703C3.18205 9.41811 2.96249 9.21138 2.76826 8.98777C2.68804 8.89495 2.61204 8.91605 2.56981 9.02996C2.46425 9.3042 2.30381 9.57422 2.27003 9.85689C2.20669 10.4011 2.20669 10.9538 2.19403 11.5023C2.18558 11.8567 2.28692 12.1858 2.49803 12.4685C2.86115 12.9579 3.30872 13.3545 3.87873 13.6034C4.14473 13.7173 4.21229 13.8523 4.14895 14.1308C4.07717 14.4472 4.00962 14.7636 3.93784 15.0758C3.84073 15.5062 3.74783 15.9323 3.64228 16.3584C3.62539 16.4217 3.54939 16.4723 3.50294 16.5314C3.44805 16.4807 3.36783 16.4428 3.34249 16.3795C3.27916 16.236 3.23271 16.0799 3.19471 15.9281C2.9076 14.7172 2.25736 13.7299 1.31157 12.9326C1.13423 12.7849 1.00334 12.8144 0.961115 13.038C0.902003 13.3376 0.864002 13.6413 0.817557 13.9451C0.792223 14.0843 0.771111 14.2236 0.75 14.3628L0.75 14.713C0.762667 14.7636 0.783778 14.81 0.792223 14.8564C0.944226 15.9787 1.50157 16.8225 2.50648 17.3541C2.69648 17.4553 2.90337 17.5271 3.10182 17.6114C3.33827 17.7085 3.43538 17.8857 3.42272 18.1388C3.39316 18.6746 3.37205 19.2147 3.35516 19.7547C3.34249 20.261 3.33405 20.7673 3.32983 21.2735C3.3256 21.6322 3.52405 21.8515 3.84917 21.9739C4.07717 22.0583 4.25029 21.9317 4.23762 21.687C4.22495 21.4634 4.20807 21.2356 4.20384 21.0077C4.19118 20.1808 4.17429 19.3581 4.17429 18.5312C4.17429 18.2105 4.27562 18.143 4.59229 18.1894C4.9723 18.2443 5.35653 18.2865 5.72387 18.1599C6.07432 18.0376 6.41633 17.8688 6.74567 17.6958C7.55213 17.2739 8.13903 16.6537 8.4177 15.772C8.44726 15.6834 8.46415 15.5948 8.4937 15.4808C8.32059 15.4555 8.17281 15.426 8.0208 15.4218C7.49302 15.4091 6.99901 15.5694 6.55144 15.8226C5.93499 16.1685 5.34809 16.5651 4.7443 16.9406C4.6683 16.987 4.58807 17.025 4.50785 17.063C4.38962 17.1178 4.32629 17.0672 4.31362 16.9448L4.31328 16.9407C4.30918 16.8917 4.30541 16.8465 4.31362 16.8014C4.38962 16.3753 4.46563 15.9492 4.55007 15.523C4.62185 15.1644 4.71896 15.0927 5.09053 15.0843C5.3312 15.08 5.58031 15.0885 5.81676 15.0421C6.96945 14.8269 7.86458 14.2151 8.48948 13.2237C8.64148 12.979 8.75549 12.7047 8.85682 12.4347C8.94971 12.1858 8.83571 12.0423 8.5697 12.0508C8.45148 12.055 8.32481 12.0677 8.21081 12.1014C7.02856 12.4516 5.99832 13.0465 5.20453 14.0126C5.15808 14.0675 5.07786 14.0928 5.0103 14.135C4.98919 14.0506 4.96808 13.962 4.95119 13.8776C4.94697 13.8523 4.96386 13.827 4.9723 13.8017C5.18342 13.1857 5.40298 12.5655 5.60987 11.9453C5.70276 11.6626 5.90121 11.5318 6.1841 11.5065C6.67811 11.4643 7.17634 11.4264 7.67035 11.3757C8.22348 11.3209 8.75126 11.1732 9.20305 10.8273C9.68017 10.4644 9.98418 9.97502 10.2375 9.44342C10.2755 9.36748 10.3093 9.28732 10.3304 9.20716C10.3684 9.0384 10.3051 8.94558 10.132 8.94136C9.98417 8.93714 9.83639 8.94136 9.68861 8.95824C9.00882 9.03418 8.41348 9.32108 7.86458 9.71766C7.48457 9.99612 7.09612 10.2619 6.70767 10.5277C6.65278 10.5615 6.56411 10.5488 6.49233 10.5615C6.49655 10.4855 6.47544 10.3885 6.51344 10.3336L7.70858 8.09116C7.70858 8.09116 8.03061 7.63872 8.26093 7.58583C8.66526 7.49128 9.06161 7.39168 9.46551 7.30133C9.94759 7.19349 10.397 7.03144 10.7895 6.71941C11.3482 6.27586 11.6723 5.67697 11.9129 5.02293C11.9665 4.87148 12.0647 4.69912 11.9347 4.55866C11.8089 4.41863 11.6268 4.49764 11.47 4.53681C10.5206 4.77518 9.74414 5.2729 9.14707 6.0518C9.08855 6.12642 8.96709 6.15222 8.87709 6.20243L8.90572 5.92121C8.90657 5.91282 8.91205 5.90065 8.91711 5.89269C9.33171 4.94678 9.85039 4.06236 10.4501 3.21588C11.1294 2.25451 11.4249 1.18622 11.1248 0.00641417L11.0618 4.11725e-08C10.8805 0.113013 10.6762 0.202474 10.5138 0.338612C9.64626 1.06454 9.11917 1.9481 9.19405 3.13043C9.24187 3.91136 9.08559 4.65456 8.68488 5.33895C8.53066 5.60314 8.39659 5.87787 8.24615 6.14669C8.21496 6.20288 8.14768 6.23844 8.09635 6.28411C8.06538 6.2131 8.03398 6.1463 8.01142 6.07615C8.00138 6.04968 8.01362 6.01276 8.02082 5.9838C8.09793 5.6015 8.16707 5.21414 8.24838 4.83227C8.43899 3.91869 8.33798 3.0348 7.93146 2.19191C7.82346 1.96039 7.64661 1.94663 7.49375 2.15583C7.10422 2.68869 6.84064 3.27678 6.73575 3.93191C6.56458 5.02981 6.78847 6.04071 7.39818 6.97214C7.59304 7.26763 7.55636 7.30133 7.35801 7.6169L6.31686 9.48287Z" fill="#47412E" />
                </svg>
                What makes us tick
            </div>
        </div>
        <?php if (!empty(get_field('titles_makes_us'))): ?>
            <div class="what_makes_us-titles">
                <?php echo get_field('titles_makes_us'); ?>
            </div>
        <?php else: ?>
            <div class="what_makes_us-titles">
                <h2>Our <b>ambition</b> to <b>improve</b> and <b>innovate</b> <br>the <b>inadequate standards</b><br> of estate agents.</h2>
                <h2>Our <b>ambition</b> to <b>adapt</b> to the <br><b>ever-changing landscape</b> of property <br>and it’s <b>marketing.</b></h2>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="spacing"></div>

<!-- <?php if (have_rows('item_feature')): ?>
    <div class="w-100 sticky_top feature_container">
        <?php while (have_rows('item_feature')): the_row(); ?>
            <section class="vision feature">
                <div class="container">
                    <div class="feature-grid">
                        <div class="w-100">
                            <?php
                            if (get_row_index() == 1) {
                                get_title('Our Vision', 'feature-title');
                            } elseif (get_row_index() == 2) {
                                get_title('Our Mission', 'feature-title');
                            } else {
                                get_title('Our People', 'feature-title');
                            }
                            ?>
                        </div>
                        <div class="feature_content">
                            <?php if (!empty(get_sub_field('description_item'))): ?>
                                <div class="feature_description">
                                    <?php echo get_sub_field('description_item'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="feature_images">
                                <div>
                                    <img
                                        src="<?php echo get_sub_field('image_1_feature')['url'] ?>"
                                        alt="<?php echo get_sub_field('image_1_feature')['alt'] ?>"
                                        width="<?php echo get_sub_field('image_1_feature')['width'] ?>"
                                        height="<?php echo get_sub_field('image_1_feature')['height'] ?>"
                                        loading="lazy">
                                </div>
                                <div>
                                    <img
                                        src="<?php echo get_sub_field('image_2_feature')['url'] ?>"
                                        alt="<?php echo get_sub_field('image_2_feature')['alt'] ?>"
                                        width="<?php echo get_sub_field('image_2_feature')['width'] ?>"
                                        height="<?php echo get_sub_field('image_2_feature')['height'] ?>"
                                        loading="lazy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endwhile; ?>
    </div>
<?php endif; ?> -->

<?php
$args = array(
    'post_type' => 'member',
    'posts_per_page' => -1,
    'order' => 'ASC'
);
$query = new WP_Query($args);
?>

<?php if ($query->have_posts()) : ?>
    <section class="our_team about_page" id="team">
        <div class="container">
            <div class="our_team-title">
                <?php get_title('Our Team'); ?>

                <div class="our_team-info">
                    <?php if (!empty(get_field('description_our_team'))): ?>
                        <p><?php echo get_field('description_our_team'); ?></p>
                    <?php else: ?>
                        <p>Lorem ipsum dolor sit amet consectetur. Molestie consequat cursus porttitor auctor dictumst elementum eleifend curabitur dolor. Vel eget commodo hendrerit quis senectus pretium risus. Et erat sed egestas ut tellus malesuada.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="our_team-list">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php get_card_member(get_the_ID()); ?>
                <?php endwhile; ?>
                <?php wp_reset_postdata();
                wp_reset_query(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- <?php if (have_rows('row')): ?>
    <section class="accolades">
        <div class="container">
            <?php get_title('Accolades', 'accolades_title'); ?>
            <div class="accolades_table">
                <?php while (have_rows('row')): the_row(); ?>
                    <div class="accolades_table-tr">
                        <div class="accolades_table-td">
                            <p><?php echo get_sub_field('year_row'); ?></p>
                        </div>
                        <div class="accolades_table-td">
                            <p><?php echo get_sub_field('award_row'); ?></p>
                        </div>
                        <div class="accolades_table-td">
                            <?php if (get_sub_field('state_row') != 'gold'): ?>
                            <span style="color:#000">
                            <?php else: ?>
                            <span>
                            <?php endif; ?>
                                <?php echo strtolower(get_sub_field('state_row')); ?>
                            </span>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php endif; ?> -->

<?php get_template_part('inc/sections/get_valuation'); ?>

<?php get_footer(); ?>