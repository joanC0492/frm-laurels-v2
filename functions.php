<?php

/** 
 *FullTimeForce
 *@link 
 *@package WordPress
 *@subpackage FullTimeForce
 *@since 1.0.0
 *@version 1.0.0
 */

use function PHPSTORM_META\type;

define('URL', get_stylesheet_directory_uri());
define('IMG', URL . '/images');
define('JS', URL . '/libraries/js');
define('CSS', URL . '/libraries/css');
define('NOT_APPEAR', false);


// Registrar el webhook en la API REST de WordPress
add_action('rest_api_init', function () {
    register_rest_route('rex/v1', '/webhook/', array(
        'methods'  => 'POST',
        'callback' => 'rex_webhook_handler',
        'permission_callback' => '__return_true' // Permite llamadas sin autenticación
    ));
});

// Manejar la solicitud del webhook
function rex_webhook_handler(WP_REST_Request $request)
{
    // Obtener datos JSON enviados por REX
    $data = $request->get_json_params();

    // Validar si se recibieron datos correctos
    if (!$data || !isset($data['event']) || !isset($data['data'])) {
        return new WP_REST_Response(['message' => 'Invalid data'], 400);
    }

    // Extraer información de la propiedad
    $property = $data['data'];
    $property_id = $property['id'] ?? 'N/A';
    $property_address = $property['address']['street'] ?? 'Dirección no disponible';
    $property_price = $property['price'] ?? 'Precio no disponible';

    // Guardar datos temporalmente en transients (1 hora)
    set_transient('rex_last_webhook', [
        'id'      => $property_id,
        'address' => $property_address,
        'price'   => $property_price
    ], HOUR_IN_SECONDS);

    return new WP_REST_Response(['message' => 'Webhook procesado correctamente'], 200);
}


function rex_last_webhook_data()
{
    $data = get_transient('rex_last_webhook');

    if (!$data) {
        return '<p>No hay datos recientes del webhook.</p>';
    }

    $output = "<h2>Última Propiedad Actualizada</h2>";
    $output .= "<p><strong>Dirección:</strong> {$data['address']}</p>";
    $output .= "<p><strong>ID:</strong> {$data['id']}</p>";
    $output .= "<p><strong>Precio:</strong> {$data['price']}</p>";

    return $output;
}
add_shortcode('rex_webhook', 'rex_last_webhook_data');

function debuggear($array)
{
    echo '<pre>';
    var_dump($array);
    echo '</pre>';
}

function get_current_url()
{
    $protocol = is_ssl() ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $request = $_SERVER['REQUEST_URI'];
    return $protocol . $host . $request;
}

function remove_sharethis_by_url()
{
    if (is_front_page()) {
        global $wp_scripts;
        foreach ($wp_scripts->registered as $key => $script) {
            if (strpos($script->src, '//platform-api.sharethis.com/js/sharethis.js') !== false) {
                wp_dequeue_script($key);
                wp_deregister_script($key);
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'remove_sharethis_by_url', 100);

function remove_wp_head_extras()
{
    remove_action('wp_head', 'rsd_link'); // Quita RSD (Really Simple Discovery)
    remove_action('wp_head', 'wlwmanifest_link'); // Quita WLW (Windows Live Writer)
    remove_action('wp_head', 'wp_generator'); // Quita el número de versión de WordPress
    remove_action('wp_head', 'feed_links', 2); // Quita enlaces de RSS
    remove_action('wp_head', 'feed_links_extra', 3); // Quita enlaces de RSS adicionales
    remove_action('wp_head', 'wp_shortlink_wp_head', 10); // Quita shortlinks
    remove_action('wp_head', 'rest_output_link_wp_head', 10); // Quita la API REST link
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10); // Quita enlaces prev/next
}
add_action('init', 'remove_wp_head_extras');

if (! function_exists('enable_gzip_compression')) {
    function enable_gzip_compression()
    {
        // Evita ejecutar en el área de administración
        if (is_admin()) {
            return;
        }

        // Activa la compresión GZIP si está disponible
        if (! ob_start('ob_gzhandler')) {
            ob_start();
        }
    }
    add_action('init', 'enable_gzip_compression');
}

function disable_emojis()
{
    // Quitar los scripts y estilos de emojis
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    // Evitar que el tinymce cargue emojis
    add_filter('tiny_mce_plugins', function ($plugins) {
        return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
    });

    // Quitar los DNS prefetch relacionados con emojis
    add_filter('emoji_svg_url', '__return_false');
}
add_action('init', 'disable_emojis');

function get_api_token()
{

    $api_url = 'https://api.uk.rexsoftware.com/v1/rex/Authentication/login';

    $headers = array(
        'Content-Type' => 'application/json'
    );

    //-----------------------
    $search_params = array(
        'email' => 'r.muat@laurels.co.uk',
        'password' => '35975863Rm!',
    );
    //-----------------------

    // Hacer la solicitud POST a la API de Rex
    $response = wp_remote_post($api_url, array(
        'headers' => $headers,
        'body' => json_encode($search_params),
    ));

    // Comprobar si la solicitud fue exitosa
    if (is_wp_error($response)) {
        return '<p class="no-one">No properties found</p>';
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if ($data) {
        return $data['result'];
    }
}

// define('REX_API_TOKEN', 'ccab-6b9b-d5c6-4a2d-e8dd-fb44-c61d-c819-4677-59785');

if (!function_exists('general_scripts')):
    function general_scripts()
    {
        wp_register_style('style', get_stylesheet_uri(), array(), '1.0.0', 'all');
        wp_enqueue_style('style');

        wp_register_style('maincss', get_template_directory_uri() . '/public/css/app.css', '1.0.0', 'all');
        wp_enqueue_style('maincss');

        // wp_register_style('animatecss', CSS . '/animate.min.css', '1.0.0', 'all');
        // wp_enqueue_style('animatecss');

        if (is_page_template('page-template/join-laurels.php')) {
            wp_register_style('join-laurels', get_template_directory_uri() . '/join-laurels.css', array(), '1.0.0', 'all');
            wp_enqueue_style('join-laurels');
        }

        if (is_page('residential-property') || is_page('sproperty') || is_singular('successful_property')) {
            wp_register_style('mapcss', CSS . '/leaflet.css', '1.0.0', 'all');
            wp_enqueue_style('mapcss');

            wp_register_script('mapjs', JS . '/leaflet.js', array(), '1.0.0', true);
            wp_enqueue_script('mapjs');

            // wp_register_script('sharerjs', JS . '/sharer.min.js', array(), '1.0.0', true);
            // wp_enqueue_script('sharerjs');
        }

        wp_register_script('mainjs', get_template_directory_uri() . '/public/js/main.min.js', array(), '1.0.0', true);
        wp_enqueue_script('mainjs');

        // wp_register_script('wowjs', JS . '/wow.min.js', array(), '1.0.0', true);
        // wp_enqueue_script('wowjs');
    }
endif;
add_action('wp_enqueue_scripts', 'general_scripts');

//add postthumbnail function
if (function_exists('add_theme_support'))
    add_theme_support('post-thumbnails');

//excerpt 30 word
function my_excerpt_length($length)
{
    return 30;
}
add_filter('excerpt_length', 'my_excerpt_length');

//registrar menus
function register_my_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Header'),
            'footer-menu' => __('Footer'),
        )
    );
}
add_action('init', 'register_my_menus');

//require_once get_template_directory() . '/inc/modules/information_module.php';
require_once get_template_directory() . '/inc/modules/member.php';
require_once get_template_directory() . '/inc/modules/our_succeses.php';


function add_phone_field_validation()
{
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneFields = [
                document.getElementById('input_1_4'),
                document.getElementById('input_3_19'),
                document.getElementById('input_4_4')
            ];

            phoneFields.forEach(function(field) {
                if (field) {
                    field.addEventListener('input', function(e) {
                        this.value = this.value.replace(/[^0-9+\s-]/g, '');
                    });
                }
            });
        });
    </script>
<?php
}
add_action('wp_footer', 'add_phone_field_validation');

add_filter('gform_submit_button', 'leg_gform_submit_button_icon', 10, 2);
function leg_gform_submit_button_icon($button, $form)
{
    return $button .= '<img src="' . IMG . '/arrowc.svg">';
}

function get_title($text = '', $classes = '')
{
    if (!empty($text)) {
        echo '<div class="' . $classes . ' animation_title">
            <h2>' . $text . '<span>.<svg xmlns="http://www.w3.org/2000/svg" width="56" height="70" viewBox="0 0 56 70" fill="none"><path d="M34.3275 33.872C34.143 33.8 33.9306 33.7671 33.7445 33.7057C31.7724 33.0311 29.8049 32.8894 27.8031 33.6007C27.0327 33.8725 26.2386 34.0863 25.4445 34.3001C25.2067 34.3611 24.9536 34.311 24.7028 34.3156C24.6898 34.2593 24.6661 34.2013 24.6425 34.1434C24.8117 33.9632 24.9434 33.7446 25.1379 33.6117C26.6874 32.5915 28.2459 31.5835 29.815 30.5772C30.3462 30.2358 30.918 30.1939 31.5025 30.4908C32.1867 30.8466 32.8865 31.1722 33.5584 31.5369C35.3235 32.4945 37.1723 33.0523 39.2129 32.7925C40.622 32.6087 41.9236 32.1367 43.1118 31.3429C43.7288 30.9388 43.7274 30.667 43.0996 30.2982C42.7404 30.0905 42.3812 29.8828 42.0097 29.6841C40.7352 28.998 39.3756 28.5811 37.9152 28.6048C36.9121 28.6234 35.8992 28.7056 34.8929 28.7453C34.7516 28.7452 34.6062 28.7009 34.3726 28.6648C34.5329 28.4723 34.6302 28.3353 34.7438 28.2334C35.1304 27.913 35.544 27.6294 35.911 27.2952C36.7235 26.5411 37.6417 26.3682 38.6837 26.6599C40.0589 27.0466 41.4271 26.9868 42.8069 26.7116C45.4979 26.1831 47.7263 24.9203 49.2908 22.6097C49.7144 21.98 49.5709 21.6428 48.8374 21.6053C46.9605 21.5103 45.1291 21.683 43.4172 22.5586C42.8991 22.8152 42.3648 23.0366 41.8214 23.2458C41.6474 23.3166 41.4317 23.3049 41.2308 23.339C41.2055 23.2917 41.168 23.2532 41.141 23.2165C41.2359 23.0248 41.2933 22.7947 41.4364 22.643C42.24 21.7355 43.0616 20.8524 43.8849 19.9587C44.2912 19.511 44.7897 19.2406 45.382 19.1368C46.4219 18.9501 47.4422 18.7496 48.4805 18.5736C49.7198 18.3635 50.8832 18.0113 51.922 17.2705C53.4004 16.2176 54.3034 14.7387 55.0015 13.1087C55.1578 12.731 55.4301 12.3061 55.1184 11.9319C54.8173 11.5594 54.3442 11.736 53.9407 11.8148C51.4964 12.2946 49.4576 13.4563 47.8371 15.3563C47.6785 15.5381 47.3664 15.5876 47.1311 15.7033L47.2411 14.9925C47.2444 14.9712 47.26 14.9411 47.2739 14.9215C48.4528 12.5729 49.8881 10.3944 51.5242 8.323C53.3778 5.97024 54.2703 3.29489 53.6643 0.257203L53.5051 0.232549C53.0295 0.495676 52.4984 0.695899 52.0677 1.02029C49.7669 2.74981 48.3104 4.92506 48.3439 7.93929C48.3619 9.93 47.8662 11.7977 46.7572 13.4836C46.3303 14.1345 45.9532 14.8148 45.5353 15.4779C45.4486 15.6166 45.2729 15.698 45.1364 15.8072C45.0671 15.6227 44.9962 15.4488 44.9481 15.2675C44.9262 15.199 44.9622 15.1068 44.9843 15.0342C45.2309 14.0729 45.458 13.0978 45.7152 12.1383C46.3207 9.84214 46.1813 7.58277 45.2601 5.38706C45.0164 4.78445 44.5688 4.72603 44.1527 5.23734C43.0922 6.53968 42.3444 7.99906 41.991 9.64984C41.4105 12.4169 41.8453 15.0153 43.2711 17.463C43.727 18.2396 43.7138 18.4657 43.0835 19.096C41.4845 20.7169 39.857 22.3116 38.24 23.908C38.1002 24.0384 37.9335 24.1321 37.7685 24.2152C37.6753 24.2551 37.5389 24.2231 37.4295 24.2279C37.4337 24.1308 37.4076 24.0181 37.4436 23.9259C37.6687 23.385 37.8742 22.8302 38.1613 22.3098C38.8566 21.0487 39.3249 19.709 39.545 18.2875C39.7453 16.9932 39.6966 15.6929 39.5171 14.3942C39.4709 14.0611 39.5014 13.6531 39.1005 13.5041C38.7102 13.3568 38.4004 13.6021 38.1062 13.8173C38.0572 13.8531 38.0065 13.8996 37.9558 13.9461C35.8189 16.092 34.6708 18.6627 34.7876 21.7006C34.8324 22.8156 35.0945 23.9316 35.2929 25.0378C35.4254 25.797 35.3606 26.1454 34.773 26.4998C33.4769 27.2877 32.1702 28.074 30.8382 28.8128C30.4329 29.0434 29.9517 29.1318 29.5032 29.2905C29.455 29.2505 29.4191 29.2015 29.3816 29.1631C29.5371 28.7201 29.6641 28.2509 29.8605 27.825C30.3654 26.7408 30.8898 25.6706 31.4355 24.6036C32.2454 23.0234 32.6234 21.3547 32.4312 19.5761C32.3632 18.892 32.1003 18.7644 31.4907 19.0502C30.0624 19.709 29.0511 20.8343 28.1418 22.0731C27.1107 23.4669 26.6732 25.0287 26.8964 26.747C27.0011 27.5453 27.1834 28.334 27.2988 29.1339C27.402 29.8017 27.1377 30.3148 26.5608 30.6709C25.491 31.3309 24.4319 31.9925 23.3548 32.6296C23.1759 32.7323 22.9284 32.7157 22.7152 32.7587C22.7072 32.5293 22.6176 32.2656 22.7002 32.0829C23.0856 31.2083 23.4711 30.3338 23.9471 29.5058C24.8804 27.9014 25.3107 26.1756 25.1937 24.3325C25.1567 23.7293 25.0542 23.1268 24.8938 22.548C24.7448 22.0361 24.4255 21.9215 24.0037 22.2581C23.4471 22.6934 22.9248 23.1883 22.4718 23.7265C22.0328 24.2451 21.7097 24.8577 21.3277 25.4286C20.5484 26.6007 20.1961 27.8932 20.3485 29.2964C20.5156 30.7453 20.739 32.1812 20.9412 33.6138C21.0029 34.0579 20.9405 34.461 20.6299 34.7823C19.281 36.1921 17.9215 37.6002 16.5547 38.9854C16.3348 39.2121 16.0128 39.3252 15.699 39.5265C15.6665 39.3151 15.616 39.2203 15.6291 39.1355C15.7293 38.4883 15.7976 37.8363 15.9811 37.2129C16.493 35.5215 16.8636 33.8299 16.6502 32.0479C16.5309 31.0626 16.2973 30.114 15.8594 29.2206C15.6205 28.7274 15.302 28.6781 14.9072 29.0515C14.7535 29.2015 14.6284 29.3776 14.5033 29.5538C13.0551 31.5348 12.2789 33.7393 12.352 36.2166C12.3956 37.831 12.7791 39.3569 13.4673 40.8104C13.7535 41.4196 13.8012 42.0245 13.4266 42.6183C12.8386 43.5375 12.2505 44.4567 11.6429 45.3621C11.4744 45.6075 11.2186 45.7852 11.002 45.9907C10.9506 45.9718 10.9081 45.9653 10.8567 45.9464C10.7752 45.6297 10.662 45.308 10.6353 44.9888C10.4396 42.6012 9.97428 40.2697 9.08988 38.0471C8.81518 37.3637 8.34357 36.7584 7.94222 36.1205C7.77663 35.8559 7.57731 35.8793 7.4268 36.1493C7.05462 36.7978 6.54607 37.4143 6.35109 38.1119C5.97998 39.4558 5.76484 40.8456 5.51948 42.2198C5.36029 43.1076 5.487 43.9745 5.90782 44.7675C6.63037 46.1395 7.6014 47.3109 8.93781 48.1587C9.56234 48.5487 9.67966 48.9145 9.41201 49.59C9.10834 50.3577 8.8153 51.1271 8.51328 51.8842C8.10157 52.9285 7.70212 53.9638 7.27082 54.9942C7.20371 55.1468 6.9929 55.2445 6.85312 55.3749C6.73481 55.2262 6.54786 55.0995 6.50879 54.9306C6.40538 54.5452 6.34936 54.1346 6.31293 53.7379C6.06231 50.5814 4.81159 47.8458 2.74377 45.4726C2.35534 45.0323 2.01471 45.0556 1.8215 45.6014C1.55626 46.3316 1.34246 47.0807 1.10742 47.8264C0.989522 48.1667 0.88224 48.5085 0.774958 48.8504L0.638646 49.7309C0.650789 49.8632 0.685808 49.9881 0.688977 50.1081C0.634333 52.9892 1.70732 55.3279 4.02724 57.0557C4.46559 57.3843 4.95791 57.6452 5.42406 57.9346C5.98085 58.2707 6.15606 58.754 6.02567 59.3856C5.74278 60.7214 5.47947 62.0711 5.22679 63.4225C4.99786 64.6906 4.77955 65.9604 4.57185 67.2318C4.42164 68.1319 4.83524 68.7608 5.60512 69.195C6.1456 69.4959 6.63016 69.245 6.69357 68.6248C6.74876 68.0576 6.79498 67.4782 6.87305 66.9037C7.16309 64.8194 7.44087 62.7441 7.76277 60.6648C7.88758 59.8585 8.16867 59.7283 8.94688 59.9682C9.88107 60.2541 10.8308 60.5097 11.8037 60.3344C12.7326 60.1632 13.6583 59.872 14.5537 59.5652C16.7458 58.8183 18.463 57.4873 19.507 55.3785C19.6158 55.1672 19.6927 54.951 19.8114 54.6761C19.386 54.545 19.0259 54.4133 18.6453 54.3435C17.3231 54.1062 16.0185 54.317 14.7945 54.7793C13.1098 55.4093 11.4796 56.178 9.81523 56.8872C9.60605 56.9743 9.38955 57.0386 9.17304 57.1028C8.85442 57.1947 8.71487 57.0427 8.73064 56.7302C8.73973 56.6012 8.74718 56.4829 8.78648 56.3695C9.14346 55.3276 9.50045 54.2857 9.87866 53.247C10.1987 52.3732 10.4709 52.2307 11.4084 52.3541C12.0153 52.4372 12.6384 52.5554 13.251 52.5307C16.2332 52.4384 18.7222 51.2486 20.6794 48.9988C21.1569 48.4426 21.5503 47.7974 21.9102 47.1579C22.2407 46.5682 22.0099 46.1631 21.3377 46.0808C21.0388 46.0453 20.7154 46.0279 20.4156 46.0684C17.3065 46.4887 14.4844 47.5835 12.1123 49.7039C11.9741 49.8237 11.7625 49.8561 11.5762 49.9359C11.556 49.7155 11.5374 49.4845 11.5278 49.2658C11.527 49.2005 11.5793 49.1434 11.6104 49.083C12.3811 47.6163 13.1746 46.1423 13.9362 44.6634C14.2798 43.9887 14.8298 43.7371 15.5509 43.7836C16.8096 43.8698 18.0772 43.9683 19.3391 44.0333C20.7512 44.1107 22.1359 43.9448 23.4065 43.2508C24.7475 42.5241 25.7025 41.4119 26.5464 40.1738C26.6715 39.9976 26.7877 39.8092 26.872 39.6158C27.0332 39.2063 26.9101 38.9482 26.4764 38.8702C26.1065 38.8021 25.7332 38.7552 25.3551 38.7401C23.6162 38.6664 22.0075 39.1561 20.4729 39.9396C19.4089 40.4919 18.3287 41.009 17.2485 41.5262C17.0973 41.5897 16.8793 41.5233 16.6939 41.5272C16.7341 41.3379 16.7187 41.0857 16.8356 40.9626C18.3807 39.4093 19.933 37.879 21.4944 36.3609C21.8017 36.0609 22.1791 36.0107 22.6103 36.1752C23.6481 36.564 24.6704 36.9829 25.7353 37.2673C28.4497 37.9917 30.9813 37.5797 33.2363 35.8648C33.7038 35.5135 34.128 35.0904 34.5221 34.6517C34.8221 34.3288 34.695 34.0267 34.3275 33.872Z" fill="#9B8329" /></svg></span></h2>
        </div>';
    }
}

