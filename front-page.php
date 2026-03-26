<?php
/*
    Template name: homepage
*/

get_header();
?>

<section class="hero hero_frontpage">
    <div class="wh-100 absolute hero_frontpage-container">
        <img src="<?php echo IMG; ?>/laurels-poster.webp" loading="lazy">
    </div>
    <div class="container">
        <div class="hero_title">
            <div class="w-100">
                <?php if (!empty(get_field('title_hero'))): ?>
                    <h1><?php echo get_field('title_hero'); ?></h1>
                <?php else: ?>
                    <h1>Discover Your Property’s True Value.</h1>
                <?php endif; ?>
            </div>
            <div class="hero_description">
                <?php if (!empty(get_field('description_hero'))): ?>
                    <p><?php echo get_field('description_hero'); ?></p>
                <?php else: ?>
                    <p>Expert Valuations and sales for Residential and Commercial Properties</p>
                <?php endif; ?>
            </div>
            <div class="hero_title-actions">
                <?php if (!empty(get_field('button_1_hero'))): ?>
                    <a href="<?php echo get_field('button_1_hero')['url']; ?>" title="<?php echo get_field('button_1_hero')['title']; ?>"><?php echo get_field('button_1_hero')['title']; ?></a>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('get-in-touch')) ?>?valuation" title="Book a Valuation" target="_blank">Book a Valuation</a>
                <?php endif; ?>

                <?php if (!empty(get_field('button_2_hero'))): ?>
                    <a href="<?php echo get_field('button_2_hero')['url']; ?>" title="<?php echo get_field('button_2_hero')['title']; ?>" target="<?php echo get_field('button_2_hero')['target']; ?>"><?php echo get_field('button_2_hero')['title']; ?></a>
                <?php else: ?>
                    <a href="<?php echo esc_url(home_url('for-sale')) ?>" title="Explore Our Listings">Explore Our Listings</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div class="spacing first"></div>

<?php get_template_part('inc/sections/successes_slider'); ?>

<?php get_template_part('inc/sections/stats'); ?>

