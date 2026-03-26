<?php
/*
    Template name: Join Laurels
*/
if (!isset($_GET['preview']) || $_GET['preview'] !== 'true') {
    wp_redirect('https://laurels.co.uk/');
    exit;
}
// ── Hero ──────────────────────────────────────────────────────────────
$hero_bg_image = get_field('hero_bg_image');
$hero_title = get_field('hero_title');
$hero_subtitle = get_field('hero_subtitle');
$hero_tagline = get_field('hero_tagline');
$hero_logo = get_field('hero_logo');

// ── Section 02 — About ───────────────────────────────────────────────
$s02_leaf_image = get_field('s02_leaf_image');
$s02_icon = get_field('s02_icon');
$s02_title = get_field('s02_title');
$s02_text = get_field('s02_text');
$s02_image = get_field('s02_image');

// ── Section 03 — Why Laurels ─────────────────────────────────────────
$s03_leaf_image = get_field('s03_leaf_image');
$s03_title = get_field('s03_title');
$s03_intro_text = get_field('s03_intro_text');
$s03_qualities = get_field('s03_qualities');
$s03_closing_text = get_field('s03_closing_text');
$s03_image = get_field('s03_image');

// ── Section 04 — How It Works ────────────────────────────────────────
$s04_image = get_field('s04_image');
$s04_leaf_image = get_field('s04_leaf_image');
$s04_title = get_field('s04_title');
$s04_text = get_field('s04_text');
$s04_requirements_title = get_field('s04_requirements_title');
$s04_requirements = get_field('s04_requirements');

// ── Section 05 — What's In It For You ───────────────────────────────
$s05_image = get_field('s05_image');
$s05_title = get_field('s05_title');
$s05_list = get_field('s05_list');
$s05_senior_title = get_field('s05_senior_title');
$s05_senior_checklist = get_field('s05_senior_checklist');

// ── Section 06 — Costs & Earnings ───────────────────────────────────
$s06_title = get_field('s06_title');
$s06_table = get_field('s06_table');
$s06_footnote = get_field('s06_footnote');

// ── Section 07 — Location & Training ────────────────────────────────
$s07_leaf_image = get_field('s07_leaf_image');
$s07_image = get_field('s07_image');
$s07_icon = get_field('s07_icon');
$s07_blocks = get_field('s07_blocks');

// ── Section 08 — Ready to Get Started ───────────────────────────────
$s08_image = get_field('s08_image');
$s08_leaf_image = get_field('s08_leaf_image');
$s08_title = get_field('s08_title');
$s08_steps_intro = get_field('s08_steps_intro');
$s08_steps = get_field('s08_steps');
$s08_closing_text = get_field('s08_closing_text');
$s08_contact = get_field('s08_contact');

// ── Section 09 — CTA Final ───────────────────────────────────────────
$s09_leaf_image = get_field('s09_leaf_image');
$s09_title = get_field('s09_title');
$s09_subtitle = get_field('s09_subtitle');