function get_card_member($post_id)
{

    $thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
    if (!$thumbnail_url) {
        // Imagen por defecto si no hay thumbnail
        $thumbnail_url = IMG . '/2.png';
    }

    $title = get_the_title($post_id);
    $permalink = get_permalink($post_id);
    $name = explode(' ', $title)[0];

    $position = get_field('position_member', $post_id);

    echo '<a class="member_card" href="' . esc_url($permalink) . '">
        <div class="member_card-image">
            <img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($title) . '" loading="lazy">
            <div class="member_card-bio">
                <p>Bio</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                    <path d="M1 6H11M6 1V11" stroke="#47412E" stroke-linecap="square" />
                </svg>
            </div>
        </div>
        <div class="member_card-info">
            <h3>' . esc_html($name) . '</h3>';
    if (!empty($position)) {
        echo '<span>' . $position . '</span>';
    }
    echo '</div>
    </a>';
}

function get_card_article($post_id)
{
    $thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
    if (!$thumbnail_url) {
        $thumbnail_url = IMG . '/3.png';
    }

    $title     = get_the_title($post_id);
    $permalink = get_permalink($post_id);

    $date = get_the_date('d.m.y', $post_id);

    $content       = get_post_field('post_content', $post_id);
    $word_count    = str_word_count(wp_strip_all_tags($content));
    $reading_time  = ceil($word_count / 200);

    echo '<a href="' . esc_url($permalink) . '" class="d-block article_post">
        <div class="article_post-image">
            <img class="d-block" src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($title) . '">
        </div>
        <div class="article_post-info">
            <div class="article_post-name">
                <h2>' . esc_html($title) . '</h2>
                <p>' . esc_html($date) . ' • ' . esc_html($reading_time) . ' min read</p>
            </div>
            <div class="article_post-button">
                Read More
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M0.667969 8H14.668M14.668 8L7.66797 1M14.668 8L7.66797 15" stroke="white"/>
                </svg>
            </div>
        </div>
    </a>';
}

//----------------------------------------------------

function get_successful_property_count()
{
    $args = array(
        'post_type'      => 'successful_property',
        'posts_per_page' => -1, // Traer todos los posts
        'fields'         => 'ids', // Optimiza la consulta al solo traer IDs
    );

    $query = new WP_Query($args);

    // Devuelve el total de publicaciones
    $total_posts = $query->found_posts;

    // Limpia los datos del query
    wp_reset_postdata();

    return $total_posts;
}

