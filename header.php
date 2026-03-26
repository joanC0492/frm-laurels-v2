<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo IMG; ?>/leaf_map.svg" type="image/x-icon">
    <link rel="icon" href="<?php echo IMG; ?>/leaf_map.svg" type="image/x-icon">
    <?php wp_head(); ?>

    <?php if (is_404()): ?>
        <title><?php esc_attr_e("Error Page - 404"); ?></title>
    <?php else: ?>
        <title><?php echo wp_get_document_title(); ?></title>
    <?php endif; ?>

    <?php if (is_page('residential-property') || is_page('sproperty')): ?>
        <meta property="og:title" content="Check out this property for sale on Laurels.co.uk">
    <?php endif; ?>
    <meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>">
</head>

<body <?php body_class(); ?>>

    <?php
    if (is_front_page() || is_page('partners') || is_page('about') || is_page('expertise') || is_page('prime-real-estate') || is_page('commercial-real-estate') || is_page('partners-test')) {
        $scroll = true;
    } else {
        $scroll = false;
        echo '<input type="hidden" class="no_scroll">';
    }
    ?>

    <header class="header <?php if (!$scroll) {
        echo 'scrolled';
    } ?>">
        <div class="container">
            <div class="header_grid">
                <div class="header_menu">
                    <div class="header_menu-bg toggle_menu"></div>
                    <?php wp_nav_menu(array('theme_location' => 'header-menu', 'container_class' => 'header_nav w-100', 'menu_class' => 'ul_menu')); ?>
                </div>
                <div>
                    <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo get_bloginfo('name'); ?>"
                        class="header_logo page_logo d-block w-100">
                        <img src="<?php echo IMG; ?>/logo.svg" width="439" height="211"
                            title="<?php echo get_bloginfo('name'); ?>" alt="<?php echo get_bloginfo('name'); ?>"
                            class="w-100" loading="lazy">
                    </a>
                </div>
                <div class="header_submenu">
                    <ul class="actions">
                        <li>
                            <a href="<?php echo esc_url(home_url('get-in-touch')) ?>" title="Contact"
                                target="_blank">Contact</a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url(home_url('get-in-touch')) ?>?valuation" title="Book A Valuation"
                                target="_blank">Book A Valuation</a>
                        </li>
                    </ul>
                    <button type="button" class="header_burger toggle_menu">
                        <span></span><span></span><span></span>
                    </button>
                </div>
            </div>
        </div>
    </header>