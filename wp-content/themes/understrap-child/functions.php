<?php

//Parent and child styles 
function my_theme_enqueue_styles() {

    $parent_style = 'understrap-styles'; 

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/theme.min.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function create_post_type() {
  register_post_type( 'real_properties',
    array(
      'labels' => array(
        'name' => __( 'Недвижимость' ),
        'singular_name' => __( 'Объект Недвижимости' ),
        'add_new_item'  => __( 'Добавить новый объект' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'thumbnail'),
      'menu_position' => 5,

    )
  );
  register_post_type( 'cities',
    array(
      'labels' => array(
        'name' => __( 'Города' ),
        'singular_name' => __( 'Город' ),
        'add_new_item'  => __( 'Добавить новый город' )
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'thumbnail'),
      'menu_position' => 5,

    )
  );

  register_taxonomy(
		'real_property_type',
		'real_properties',
		array(
      'label' => __( 'Типы недвижимости' ),
      'hierarchical'  => true,
		)
  );
  
}
add_action( 'init', 'create_post_type' );


// Show posts of 'cities', 'real_properties'  post types on home page
function add_my_post_types_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', array( 'cities', 'real_properties' ) );
  return $query;
}
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );

?>