function get_property_card($post_id, $format = 1)
{
    $thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
    $title = get_the_title($post_id);

    $tag = !empty(get_field('tag_property', $post_id)) ? get_field('tag_property', $post_id) : '';
    $price = !empty(get_field('price_property', $post_id)) ? get_field('price_property', $post_id) : '';
    $ubication = !empty(get_field('ubication_property', $post_id)) ? get_field('ubication_property', $post_id) : '';

    $link = !empty(get_field('link_property', $post_id)) ? get_field('link_property', $post_id) : '';

    if ($format == 1) {

        $link = get_permalink();

        if (!empty($link)) {
            echo '<a class="apartment_card" href="' . $link . '" alt="' . esc_html($title) . '" target="_blank">';
        } else {
            echo '<a class="apartment_card" alt="' . esc_html($title) . '">';
        }

        echo '<div class="apartment_card-img">
                <img src="' . $thumbnail_url . '" alt="' . esc_html($title) . '" loading="lazy">
            </div>
            <div class="apartment_card-info">
                <div class="apartment_card-name">
                    <h3>' . esc_html($title) . '</h3>';
        if (!empty($ubication)) {
            echo '<p>' . esc_html($ubication) . '</p>';
        }
        echo '  </div>';
        if (! empty($tag) && ! is_home() && ! is_front_page()) {
            echo '<span class="apartment_card-state"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="22" viewBox="0 0 12 22" fill="none">
                        <path d="M6.31686 9.48287C6.24508 9.58413 6.09543 9.7472 5.98565 9.84423C5.96032 9.76407 5.93499 9.73032 5.93499 9.69657C5.93499 9.43921 5.92232 9.18184 5.9561 8.9287C6.05321 8.241 6.09543 7.56174 5.90543 6.88248C5.79987 6.50699 5.65209 6.15259 5.42831 5.83195C5.30586 5.65475 5.1792 5.65475 5.0483 5.82351C4.99764 5.89102 4.95964 5.96696 4.92164 6.0429C4.47829 6.89936 4.3094 7.80223 4.48674 8.75994C4.60074 9.38436 4.84141 9.95393 5.19608 10.4771C5.34386 10.6965 5.39876 10.9285 5.28898 11.1817C5.11586 11.574 4.94275 11.9664 4.76119 12.3545C4.71052 12.46 4.62185 12.5444 4.55007 12.6372C4.52896 12.633 4.51207 12.633 4.49096 12.6288C4.44029 12.5106 4.37696 12.3925 4.3474 12.2702C4.12784 11.3546 3.80695 10.4771 3.32983 9.66703C3.18205 9.41811 2.96249 9.21138 2.76826 8.98777C2.68804 8.89495 2.61204 8.91605 2.56981 9.02996C2.46425 9.3042 2.30381 9.57422 2.27003 9.85689C2.20669 10.4011 2.20669 10.9538 2.19403 11.5023C2.18558 11.8567 2.28692 12.1858 2.49803 12.4685C2.86115 12.9579 3.30872 13.3545 3.87873 13.6034C4.14473 13.7173 4.21229 13.8523 4.14895 14.1308C4.07717 14.4472 4.00962 14.7636 3.93784 15.0758C3.84073 15.5062 3.74783 15.9323 3.64228 16.3584C3.62539 16.4217 3.54939 16.4723 3.50294 16.5314C3.44805 16.4807 3.36783 16.4428 3.34249 16.3795C3.27916 16.236 3.23271 16.0799 3.19471 15.9281C2.9076 14.7172 2.25736 13.7299 1.31157 12.9326C1.13423 12.7849 1.00334 12.8144 0.961115 13.038C0.902003 13.3376 0.864002 13.6413 0.817557 13.9451C0.792223 14.0843 0.771111 14.2236 0.75 14.3628L0.75 14.713C0.762667 14.7636 0.783778 14.81 0.792223 14.8564C0.944226 15.9787 1.50157 16.8225 2.50648 17.3541C2.69648 17.4553 2.90337 17.5271 3.10182 17.6114C3.33827 17.7085 3.43538 17.8857 3.42272 18.1388C3.39316 18.6746 3.37205 19.2147 3.35516 19.7547C3.34249 20.261 3.33405 20.7673 3.32983 21.2735C3.3256 21.6322 3.52405 21.8515 3.84917 21.9739C4.07717 22.0583 4.25029 21.9317 4.23762 21.687C4.22495 21.4634 4.20807 21.2356 4.20384 21.0077C4.19118 20.1808 4.17429 19.3581 4.17429 18.5312C4.17429 18.2105 4.27562 18.143 4.59229 18.1894C4.9723 18.2443 5.35653 18.2865 5.72387 18.1599C6.07432 18.0376 6.41633 17.8688 6.74567 17.6958C7.55213 17.2739 8.13903 16.6537 8.4177 15.772C8.44726 15.6834 8.46415 15.5948 8.4937 15.4808C8.32059 15.4555 8.17281 15.426 8.0208 15.4218C7.49302 15.4091 6.99901 15.5694 6.55144 15.8226C5.93499 16.1685 5.34809 16.5651 4.7443 16.9406C4.6683 16.987 4.58807 17.025 4.50785 17.063C4.38962 17.1178 4.32629 17.0672 4.31362 16.9448L4.31328 16.9407C4.30918 16.8917 4.30541 16.8465 4.31362 16.8014C4.38962 16.3753 4.46563 15.9492 4.55007 15.523C4.62185 15.1644 4.71896 15.0927 5.09053 15.0843C5.3312 15.08 5.58031 15.0885 5.81676 15.0421C6.96945 14.8269 7.86458 14.2151 8.48948 13.2237C8.64148 12.979 8.75549 12.7047 8.85682 12.4347C8.94971 12.1858 8.83571 12.0423 8.5697 12.0508C8.45148 12.055 8.32481 12.0677 8.21081 12.1014C7.02856 12.4516 5.99832 13.0465 5.20453 14.0126C5.15808 14.0675 5.07786 14.0928 5.0103 14.135C4.98919 14.0506 4.96808 13.962 4.95119 13.8776C4.94697 13.8523 4.96386 13.827 4.9723 13.8017C5.18342 13.1857 5.40298 12.5655 5.60987 11.9453C5.70276 11.6626 5.90121 11.5318 6.1841 11.5065C6.67811 11.4643 7.17634 11.4264 7.67035 11.3757C8.22348 11.3209 8.75126 11.1732 9.20305 10.8273C9.68017 10.4644 9.98418 9.97502 10.2375 9.44342C10.2755 9.36748 10.3093 9.28732 10.3304 9.20716C10.3684 9.0384 10.3051 8.94558 10.132 8.94136C9.98417 8.93714 9.83639 8.94136 9.68861 8.95824C9.00882 9.03418 8.41348 9.32108 7.86458 9.71766C7.48457 9.99612 7.09612 10.2619 6.70767 10.5277C6.65278 10.5615 6.56411 10.5488 6.49233 10.5615C6.49655 10.4855 6.47544 10.3885 6.51344 10.3336L7.70858 8.09116C7.70858 8.09116 8.03061 7.63872 8.26093 7.58583C8.66526 7.49128 9.06161 7.39168 9.46551 7.30133C9.94759 7.19349 10.397 7.03144 10.7895 6.71941C11.3482 6.27586 11.6723 5.67697 11.9129 5.02293C11.9665 4.87148 12.0647 4.69912 11.9347 4.55866C11.8089 4.41863 11.6268 4.49764 11.47 4.53681C10.5206 4.77518 9.74414 5.2729 9.14707 6.0518C9.08855 6.12642 8.96709 6.15222 8.87709 6.20243L8.90572 5.92121C8.90657 5.91282 8.91205 5.90065 8.91711 5.89269C9.33171 4.94678 9.85039 4.06236 10.4501 3.21588C11.1294 2.25451 11.4249 1.18622 11.1248 0.00641417L11.0618 4.11725e-08C10.8805 0.113013 10.6762 0.202474 10.5138 0.338612C9.64626 1.06454 9.11917 1.9481 9.19405 3.13043C9.24187 3.91136 9.08559 4.65456 8.68488 5.33895C8.53066 5.60314 8.39659 5.87787 8.24615 6.14669C8.21496 6.20288 8.14768 6.23844 8.09635 6.28411C8.06538 6.2131 8.03398 6.1463 8.01142 6.07615C8.00138 6.04968 8.01362 6.01276 8.02082 5.9838C8.09793 5.6015 8.16707 5.21414 8.24838 4.83227C8.43899 3.91869 8.33798 3.0348 7.93146 2.19191C7.82346 1.96039 7.64661 1.94663 7.49375 2.15583C7.10422 2.68869 6.84064 3.27678 6.73575 3.93191C6.56458 5.02981 6.78847 6.04071 7.39818 6.97214C7.59304 7.26763 7.55636 7.30133 7.35801 7.6169L6.31686 9.48287Z" fill="#47412E" />
                    </svg><p>' . $tag . '</p></span>';
        }
        echo '</div>
        </a>';
    }

    if ($format == 2) {

        echo '<div class="apartment_line">
            <div class="apartment_line-info">';
        if (!empty($tag)) {
            echo '<div class="tag"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="22" viewBox="0 0 12 22" fill="none"><path d="M6.31686 9.48287C6.24508 9.58413 6.09543 9.7472 5.98565 9.84423C5.96032 9.76407 5.93499 9.73032 5.93499 9.69657C5.93499 9.43921 5.92232 9.18184 5.9561 8.9287C6.05321 8.241 6.09543 7.56174 5.90543 6.88248C5.79987 6.50699 5.65209 6.15259 5.42831 5.83195C5.30586 5.65475 5.1792 5.65475 5.0483 5.82351C4.99764 5.89102 4.95964 5.96696 4.92164 6.0429C4.47829 6.89936 4.3094 7.80223 4.48674 8.75994C4.60074 9.38436 4.84141 9.95393 5.19608 10.4771C5.34386 10.6965 5.39876 10.9285 5.28898 11.1817C5.11586 11.574 4.94275 11.9664 4.76119 12.3545C4.71052 12.46 4.62185 12.5444 4.55007 12.6372C4.52896 12.633 4.51207 12.633 4.49096 12.6288C4.44029 12.5106 4.37696 12.3925 4.3474 12.2702C4.12784 11.3546 3.80695 10.4771 3.32983 9.66703C3.18205 9.41811 2.96249 9.21138 2.76826 8.98777C2.68804 8.89495 2.61204 8.91605 2.56981 9.02996C2.46425 9.3042 2.30381 9.57422 2.27003 9.85689C2.20669 10.4011 2.20669 10.9538 2.19403 11.5023C2.18558 11.8567 2.28692 12.1858 2.49803 12.4685C2.86115 12.9579 3.30872 13.3545 3.87873 13.6034C4.14473 13.7173 4.21229 13.8523 4.14895 14.1308C4.07717 14.4472 4.00962 14.7636 3.93784 15.0758C3.84073 15.5062 3.74783 15.9323 3.64228 16.3584C3.62539 16.4217 3.54939 16.4723 3.50294 16.5314C3.44805 16.4807 3.36783 16.4428 3.34249 16.3795C3.27916 16.236 3.23271 16.0799 3.19471 15.9281C2.9076 14.7172 2.25736 13.7299 1.31157 12.9326C1.13423 12.7849 1.00334 12.8144 0.961115 13.038C0.902003 13.3376 0.864002 13.6413 0.817557 13.9451C0.792223 14.0843 0.771111 14.2236 0.75 14.3628L0.75 14.713C0.762667 14.7636 0.783778 14.81 0.792223 14.8564C0.944226 15.9787 1.50157 16.8225 2.50648 17.3541C2.69648 17.4553 2.90337 17.5271 3.10182 17.6114C3.33827 17.7085 3.43538 17.8857 3.42272 18.1388C3.39316 18.6746 3.37205 19.2147 3.35516 19.7547C3.34249 20.261 3.33405 20.7673 3.32983 21.2735C3.3256 21.6322 3.52405 21.8515 3.84917 21.9739C4.07717 22.0583 4.25029 21.9317 4.23762 21.687C4.22495 21.4634 4.20807 21.2356 4.20384 21.0077C4.19118 20.1808 4.17429 19.3581 4.17429 18.5312C4.17429 18.2105 4.27562 18.143 4.59229 18.1894C4.9723 18.2443 5.35653 18.2865 5.72387 18.1599C6.07432 18.0376 6.41633 17.8688 6.74567 17.6958C7.55213 17.2739 8.13903 16.6537 8.4177 15.772C8.44726 15.6834 8.46415 15.5948 8.4937 15.4808C8.32059 15.4555 8.17281 15.426 8.0208 15.4218C7.49302 15.4091 6.99901 15.5694 6.55144 15.8226C5.93499 16.1685 5.34809 16.5651 4.7443 16.9406C4.6683 16.987 4.58807 17.025 4.50785 17.063C4.38962 17.1178 4.32629 17.0672 4.31362 16.9448L4.31328 16.9407C4.30918 16.8917 4.30541 16.8465 4.31362 16.8014C4.38962 16.3753 4.46563 15.9492 4.55007 15.523C4.62185 15.1644 4.71896 15.0927 5.09053 15.0843C5.3312 15.08 5.58031 15.0885 5.81676 15.0421C6.96945 14.8269 7.86458 14.2151 8.48948 13.2237C8.64148 12.979 8.75549 12.7047 8.85682 12.4347C8.94971 12.1858 8.83571 12.0423 8.5697 12.0508C8.45148 12.055 8.32481 12.0677 8.21081 12.1014C7.02856 12.4516 5.99832 13.0465 5.20453 14.0126C5.15808 14.0675 5.07786 14.0928 5.0103 14.135C4.98919 14.0506 4.96808 13.962 4.95119 13.8776C4.94697 13.8523 4.96386 13.827 4.9723 13.8017C5.18342 13.1857 5.40298 12.5655 5.60987 11.9453C5.70276 11.6626 5.90121 11.5318 6.1841 11.5065C6.67811 11.4643 7.17634 11.4264 7.67035 11.3757C8.22348 11.3209 8.75126 11.1732 9.20305 10.8273C9.68017 10.4644 9.98418 9.97502 10.2375 9.44342C10.2755 9.36748 10.3093 9.28732 10.3304 9.20716C10.3684 9.0384 10.3051 8.94558 10.132 8.94136C9.98417 8.93714 9.83639 8.94136 9.68861 8.95824C9.00882 9.03418 8.41348 9.32108 7.86458 9.71766C7.48457 9.99612 7.09612 10.2619 6.70767 10.5277C6.65278 10.5615 6.56411 10.5488 6.49233 10.5615C6.49655 10.4855 6.47544 10.3885 6.51344 10.3336L7.70858 8.09116C7.70858 8.09116 8.03061 7.63872 8.26093 7.58583C8.66526 7.49128 9.06161 7.39168 9.46551 7.30133C9.94759 7.19349 10.397 7.03144 10.7895 6.71941C11.3482 6.27586 11.6723 5.67697 11.9129 5.02293C11.9665 4.87148 12.0647 4.69912 11.9347 4.55866C11.8089 4.41863 11.6268 4.49764 11.47 4.53681C10.5206 4.77518 9.74414 5.2729 9.14707 6.0518C9.08855 6.12642 8.96709 6.15222 8.87709 6.20243L8.90572 5.92121C8.90657 5.91282 8.91205 5.90065 8.91711 5.89269C9.33171 4.94678 9.85039 4.06236 10.4501 3.21588C11.1294 2.25451 11.4249 1.18622 11.1248 0.00641417L11.0618 4.11725e-08C10.8805 0.113013 10.6762 0.202474 10.5138 0.338612C9.64626 1.06454 9.11917 1.9481 9.19405 3.13043C9.24187 3.91136 9.08559 4.65456 8.68488 5.33895C8.53066 5.60314 8.39659 5.87787 8.24615 6.14669C8.21496 6.20288 8.14768 6.23844 8.09635 6.28411C8.06538 6.2131 8.03398 6.1463 8.01142 6.07615C8.00138 6.04968 8.01362 6.01276 8.02082 5.9838C8.09793 5.6015 8.16707 5.21414 8.24838 4.83227C8.43899 3.91869 8.33798 3.0348 7.93146 2.19191C7.82346 1.96039 7.64661 1.94663 7.49375 2.15583C7.10422 2.68869 6.84064 3.27678 6.73575 3.93191C6.56458 5.02981 6.78847 6.04071 7.39818 6.97214C7.59304 7.26763 7.55636 7.30133 7.35801 7.6169L6.31686 9.48287Z" fill="#47412E" /></svg>' . $tag . '</div>';
        }
        echo '  <h3>' . esc_html($title) . '</h3>';
        if (!empty($ubication)) {
            echo '<h4>' . esc_html($ubication) . '</h4>';
        }
        if (!empty($price)) {
            echo '<h4 class="price">' . $price . '</h4>';
        }
        if (!empty($link)) {
            echo '<a href="' . $link . '" alt="Explore Property">Explore Property</a>';
        }
        echo '</div>
            <div class="apartment_line-image">
                <img src="' . $thumbnail_url . '" alt="' . esc_html($title) . '">';
        if (!empty($link)) {
            echo '<a href="' . $link . '" alt="Explore Property">Explore Property</a>';
        }
        echo '</div>
        </div>';
    }
}

