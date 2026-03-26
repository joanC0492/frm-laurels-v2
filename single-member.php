<?php

get_header();

$post_id = get_the_ID();

$full_name = get_the_title();
$first_name = explode(" ", $full_name)[0] ?? '';

$id_in_rex = !empty(get_field('id_in_rex')) ? get_field('id_in_rex') : 0;

?>

<div class="single_member single_member-<?php echo $post_id ?> member">
    <div class="container">
        <div class="single_member-grid">
            <div class="single_member-info">
                <p>Our People</p>
                <h1><?php echo $full_name; ?></h1>

                <?php if (!empty(get_field('position_member'))): ?>
                    <h2><?php echo get_field('position_member') ?></h2>
                <?php endif; ?>

                <div class="single_member-image hover_video for_mobile">
                    <?php
                    if (!empty(get_field('video_thumb'))) {
                        if (has_post_thumbnail($post_id)) {
                            $thumbnail_id = get_post_thumbnail_id($post_id);
                            $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'full');
                            if (!empty($thumbnail_src)) {
                                echo '<video muted loop id="thumb" poster="' . $thumbnail_src[0] . '" playsinline autoplay>
                                <source src="' . get_field('video_thumb')['url'] . '">
                            </video>';
                            } else {
                                echo '<video muted loop id="thumb" playsinline autoplay>
                                <source src="' . get_field('video_thumb')['url'] . '">
                            </video>';
                            }
                        } else {
                            echo '<video muted loop id="thumb" playsinline autoplay>
                            <source src="' . get_field('video_thumb')['url'] . '">
                        </video>';
                        }
                    } else {
                        if (has_post_thumbnail()) {
                            echo get_the_post_thumbnail($post_id, 'full');
                        }
                    }
                    ?>
                </div>

                <div class="single_member-description">
                    <p><?php echo get_the_excerpt(); ?></p>
                </div>
                <?php the_content(); ?>

                <?php if (!empty(get_field('linkedin_member')) || !empty(get_field('instagram_member'))): ?>
                    <div class="single_member-actions">
                        <?php if (!empty(get_field('linkedin_member'))): ?>
                            <a href="<?php echo get_field('linkedin_member'); ?>" class="linkedin" target="_blank" title="Linkedin">Linkedin</a>
                        <?php endif; ?>

                        <?php if (!empty(get_field('instagram_member'))): ?>
                            <a href="<?php echo get_field('instagram_member'); ?>" class="instagram" target="_blank" title="Instagram">Instagram</a>
                        <?php endif; ?>

                        <?php if (!empty(get_field('email_member'))): ?>
                            <a href="mailto:<?php echo get_field('email_member'); ?>" class="email" target="_blank" title="Email">Email</a>
                        <?php endif; ?>

                        <?php if (!empty(get_field('phone_member'))): ?>
                            <a href="tel:<?php echo get_field('phone_member'); ?>" class="phone" target="_blank" title="Phone">Phone</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="single_member-image hover_video">
                <?php
                if (!empty(get_field('video_thumb'))) {
                    if (has_post_thumbnail($post_id)) {
                        $thumbnail_id = get_post_thumbnail_id($post_id);
                        $thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'full');
                        if (!empty($thumbnail_src)) {
                            echo '<video muted loop id="thumb" poster="' . $thumbnail_src[0] . '" playsinline autoplay>
                                <source src="' . get_field('video_thumb')['url'] . '">
                            </video>';
                        } else {
                            echo '<video muted loop id="thumb" playsinline autoplay>
                                <source src="' . get_field('video_thumb')['url'] . '">
                            </video>';
                        }
                    } else {
                        echo '<video muted loop id="thumb" playsinline autoplay>
                            <source src="' . get_field('video_thumb')['url'] . '">
                        </video>';
                    }
                } else {
                    if (has_post_thumbnail()) {
                        echo get_the_post_thumbnail($post_id, 'full');
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php if(NOT_APPEAR): ?>
<section class="for_sale smember" id="listings">
    <div class="container">
        <div class="for_sale-subtitle">
            <?php if (!empty($first_name)): ?>
                <h2>Listings Managed by <?php echo $first_name; ?></h2>
            <?php else: ?>
                <h2>Listings Managed</h2>
            <?php endif; ?>
        </div>
        <?php
        $show = isset($_GET['show']) ? intval($_GET['show']) : 6;
        $availability = isset($_GET['availability']) ? $_GET['availability'] : 'available';
        $currentPage = isset($_GET['pagination']) ? intval($_GET['pagination']) : 1;

        $more_properties = '';
        if ($show != 6) {
            $more_properties = '&show=' . $show;
        }
        ?>
        <!-- <div class="for_sale-filters">
            <div class="filter">
                <div class="filter-options">
                    <a data-attr="availability" href="?availability=available<?php echo $more_properties; ?>" class="filter-button prop <?php echo $availability == 'available' ? 'active' : ''; ?>" data-option="available">Available Property</a>
                    <a data-attr="availability" href="?availability=sold<?php echo $more_properties; ?>" class="filter-button prop <?php echo $availability == 'sold' ? 'active' : ''; ?>" data-option="sold">Sold Property</a>
                </div>
            </div>
        </div> -->
        <div class="for_sale-list" data-bedrooms="" data-property-type="">
            <?php get_properties_grid($currentPage, '', $show, '', '', $availability, $id_in_rex); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
$args = array(
    'post_type' => 'member',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'post__not_in' => array($post_id), // Excluir el ID actual
);

$query = new WP_Query($args);
?>

<?php if ($query->have_posts()) : ?>
    <section class="our_team single_member-section">
        <div class="container">
            <div class="our_team_title">
                <h2>Other Team Members</h2>
            </div>
        </div>
        <div class="our_team-slider relative">
            <div class="splide" role="group" id="teammates">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <li class="splide__slide">
                                <?php get_card_member(get_the_ID()); ?>
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

<?php get_footer(); ?>

<script>
    let filterActives = document.querySelectorAll('.filter-button.active');
    if (filterActives) {
        Array.from(filterActives).forEach(filter => {
            filter.addEventListener('click', (e) => {
                e.preventDefault();

                // Obtener atributos del filtro activado
                const option = e.currentTarget.getAttribute('data-option');
                const attr = e.currentTarget.getAttribute('data-attr');

                // Manipular la URL
                const url = new URL(window.location.href);
                const params = url.searchParams;

                // Eliminar el filtro de los parámetros de la URL
                params.delete(attr);

                // Recargar la página con la nueva URL
                window.location.href = url.toString();
            });
        });
    }
</script>

<?php if (!empty($_GET)): ?>
    <script>
		document.addEventListener('DOMContentLoaded', function () {
    		const target = document.querySelector('#listings');
    		if (target) {
      			const offset = -150;
      			const topPos = target.getBoundingClientRect().top + window.pageYOffset + offset;
      			window.scrollTo({ top: topPos, behavior: 'smooth' });
    		}
  		});
    </script>
<?php endif; ?>