get_header(); ?>
<main class="join-laurels">
    <!-- ===================== HERO ===================== -->
    <?php if (!empty($hero_title)): ?>
        <section id="hero" class="join-hero">
            <?php if (!empty($hero_bg_image)): ?>
                <img src="<?= esc_url($hero_bg_image['url']); ?>" alt="<?= esc_attr($hero_bg_image['alt']); ?>"
                    class="join-hero__bg">
            <?php endif; ?>
            <div class="container join-hero__container">
                <div class="join-hero__top">
                    <?php if (!empty($hero_title)): ?>
                        <h1 class="join-hero__title">
                            <?= esc_html($hero_title); ?>
                        </h1>
                    <?php endif; ?>
                    <?php if (!empty($hero_subtitle)): ?>
                        <p class="join-hero__subtitle">
                            <?= esc_html($hero_subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="join-hero__bottom">
                    <?php if (!empty($hero_tagline)): ?>
                        <div class="join-hero__tagline">
                            <?= wp_kses_post($hero_tagline); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($hero_logo)): ?>
                        <img src="<?= esc_url($hero_logo['url']); ?>" alt="<?= esc_attr($hero_logo['alt']); ?>"
                            class="join-hero__logo">
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ===================== SECTION 02 — About Laurels (dark) ===================== -->
    <?php if (!empty($s02_title) || !empty($s02_text)): ?>
        <section id="section-02" class="join-section-02">
            <?php if (!empty($s02_leaf_image)): ?>
                <img src="<?= esc_url($s02_leaf_image['url']); ?>" alt="<?= esc_attr($s02_leaf_image['alt']); ?>"
                    class="join-section-02__leaf">
            <?php endif; ?>
            <div class="container">
                <div class="join-section-02__grid">
                    <div class="join-section-02__content">
                        <?php if (!empty($s02_icon)): ?>
                            <img src="<?= esc_url($s02_icon['url']); ?>" alt="<?= esc_attr($s02_icon['alt']); ?>"
                                class="join-section-02__icon">
                        <?php endif; ?>
                        <?php if (!empty($s02_title)): ?>
                            <h2 class="join-section-02__title"><?= esc_html($s02_title); ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($s02_text)): ?>
                            <div class="join-section-02__text"><?= wp_kses_post($s02_text); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($s02_image)): ?>
                        <div class="join-section-02__image">
                            <img src="<?= esc_url($s02_image['url']); ?>" alt="<?= esc_attr($s02_image['alt']); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ===================== SECTION 03 — Why Laurels (beige) ===================== -->
    <?php if (!empty($s03_title)): ?>
        <section id="section-03" class="join-section-03">
            <?php if (!empty($s03_leaf_image)): ?>
                <img src="<?= esc_url($s03_leaf_image['url']); ?>" alt="<?= esc_attr($s03_leaf_image['alt']); ?>"
                    class="join-section-03__leaf">
            <?php endif; ?>
            <div class="join-section-03__grid">
                <div class="join-section-03__left">
                    <?php if (!empty($s03_title)): ?>
                        <h2 class="join-section-03__title"><?= esc_html($s03_title); ?></h2>
                    <?php endif; ?>
                    <div class="join-section-03__text">
                        <?php if (!empty($s03_intro_text))
                            echo wp_kses_post($s03_intro_text); ?>
                        <?php if (!empty($s03_qualities)): ?>
                            <ul class="join-section-03__list">
                                <?php foreach ($s03_qualities as $quality): ?>
                                    <li><?= esc_html($quality['item']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if (!empty($s03_closing_text))
                            echo wp_kses_post($s03_closing_text); ?>
                    </div>
                </div>
                <?php if (!empty($s03_image)): ?>
                    <div class="join-section-03__media">
                        <img src="<?= esc_url($s03_image['url']); ?>" alt="<?= esc_attr($s03_image['alt']); ?>">
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- ===================== SECTION 04 — How It Works (beige) ===================== -->
    <?php if (!empty($s04_title) || !empty($s04_text)): ?>
        <section id="section-04" class="join-section-04">
            <div class="join-section-04__grid">
                <?php if (!empty($s04_image)): ?>
                    <div class="join-section-04__image">
                        <img src="<?= esc_url($s04_image['url']); ?>" alt="<?= esc_attr($s04_image['alt']); ?>">
                    </div>
                <?php endif; ?>
                <div class="join-section-04__content">
                    <?php if (!empty($s04_leaf_image)): ?>
                        <img src="<?= esc_url($s04_leaf_image['url']); ?>" alt="<?= esc_attr($s04_leaf_image['alt']); ?>"
                            class="join-section-04__leaf">
                    <?php endif; ?>
                    <div class="join-section-04__inner">
                        <?php if (!empty($s04_title)): ?>
                            <h2 class="join-section-04__title"><?= esc_html($s04_title); ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($s04_text)): ?>
                            <div class="join-section-04__text"><?= wp_kses_post($s04_text); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($s04_requirements_title)): ?>
                            <h3 class="join-section-04__subtitle"><?= esc_html($s04_requirements_title); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($s04_requirements)): ?>
                            <ul class="join-section-04__list">
                                <?php foreach ($s04_requirements as $req): ?>
                                    <li><?= esc_html($req['item']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ===================== SECTION 05 — What's In It For You (dark) ===================== -->
    <?php if (!empty($s05_title) || !empty($s05_list)): ?>
        <section id="section-05" class="join-section-05">
            <div class="join-section-05__grid">
                <?php if (!empty($s05_image)): ?>
                    <div class="join-section-05__image">
                        <img src="<?= esc_url($s05_image['url']); ?>" alt="<?= esc_attr($s05_image['alt']); ?>">
                    </div>
                <?php endif; ?>
                <div class="join-section-05__content">
                    <?php if (!empty($s05_title)): ?>
                        <h2 class="join-section-05__title"><?= esc_html($s05_title); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($s05_list)): ?>
                        <?php foreach ($s05_list as $list_row): ?>
                            <?php if (!empty($list_row['s05_checklist'])): ?>
                                <ul class="join-section-05__checklist">
                                    <?php foreach ($list_row['s05_checklist'] as $item): ?>
                                        <li><?= wp_kses_post($item['item']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php if (!empty($list_row['s05_footnote'])): ?>
                                <p class="join-section-05__footnote"><?= esc_html($list_row['s05_footnote']); ?></p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!empty($s05_senior_title)): ?>
                        <h3 class="join-section-05__subtitle"><?= esc_html($s05_senior_title); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($s05_senior_checklist)): ?>
                        <ul class="join-section-05__checklist">
                            <?php foreach ($s05_senior_checklist as $item): ?>
                                <li><?= wp_kses_post($item['item']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ===================== SECTION 06 — Costs & Earnings (light) ===================== -->
    <?php if (!empty($s06_table)): ?>
        <section id="section-06" class="join-section-06">
            <div class="container">
                <?php if (!empty($s06_title)): ?>
                    <h2 class="join-section-06__title"><?= esc_html($s06_title); ?></h2>
                <?php endif; ?>
                <?php if (!empty($s06_table)): ?>
                    <div class="join-section-06__table-wrap">
                        <?= wp_kses_post($s06_table); ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($s06_footnote)): ?>
                    <div class="join-section-06__footnote"><?= wp_kses_post($s06_footnote); ?></div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- ===================== SECTION 07 — Location & Training (beige) ===================== -->
    <?php if (!empty($s07_blocks)): ?>
        <section id="section-07" class="join-section-07">
            <?php if (!empty($s07_leaf_image)): ?>
                <img src="<?= esc_url($s07_leaf_image['url']); ?>" alt="<?= esc_attr($s07_leaf_image['alt']); ?>"
                    class="join-section-07__leaf">
            <?php endif; ?>
            <div class="join-section-07__grid">
                <?php if (!empty($s07_image)): ?>
                    <div class="join-section-07__image">
                        <img src="<?= esc_url($s07_image['url']); ?>" alt="<?= esc_attr($s07_image['alt']); ?>">
                    </div>
                <?php endif; ?>
                <div class="join-section-07__content">
                    <?php if (!empty($s07_icon)): ?>
                        <img src="<?= esc_url($s07_icon['url']); ?>" alt="<?= esc_attr($s07_icon['alt']); ?>"
                            class="join-section-07__icon">
                    <?php endif; ?>
                    <?php if (!empty($s07_blocks)): ?>
                        <?php foreach ($s07_blocks as $block): ?>
                            <div class="join-section-07__block">
                                <?php if (!empty($block['block_title'])): ?>
                                    <h3 class="join-section-07__block-title"><?= esc_html($block['block_title']); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($block['block_text']))
                                    echo wp_kses_post($block['block_text']); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ===================== SECTION 08 — Ready to Get Started (light) ===================== -->
    <?php if (!empty($s08_title) || !empty($s08_steps)): ?>
        <section id="section-08" class="join-section-08">
            <?php if (!empty($s08_image)): ?>
                <div class="join-section-08__image-wrap">
                    <img src="<?= esc_url($s08_image['url']); ?>" alt="<?= esc_attr($s08_image['alt']); ?>">
                </div>
            <?php endif; ?>
            <?php if (!empty($s08_leaf_image)): ?>
                <img src="<?= esc_url($s08_leaf_image['url']); ?>" alt="<?= esc_attr($s08_leaf_image['alt']); ?>"
                    class="join-section-08__leaf">
            <?php endif; ?>
            <div class="container">
                <div class="join-section-08__content">
                    <?php if (!empty($s08_title)): ?>
                        <h2 class="join-section-08__title"><?= esc_html($s08_title); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($s08_steps_intro)): ?>
                        <p><?= esc_html($s08_steps_intro); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($s08_steps)): ?>
                        <ol class="join-section-08__steps">
                            <?php foreach ($s08_steps as $step): ?>
                                <li><?= esc_html($step['step']); ?></li>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                    <?php if (!empty($s08_closing_text))
                        echo wp_kses_post($s08_closing_text); ?>
                    <?php if (!empty($s08_contact)): ?>
                        <div class="join-section-08__contact"><?= wp_kses_post($s08_contact); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </section> 
    <?php endif; ?>

    <!-- ===================== SECTION 09 — CTA Final (dark) ===================== -->
    <?php if (!empty($s09_title)): ?>
        <section id="section-09" class="join-section-09">
            <?php if (!empty($s09_leaf_image)): ?>
                <img src="<?= esc_url($s09_leaf_image['url']); ?>" alt="<?= esc_attr($s09_leaf_image['alt']); ?>"
                    class="join-section-09__leaf">
            <?php endif; ?>
            <div class="container">
                <div class="join-section-09__content">
                    <?php if (!empty($s09_title)): ?>
                        <h2 class="join-section-09__title"><?= esc_html($s09_title); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($s09_subtitle)): ?>
                        <p class="join-section-09__subtitle"><?= esc_html($s09_subtitle); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>
<?php get_footer(); ?>