function deleteLetters($sentence)
{
    // Usamos preg_replace para eliminar todas las letras de la a a la z (mayúsculas y minúsculas)
    return preg_replace('/[a-zA-Z]/', '', $sentence);
}
function get_properties_grid($actualPage, $search = '', $show = 9, $filterBedrooms = '', $filterPropertyType = '', $filterAvailability = '', $id_member = 0, $type = 'sale')
{

    $api_url = 'https://api.uk.rexsoftware.com/v1/rex/published-listings/search';

    $headers = array(
        'Authorization' => 'Bearer ' . get_api_token(),
        'Content-Type' => 'application/json',
    );

    $limit = $show;

    if ($actualPage == 1) {
        $offset = 0;
    } else {
        $offset = ($actualPage * $limit) - $limit;
    }

    $listing_category = ['residential_sale', 'commercial_sale']; // default: venta

    if ($type === 'rental') {
        $listing_category = ['residential_rent', 'commercial_rent'];
    }

    //-----------------------
    $search_params = array(
        'offset' => $offset,
        'limit' => $limit,
        'order_by' => array(
            "system_publication_time" => "DESC"
        ),
        'criteria' => array(
            array(
                "name" => "listing_category_id",
                "type" => "in",
                "value" => $listing_category
            ),
        )
    );
    //-----------------------

    if (!empty($filterBedrooms)) {
        $bedroom_criteria = array();
        if ($filterBedrooms == '1-2') {
            $bedroom_criteria[] = array(
                "name" => "property.attr_bedrooms",
                "type" => "<",
                "value" => 3
            );
        } elseif ($filterBedrooms == '3-4') {
            $bedroom_criteria[] = array(
                "name" => "property.attr_bedrooms",
                "type" => ">",
                "value" => 2
            );
            $bedroom_criteria[] = array(
                "name" => "property.attr_bedrooms",
                "type" => "<",
                "value" => 5
            );
        } elseif ($filterBedrooms == '5') {
            $bedroom_criteria[] = array(
                "name" => "property.attr_bedrooms",
                "type" => ">",
                "value" => 4
            );
        }
        $search_params['criteria'] = array_merge($search_params['criteria'], $bedroom_criteria);
    }
    if (!empty($filterPropertyType)) {
        $property_type_criteria = array();
        if ($filterPropertyType == 'flat') {
            $property_type_criteria[] = array(
                "name" => "property.property_subcategory_id",
                "type" => "in",
                "value" => ["26518", "26509"]
            );
        } elseif ($filterPropertyType == 'end-of-terrace') {
            $property_type_criteria[] = array(
                "name" => "property.property_subcategory_id",
                "type" => "in",
                "value" => ["26516"]
            );
        } elseif ($filterPropertyType == 'terraced') {
            $property_type_criteria[] = array(
                "name" => "property.property_subcategory_id",
                "type" => "in",
                "value" => ["26529", "26530"]
            );
        } elseif ($filterPropertyType == 'semi-detached') {
            $property_type_criteria[] = array(
                "name" => "property.property_subcategory_id",
                "type" => "in",
                "value" => ["26528", "26527"]
            );
        } elseif ($filterPropertyType == 'detached') {
            $property_type_criteria[] = array(
                "name" => "property.property_subcategory_id",
                "type" => "in",
                "value" => ["26515", "26514"]
            );
        }
        $search_params['criteria'] = array_merge($search_params['criteria'], $property_type_criteria);
    }
    if (!empty($search)) {
        $search_criteria = array(
            array(
                "name" => "property.system_search_key",
                "type" => "LIKE",
                "value" => "%$search%"
            )
        );
        $search_params['criteria'] = array_merge($search_params['criteria'], $search_criteria);
    }

    if ($id_member != 0) {

        $search_params['criteria'][] = array(
            "name" => "listing.listing_agent_1_id",
            "type" => "in",
            "value" => [(string)$id_member]
        );
    } else {
        if ($type === 'rental') {
            // Rental → solo activos
            $search_params['criteria'][] = array(
                "name" => "listing.system_listing_state",
                "type" => "in",
                "value" => ['current']
            );
        } else {
            // Sale → activos y vendidos
            $search_params['criteria'][] = array(
                "name" => "listing.system_listing_state",
                "type" => "in",
                "value" => ['current', 'sold']
            );
        }
    }

    if (!empty($filterAvailability)) {
        if ($filterAvailability == 'available') {
            $search_params['criteria'][] = array(
                "name" => "listing.system_listing_state",
                "type" => "in",
                "value" => ['current']
            );
            // "value" => ['current', 'withdrawn']
        } elseif ($filterAvailability == 'sold') {
            $search_params['criteria'][] = array(
                "name" => "listing.system_listing_state",
                "type" => "in",
                "value" => ['sold']
            );
        }
    }

    // debuggear($search_params);

    // Hacer la solicitud POST a la API de Rex
    $response = wp_remote_post($api_url, array(
        'headers' => $headers,
        'body' => json_encode($search_params),
    ));

    // Comprobar si la solicitud fue exitosa
    if (is_wp_error($response)) {
        return '<p class="no-one">No properties found</p>';
    }

    $gallery = '';
    $output = '';
    $price = '';
    $state = '';
    $subcategories = [];
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    //var_dump($data);

    $totalProperties = isset($data['result']['total']) ? intval($data['result']['total']) : 0;

    $output = '';

    if (isset($data['result']['rows'])) {
        if (!empty($data['result']['rows'])) {
            $output .= '<div class="for_sale-grid">';
            foreach ($data['result']['rows'] as $property) {

                // echo '<pre>';
                // var_dump($property);
                // echo '</pre><br><br><br>';

                $property_id = $property['id'];

                $contract_status = '';

                if (isset($property['price_advertise_as']) && !is_null($property['price_advertise_as'])) {
                    $price = deleteLetters($property['price_advertise_as']);
                } else {
                    $price = '';
                }

                /*if (isset($property['price_rent']) && !is_null($property['price_rent'])) {
                    $price = '£' . number_format($property['price_rent']) . ' p/month';
                } else {
                    $price = isset($property['price_match']) ? '£' . number_format($property['price_match']) : '';
                }*/

                $read_url1 = 'https://api.uk.rexsoftware.com/v1/rex/listings/read';

                $read_params = array(
                    'id' => $property_id,
                    'extra_fields' => ["contract", "application", "idealfors", "allowances", "events", "links", "bookings", "images", "floorplans", "tags", "features", "views", "advert_internet", "advert_brochure", "advert_stocklist", "documents", "subcategories", "meta", "cf.properties.*", "cf.listings.*"]
                );

                $read_response1 = wp_remote_post($read_url1, array(
                    'headers' => $headers,
                    'body' => json_encode($read_params),
                ));

                if (!is_wp_error($read_response1)) {
                    $read_body = wp_remote_retrieve_body($read_response1);
                    $read_data = json_decode($read_body, true);

                    $result = $read_data['result'];

                    // echo '<pre>';
                    // var_dump($result);
                    // echo '</pre>';

                    $contract_status = isset($result['comm_est_based_on_service']) && !empty($result['comm_est_based_on_service']) ? $result['comm_est_based_on_service'] : '';

                    $state = isset($result['system_listing_state']) ? $result['system_listing_state'] : '';

                    if (isset($result['property'])) {
                        $home = $result['property'];

                        $bed = isset($home['attr_bedrooms']) ? $home['attr_bedrooms'] : '';
                        $bath = isset($home['attr_bathrooms']) ? $home['attr_bathrooms'] : '';
                        $buildarea = isset($home['attr_buildarea']) ? $home['attr_buildarea'] . ' ' . $home['attr_buildarea_unit']['text'] : '';

                        $town_name = isset($home['adr_suburb_or_town']) ? $home['adr_suburb_or_town'] : '';
                        // $name_property = isset($home['adr_street_name']) ? $home['adr_street_number'] . ' ' . $home['adr_street_name'] : '';
                        $name_property = isset($home['adr_street_name']) ? $home['adr_street_name'] : '';
                    } else {
                        $bed = '';
                        $bath = '';
                        $buildarea = '';
                        $town_name = '';
                        $name_property = '';
                    }

                    if (isset($result['related'])) {
                        $related = $result['related'];
                        $gallery = isset($related['listing_images']) ? $related['listing_images'] : '';
                        $subcategories = isset($related['listing_subcategories']) ? $related['listing_subcategories'] : [];
                    } else {
                        $gallery = '';
                    }
                }


                $output .= '<a class="property_card" href="' . esc_url(home_url('residential-property')) . '?n=' . $property_id . '"';

                if (!empty($bed)) {
                    $output .= ' data-bedrooms="' . esc_attr($bed) . '"';
                }
                if (!empty($subcategories)) {
                    $property_category = $subcategories[0]['subcategory']['text'];
                    $property_category = strtolower($property_category);

                    if ($property_category == 'detached house') {
                        $property_category = 'detached';
                    }

                    $output .= ' data-property-type="' . strtolower($property_category) . '"';
                }

                $output .= '><div class="property_card-image relative">';

                if (isset($gallery) && !empty($gallery)) {
                    $mainImage = $gallery[0]['url'];
                    $output .= '<img src="https:' . esc_url($mainImage) . '" alt="' . $name_property . '" loading="lazy">';
                } else {
                    $output .= '<img src="' . IMG . '/1.jpg" alt="' . $name_property . '" loading="lazy">'; // Imagen por defecto si no hay imagen
                }

                if ($state == 'sold') {
                    $output .= '<span class="under_offer absolute">Sold</span>';
                } else {
                    if ($contract_status == 'Contracts') {
                        $output .= '<span class="under_offer absolute">Under Offer</span>';
                    }
                }

                $output .= '</div>';

                $output .= '<div class="w-100 relative property_card-mt">
                        <div class="property_card-info w-100 relative">
                            <div class="property_card-top">
                                <h3>' . esc_html($name_property) . '</h3>
                                <p>' . esc_html($town_name) . '</p>
                            </div>
                        <div class="property_card-bottom">
                            <div class="property_card-price">';
                if (!empty($price)) {
                    $output .= '<p>' . esc_html($price) . '</p>';
                } else {
                    $output .= '<p style="opacity:0;pointer-events:none;">£0</p>';
                }
                $output .= '</div>
                            <div class="property_card-features">';
                if (!empty($bed)) {
                    $output .= '<div class="tag">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M1.33398 2.66797V13.3346M1.33398 5.33463H13.334C13.6876 5.33463 14.0267 5.47511 14.2768 5.72516C14.5268 5.97521 14.6673 6.31435 14.6673 6.66797V13.3346M1.33398 11.3346H14.6673M4.00065 5.33463V11.3346" stroke="#47412E" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p>' . esc_html($bed) . ' bed</p>
                                </div>';
                }
                if (!empty($bath)) {
                    $output .= '<div class="tag">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M6.00065 4L4.33398 2.33333C4.16302 2.14046 3.92419 2.02105 3.66732 2C3.12265 2 2.66732 2.45533 2.66732 3V11.3333C2.66732 11.687 2.80779 12.0261 3.05784 12.2761C3.30789 12.5262 3.64703 12.6667 4.00065 12.6667H12.0007C12.3543 12.6667 12.6934 12.5262 12.9435 12.2761C13.1935 12.0261 13.334 11.687 13.334 11.3333V8M6.66732 3.33333L5.33398 4.66667M1.33398 8H14.6673M4.66732 12.6667V14M11.334 12.6667V14" stroke="#47412E" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p>' . esc_html($bath) . ' bath</p>
                                </div>';
                }
                if (!empty($buildarea)) {
                    $output .= '<div class="tag">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <g clip-path="url(#clip0_1923_5648)">
                                            <path d="M9.66653 8.33344L10.9999 7.00011M7.66653 6.33345L8.99987 5.00011M5.66653 4.33345L6.99987 3.00011M11.6665 10.3334L12.9999 9.00011M14.1999 10.2001C14.349 10.3488 14.4674 10.5254 14.5481 10.7199C14.6289 10.9144 14.6705 11.1229 14.6705 11.3334C14.6705 11.544 14.6289 11.7525 14.5481 11.947C14.4674 12.1415 14.349 12.3181 14.1999 12.4668L12.4665 14.2001C12.3179 14.3493 12.1413 14.4676 11.9468 14.5484C11.7523 14.6291 11.5438 14.6707 11.3332 14.6707C11.1226 14.6707 10.9141 14.6291 10.7196 14.5484C10.5251 14.4676 10.3485 14.3493 10.1999 14.2001L1.79987 5.80011C1.50024 5.49903 1.33203 5.09155 1.33203 4.66678C1.33203 4.24201 1.50024 3.83453 1.79987 3.53345L3.5332 1.80011C3.83428 1.50048 4.24177 1.33228 4.66653 1.33228C5.0913 1.33228 5.49879 1.50048 5.79987 1.80011L14.1999 10.2001Z" stroke="#47412E" stroke-linecap="round" stroke-linejoin="round"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1923_5648">
                                                <rect width="16" height="16" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <p>' . esc_html($buildarea) . '</p>
                                </div>';
                }
                $output .= '</div>
                                </div>
                            </div>
                        
                        <div class="w-100 property_card-listing absolute">
                            <p>View Listing</p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                                <path d="M0 8H14M14 8L7 1M14 8L7 15" stroke="white"/>
                            </svg>
                        </div>
            
                        </div>
                    </a>';
            }
            $output .= '</div>';
        } else {
            $output .= '<div class="w-100">
                <p class="no-one">No properties found</p>
            </div>';
        }
    } else {
        $output .= '<div class="w-100">
            <p class="no-one">No properties found</p>
        </div>';
    }

    if (empty($search) && ($totalProperties > $limit)) {

        $totalPages = ceil($totalProperties / $limit);
        $maxPagesToShow = 5; // Limitar el rango de páginas a mostrar (ejemplo: máximo 5 botones)

        $startPage = max(1, $actualPage - floor($maxPagesToShow / 2));
        $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);

        // Ajustar el rango si está desbalanceado
        if (($endPage - $startPage + 1) < $maxPagesToShow) {
            $startPage = max(1, $endPage - $maxPagesToShow + 1);
        }

        $output .= '<div class="for_sale-pagination pagination">
            <div class="pagination-nav">';
        if ($actualPage > 1) {
            $prevHref = '?s=&pagination=' . ($actualPage - 1);
            if (!empty($filterBedrooms)) {
                $prevHref .= '&bedrooms=' . $filterBedrooms;
            }
            if (!empty($filterPropertyType)) {
                $prevHref .= '&property_type=' . $filterPropertyType;
            }
            if (!empty($filterAvailability)) {
                $prevHref .= '&availability=' . $filterAvailability;
            }

            $output .= '<a class="pagination-prev" href="' . $prevHref . '" title="Prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M9 15L2 8M2 8L9 1M2 8H16" stroke="#47412E" stroke-width="1.5" />
                        </svg>
                    </a>';
        }
        for ($i = $startPage; $i <= $endPage; $i++) {
            $extra_class = ($i == $actualPage) ? 'active' : '';
            $curHref = '?s=&pagination=' . $i;
            if (!empty($filterBedrooms)) {
                $curHref .= '&bedrooms=' . $filterBedrooms;
            }
            if (!empty($filterPropertyType)) {
                $curHref .= '&property_type=' . $filterPropertyType;
            }
            if (!empty($filterAvailability)) {
                $curHref .= '&availability=' . $filterAvailability;
            }

            $output .= '<a class="pagination-button ' . $extra_class . '" href="' . $curHref . '">' . $i . '</a>';
        }
        if ($endPage < $totalPages) {
            $output .= '<span class="pagination-ellipsis">...</span>
                    <a class="pagination-button" href="?pagination=' . $totalPages . '">' . $totalPages . '</a>';
        }
        if ($actualPage < $totalPages) {
            $nextHref = '?s=&pagination=' . ($actualPage + 1);
            if (!empty($filterBedrooms)) {
                $nextHref .= '&bedrooms=' . $filterBedrooms;
            }
            if (!empty($filterPropertyType)) {
                $nextHref .= '&property_type=' . $filterPropertyType;
            }
            if (!empty($filterAvailability)) {
                $nextHref .= '&availability=' . $filterAvailability;
            }

            $output .= '<a class="pagination-next" href="' . $nextHref . '" title="Next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M7 1L14 8M14 8L7 15M14 8L-6.11959e-07 8" stroke="#47412E" stroke-width="1.5" />
                        </svg>
                    </a>';
        }
        $output .= '</div>';
        if ($id_member == 0) {
            $output .= '<div class="pagination-showing">
                    <p>
                        Showing
                        <select id="nav_posts" style="color:#400040">';
            for ($i = 1; $i < 5; $i++) {
                if ($limit == (9 * $i)) {
                    $output .= '<option style="color:#400040" value="' . (9 * $i) . '" selected>' . (9 * $i) . '</option>';
                } else {
                    $output .= '<option style="color:#400040" value="' . (9 * $i) . '">' . (9 * $i) . '</option>';
                }
            }
            $output .= '</select>
                        items out of ' . $totalProperties . '
                    </p>
                </div>';
        }
        $output .= '</div>';
    }

    echo $output;
}

//----------------------------------------------------

function get_letter_epc($number = 0)
{
    if ($number >= 92) {
        return 'A';
    } elseif ($number >= 81 && $number <= 91) {
        return 'B';
    } elseif ($number >= 69 && $number <= 80) {
        return 'C';
    } elseif ($number >= 55 && $number <= 68) {
        return 'D';
    } elseif ($number >= 39 && $number <= 54) {
        return 'E';
    } elseif ($number >= 21 && $number <= 38) {
        return 'F';
    } elseif ($number >= 1 && $number <= 20) {
        return 'G';
    } else {
        return '';
    }
}

