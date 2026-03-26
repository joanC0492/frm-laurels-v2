<?php if (have_rows('stats_repeater')): ?>
    <section class="stats">
        <div class="container">
            <div class="stats_grid">

                <?php $dataItems = 11;
                while (have_rows('stats_repeater')): the_row();

                    if (get_row_index() == 2) {
                        $dataItems = 13;
                    }
                    if (get_row_index() == 3) {
                        $dataItems = 12;
                    }

                ?>
                    <div class="stat">
                        <div class="stat_number">
                            <div class="absolute stat<?php echo get_row_index(); ?>" data-items="<?php echo $dataItems; ?>">

                                <?php if (get_row_index() == 1): ?>
                                    <span class="shadow">0</span>
                                    <span class="shadow">100</span>
                                    <span class="shadow">200</span>
                                    <span class="shadow">300</span>
                                    <span class="shadow">400</span>
                                    <span class="shadow">500</span>
                                    <span class="shadow">600</span>
                                    <span class="shadow">700</span>
                                    <span class="shadow">800</span>
                                    <span class="shadow">900</span>
                                    <span class="shadow"><?php echo get_sub_field('number_stat') ?? ''; ?></span>
                                <?php elseif (get_row_index() == 2): ?>
                                    <span class="shadow">0.0</span>
                                    <span class="shadow">0.1</span>
                                    <span class="shadow">0.2</span>
                                    <span class="shadow">0.3</span>
                                    <span class="shadow">0.4</span>
                                    <span class="shadow">0.5</span>
                                    <span class="shadow">0.6</span>
                                    <span class="shadow">0.7</span>
                                    <span class="shadow">0.8</span>
                                    <span class="shadow">0.9</span>
                                    <span class="shadow">1.0</span>
                                    <span class="shadow">1.1</span>
                                    <span class="shadow"><?php echo get_sub_field('number_stat') ?? ''; ?></span>
                                <?php else: ?>
                                    <span class="shadow">0</span>
                                    <span class="shadow">2</span>
                                    <span class="shadow">4</span>
                                    <span class="shadow">6</span>
                                    <span class="shadow">8</span>
                                    <span class="shadow">10</span>
                                    <span class="shadow">12</span>
                                    <span class="shadow">14</span>
                                    <span class="shadow">16</span>
                                    <span class="shadow">18</span>
                                    <span class="shadow">20</span>
                                    <span class="shadow"><?php echo get_sub_field('number_stat') ?? ''; ?></span>
                                <?php endif; ?>

                            </div>

                            <?php if (!empty(get_sub_field('sign_1'))): ?>
                                <span><?php echo get_sub_field('sign_1'); ?></span>
                            <?php endif; ?>

                            <span class="main"><?php echo get_sub_field('number_stat') ?? ''; ?></span>

                            <?php if (get_row_index() == 1): ?>
                                <span><?php echo get_sub_field('sign_2') ?? ''; ?></span>
                            <?php else: ?>
                                <span class="small"><?php echo get_sub_field('sign_2') ?? ''; ?></span>
                            <?php endif; ?>


                        </div>
                        <?php if (!empty(get_sub_field('label_stat'))): ?>
                            <div class="stat_text">
                                <p><?php echo get_sub_field('label_stat') ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>

            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const statsSection = document.querySelector(".stats");
            const statNumbers = document.querySelectorAll(".stats .stat_number");

            if (statsSection && statNumbers.length > 0) {
                const observer = new IntersectionObserver(
                    (entries, observer) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                statNumbers.forEach(stat => stat.classList.add("active"));
                                observer.unobserve(entry.target); // Detiene la observación después de activar.
                            }
                        });
                    }, {
                        threshold: 0.5 // Activa cuando el 50% de la sección es visible.
                    }
                );
                observer.observe(statsSection);
            }
        });
    </script>
<?php endif; ?>