<?php
/*
    Template name: test
*/

get_header();

?>
<style>body{padding-block:5rem;}</style>
<?php

echo do_shortcode('[rex_webhook]');

get_footer();

?>