function removeLeadingNumbers($string)
{
    // Utiliza una expresión regular para coincidir con números al principio de la cadena
    // que estén seguidos por un espacio.
    return preg_replace('/^\d+\s/', '', $string);
}

function get_body_single_property($id = '')
{
    $allowed_states = ['current', 'rent', 'sold'];

    if (!empty($id)) {

        $PlacesOfInterest = [];

        $property_category = '';
        $description = '';
        $key_features = [];
        $name_property = 'Property in Laurels';
        $gallery = [];
        $floorplan = [];
        $direction = '';
        $epc_image = '';
        $epc = '';
        $state = '';
        $price = '';

        // Configurar los encabezados para la solicitud
        $headers = array(
            'Authorization' => 'Bearer ' . get_api_token(),
            'Content-Type' => 'application/json',
        );

        $read_url1 = 'https://api.uk.rexsoftware.com/v1/rex/listings/read';
        $read_url2 = 'https://api.uk.rexsoftware.com/v1/rex/custom-fields/get-values-keyed-by-field-name';

        $read_params1 = array(
            'id' => $id,
            'extra_fields' => ["contract", "application", "idealfors", "allowances", "events", "links", "bookings", "images", "floorplans", "tags", "features", "views", "advert_internet", "advert_brochure", "advert_stocklist", "documents", "subcategories", "meta", "cf.properties.*", "cf.listings.*"]
        );
        $read_params2 = array(
            'service_name' => 'Listings',
            'service_object_id' => $id
        );

        $read_response1 = wp_remote_post($read_url1, array(
            'headers' => $headers,
            'body' => json_encode($read_params1),
        ));
        $read_response2 = wp_remote_post($read_url2, array(
            'headers' => $headers,
            'body' => json_encode($read_params2),
        ));

        if (!is_wp_error($read_response1)) {
            $read_body = wp_remote_retrieve_body($read_response1);
            $read_data = json_decode($read_body, true);

            $result = $read_data['result'];

            $id_agent = isset($result['listing_agent_1']['id']) ? $result['listing_agent_1']['id'] : 0;

            $contract_status = isset($result['comm_est_based_on_service']) && !empty($result['comm_est_based_on_service']) ? $result['comm_est_based_on_service'] : '';

            $state = isset($result['system_listing_state']) ? $result['system_listing_state'] : '';

            if (empty($state) || !in_array($state, $allowed_states)) {
                wp_safe_redirect(home_url('/'));
                exit;
            }

            $epc = isset($result['epc_current_eer']) ? $result['epc_current_eer'] : '';
            if (!empty($epc)) {
                $epc = get_letter_epc(intval($epc));
            }

            if (isset($result['epc_combined_chart'])) {
                $epc_image = $result['epc_combined_chart']['url'];
            }

            if (isset($result['address'])) {

                $address = $result['address'];
                $name_property = isset($address['street_name']) ? $address['street_number'] . ' ' . $address['street_name'] : '';
                echo '<input type="hidden" id="map_data" data-lat="' . $address['latitude'] . '" data-lng="' . $address['longitude'] . '">';
            } elseif (isset($result['property'])) {

                $property = $result['property'];
                // $name_property = isset($property['adr_street_name']) ? $property['adr_street_number'] . ' ' . $property['adr_street_name'] : '';
                $name_property = isset($property['adr_street_name']) ? $property['adr_street_name'] : '';

                // $direction = isset($property['system_search_key']) ? $property['system_search_key'] : '';
                // $direction = isset($property['adr_suburb_or_town']) ? $property['adr_suburb_or_town'] : '';
                $direction = isset($property['adr_street_name']) ? $property['adr_street_name'] . ', ' . $property['adr_suburb_or_town'] . ', ' . explode(' ', $property['adr_postcode'])[0] : '';

                $bed = isset($property['attr_bedrooms']) ? $property['attr_bedrooms'] : '';
                $bath = isset($property['attr_bathrooms']) ? $property['attr_bathrooms'] : '';
                $tenure = isset($property['attr_tenure']) ? $property['attr_tenure']['text'] : '';
                $buildarea = isset($property['attr_buildarea']) ? number_format($property['attr_buildarea']) . ' ' . $property['attr_buildarea_unit']['text'] : '';
                $landarea = isset($property['attr_landarea']) ? number_format($property['attr_landarea']) . ' ' . $property['attr_landarea_unit'] : '';

                echo '<input type="hidden" id="map_data" data-lat="' . $property['adr_latitude'] . '" data-lng="' . $property['adr_longitude'] . '">';
            }

            if (isset($result['related'])) {
                $related = $result['related'];

                $floorplan = isset($related['listing_floorplans']) ? $related['listing_floorplans'] : [];
                $gallery = isset($related['listing_images']) ? $related['listing_images'] : [];
                $key_features = isset($related['listing_highlights']) ? $related['listing_highlights'] : [];
                $description = isset($related['listing_adverts'][0]['advert_body']) ? $related['listing_adverts'][0]['advert_body'] : [];

                $subcategories = isset($related['listing_subcategories']) ? $related['listing_subcategories'] : [];
            }

            // $price = isset($result['price_match']) ? '£' . number_format($result['price_match']) : '';

            if (isset($result['price_advertise_as']) && !is_null($result['price_advertise_as'])) {
                $price = deleteLetters($result['price_advertise_as']);
            } else {
                $price = '';
            }
        }

        if (!is_wp_error($read_response2)) {
            $read_body = wp_remote_retrieve_body($read_response2);
            $read_data = json_decode($read_body, true);

            $PlacesOfInterest = $read_data['result'];
        }

        if (!empty($gallery)) {
            echo '<meta property="og:image" content="' . esc_url($gallery[0]['url']) . '">';
        }
        if (!empty($direction)) {
            echo '<meta property="og:description" content="' . $direction . '">';
        }

        echo '<script>
        	function setTitle(){
            	document.title = "' . $name_property . ' - Laurels";
            }
        	window.onpaint = setTitle();
        </script>';

        if (!empty($gallery)) {
            echo '<div class="popup" data-popup="1">
                <div class="popup__bg wh-100"></div>
                <div class="popup_content wh-100">
                    <div class="popup__body">
                        <button type="button" class="popup__close popup_toggle" data-id="1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M13 1L1 13M1 1L13 13" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <p>Close</p>
                        </button>
                        <div class="popup__slider">
                            <div class="splide w-100" role="group" id="property_photos">
                                <div class="splide__arrows">
                                	<button class="splide__arrow splide__arrow--prev">
                                		<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                                            <path d="M12.5013 1.33336L24.168 13M24.168 13L12.5013 24.6667M24.168 13L0.834636 13" stroke="#47412E" stroke-width="1.5"/>
                                        </svg>
                                	</button>
                                	<button class="splide__arrow splide__arrow--next">
                                		<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                                            <path d="M12.5013 1.33336L24.168 13M24.168 13L12.5013 24.6667M24.168 13L0.834636 13" stroke="#47412E" stroke-width="1.5"/>
                                        </svg>
                                	</button>
                                </div>
                                <div class="splide__track">
                                    <ul class="splide__list">';
            foreach ($gallery as $n => $image) {
                echo '<li class="splide__slide">
                                                <img src="' . $image['url'] . '" data-id="' . $n . '" class="d-block w-100">
                                            </li>';
            }
            echo '</ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

        if (!empty($epc_image)) {
            echo '<div class="popup" data-popup="3">
                <div class="popup__bg wh-100"></div>
                <div class="popup_content wh-100">
                    <div class="popup__body">
                        <button type="button" class="popup__close popup_toggle" data-id="3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M13 1L1 13M1 1L13 13" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <p>Close</p>
                        </button>
                        <div class="popup__slider">
                            <img src="' . esc_url($epc_image) . '" class="d-block w-100">
                        </div>
                    </div>
                </div>
            </div>';
        }

        if (!empty($floorplan)) {
            echo '<div class="popup" data-popup="2">
                <div class="popup__bg wh-100"></div>
                <div class="popup_content wh-100">
                    <div class="popup__body">
                        <button type="button" class="popup__close popup_toggle" data-id="2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M13 1L1 13M1 1L13 13" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            <p>Close</p>
                        </button>
                        <div class="popup__box">
                            <img src="' . esc_url($floorplan[0]['url']) . '">
                        </div>
                    </div>
                </div>
            </div>';
        }

        echo '<main class="single_property">
            <div class="container">
    
        <div class="single_property-head">
            <div class="single_property-name">
                <div class="single_property-back">
                    <a title="Back To Results" href="' . esc_url(home_url('for-sale')) . '">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                            <path d="M15 8L0.999999 8M0.999999 8L8 15M0.999999 8L8 1" stroke="black" />
                        </svg>
                        <p>Back To Results</p>
                    </a>
                </div>
                <h1>' . $name_property . '</h1>';
        if (!empty($direction)) {
            echo '<h2>' . removeLeadingNumbers($direction) . '</h2>';
        }
        echo '</div>
            <div class="single_property-price">';
        if (!empty($price)) {
            echo '<p>Guide Price</p>
                    <h3>' . $price . '</h3>';
        }
        echo '<div class="share">
                    <button type="button" class="share_button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M8.59 13.51L15.42 17.49M15.41 6.51L8.59 10.49M21 5C21 6.65685 19.6569 8 18 8C16.3431 8 15 6.65685 15 5C15 3.34315 16.3431 2 18 2C19.6569 2 21 3.34315 21 5ZM9 12C9 13.6569 7.65685 15 6 15C4.34315 15 3 13.6569 3 12C3 10.3431 4.34315 9 6 9C7.65685 9 9 10.3431 9 12ZM21 19C21 20.6569 19.6569 22 18 22C16.3431 22 15 20.6569 15 19C15 17.3431 16.3431 16 18 16C19.6569 16 21 17.3431 21 19Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Share
                    </button>
                    <div class="share_box">
                        <div class="share_box-widget">
                            ' . do_shortcode("[sharethis-inline-buttons]") . '
                        </div>
                        <div class="share_box-input">
                            <button type="button" class="copy_url" title="Copy URL">Copy URL</button>
                            <input type="hidden" class="value_url" value="' . esc_url(home_url('residential-property')) . '?n=' . $id . '">
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        if (!empty($gallery)) {
            echo '<div class="single_property-images relative">';
            /*foreach($gallery as $n => $image){
                if($n > 2){
                    echo '<a href="'.$image['url'].'" data-id="'.$n.'" class="glightbox3" data-gallery="gallery1" style="display:none">
                        <img src="'.$image['url'].'">
                    </a>';
                }else{
                    echo '<a href="'.$image['url'].'" data-id="'.$n.'" class="glightbox3" data-gallery="gallery1">
                        <img src="'.$image['url'].'">
                    </a>';
                }
            }*/

            foreach ($gallery as $n => $image) {
                if ($n > 2) {
                    echo '<a class="popup_toggle" data-id="1" style="display:none">
                        <img src="' . $image['url'] . '">
                    </a>';
                } else {
                    echo '<a class="popup_toggle" data-id="1">
                        <img src="' . $image['url'] . '">
                    </a>';
                }
            }

            if ($state == 'sold') {
                echo '<span class="under_offer absolute" style="display:block !important;">Sold</span>';
            } else {
                if ($contract_status == 'Contracts') {
                    echo '<span class="under_offer absolute" style="display:block !important;">Under Offer</span>';
                }
            }

            echo '</div>';
        }
        echo '<div class="single_property-actions">
            <div>';

        if (!empty($subcategories) || !empty($bed) || !empty($bath) || !empty($buildarea) || !empty($landarea)) {
            echo '<ul>';
            if (!empty($subcategories)) {
                $property_category = $subcategories[0]['subcategory']['text'];
                echo '<li>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M15 21V13C15 12.7348 14.8946 12.4804 14.7071 12.2929C14.5196 12.1053 14.2652 12 14 12H10C9.73478 12 9.48043 12.1053 9.29289 12.2929C9.10536 12.4804 9 12.7348 9 13V21M3 9.99997C2.99993 9.70904 3.06333 9.42159 3.18579 9.15768C3.30824 8.89378 3.4868 8.65976 3.709 8.47197L10.709 2.47297C11.07 2.16788 11.5274 2.00049 12 2.00049C12.4726 2.00049 12.93 2.16788 13.291 2.47297L20.291 8.47197C20.5132 8.65976 20.6918 8.89378 20.8142 9.15768C20.9367 9.42159 21.0001 9.70904 21 9.99997V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V9.99997Z" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>';
                if ($property_category == 'Detached house') {
                    echo '<p>Detached</p>';
                } else {
                    echo '<p>' . $property_category . '</p>';
                }
                echo '</span>
                        </li>';
            }
            if (!empty($bed)) {
                echo '<li>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M2 4V20M2 8H20C20.5304 8 21.0391 8.21071 21.4142 8.58579C21.7893 8.96086 22 9.46957 22 10V20M2 17H22M6 8V17" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p>' . $bed . ' Bed</p>
                            </span>
                        </li>';
            }
            if (!empty($bath)) {
                echo '<li>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 6L6.5 3.5C6.24356 3.21069 5.88531 3.03157 5.5 3C4.683 3 4 3.683 4 4.5V17C4 17.5304 4.21071 18.0391 4.58579 18.4142C4.96086 18.7893 5.46957 19 6 19H18C18.5304 19 19.0391 18.7893 19.4142 18.4142C19.7893 18.0391 20 17.5304 20 17V12M10 5L8 7M2 12H22M7 19V21M17 19V21" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p>' . $bath . ' Bath</p>
                            </span>
                        </li>';
            }
            if (!empty($buildarea) || !empty($landarea)) {
                echo '<li>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M14.5018 12.5L16.5018 10.5M11.5018 9.50005L13.5018 7.50005M8.50176 6.50005L10.5018 4.50005M17.5018 15.5L19.5018 13.5M21.3018 15.3C21.5255 15.523 21.703 15.788 21.8242 16.0797C21.9453 16.3714 22.0076 16.6842 22.0076 17C22.0076 17.3159 21.9453 17.6287 21.8242 17.9204C21.703 18.2121 21.5255 18.4771 21.3018 18.7L18.7018 21.3C18.4788 21.5238 18.2138 21.7013 17.9221 21.8225C17.6304 21.9436 17.3176 22.0059 17.0018 22.0059C16.6859 22.0059 16.3731 21.9436 16.0814 21.8225C15.7897 21.7013 15.5247 21.5238 15.3018 21.3L2.70176 8.70005C2.25231 8.24842 2 7.6372 2 7.00005C2 6.36289 2.25231 5.75167 2.70176 5.30005L5.30176 2.70005C5.75338 2.2506 6.3646 1.99829 7.00176 1.99829C7.63891 1.99829 8.25013 2.2506 8.70176 2.70005L21.3018 15.3Z" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p>';
                if (!empty($buildarea)) {
                    echo $buildarea;
                }
                if (!empty($buildarea) && !empty($landarea)) {
                    echo ' / ';
                }
                if (!empty($landarea)) {
                    echo $landarea;
                }
                echo '</p>
                            </span>
                        </li>';
            }
            echo '</ul>';
        } else {
            echo '<ul class="d-none"></ul>';
        }

        echo '<ul>';
        if (!empty($epc)) {
            echo '<li>
                            <span class="popup_toggle" data-id="3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M2 21C2 18 3.85 15.64 7.08 15C9.5 14.52 12 13 13 12M11 20C9.24406 20.0053 7.55025 19.3505 6.25452 18.1654C4.95878 16.9803 4.15577 15.3515 4.00474 13.6021C3.8537 11.8527 4.36569 10.1104 5.43915 8.72074C6.51261 7.33112 8.06913 6.3957 9.8 6.1C15.5 5 17 4.48 19 2C20 4 21 6.18 21 10C21 15.5 16.22 20 11 20Z" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p>EPC Rating: ' . $epc . '*</p>
                            </span>
                        </li>';
        }
        if (!empty($gallery)) {
            echo '<li>
                        <span class="popup_toggle" data-id="1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M14.5 4H9.5L7 7H4C3.46957 7 2.96086 7.21071 2.58579 7.58579C2.21071 7.96086 2 8.46957 2 9V18C2 18.5304 2.21071 19.0391 2.58579 19.4142C2.96086 19.7893 3.46957 20 4 20H20C20.5304 20 21.0391 19.7893 21.4142 19.4142C21.7893 19.0391 22 18.5304 22 18V9C22 8.46957 21.7893 7.96086 21.4142 7.58579C21.0391 7.21071 20.5304 7 20 7H17L14.5 4Z" stroke="black" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M12 16C13.6569 16 15 14.6569 15 13C15 11.3431 13.6569 10 12 10C10.3431 10 9 11.3431 9 13C9 14.6569 10.3431 16 12 16Z" stroke="black" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                            <p>Gallery</p>
                        </span>
                    </li>';
        }
        if (!empty($floorplan)) {
            echo '<li>
                        <span class="popup_toggle" data-id="2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M17.5 19V19.75V19ZM17.5 12V11.25V12ZM3 8.5H2.25H3ZM6.5 5V4.25V5ZM8.25 19C8.25 20.2426 7.24264 21.25 6 21.25V22.75C8.07107 22.75 9.75 21.0711 9.75 19H8.25ZM6 21.25C4.75736 21.25 3.75 20.2426 3.75 19H2.25C2.25 21.0711 3.92893 22.75 6 22.75V21.25ZM3.75 19C3.75 17.7574 4.75736 16.75 6 16.75V15.25C3.92893 15.25 2.25 16.9289 2.25 19H3.75ZM6 16.75C7.24264 16.75 8.25 17.7574 8.25 19H9.75C9.75 16.9289 8.07107 15.25 6 15.25V16.75ZM9 19.75H17.5V18.25H9V19.75ZM17.5 19.75C18.6272 19.75 19.7082 19.3022 20.5052 18.5052L19.4445 17.4445C18.9288 17.9603 18.2293 18.25 17.5 18.25V19.75ZM20.5052 18.5052C21.3022 17.7082 21.75 16.6272 21.75 15.5H20.25C20.25 16.2293 19.9603 16.9288 19.4445 17.4445L20.5052 18.5052ZM21.75 15.5C21.75 14.3728 21.3022 13.2918 20.5052 12.4948L19.4445 13.5555C19.9603 14.0712 20.25 14.7707 20.25 15.5H21.75ZM20.5052 12.4948C19.7082 11.6978 18.6272 11.25 17.5 11.25V12.75C18.2293 12.75 18.9288 13.0397 19.4445 13.5555L20.5052 12.4948ZM17.5 11.25H6.5V12.75H17.5V11.25ZM6.5 11.25C5.77065 11.25 5.07118 10.9603 4.55546 10.4445L3.4948 11.5052C4.29183 12.3022 5.37283 12.75 6.5 12.75V11.25ZM4.55546 10.4445C4.03973 9.92882 3.75 9.22935 3.75 8.5H2.25C2.25 9.62717 2.69777 10.7082 3.4948 11.5052L4.55546 10.4445ZM3.75 8.5C3.75 7.77065 4.03973 7.07118 4.55546 6.55546L3.4948 5.4948C2.69777 6.29183 2.25 7.37283 2.25 8.5H3.75ZM4.55546 6.55546C5.07118 6.03973 5.77065 5.75 6.5 5.75V4.25C5.37283 4.25 4.29183 4.69777 3.4948 5.4948L4.55546 6.55546ZM6.5 5.75H15V4.25H6.5V5.75ZM20.25 5C20.25 6.24264 19.2426 7.25 18 7.25V8.75C20.0711 8.75 21.75 7.07107 21.75 5H20.25ZM18 7.25C16.7574 7.25 15.75 6.24264 15.75 5H14.25C14.25 7.07107 15.9289 8.75 18 8.75V7.25ZM15.75 5C15.75 3.75736 16.7574 2.75 18 2.75V1.25C15.9289 1.25 14.25 2.92893 14.25 5H15.75ZM18 2.75C19.2426 2.75 20.25 3.75736 20.25 5H21.75C21.75 2.92893 20.0711 1.25 18 1.25V2.75Z" fill="black" />
                            </svg>
                            <p>Floorplan</p>
                        </span>
                    </li>';
        }
        echo '<li>
                        <button data-target="#map" type="button" class="scroll_map">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M20 10C20 14.993 14.461 20.193 12.601 21.799C12.4277 21.9293 12.2168 21.9998 12 21.9998C11.7832 21.9998 11.5723 21.9293 11.399 21.799C9.539 20.193 4 14.993 4 10C4 7.87827 4.84285 5.84344 6.34315 4.34315C7.84344 2.84285 9.87827 2 12 2C14.1217 2 16.1566 2.84285 17.6569 4.34315C19.1571 5.84344 20 7.87827 20 10Z" stroke="black" stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="black" stroke-width="1.5" stroke-linejoin="round" />
                            </svg>
                            <p>Map</p>
                        </button>
                    </li>
                </ul>
            </div>';

        if (!empty($state)) {
            if ($state == 'sold') {
                echo '<a title="Book A Viewing" disabled>Book A Viewing</a>';
            } else {
                echo '<a href="' . esc_url(home_url('get-in-touch')) . '?viewing" title="Book A Viewing">Book A Viewing</a>';
            }
        } else {
            echo '<a></a>';
        }

        echo '</div>';

        $disclaimer1 = "- We try to make our details accurate & reliable, they're only a general guide and if there is any point which is of particular importance to you, please contact us and we'll check the position for you, especially if you are thinking of travelling some distance to view the property.";
        $disclaimer2 = "- Measurements shown are supplied for guidance only & must be considered incorrect.";
        $disclaimer3 = "- We've not tested any services/equipment or appliances in this property. We strongly advise buyers to get their own survey or service reports before finalising their offer to purchase.";
        $disclaimer4 = "- The details are issued in good faith and they're based on written/verbal info by the owners. They do not constitute representations of fact or form part of any offer or contract. Everything should be independently verified by prospective buyers. Neither Laurels nor any of its employees/agents has any authority to make/give any representation/warranty in relation to this property.";

        echo '<div class="single_property-content">';

        echo '<div class="w-100 single_property-lefty">';
        if (!empty($key_features)) {
            echo '<div class="wh-100"><div class="single_property-features">
                    <h4>Key Features</h4>
                    <ul>';
            if (!empty($tenure)) {
                echo '<li>Tenure: ' . $tenure . '</li>';
            }
            foreach ($key_features as $feature) {
                echo '<li>' . $feature['description'] . '</li>';
            }
            echo '</ul>
                </div></div>';
        }

        if ($id_agent != 0) {

            $args = array(
                'post_type' => 'member',
                'posts_per_page' => 1,
                'meta_query' => array(
                    array(
                        'key' => 'id_in_rex',
                        'value' => "$id_agent",
                        'compare' => '='
                    )
                )
            );
            $query = new WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    $fullname = get_the_title();
                    $firstname = explode(" ", $fullname)[0] ?? '';
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $member_link = get_permalink();

                    echo '<div class="managed_by">
                        <h4>Listing managed by:</h4>
                        <div class="managed_by-member">
                            <img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '" title="' . esc_attr(get_the_title()) . '">
                            <div class="managed_by-info">
                                <h3>' . $fullname . '</h3>
                                <div>';
                    if (!empty($state)) {
                        if ($state == 'sold') {
                            echo '<a title="Book A Viewing" disabled>
                                                    Book A Viewing
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                        <path d="M0.5 8H14.5M14.5 8L7.5 1M14.5 8L7.5 15" stroke="white" />
                                                    </svg>
                                                </a>';
                        } else {
                            echo '<a title="Book A Viewing" href="' . esc_url(home_url('get-in-touch')) . '?viewing">
                                                        Book A Viewing
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M0.5 8H14.5M14.5 8L7.5 1M14.5 8L7.5 15" stroke="white" />
                                                        </svg>
                                                    </a>';
                        }
                    }
                    echo "<a href='" . esc_url($member_link) . "' class='xplr' title='" . esc_attr(get_the_title()) . "'>
                            Explore " . $firstname . "'s Properties
                        </a>
                                </div>
                            </div>
                        </div>
                    </div>";
                }
                wp_reset_postdata();
            }
        }

        echo '</div>';

        echo '<div class="w-100">';
        if (!empty($description)) {
            echo '<div class="single_property-description">
                        <h4>Description</h4>
                        <div class="text_content">
                            <p>' . nl2br($description) . '</p>
                        </div>
                    </div>';
        }
        echo '<div class="single_property-disclaimer">
                    <h5>Disclaimer</h5>
                    <ul>
                        <li>' . $disclaimer1 . '</li>
                        <li>' . $disclaimer2 . '</li>
                        <li>' . $disclaimer3 . '</li>
                        <li>' . $disclaimer4 . '</li>
                    </ul>
                </div>
                <div class="single_property-buttons">';
        if (!empty($state)) {
            if ($state == 'sold') {
                echo '<a title="Book A Viewing" disabled>
                            Book A Viewing
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M0.5 8H14.5M14.5 8L7.5 1M14.5 8L7.5 15" stroke="white" />
                            </svg>
                        </a>';
            } else {
                echo '<a title="Book A Viewing" href="' . esc_url(home_url('get-in-touch')) . '?viewing">
                                Book A Viewing
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M0.5 8H14.5M14.5 8L7.5 1M14.5 8L7.5 15" stroke="white" />
                                </svg>
                            </a>';
            }
        } else {
            echo '<a style="opacity:0;pointer-events:none;"></a>';
        }
        echo '<a href="' . esc_url(home_url('get-in-touch')) . '" title="Email Us">
                        Email Us
                    </a>
                </div>
            </div>
        </div>
        
        <div class="w-100 single_property-lastshare">
            <div class="share">
                <button type="button" class="share_button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M8.59 13.51L15.42 17.49M15.41 6.51L8.59 10.49M21 5C21 6.65685 19.6569 8 18 8C16.3431 8 15 6.65685 15 5C15 3.34315 16.3431 2 18 2C19.6569 2 21 3.34315 21 5ZM9 12C9 13.6569 7.65685 15 6 15C4.34315 15 3 13.6569 3 12C3 10.3431 4.34315 9 6 9C7.65685 9 9 10.3431 9 12ZM21 19C21 20.6569 19.6569 22 18 22C16.3431 22 15 20.6569 15 19C15 17.3431 16.3431 16 18 16C19.6569 16 21 17.3431 21 19Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Share
                </button>
                <div class="share_box">
                    <div class="share_box-widget">
                        ' . do_shortcode("[sharethis-inline-buttons]") . '
                    </div>
                    <div class="share_box-input">
                        <button type="button" class="copy_url" title="Copy URL">Copy URL</button>
                    </div>
                </div>
            </div>
        </div>';

        if (!empty($PlacesOfInterest)) {

            // var_dump($PlacesOfInterest);

            echo '<div class="single_property-map" id="map">';

            if (!empty($PlacesOfInterest["core.key_details.Place Of Interest - Nearest Train Stations.Ubication 1"]) || !empty($PlacesOfInterest["core.key_details.Place Of Interest - Nearest Schools.Ubication 1"]) || !empty($PlacesOfInterest["core.key_details.Place Of Interest - Areas Of Interest.Ubication 1"])) {

                echo '<div id="map_canvas"></div>
                    <div class="interest">
                        <h3>Places of Interest</h3>
                        <div class="interest-grid">';

                if (!empty($PlacesOfInterest["core.key_details.Place Of Interest - Nearest Train Stations.Ubication 1"])) {
                    echo '<div>
                                    <h4>Nearest Train Stations</h4>
                                    <ul>';
                    for ($i = 1; $i < 4; $i++) {
                        $val1 = isset($PlacesOfInterest["core.key_details.Place Of Interest - Nearest Train Stations.Ubication $i"]) ? $PlacesOfInterest["core.key_details.Place Of Interest - Nearest Train Stations.Ubication $i"] : '';
                        $val2 = isset($PlacesOfInterest["core.key_details.Place Of Interest - Nearest Train Stations.Distance $i"]) ? $PlacesOfInterest["core.key_details.Place Of Interest - Nearest Train Stations.Distance $i"] : '';
                        if (!empty($val1) || !empty($val2)) {
                            echo '<li>
                                                    <img src="' . IMG . '/icon/rail_logo.svg">
                                                    <b>' . $val1 . ' •</b> ' . $val2 . '
                                                </li>';
                        }
                    }
                    echo '</ul>
                                </div>';
                }

                if (!empty($PlacesOfInterest["core.key_details.Place Of Interest - Nearest Schools.Ubication 1"])) {
                    echo '<div>
                                    <h4>Nearest Schools</h4>
                                    <ul>';
                    for ($i = 1; $i < 4; $i++) {
                        $val1 = isset($PlacesOfInterest["core.key_details.Place Of Interest - Nearest Schools.Ubication $i"]) ? $PlacesOfInterest["core.key_details.Place Of Interest - Nearest Schools.Ubication $i"] : '';
                        $val2 = isset($PlacesOfInterest["core.key_details.Place Of Interest - Nearest Schools.Distance $i"]) ? $PlacesOfInterest["core.key_details.Place Of Interest - Nearest Schools.Distance $i"] : '';
                        if (!empty($val1) || !empty($val2)) {
                            echo '<li>
                                                    <img src="' . IMG . '/icon/university.svg">
                                                    ' . $val1 . ' • ' . $val2 . '
                                                </li>';
                        }
                    }
                    echo '</ul>
                                </div>';
                }

                if (!empty($PlacesOfInterest["core.key_details.Place Of Interest - Areas Of Interest.Ubication 1"])) {
                    echo '<div>
                                    <h4>Areas Of Interest</h4>
                                    <ul>';
                    $icons = ['trees.svg', 'landmark.svg', 'shopping-bag.svg'];
                    for ($i = 1; $i < 4; $i++) {
                        $val1 = isset($PlacesOfInterest["core.key_details.Place Of Interest - Areas Of Interest.Ubication $i"]) ? $PlacesOfInterest["core.key_details.Place Of Interest - Areas Of Interest.Ubication $i"] : '';
                        $val2 = isset($PlacesOfInterest["core.key_details.Place Of Interest - Areas Of Interest.Distance $i"]) ? $PlacesOfInterest["core.key_details.Place Of Interest - Areas Of Interest.Distance $i"] : '';
                        if (!empty($val1) || !empty($val2)) {
                            echo '<li>
                                                    <img src="' . IMG . '/icon/' . $icons[$i - 1] . '">
                                                    ' . $val1 . ' • ' . $val2 . '
                                                </li>';
                        }
                    }
                    echo '</ul>
                                </div>';
                }

                echo '</div>
                    </div>';
            } else {

                echo '<div id="map_canvas" class="in_2_cols"></div>';
            }

            echo '</div>';
        }
    }
}