<section class="our_day_challenge">
    <div class="container">
        <div class="our_day_challenge_grid">
            <div class="our_day_challenge-title w-100">
                <div class="animation_title our_day_challenge-title no_flex">
                    <h2>Our 25 Day Challenge<span class="let">.<svg xmlns="http://www.w3.org/2000/svg" width="138" height="112" viewBox="0 0 138 112" fill="none">
                                <path d="M79.6672 56.3957C79.3389 56.146 78.9326 55.9587 78.5949 55.7292C75.0323 53.2504 71.1738 51.8413 66.7589 52.1203C65.0607 52.2238 63.3484 52.1977 61.6361 52.1715C61.1252 52.1576 60.6469 51.9126 60.1422 51.7784C60.1483 51.6582 60.1342 51.5286 60.12 51.399C60.5619 51.135 60.9506 50.7726 61.416 50.6179C65.1022 49.4614 68.7992 48.3347 72.5166 47.2173C73.7755 46.8375 74.9443 47.0808 75.945 48.0097C77.1114 49.1134 78.3262 50.1656 79.463 51.2802C82.4494 54.2073 85.8321 56.3817 90.0666 57.0287C92.9932 57.4668 95.8692 57.2662 98.7025 56.3567C100.169 55.9004 100.322 55.3554 99.2757 54.2579C98.6752 53.6365 98.0748 53.0152 97.4446 52.4048C95.2853 50.3019 92.8014 48.6895 89.8636 47.9016C87.8446 47.365 85.7695 46.9501 83.7318 46.4541C83.449 46.3729 83.1833 46.2012 82.7363 45.9952C83.1672 45.7015 83.4404 45.4829 83.7262 45.3438C84.6836 44.9235 85.6738 44.5922 86.5999 44.1329C88.6581 43.0878 90.5956 43.2668 92.5151 44.4469C95.0474 46.0078 97.821 46.6708 100.741 46.909C106.432 47.3901 111.616 46.1365 116.07 42.4049C117.278 41.3865 117.184 40.6291 115.737 40.1345C112.033 38.8706 108.267 38.1688 104.339 38.9427C103.155 39.1601 101.958 39.2978 100.751 39.4058C100.362 39.4481 99.9365 39.3014 99.5146 39.2547C99.4911 39.1454 99.4379 39.047 99.405 38.958C99.7047 38.6284 99.9512 38.2005 100.324 37.9787C102.453 36.6212 104.603 35.323 106.762 34.0046C107.832 33.3407 108.985 33.0843 110.23 33.2152C112.419 33.4364 114.577 33.6185 116.757 33.86C119.358 34.1483 121.889 34.1086 124.393 33.2195C127.955 31.9569 130.609 29.5125 132.939 26.648C133.468 25.9811 134.257 25.2861 133.847 24.3586C133.457 23.4405 132.409 23.5236 131.555 23.4504C126.387 23.0129 121.64 24.1727 117.309 27.0501C116.887 27.3234 116.234 27.244 115.696 27.3409L116.323 25.9807C116.342 25.9401 116.39 25.8885 116.43 25.8573C120.134 21.8292 124.253 18.2882 128.714 15.0766C133.772 11.4261 137.089 6.57984 137.613 0.150902L137.308 0.0104399C136.206 0.26524 135.028 0.362346 133.98 0.765478C128.384 2.91239 124.223 6.43465 122.566 12.4891C121.463 16.4853 119.402 19.9415 116.217 22.6828C114.99 23.7418 113.846 24.8882 112.63 25.9769C112.377 26.2049 111.979 26.2675 111.643 26.4081C111.61 25.999 111.567 25.6102 111.575 25.2198C111.57 25.0699 111.695 24.9059 111.781 24.7732C112.824 22.9896 113.837 21.1671 114.901 19.3929C117.427 15.1418 118.44 10.5382 117.851 5.61486C117.708 4.26886 116.845 3.89586 115.72 4.68159C112.851 6.68261 110.519 9.17694 108.867 12.2801C106.122 17.4885 105.506 22.9399 106.961 28.6563C107.43 30.4722 107.274 30.9173 105.651 31.8187C101.523 34.1495 97.3515 36.4116 93.2008 38.6831C92.8463 38.8644 92.4589 38.9566 92.0809 39.0285C91.8716 39.0551 91.6168 38.9131 91.3949 38.86C91.4588 38.6679 91.4711 38.4275 91.5959 38.2635C92.356 37.3092 93.0847 36.3159 93.9573 35.4381C96.0709 33.3108 97.775 30.8962 99.0288 28.1757C100.17 25.6989 100.816 23.0675 101.2 20.3644C101.298 19.6711 101.593 18.8715 100.875 18.3439C100.178 17.8257 99.4172 18.1397 98.705 18.4022C98.5863 18.446 98.4582 18.51 98.3302 18.5741C92.824 21.6485 89.0548 26.1388 87.5508 32.2885C87.0027 34.5466 86.8891 36.9311 86.6536 39.2594C86.4846 40.8553 86.1555 41.5159 84.7763 41.8894C81.7305 42.7256 78.6644 43.5524 75.5747 44.2699C74.6313 44.4997 73.6172 44.4016 72.6283 44.4627C72.5548 44.355 72.511 44.2363 72.4578 44.138C73.0227 43.3399 73.5453 42.4731 74.1821 41.7328C75.8132 39.8507 77.4755 38.0077 79.1784 36.1834C81.704 33.4829 83.4152 30.3579 84.048 26.6866C84.303 25.278 83.8496 24.8722 82.4656 25.0958C79.2289 25.5978 76.5603 27.2725 74.031 29.2328C71.1691 31.4337 69.3999 34.3105 68.8639 37.8787C68.6168 39.5371 68.5308 41.2204 68.3041 42.8882C68.1287 44.2842 67.3061 45.1605 65.9472 45.5434C63.4278 46.2529 60.9287 46.9718 58.4076 47.6314C57.9906 47.7346 57.5046 47.5598 57.053 47.524C57.1682 47.0602 57.1396 46.4809 57.4096 46.1623C58.6816 44.6317 59.9537 43.101 61.3805 41.7156C64.1669 39.0369 66.0156 35.8275 66.8358 32.0703C67.1066 30.8413 67.2461 29.5764 67.256 28.3256C67.2504 27.2154 66.6767 26.8033 65.6397 27.2361C64.2762 27.7892 62.9473 28.4813 61.7325 29.2998C60.5567 30.0871 59.5593 31.1289 58.468 32.0536C56.237 33.9545 54.7923 36.3409 54.2948 39.2377C53.8005 42.2343 53.4265 45.2373 53.0119 48.2214C52.8814 49.1459 52.5259 49.9174 51.7201 50.3829C48.2129 52.4341 44.6853 54.4758 41.1561 56.4677C40.5862 56.7957 39.8769 56.8381 39.1334 57.0615C39.1893 56.6196 39.1422 56.401 39.2171 56.2386C39.7879 55.0002 40.2977 53.7336 41.0216 52.5904C43.0141 49.4965 44.7237 46.3215 45.3159 42.6315C45.6407 40.5905 45.7155 38.5574 45.3498 36.5181C45.1536 35.3939 44.544 35.1129 43.5399 35.6347C43.1464 35.8472 42.7951 36.1284 42.4438 36.4095C38.411 39.5476 35.5959 43.5177 34.3252 48.5196C33.489 51.7771 33.384 55.0517 33.9304 58.3558C34.155 59.7392 33.9045 60.9776 32.8148 61.9522C31.1116 63.4564 29.4084 64.9606 27.6739 66.4257C27.1961 66.8209 26.5823 67.0303 26.0311 67.3177C25.9388 67.2506 25.8575 67.2132 25.7653 67.146C25.7835 66.4652 25.7407 65.7563 25.8698 65.102C26.8437 60.2095 27.2458 55.2749 26.7464 50.3188C26.5873 48.7932 25.9892 47.3115 25.5505 45.8047C25.3703 45.1801 24.9578 45.1131 24.502 45.5676C23.3859 46.6531 22.0149 47.5966 21.2255 48.882C19.7137 51.3605 18.4879 54.0201 17.2106 56.6312C16.384 58.3179 16.1418 60.1262 16.5308 61.9547C17.1927 65.115 18.4669 68.016 20.6578 70.478C21.6852 71.6161 21.7108 72.4156 20.7885 73.6151C19.7413 74.9786 18.7145 76.3514 17.6767 77.6946C16.255 79.55 14.8629 81.3945 13.4099 83.2109C13.1883 83.478 12.7103 83.5531 12.3558 83.7343C12.204 83.3689 11.9021 83.0083 11.9206 82.6476C11.9339 81.8169 12.0566 80.9627 12.2106 80.1475C13.5144 73.684 12.5749 67.4912 9.79215 61.5566C9.26628 60.4527 8.57093 60.3045 7.87183 61.2869C6.92305 62.5972 6.06649 63.9747 5.1693 65.3335C4.73861 65.9473 4.32824 66.5704 3.91788 67.1936L3.14126 68.8786C3.08993 69.1504 3.08859 69.4205 3.0263 69.6626C1.26883 75.4 2.07944 80.6965 5.73617 85.4833C6.42591 86.3919 7.26243 87.1959 8.03024 88.0421C8.95284 89.0334 9.02716 90.1015 8.4048 91.2915C7.07425 93.8043 5.77498 96.3562 4.49603 98.9174C3.31226 101.326 2.1488 103.743 1.00566 106.17C0.190006 107.886 0.6584 109.382 1.95154 110.692C2.86157 111.604 3.97532 111.379 4.45706 110.173C4.89202 109.069 5.31602 107.935 5.80097 106.829C7.57396 102.822 9.31727 98.8257 11.1512 94.8464C11.8623 93.3035 12.4997 93.2034 13.9206 94.129C15.6276 95.2357 17.383 96.2909 19.4313 96.4965C21.3891 96.685 23.4091 96.6314 25.3775 96.5294C30.194 96.2877 34.3936 94.6049 37.6902 90.9798C38.0289 90.619 38.3067 90.2301 38.7016 89.7475C37.9247 89.2418 37.279 88.7719 36.5569 88.4145C34.0453 87.1831 31.3125 86.8589 28.5974 87.0845C24.8637 87.3821 21.1599 87.9889 17.4217 88.4567C16.953 88.5114 16.4828 88.5163 16.0125 88.5211C15.322 88.5228 15.1295 88.1387 15.3399 87.5218C15.4319 87.2689 15.5145 87.0362 15.658 86.8316C16.9688 84.9496 18.2796 83.0676 19.631 81.2044C20.7717 79.6379 21.3981 79.5082 23.2048 80.2916C24.3723 80.8051 25.5523 81.3981 26.7931 81.6992C32.8171 83.2202 38.4812 82.2616 43.6872 78.8765C44.9613 78.0361 46.1181 76.9693 47.2046 75.8947C48.2036 74.9029 47.9732 73.9598 46.6744 73.4104C46.0961 73.1685 45.4585 72.9485 44.8351 72.8581C38.3694 71.9212 32.0925 72.499 26.13 75.3877C25.7849 75.5486 25.3427 75.4925 24.924 75.5457C25.0096 75.0928 25.1045 74.6197 25.2103 74.1762C25.2462 74.045 25.3836 73.9606 25.4804 73.8575C27.8624 71.3616 30.2944 68.8642 32.6654 66.3386C33.7393 65.1844 34.9843 64.9951 36.4018 65.5007C38.8725 66.3933 41.3543 67.3155 43.8438 68.1675C46.6271 69.1303 49.4943 69.5902 52.4356 68.9274C55.5362 68.2396 58.0845 66.5588 60.4826 64.5625C60.8338 64.2814 61.1742 63.9706 61.4535 63.6316C62.0107 62.9038 61.9118 62.3167 61.0881 61.9125C60.3863 61.5644 59.6658 61.257 58.9173 61.0105C55.4776 59.8683 51.9765 59.9285 48.4556 60.6195C46.0095 61.1167 43.5507 61.5342 41.092 61.9517C40.753 61.9924 40.3544 61.7349 39.9809 61.6366C40.1697 61.2805 40.2833 60.7668 40.5878 60.5871C44.5698 58.3609 48.5535 56.1848 52.5481 54.0382C53.3351 53.6133 54.1195 53.7287 54.8887 54.3047C56.7443 55.6768 58.5515 57.1005 60.521 58.279C65.5417 61.2821 70.8463 61.9054 76.3423 59.7616C77.4793 59.3257 78.5709 58.7211 79.6108 58.0681C80.3963 57.5932 80.3145 56.9156 79.6672 56.3957Z" fill="#9B8329" />
                            </svg></span></h2>
                </div>
            </div>
            <div class="w-100 our_day_challenge-info">
                <?php if (!empty(get_field('description_challenge'))): ?>
                    <p><?php echo get_field('description_challenge'); ?></p>
                <?php else: ?>
                    <p>
                        Laurels specialises in selling properties that have previously been unsuccessful with other agents. Our approach, attitude and advertising is where we differ and this is how we achieve a successful sale in under 25 days!
                        <br><br>
                        Book your free valuation below to find out how we will sell your property in under 25 days!
                    </p>
                <?php endif; ?>

                <a href="<?php echo esc_url(home_url('get-in-touch')) ?>?valuation" title="Book a Valuation" target="_blank">Book A Valuation</a>
            </div>
        </div>
    </div>
