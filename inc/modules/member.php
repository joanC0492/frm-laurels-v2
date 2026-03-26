<?php
// Creamos la función para el post type member
function custom_post_member() {
    // Registramos la función 'member' según el codex de WP
    register_post_type( 'member',
    // (http://codex.wordpress.org/Function_Reference/register_post_type)
      // Agregamos todas funciones adicionales para el post type member
      array( 'labels' => array(
        'name' => __( 'Members', 'edward-dev' ), /* El título del grupo */
        'singular_name' => __( 'Member', 'edward-dev' ), /* El título en singular */
        'all_items' => __( 'All the members', 'edward-dev' ), /* Todos los items del menú */
        'add_new' => __( 'Add new', 'edward-dev' ), /* Agregar uno nuevo */
        'add_new_item' => __( 'Add new member', 'edward-dev' ), /* Agregar nuevo con título */
        'edit' => __( 'Edit', 'edward-dev' ), /* Editar */
        'edit_item' => __( 'Edit member', 'edward-dev' ), /* Editar item */
        'new_item' => __( 'New member', 'edward-dev' ), /* Nuevo titulo en visualización */
        'view_item' => __( 'View member', 'edward-dev' ), /* Ver item */
        'search_items' => __( 'Search member', 'edward-dev' ), /* Buscar item */
        'not_found' => __( 'No results found', 'edward-dev' ), /* Se muestra si aún no hay entradas */
        'not_found_in_trash' => __( 'Nothing was found in the trash', 'edward-dev' ), /* Se muestra si no hay nada en la papelera */
        ), /* end of arrays */
        'description' => __( 'This is an example of a post type for members', 'edward-dev' ), /* Custom Type Description */
        'public' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_position' => 8, /* Este es el orden en que aparecerán en el menu de admin */
        'menu_icon' => 'dashicons-groups', /* El icono para el menu de admin */
        // Lo podemos agregar por medio de url o desde https://developer.wordpress.org/resource/dashicons
        'rewrite' => array( 'slug' => 'member', 'with_front' => false ), /* Se especifica el slug de la url, por lo general es el mismo post type 'member' */
        'has_archive' => 'member', /* Puede cambiar el nombre del slug */
        'capability_type' => 'post',
        'hierarchical' => false,
        /* Habilitamos ciertos parámetros para el editor de cada member */
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
        ) /* Fin de las opciones */
      ); /* Fin del registro post type */
}
    // Agregando la función al init de WordPress
    add_action( 'init', 'custom_post_member');

// Creamos la taxonomía membersgenero para members
add_action( 'init', 'create_member_taxonomy' );
function create_member_taxonomy() {
  register_taxonomy(
    'membersgenero', // Nombre de la taxonomía
    'member', // Nombre del post type que se le asignará
    array(
      'label' => __( 'Members Category' ),
      'rewrite' => array( 'slug' => 'membersgenero' ),
      'hierarchical' => true,
    )
  );
}


// Creamos taxonomía tags para members
/*add_action( 'init', 'create_member_taxonomy_tags' );
function create_member_taxonomy_tags() {
  register_taxonomy(
    'tag_producto', // Nombre de la taxonomía
    'member', // Nombre del post type que se le asignará
    array(
      'rewrite' => array( 'slug' => 'tag_producto' ),
      'hierarchical' => false,
      'update_count_callback' => '_update_post_term_count',
    )
  );
}*/


// Ahora vamos a agregar categorías personalizadas (estas actúan como categorías)
register_taxonomy( 'membersgenero', 
array('member'), /* Agregue el post type al cual le asignara la taxonomía */
array('hierarchical' => true,     /* Si es true actua como categoria - si es false como etiqueta */
  'labels' => array(
    'name' => __( 'Genders', 'edward-dev' ), /* Nombre de la taxonomía */
    'singular_name' => __( 'Gender', 'edward-dev' ), /* Nombre en singular de la taxonomía */
    'search_items' =>  __( 'Search genres', 'edward-dev' ), /* Título para buscar taxonomías */
    'all_items' => __( 'All genres', 'edward-dev' ), /* Listado de item de taxonomía */
    'parent_item' => __( 'Parent gender', 'edward-dev' ), /* Título del padre de la taxonomía */
    'parent_item_colon' => __( 'Parent gender:', 'edward-dev' ), /* Título del padre de la taxonomía */
    'edit_item' => __( 'Edit gender', 'edward-dev' ), /* Editar una taxonomía */
    'update_item' => __( 'Update gender', 'edward-dev' ), /* Actualizar el título de una taxonomía */
    'add_new_item' => __( 'Add new genre', 'edward-dev' ), /* Agregar nueva taxonomía */
    'new_item_name' => __( 'New genre', 'edward-dev' ) /* Título de la nueva taxonomia */
  ),
  'show_admin_column' => true, 
  'show_ui' => true,
  'query_var' => true,
  'rewrite' => array( 'slug' => 'membersgenero' ),
)
);



// Ahora vamos a agregar etiquetas personalizadas
/*register_taxonomy( 'tags_producto', 
array('member'),
array('hierarchical' => false,
  'labels' => array(
    'name' => __( 'Tags members', 'edward-dev' ),
    'singular_name' => __( 'Tag', 'edward-dev' ),
    'search_items' =>  __( 'Search tags', 'edward-dev' ),
    'all_items' => __( 'All tags', 'edward-dev' ),
    'parent_item' => __( 'Tag parent', 'edward-dev' ),
    'parent_item_colon' => __( 'Tag parent:', 'edward-dev' ),
    'edit_item' => __( 'Edit tag', 'edward-dev' ),
    'update_item' => __( 'Update tag', 'edward-dev' ),
    'add_new_item' => __( 'Add new tag', 'edward-dev' ),
    'new_item_name' => __( 'New tag', 'edward-dev' )
  ),
  'show_admin_column' => true,
  'show_ui' => true,
  'query_var' => true,
)
);*/

// /* Registra soporte para categorías al post type member */
register_taxonomy_for_object_type( 'category', 'member' );
// /* Registrar soporte para tags al post type member */
register_taxonomy_for_object_type( 'post_tag', 'member' );

?>