/**
 * Versión ACF de la ficha de propiedad individual.
 * Mantiene una estructura muy similar a get_body_single_property(),
 * pero obtiene toda la información desde campos ACF del propio post
 * y NO desde la API de REX.
 *
 * Pensado para usarse, por ejemplo, en el CPT "successful_property".
 */
function get_body_single_property_acf($post_id = 0)
{
    if (empty($post_id)) {
        $post_id = get_the_ID();
    }

    if (empty($post_id)) {
        return;
    }

    // Datos base del post
    $name_property = get_the_title($post_id);
    $place_name_acf = get_field('place_name', $post_id);
    if (!empty($place_name_acf)) {
        $name_property = $place_name_acf;
    }

    // Campos ACF según los "name" del grupo
    $direction = get_field('address_place', $post_id);
    $city      = ''; // normalmente la ciudad ya viene incluida en address_place
    $price     = get_field('price_property', $post_id);
    $bed       = get_field('bedrooms_property', $post_id);
    $bath      = get_field('bathrooms_property', $post_id);
    $buildarea = get_field('area_property', $post_id);
    $landarea  = get_field('land_area', $post_id);
    $type_property  = get_field('type_property', $post_id);

    $epc       = get_field('epc_rating', $post_id);
    $epc_image = get_field('epc_image', $post_id);
    // ACF "status" es un true/false: marcado => sold
    $is_sold   = get_field('status_property', $post_id);

    $key_features = get_field('key_features', $post_id); // repeater

    // Galería
    $gallery = [];
    $acf_gallery = get_field('gallery_property', $post_id);
    if (is_array($acf_gallery) && !empty($acf_gallery)) {
        foreach ($acf_gallery as $image) {
            if (isset($image['url'])) {
                $gallery[] = ['url' => $image['url']];
            }
        }
    } else {
        $thumb = get_the_post_thumbnail_url($post_id, 'full');
        if ($thumb) {
            $gallery[] = ['url' => $thumb];
        }
    }

    // Plano
    $floorplan = [];
    $acf_floorplan = get_field('floorplan_property', $post_id);
    if (!empty($acf_floorplan) && isset($acf_floorplan['url'])) {
        $floorplan[] = ['url' => $acf_floorplan['url']];
    }

    // Mapa (grupo "Coordenadas" → coordenadas_property[lat_prop,lng_prop])
    $map = get_field('coordenadas_property', $post_id);
    if (!empty($map) && isset($map['lat_prop']) && isset($map['lng_prop'])) {
        echo '<input type="hidden" id="map_data" data-lat="' . esc_attr($map['lat_prop']) . '" data-lng="' . esc_attr($map['lng_prop']) . '">';
    }

    // Meta tags
    if (!empty($gallery)) {
        echo '<meta property="og:image" content="' . esc_url($gallery[0]['url']) . '">';
    }
    if (!empty($direction)) {
        echo '<meta property="og:description" content="' . esc_attr($direction) . '">';
    }

    echo '<script>
        function setTitle(){
            document.title = "' . esc_js($name_property) . ' - Laurels";
        }
        window.onpaint = setTitle();
    </script>';

    // Popups de galería / EPC / plano
    if (!empty($gallery)) {
        echo '<div class="popup" data-popup="1">
            <div class="popup__bg wh-100"></div>
            <div class="popup_content wh-100">
                <div class="popup__body">
                    <button type="button" class="popup__close popup_toggle" data-id="1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M13 1L1 13M1 1L13 13" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <p>Close</p>
                    </button>
                    <div class="popup__slider">
                        <div class="splide w-100" role="group" id="property_photos">
                            <div class="splide__arrows">
                                <button class="splide__arrow splide__arrow--prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                                        <path d="M12.5013 1.33336L24.168 13M24.168 13L12.5013 24.6667M24.168 13L0.834636 13" stroke="#47412E" stroke-width="1.5"/>
                                    </svg>
                                </button>
                                <button class="splide__arrow splide__arrow--next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26" fill="none">
                                        <path d="M12.5013 1.33336L24.168 13M24.168 13L12.5013 24.6667M24.168 13L0.834636 13" stroke="#47412E" stroke-width="1.5"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="splide__track">
                                <ul class="splide__list">';
        foreach ($gallery as $n => $image) {
            echo '<li class="splide__slide">
                                        <img src="' . esc_url($image['url']) . '" data-id="' . esc_attr($n) . '" class="d-block w-100">
                                    </li>';
        }
        echo '              </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

    if (!empty($epc_image)) {
        echo '<div class="popup" data-popup="3">
            <div class="popup__bg wh-100"></div>
            <div class="popup_content wh-100">
                <div class="popup__body">
                    <button type="button" class="popup__close popup_toggle" data-id="3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M13 1L1 13M1 1L13 13" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <p>Close</p>
                    </button>
                    <div class="popup__slider">
                        <img src="' . esc_url($epc_image['url']) . '" class="d-block w-100">
                    </div>
                </div>
            </div>
        </div>';
    }

    if (!empty($floorplan)) {
        echo '<div class="popup" data-popup="2">
            <div class="popup__bg wh-100"></div>
            <div class="popup_content wh-100">
                <div class="popup__body">
                    <button type="button" class="popup__close popup_toggle" data-id="2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M13 1L1 13M1 1L13 13" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        <p>Close</p>
                    </button>
                    <div class="popup__box">
                        <img src="' . esc_url($floorplan[0]['url']) . '">
                    </div>
                </div>
            </div>
        </div>';
    }

    echo '<main class="single_property">
            <div class="container">';

    echo '<div class="single_property-head">
        <div class="single_property-name">
            <div class="single_property-back">
                <a title="Back To Results" href="' . esc_url(home_url('for-sale')) . '">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
                        <path d="M15 8L0.999999 8M0.999999 8L8 15M0.999999 8L8 1" stroke="black" />
                    </svg>
                    <p>Back To Results</p>
                </a>
            </div>
            <h1>' . esc_html($name_property) . '</h1>';

    if (!empty($direction) || !empty($city)) {
        $full_direction = trim($direction . (!empty($city) ? ', ' . $city : ''));
        echo '<h2>' . esc_html($full_direction) . '</h2>';
    }

    echo '</div>
        <div class="single_property-price">';

    if (!empty($price)) {
        echo '<p>Guide Price</p>
                <h3>' . esc_html($price) . '</h3>';
    }

    echo '<div class="share">
                <button type="button" class="share_button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M8.59 13.51L15.42 17.49M15.41 6.51L8.59 10.49M21 5C21 6.65685 19.6569 8 18 8C16.3431 8 15 6.65685 15 5C15 3.34315 16.3431 2 18 2C19.6569 2 21 3.34315 21 5ZM9 12C9 13.6569 7.65685 15 6 15C4.34315 15 3 13.6569 3 12C3 10.3431 4.34315 9 6 9C7.65685 9 9 10.3431 9 12ZM21 19C21 20.6569 19.6569 22 18 22C16.3431 22 15 20.6569 15 19C15 17.3431 16.3431 16 18 16C19.6569 16 21 17.3431 21 19Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Share
                </button>
                <div class="share_box">
                    <div class="share_box-widget">
                        ' . do_shortcode("[sharethis-inline-buttons]") . '
                    </div>
                    <div class="share_box-input">
                        <button type="button" class="copy_url" title="Copy URL">Copy URL</button>
                        <input type="hidden" class="value_url" value="' . esc_url(get_permalink($post_id)) . '">
                    </div>
                </div>
            </div>
        </div>
    </div>';

    // Imágenes de cabecera
    if (!empty($gallery)) {
        echo '<div class="single_property-images relative">';
        foreach ($gallery as $n => $image) {
            $style = $n > 2 ? 'style="display:none"' : '';
            echo '<a class="popup_toggle" data-id="1" ' . $style . '>
                    <img src="' . esc_url($image['url']) . '">
                </a>';
        }

        if ($is_sold) {
            echo '<span class="under_offer absolute" style="display:block !important;">Sold</span>';
        }

        echo '</div>';
    }

    // Bloque de acciones/características
    echo '<div class="single_property-actions">
        <div>';

    if (!empty($bed) || !empty($bath) || !empty($buildarea) || !empty($landarea)) {
        echo '<ul>';
        if (!empty($type_property)) {
            echo '<li>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M15 21V13C15 12.7348 14.8946 12.4804 14.7071 12.2929C14.5196 12.1053 14.2652 12 14 12H10C9.73478 12 9.48043 12.1053 9.29289 12.2929C9.10536 12.4804 9 12.7348 9 13V21M3 9.99997C2.99993 9.70904 3.06333 9.42159 3.18579 9.15768C3.30824 8.89378 3.4868 8.65976 3.709 8.47197L10.709 2.47297C11.07 2.16788 11.5274 2.00049 12 2.00049C12.4726 2.00049 12.93 2.16788 13.291 2.47297L20.291 8.47197C20.5132 8.65976 20.6918 8.89378 20.8142 9.15768C20.9367 9.42159 21.0001 9.70904 21 9.99997V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V9.99997Z" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <p>' . esc_html($type_property) . '</p>
                        </span>
                    </li>';
        }
        if (!empty($bed)) {
            echo '<li>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M2 4V20M2 8H20C20.5304 8 21.0391 8.21071 21.4142 8.58579C21.7893 8.96086 22 9.46957 22 10V20M2 17H22M6 8V17" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p>' . esc_html($bed) . ' Bed</p>
                        </span>
                    </li>';
        }
        if (!empty($bath)) {
            echo '<li>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M9 6L6.5 3.5C6.24356 3.21069 5.88531 3.03157 5.5 3C4.683 3 4 3.683 4 4.5V17C4 17.5304 4.21071 18.0391 4.58579 18.4142C4.96086 18.7893 5.46957 19 6 19H18C18.5304 19 19.0391 18.7893 19.4142 18.4142C19.7893 18.0391 20 17.5304 20 17V12M10 5L8 7M2 12H22M7 19V21M17 19V21" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p>' . esc_html($bath) . ' Bath</p>
                        </span>
                    </li>';
        }
        if (!empty($buildarea) || !empty($landarea)) {
            echo '<li>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M14.5018 12.5L16.5018 10.5M11.5018 9.50005L13.5018 7.50005M8.50176 6.50005L10.5018 4.50005M17.5018 15.5L19.5018 13.5M21.3018 15.3C21.5255 15.523 21.703 15.788 21.8242 16.0797C21.9453 16.3714 22.0076 16.6842 22.0076 17C22.0076 17.3159 21.9453 17.6287 21.8242 17.9204C21.703 18.2121 21.5255 18.4771 21.3018 18.7L18.7018 21.3C18.4788 21.5238 18.2138 21.7013 17.9221 21.8225C17.6304 21.9436 17.3176 22.0059 17.0018 22.0059C16.6859 22.0059 16.3731 21.9436 16.0814 21.8225C15.7897 21.7013 15.5247 21.5238 15.3018 21.3L2.70176 8.70005C2.25231 8.24842 2 7.6372 2 7.00005C2 6.36289 2.25231 5.75167 2.70176 5.30005L5.30176 2.70005C5.75338 2.2506 6.3646 1.99829 7.00176 1.99829C7.63891 1.99829 8.25013 2.2506 8.70176 2.70005L21.3018 15.3Z" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p>';
            if (!empty($buildarea)) {
                echo esc_html($buildarea);
            }
            if (!empty($buildarea) && !empty($landarea)) {
                echo ' / ';
            }
            if (!empty($landarea)) {
                echo esc_html($landarea);
            }
            echo '</p>
                        </span>
                    </li>';
        }
        echo '</ul>';
    } else {
        echo '<ul class="d-none"></ul>';
    }

    echo '<ul>';
    if (!empty($epc)) {
        echo '<li>
                    <span class="popup_toggle" data-id="3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M2 21C2 18 3.85 15.64 7.08 15C9.5 14.52 12 13 13 12M11 20C9.24406 20.0053 7.55025 19.3505 6.25452 18.1654C4.95878 16.9803 4.15577 15.3515 4.00474 13.6021C3.8537 11.8527 4.36569 10.1104 5.43915 8.72074C6.51261 7.33112 8.06913 6.3957 9.8 6.1C15.5 5 17 4.48 19 2C20 4 21 6.18 21 10C21 15.5 16.22 20 11 20Z" stroke="#47412E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p>EPC Rating: ' . esc_html($epc) . '</p>
                    </span>
                </li>';
    }
    if (!empty($gallery)) {
        echo '<li>
                    <span class="popup_toggle" data-id="1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M14.5 4H9.5L7 7H4C3.46957 7 2.96086 7.21071 2.58579 7.58579C2.21071 7.96086 2 8.46957 2 9V18C2 18.5304 2.21071 19.0391 2.58579 19.4142C2.96086 19.7893 3.46957 20 4 20H20C20.5304 20 21.0391 19.7893 21.4142 19.4142C21.7893 19.0391 22 18.5304 22 18V9C22 8.46957 21.7893 7.96086 21.4142 7.58579C21.0391 7.21071 20.5304 7 20 7H17L14.5 4Z" stroke="black" stroke-width="1.5" stroke-linejoin="round" />
                            <path d="M12 16C13.6569 16 15 14.6569 15 13C15 11.3431 13.6569 10 12 10C10.3431 10 9 11.3431 9 13C9 14.6569 10.3431 16 12 16Z" stroke="black" stroke-width="1.5" stroke-linejoin="round" />
                        </svg>
                        <p>Gallery</p>
                    </span>
                </li>';
    }
    if (!empty($floorplan)) {
        echo '<li>
                    <span class="popup_toggle" data-id="2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17.5 19V19.75V19ZM17.5 12V11.25V12ZM3 8.5H2.25H3ZM6.5 5V4.25V5ZM8.25 19C8.25 20.2426 7.24264 21.25 6 21.25V22.75C8.07107 22.75 9.75 21.0711 9.75 19H8.25ZM6 21.25C4.75736 21.25 3.75 20.2426 3.75 19H2.25C2.25 21.0711 3.92893 22.75 6 22.75V21.25ZM3.75 19C3.75 17.7574 4.75736 16.75 6 16.75V15.25C3.92893 15.25 2.25 16.9289 2.25 19H3.75ZM6 16.75C7.24264 16.75 8.25 17.7574 8.25 19H9.75C9.75 16.9289 8.07107 15.25 6 15.25V16.75ZM9 19.75H17.5V18.25H9V19.75ZM17.5 19.75C18.6272 19.75 19.7082 19.3022 20.5052 18.5052L19.4445 17.4445C18.9288 17.9603 18.2293 18.25 17.5 18.25V19.75ZM20.5052 18.5052C21.3022 17.7082 21.75 16.6272 21.75 15.5H20.25C20.25 16.2293 19.9603 16.9288 19.4445 17.4445L20.5052 18.5052ZM21.75 15.5C21.75 14.3728 21.3022 13.2918 20.5052 12.4948L19.4445 13.5555C19.9603 14.0712 20.25 14.7707 20.25 15.5H21.75ZM20.5052 12.4948C19.7082 11.6978 18.6272 11.25 17.5 11.25V12.75C18.2293 12.75 18.9288 13.0397 19.4445 13.5555L20.5052 12.4948ZM17.5 11.25H6.5V12.75H17.5V11.25ZM6.5 11.25C5.77065 11.25 5.07118 10.9603 4.55546 10.4445L3.4948 11.5052C4.29183 12.3022 5.37283 12.75 6.5 12.75V11.25ZM4.55546 10.4445C4.03973 9.92882 3.75 9.22935 3.75 8.5H2.25C2.25 9.62717 2.69777 10.7082 3.4948 11.5052L4.55546 10.4445ZM3.75 8.5C3.75 7.77065 4.03973 7.07118 4.55546 6.55546L3.4948 5.4948C2.69777 6.29183 2.25 7.37283 2.25 8.5H3.75ZM4.55546 6.55546C5.07118 6.03973 5.77065 5.75 6.5 5.75V4.25C5.37283 4.25 4.29183 4.69777 3.4948 5.4948L4.55546 6.55546ZM6.5 5.75H15V4.25H6.5V5.75ZM20.25 5C20.25 6.24264 19.2426 7.25 18 7.25V8.75C20.0711 8.75 21.75 7.07107 21.75 5H20.25ZM18 7.25C16.7574 7.25 15.75 6.24264 15.75 5H14.25C14.25 7.07107 15.9289 8.75 18 8.75V7.25ZM15.75 5C15.75 3.75736 16.7574 2.75 18 2.75V1.25C15.9289 1.25 14.25 2.92893 14.25 5H15.75ZM18 2.75C19.2426 2.75 20.25 3.75736 20.25 5H21.75C21.75 2.92893 20.0711 1.25 18 1.25V2.75Z" fill="black" />
                        </svg>
                        <p>Floorplan</p>
                    </span>
                </li>';
    }

    echo '<li>
                <button data-target="#map" type="button" class="scroll_map">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M20 10C20 14.993 14.461 20.193 12.601 21.799C12.4277 21.9293 12.2168 21.9998 12 21.9998C11.7832 21.9998 11.5723 21.9293 11.399 21.799C9.539 20.193 4 14.993 4 10C4 7.87827 4.84285 5.84344 6.34315 4.34315C7.84344 2.84285 9.87827 2 12 2C14.1217 2 16.1566 2.84285 17.6569 4.34315C19.1571 5.84344 20 7.87827 20 10Z" stroke="black" stroke-width="1.5" stroke-linejoin="round" />
                        <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="black" stroke-width="1.5" stroke-linejoin="round" />
                    </svg>
                    <p>Map</p>
                </button>
            </li>
        </ul>
    </div>';

    if ($is_sold) {
        echo '<a title="Book A Viewing" disabled>Book A Viewing</a>';
    } else {
        echo '<a href="' . esc_url(home_url('get-in-touch')) . '?viewing" title="Book A Viewing">Book A Viewing</a>';
    }

    echo '</div>'; // .single_property-actions

    // Disclaimer y descripción
    $disclaimer1 = "- We try to make our details accurate & reliable, they're only a general guide and if there is any point which is of particular importance to you, please contact us and we'll check the position for you, especially if you are thinking of travelling some distance to view the property.";
    $disclaimer2 = "- Measurements shown are supplied for guidance only & must be considered incorrect.";
    $disclaimer3 = "- We've not tested any services/equipment or appliances in this property. We strongly advise buyers to get their own survey or service reports before finalising their offer to purchase.";
    $disclaimer4 = "- The details are issued in good faith and they're based on written/verbal info by the owners. They do not constitute representations of fact or form part of any offer or contract. Everything should be independently verified by prospective buyers. Neither Laurels nor any of its employees/agents has any authority to make/give any representation/warranty in relation to this property.";

    echo '<div class="single_property-content">
        <div class="w-100 single_property-lefty">';

    if (!empty($key_features)) {
        echo '<div class="wh-100">
            <div class="single_property-features">
                <h4>Key Features</h4>
                <ul>';
        foreach ($key_features as $feature) {
            $text = '';
            if (is_array($feature)) {
                $text = $feature['key_feature_value'] ?? '';
            }
            if (!empty($text)) {
                echo '<li>' . esc_html($text) . '</li>';
            }
        }
        echo '</ul>
            </div></div>';
    }

    echo '</div>'; // left column

    echo '<div class="w-100">';
    $description = get_field('description_property', $post_id);
    if (empty($description)) {
        $description = get_post_field('post_content', $post_id);
    }
    if (!empty($description)) {
        echo '<div class="single_property-description">
                    <h4>Description</h4>
                    <div class="text_content">
                        ' . nl2br($description) . '
                    </div>
                </div>';
    }

    echo '<div class="single_property-disclaimer">
                <h5>Disclaimer</h5>
                <ul>
                    <li>' . $disclaimer1 . '</li>
                    <li>' . $disclaimer2 . '</li>
                    <li>' . $disclaimer3 . '</li>
                    <li>' . $disclaimer4 . '</li>
                </ul>
            </div>
            <div class="single_property-buttons">';

    if ($is_sold) {
        echo '<a title="Book A Viewing" disabled>
                    Book A Viewing
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M0.5 8H14.5M14.5 8L7.5 1M14.5 8L7.5 15" stroke="white" />
                    </svg>
                </a>';
    } else {
        echo '<a title="Book A Viewing" href="' . esc_url(home_url('get-in-touch')) . '?viewing">
                    Book A Viewing
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M0.5 8H14.5M14.5 8L7.5 1M14.5 8L7.5 15" stroke="white" />
                    </svg>
                </a>';
    }

    echo '<a href="' . esc_url(home_url('get-in-touch')) . '" title="Email Us">
                Email Us
            </a>
        </div>
        </div>
    </div>';

    echo '<div class="w-100 single_property-lastshare">
            <div class="share">
                <button type="button" class="share_button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M8.59 13.51L15.42 17.49M15.41 6.51L8.59 10.49M21 5C21 6.65685 19.6569 8 18 8C16.3431 8 15 6.65685 15 5C15 3.34315 16.3431 2 18 2C19.6569 2 21 3.34315 21 5ZM9 12C9 13.6569 7.65685 15 6 15C4.34315 15 3 13.6569 3 12C3 10.3431 4.34315 9 6 9C7.65685 9 9 10.3431 9 12ZM21 19C21 20.6569 19.6569 22 18 22C16.3431 22 15 20.6569 15 19C15 17.3431 16.3431 16 18 16C19.6569 16 21 17.3431 21 19Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Share
                </button>
                <div class="share_box">
                    <div class="share_box-widget">
                        ' . do_shortcode("[sharethis-inline-buttons]") . '
                    </div>
                    <div class="share_box-input">
                        <button type="button" class="copy_url" title="Copy URL">Copy URL</button>
                    </div>
                </div>
            </div>
        </div>';

        echo '<div class="single_property-map" id="map">
            <div id="map_canvas" class="in_2_cols"></div>
        </div>';
}


//------------------------------------------

function log_cron_event($message)
{
    $log_file = get_template_directory() . '/cron_log.txt';

    // Obtener contenido del archivo si existe
    if (file_exists($log_file)) {
        $lines = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $total_lines = count($lines);

        if ($total_lines >= 100) {
            // Eliminar las primeras 50 líneas y mantener el resto
            $lines = array_slice($lines, 50);
            file_put_contents($log_file, implode("\n", $lines) . "\n");
        }
    }

    // Obtener fecha y hora en formato [28-Mar-2025 13:15:19 UTC]
    $timestamp = gmdate("d-M-Y H:i:s") . " UTC";
    $log_entry = "[$timestamp] $message\n";

    // Escribir en el archivo de log
    error_log($log_entry, 3, $log_file);
}

function get_positions()
{
    $api_url = 'https://api.uk.rexsoftware.com/v1/rex/published-listings/search';
    $headers = array(
        'Authorization' => 'Bearer ' . get_api_token(),
        'Content-Type'  => 'application/json',
    );

    $offset = 0;
    $limit = 100;
    $all_properties = [];

    log_cron_event("Iniciando la actualización de propiedades...");

    while (true) {
        $search_params = array(
            'offset'   => $offset,
            'limit'    => $limit,
            'criteria' => array(
                array(
                    "name"  => "listing_category_id",
                    "type"  => "in",
                    "value" => ['residential_sale', 'commercial_sale']
                ),
                array(
                    "name"  => "system_listing_state",
                    "type"  => "in",
                    "value" => ['sold']
                )
            )
        );

        $response = wp_remote_post($api_url, array(
            'headers' => $headers,
            'body'    => json_encode($search_params),
        ));

        if (is_wp_error($response)) {
            log_cron_event("ERROR: Falló la solicitud API - " . $response->get_error_message());
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (!isset($data['result']['rows']) || empty($data['result']['rows'])) {
            log_cron_event("INFO: No se encontraron más propiedades. Terminando proceso.");
            break;
        }

        $rows = $data['result']['rows'];

        foreach ($rows as $l => $property) {
            $nro = intval($offset + $l + 1);
            $property_id = $property['id'];
            $url_property = esc_url(home_url('residential-property')) . '?n=' . $property_id;
            $price = isset($property['price_match']) ? '£' . number_format($property['price_match']) : '';

            $read_url1 = 'https://api.uk.rexsoftware.com/v1/rex/listings/read';
            $read_params = array(
                'id'           => $property_id,
                'extra_fields' => ['images']
            );

            $read_response1 = wp_remote_post($read_url1, array(
                'headers' => $headers,
                'body'    => json_encode($read_params),
            ));

            $lat = $lng = $bed = $bath = $buildarea = $town_name = $name_property = $thumb = null;

            if (!is_wp_error($read_response1)) {
                $read_body = wp_remote_retrieve_body($read_response1);
                $read_data = json_decode($read_body, true);
                $result = $read_data['result'];

                if (isset($result['property'])) {
                    $home = $result['property'];
                    $lat = isset($home['adr_latitude']) ? floatval($home['adr_latitude']) : null;
                    $lng = isset($home['adr_longitude']) ? floatval($home['adr_longitude']) : null;
                    $bed = isset($home['attr_bedrooms']) ? intval($home['attr_bedrooms']) : null;
                    $bath = isset($home['attr_bathrooms']) ? intval($home['attr_bathrooms']) : null;
                    $buildarea = isset($home['attr_buildarea']) ? $home['attr_buildarea'] . ' ' . $home['attr_buildarea_unit']['text'] : null;
                    $town_name = isset($home['adr_suburb_or_town']) ? $home['adr_suburb_or_town'] : null;
                    $name_property = isset($home['adr_street_name']) ? $home['adr_street_number'] . ' ' . $home['adr_street_name'] : null;
                }

                if (isset($result['related']['listing_images'][0]['url'])) {
                    $thumb = $result['related']['listing_images'][0]['url'];
                }
            }

            if (empty($name_property) || empty($lat) || empty($lng)) {
                continue;
            }

            $all_properties[] = [
                'nro'           => $nro,
                'lat'           => $lat,
                'lng'           => $lng,
                'thumb'         => esc_url($thumb),
                'price'         => $price,
                'name_property' => $name_property,
                'town'          => $town_name,
                'bed'           => $bed,
                'bath'          => $bath,
                'buildarea'     => $buildarea,
                'url'           => $url_property,
            ];
        }

        if (count($rows) < $limit) {
            break;
        }

        $offset += $limit;
    }

    if (empty($all_properties)) {
        log_cron_event("WARN: No se generaron propiedades, archivo no creado.");
        return false;
    }

    $file_path = get_template_directory() . '/COPY_HERE.php';
    $file_content = "locations = " . json_encode($all_properties, JSON_PRETTY_PRINT) . ";\n";

    if (file_put_contents($file_path, $file_content) !== false) {
        log_cron_event("SUCCESS: Archivo COPY_HERE.php generado correctamente con " . count($all_properties) . " propiedades.");
        return true;
    } else {
        log_cron_event("ERROR: Falló la escritura del archivo COPY_HERE.php.");
        return false;
    }
}

function regenerate_copy_here_file()
{
    get_positions();
}

function setup_cron_event()
{
    if (!wp_next_scheduled('regenerate_copy_here_event')) {
        wp_schedule_event(time(), 'daily', 'regenerate_copy_here_event');
    }
}
add_action('wp', 'setup_cron_event');
add_action('regenerate_copy_here_event', 'regenerate_copy_here_file');
