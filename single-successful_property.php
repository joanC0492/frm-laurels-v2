<?php

get_header();

?>

<style>
    html,
    body {
        scroll-behavior: smooth;
    }
</style>

<!--<main class="single_property">
    <div class="container"> -->

<?php get_body_single_property_acf(get_the_ID()); ?>



<div class="mortgage_calculator">
    <div class="mortgage_calculator-grid">
        <div class="w-100 mortgage_calculator-info">
            <h2>Mortgage Calculator</h2>
            <p>Something different in mind? Get in touch to explore our bespoke mortgage solutions.</p>
            <a href="<?php echo esc_url(home_url('get-in-touch')); ?>" title="Speak to an Expert">Speak to an Expert</a>
        </div>
        <div class="w-100 mortgage_calculator-output">
            <?php echo do_shortcode('[gravityform id="2" title="true" ajax="true"]'); ?>
        </div>
    </div>
</div>

</div>
</main>

<?php get_template_part('inc/sections/get_valuation'); ?>

<?php get_footer(); ?>

<script>
    jQuery(document).ready(function($) {
        $('#input_2_1, #input_2_4, #input_2_3, #input_2_6').on('input', function() {
            var P = parseFloat($('#input_2_1').val().replace(/[^0-9.]/g, '')) || 0;
            var r = parseFloat($('#input_2_4').val()) / 100 || 0;
            var n = parseFloat($('#input_2_3').val()) || 0;
            var t = parseFloat($('#input_2_6').val()) || 0;

            if (P > 0 && r > 0 && n > 0 && t > 0) {
                var ratePerPeriod = r / n;
                var totalPayments = t * n;

                var factor = Math.pow(1 + ratePerPeriod, totalPayments);
                var monthlyRepayment = P * ((ratePerPeriod * factor) / (factor - 1));

                $('#input_2_10').val('£' + monthlyRepayment.toFixed(2));
            } else {
                $('#input_2_10').val('£0.00');
            }
        });
    });
</script>

<script>
    let scroll_map = document.querySelector('.scroll_map')
    if (scroll_map) {
        scroll_map.addEventListener('click', (e) => {
            const mapSection = document.querySelector('#map');
            if (mapSection) {
                const offsetTop = mapSection.offsetTop - 80;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    }
</script>