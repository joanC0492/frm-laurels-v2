<footer class="footer">
    <div class="container">
        <div class="footer_top">
            <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo get_bloginfo('name'); ?>" class="footer_logo page_logo d-block w-100">
                <img src="<?php echo IMG; ?>/logo.svg" width="439" height="211" title="<?php echo get_bloginfo('name'); ?>" alt="<?php echo get_bloginfo('name'); ?>" class="d-block w-100" loading="lazy">
            </a>
            <?php wp_nav_menu(array('theme_location' => 'footer-menu', 'container_class' => '', 'menu_class' => 'ul_menu')); ?>
        </div>
        <div class="line w-100"></div>
        <div class="footer_bottom">
            <p>Laurels Property Partners 2025&copy;</p>
            <ul>
                <li>
                    <a href="<?php echo esc_url(home_url('privacy-cookies')) ?>" title="Privacy & Cookies">Privacy & Cookies</a>
                </li>
                <li>
                    <a href="<?php echo esc_url(home_url('terms-of-use')) ?>" title="Terms Of Use">Terms Of Use</a>
                </li>
            </ul>
        </div>
    </div>
</footer>

<input type="hidden" name="base_url" value="<?php echo home_url(); ?>">
<input type="hidden" name="admin_ajax" value="<?php echo admin_url('admin-ajax.php'); ?>">
<input type="hidden" name="uri" value="<?php echo home_url(add_query_arg(array(), $wp->request)); ?>">
<input type="hidden" name="urlTheme" value="<?php echo get_template_directory_uri(); ?>">

<?php wp_footer(); ?>

<script>
    document.body.addEventListener('click', (e)=>{
        if(e.target.classList.contains('toggle_menu')){
            document.querySelector('.header_menu').classList.toggle('active');
        }
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // const bodyChildren = document.querySelectorAll("body > *");
        const bodyChildren = document.querySelectorAll("section");

        if (bodyChildren.length > 0) {
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            setTimeout(() => {
                                entry.target.classList.add("in_animation_progress");
                            }, 1000);
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                }
            );

            bodyChildren.forEach(child => observer.observe(child));
        }
    });
</script>

</body>

</html>