</section>

<?php get_template_part('inc/sections/instant'); ?>

<div class="w-100 sticky_top">
    <?php get_template_part('inc/sections/about_digital'); ?>
    <div class="spacing second"></div>
    <!-- <?php get_template_part('inc/sections/members_slider'); ?> -->


    <?php if (have_rows('comments')): ?>
        <section class="our_clients">
            <div class="container">
                <div class="our_clients-title">
                    <?php get_title('From Our Clients', 'successes_title'); ?>
                    <div class="our_clients-sign">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 10" fill="none">
                            <path d="M5 1L1 5M1 5L5 9M1 5H21" stroke="black" stroke-linecap="round" />
                        </svg>
                        <p>DRAG</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 10" fill="none">
                            <path d="M17 1L21 5M21 5L17 9M21 5H1" stroke="black" stroke-linecap="round" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="our_clients-slider">
                <div class="splide" role="group" id="clients">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php while (have_rows('comments')): the_row(); ?>
                                <li class="splide__slide">
                                    <div class="comment">
                                        <div class="comment-info">
                                            <?php if (!empty(get_sub_field('number_of_stars'))): ?>
                                                <div class="stars">
                                                    <?php for ($i = 0; $i < intval(get_sub_field('number_of_stars')); $i++): ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" viewBox="0 0 20 19" fill="none">
                                                            <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="#9B8329" />
                                                        </svg>
                                                    <?php endfor; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="stars" style="opacity:0;pointer-events:none;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" viewBox="0 0 20 19" fill="none">
                                                        <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="#9B8329" />
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <h5><?php echo get_sub_field('title_comment'); ?></h5>
                                            <p><?php echo get_sub_field('description_comment'); ?></p>
                                        </div>

                                        <?php if (!empty(get_sub_field('author_comment'))): ?>
                                            <div class="comment-username">
                                                <p><?php echo get_sub_field('author_comment'); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

</div>

<?php get_template_part('inc/sections/get_valuation'); ?>

<?php get_footer(); ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let containerVideo = document.querySelector('.hero_frontpage-container');
        if (containerVideo) {
            setTimeout(() => {
                containerVideo.innerHTML = '';
                containerVideo.innerHTML = `
                    <video poster="<?php echo IMG; ?>/laurels-poster.webp" loop muted autoplay playsinline>
                        <source src="<?php echo IMG; ?>/hero.mp4" type="video/mp4">
                    </video>`;
            }, 500);
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const section = document.querySelector("section.get_in_touch");
        if (!section) return;

        const observer = new MutationObserver(() => {
            if (section.querySelector(".gform_confirmation_message")) {
                if (!section.classList.contains("sended")) {
                    section.classList.add("sended");
                    observer.disconnect();
                }
            } else {
                if (section.classList.contains("sended")) {
                    section.classList.remove("sended");
                }
            }
        });

        observer.observe(section, {
            childList: true,
            subtree: true
        });
    });
</script>