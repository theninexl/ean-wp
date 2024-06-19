<?php 
if(!defined('REDIRECT_URL')){
  define( 'REDIRECT_URL', 'https://elarcadenoe.es' );
}

if(!function_exists('a_custom_redirect')){
  function a_custom_redirect() {
    header("Location: ".REDIRECT_URL);
    die();
  }
}

if(!function_exists('a_theme_setup')) {
  function a_theme_setup() {
    add_theme_support('post-thumbnails');
  }
  add_action ( 'after_setup_theme', 'a_theme_setup');
}

// NEED INSTALLED ACF
if(class_exists('acf')){
  //ADD PAGES OF THEME SETTINGS
  // CUSTOM OPTIONS THEME
  if( function_exists('acf_add_options_page')) {

  acf_add_options_page(array(
    'page_title'    => 'Theme Settings',
    'menu_title'    => 'Theme Settings',
    'menu_slug'     => 'theme-settings',
    'capability'    => 'edit_posts',
    'redirect'      => true
  ));

  acf_add_options_sub_page(array(
      'page_title'    => 'Theme General Settings',
      'menu_title'    => 'General',
      'parent_slug'   => 'theme-settings',
  ));

  acf_add_options_page(array(
    'page_title'    => 'Blocks',
    'menu_title'    => 'Blocks',
    'menu_slug'     => 'blocks',
    'capability'    => 'edit_posts',
    'redirect'      => true
  ));

  acf_add_options_sub_page(array(
    'page_title'    => 'Header',
    'menu_title'    => 'Header',
    'parent_slug'   => 'blocks',
  ));

  acf_add_options_sub_page(array(
    'page_title'    => 'Footer',
    'menu_title'    => 'Footer',
    'parent_slug'   => 'blocks',
  ));

  acf_add_options_sub_page(array(
    'page_title'    => 'Cookies',
    'menu_title'    => 'Cookies',
    'parent_slug'   => 'blocks',
  ));

  acf_add_options_sub_page(array(
    'page_title'    => 'About',
    'menu_title'    => 'About',
    'parent_slug'   => 'blocks',
  ));

  }
}

if(!function_exists('a_mime_types')){
  function a_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  }
  add_filter('upload_mimes', 'a_mime_types');
}



// ADD CUSTOM IMAGE SIZE
if(!function_exists('a_add_image_size')){
  function a_add_image_size() {
    add_image_size( 'custom-medium',      300, 9999);
    add_image_size( 'custom-tablet',      600, 9999);
    add_image_size( 'custom-large',       1200, 9999);
    add_image_size( 'custom-large-crop',  1200, 1200, true);
    add_image_size( 'custom-desktop',     1600, 9999);
    add_image_size( 'custom-full',        2560, 9999);
  }
  add_action( 'after_setup_theme', 'a_add_image_size' );  
}


if(!function_exists('a_custom_image_size_names')){
  function a_custom_image_size_names( $sizes ) {
    return array_merge( $sizes, array(
      'custom-medium'       => __('Custom medium', 'elarcadenoe'),
      'custom-tablet'       => __('Custom tablet', 'elarcadenoe'),
      'custom-large'        => __('Custom large', 'elarcadenoe'),
      'custom-large-crop'   => __('Custom large crop', 'elarcadenoe'),
      'custom-desktop'      => __('Custom desktop', 'elarcadenoe'),
      'custom-full'         => __('Custom full', 'elarcadenoe'),
    ) );
  }
  add_filter( 'image_size_names_choose', 'a_custom_image_size_names' );
}

//disable for posts
add_filter('use_block_editor_for_post', '__return_false', 10);
//disable for post types
add_filter('use_block_editor_for_post_type', '__return_false', 10);

//REGISTER MENUS
if(!function_exists('a_custom_navigation_menus')){
  function a_custom_navigation_menus(){
    $locations = array(
      'header_menu' => __('Header Menu','elarcadenoe'),
      'footer_menu' => __('Footer Menu','elarcadenoe'),
    );
    register_nav_menus($locations);
  }
  add_action( 'init', 'a_custom_navigation_menus' );
}

if(!function_exists('a_register_custom_post_types')){
  function a_register_custom_post_types() {
	
    //CPT PROJECT
      $singular_name  = __('Project', 'elarcadenoe');
      $plural_name    = __('Projects', 'elarcadenoe');
      $slug_name      = 'cpt-project';
  
      $labels = array(
        'name'               => $plural_name,
        'singular_name'      => $singular_name,
        'menu_name'          => $plural_name,
        'add_new'            => sprintf(__('Add %s','elarcadenoe'), $singular_name),
        'add_new_item'       => sprintf(__('Add new %s','elarcadenoe'), $singular_name),
        'edit'               => __('Edit %s','elarcadenoe'),
        'edit_item'          => sprintf(__('Edit %s','elarcadenoe'), $singular_name),
        'new_item'           => sprintf(__('New %s','elarcadenoe'), $singular_name),
        'view'               => sprintf(__('View %s','elarcadenoe'), $singular_name),
        'view_item'          => sprintf(__('View %s','elarcadenoe'), $singular_name),
        'search_items'       => sprintf(__('Search %s','elarcadenoe'), $plural_name),
        'not_found'          => sprintf(__('%s not found','elarcadenoe'), $plural_name),
        'not_found_in_trash' => sprintf(__('%s not found in trash','elarcadenoe'), $plural_name),
        'parent'             => sprintf(__('Parent %s','elarcadenoe'), $singular_name),
      );
  $args = array(
      'label'           => $singular_name,
      'description'     => $singular_name,
      'labels'          => $labels ,
      'supports'        => array('title', 'thumbnail', 'revisions'),
      'public'          => true,
      'show_ui'         => true,
      'show_in_menu'    => true,
      'menu_position'   => 4,
      'show_in_admin_bar'=> true,
      'show_in_nav_menus'=> true,
      'capability_type' => 'post',
      'map_meta_cap'    => true,
      'has_archive'     => false,
      'query_var'       => $slug_name,      
      'menu_icon'       => 'dashicons-images-alt2',
      'show_in_rest'    => true,
    );
    register_post_type( $slug_name, $args );
  
  }
  add_action( 'init', 'a_register_custom_post_types', 0 );

  
}

?>


