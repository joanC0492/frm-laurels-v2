<?php
// Creamos la función para el post type successful_property
function custom_post_successful_property() {
    // Registramos el post type 'successful_property'
    register_post_type( 'successful_property',
        array(
            'labels' => array(
                'name' => __( 'Successful Properties', 'edward-dev' ), /* El título del grupo */
                'singular_name' => __( 'Successful Property', 'edward-dev' ), /* El título en singular */
                'all_items' => __( 'All Successful Properties', 'edward-dev' ), /* Todos los items del menú */
                'add_new' => __( 'Add New', 'edward-dev' ), /* Agregar uno nuevo */
                'add_new_item' => __( 'Add New Successful Property', 'edward-dev' ), /* Agregar nuevo con título */
                'edit' => __( 'Edit', 'edward-dev' ), /* Editar */
                'edit_item' => __( 'Edit Successful Property', 'edward-dev' ), /* Editar item */
                'new_item' => __( 'New Successful Property', 'edward-dev' ), /* Nuevo título en visualización */
                'view_item' => __( 'View Successful Property', 'edward-dev' ), /* Ver item */
                'search_items' => __( 'Search Successful Properties', 'edward-dev' ), /* Buscar item */
                'not_found' => __( 'No Successful Properties Found', 'edward-dev' ), /* Se muestra si aún no hay entradas */
                'not_found_in_trash' => __( 'No Successful Properties Found in Trash', 'edward-dev' ), /* Se muestra si no hay nada en la papelera */
            ), /* Fin del array labels */
            'description' => __( 'This is a custom post type for Successful Properties', 'edward-dev' ), /* Descripción */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 8, /* Orden en el menú de admin */
            'menu_icon' => 'dashicons-admin-home', /* Icono del menú de admin */
            'rewrite' => array( 'slug' => 'successful-property', 'with_front' => false ), /* Slug de la URL */
            'has_archive' => 'successful-property', /* Archivo del post type */
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'revisions' )
        ) /* Fin de las opciones */
    );
}
// Agregando la función al init de WordPress
add_action( 'init', 'custom_post_successful_property' );

// Creamos la taxonomía successful_property_category para successful_property
add_action( 'init', 'create_successful_property_taxonomy' );
function create_successful_property_taxonomy() {
    register_taxonomy(
        'successful_property_category',
        'successful_property',
        array(
            'label' => __( 'Successful Property Categories', 'edward-dev' ),
            'rewrite' => array( 'slug' => 'successful-property-category' ),
            'hierarchical' => true,
            'labels' => array(
                'name' => __( 'Categories', 'edward-dev' ),
                'singular_name' => __( 'Category', 'edward-dev' ),
                'search_items' => __( 'Search Categories', 'edward-dev' ),
                'all_items' => __( 'All Categories', 'edward-dev' ),
                'parent_item' => __( 'Parent Category', 'edward-dev' ),
                'parent_item_colon' => __( 'Parent Category:', 'edward-dev' ),
                'edit_item' => __( 'Edit Category', 'edward-dev' ),
                'update_item' => __( 'Update Category', 'edward-dev' ),
                'add_new_item' => __( 'Add New Category', 'edward-dev' ),
                'new_item_name' => __( 'New Category', 'edward-dev' )
            ),
            'show_admin_column' => true,
            'show_ui' => true,
            'query_var' => true,
        )
    );
}

// Registra soporte para categorías y etiquetas al post type successful_property
register_taxonomy_for_object_type( 'category', 'successful_property' );
register_taxonomy_for_object_type( 'post_tag', 'successful_property' );
?>
