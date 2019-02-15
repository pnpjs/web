<?php

namespace PNP\WpThemeBase\Dashboard;

/**
 * 添加自定义文章类型
 * @see https://developer.wordpress.org/reference/functions/register_post_type/
 */
function create_post_type() {
    $labels = array(
        'name' => _x('Works', 'post type general name'), // 复数
        'singular_name' => _x('Work', 'post type singular name'), // 单数
        'add_new' => _x('Add New', 'work'),
        'add_new_item' => __('Add New work'),
        'edit_item' => __('Edit work'),
        'new_item' => __('New work'),
        'view_item' => __('View work'),
        'view_items' => __('View work'),
        'search_items' => __('Search work'),
        'not_found' =>  __('No work found'),
        'not_found_in_trash' => __('No work found in Trash'),
        'parent_item_colon' => __('Parent Work: '),
        'all_items' => __( '所有作品' ),
        'archives' => __('Work Archives'),
        'attributes' => __('Work Attributes'),
        'insert_into_item' => __('Insert into work'),
        'uploaded_to_this_item' => __('Uploaded to this work'),
        'set_featured_image' => __('Set featured image'),
        'remove_featured_image' => __('Remove featured image'),
        'use_featured_image' => __('Use as featured image'),
        'menu_name' =>  __('作品'),
        'filter_items_list' => __('Filter works list'),
        'items_list' => __('Works list')
    );
    $args = array(
        'labels' => $labels,
        'description' => __('description'),
        'public' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
        'hierarchical' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => false,
        // 'rest_base' => 'work',
        // 'rest_controller_class' => 'WP_REST_Posts_Controller'
        'menu_position' => null,
        'menu_icon' => null,
        'capability_type' => 'post',
        // 'capabilities' => null,
        'map_meta_cap' => false,
        'supports' => array(
            'title', 'editor', 'comments', 'revisions',
            'trackbacks', 'author', 'excerpt', 'page-attributes',
            'thumbnail', 'custom-fields', 'post-formats'
        ),
        'register_meta_box_cb' => false,
        // 'taxonomies' => array('post_tag','category'),
        'has_archive' => true,
        'rewrite' => true,
        'query_var' => true,
        'can_export' => true,
        'delete_with_user' => false,
        // '_builtin' => false,
        // '_edit_link' => 'post.php?post=%d'
    );
    register_post_type('work', $args);
    // register_taxonomy_for_object_type( 'work_category', 'Works' );
}
add_action('init', 'PNP\\WpThemeBase\\Dashboard\\create_post_type');
function my_taxonomies_movie() {
    $labels = array(
        'name' => _x( '作品分类', 'taxonomy 名称' ),
        'singular_name' => _x( '作品分类', 'taxonomy 单数名称' ),
        'search_items' => __( '搜索作品分类' ),
        'all_items' => __( '所有作品分类' ),
        'parent_item' => __( '该作品分类的上级分类' ),
        'parent_item_colon' => __( '该作品分类的上级分类：' ),
        'edit_item' => __( '编辑作品分类' ),
        'update_item' => __( '更新最胖分类' ),
        'add_new_item' => __( '添加新的作品分类' ),
        'new_item_name' => __( '新作品分类' ),
        'menu_name' => __( '作品分类' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
    );
    register_taxonomy( 'work_category', 'work', $args );
}
add_action('init', 'PNP\\WpThemeBase\\Dashboard\\my_taxonomies_movie', 0);
add_action('admin_init', 'flush_rewrite_rules');

/**
 * 文章类型放入主循环中
 */
function add_my_post_types_to_query( $query ) {
    if ( is_home() && $query->is_main_query() )
        $query->set( 'post_type', array( 'post', 'page', 'movie' ) );
    return $query;
}
add_action( 'pre_get_posts', 'PNP\\WpThemeBase\\Dashboard\\add_my_post_types_to_query' );
// end 添加自定义文章类型

// start 添加文章类型
function pnp_setup() {

    load_theme_textdomain( 'wb-lili', get_template_directory() . '/languages' );

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    add_theme_support( 'automatic-feed-links' );

    // 默认的wordpress 3.1及之后的版本支持的10中文章类型有：
    // Standard、Aside、Chat、Gallery、Image、Link、Quote、Status、Video、Audio
    // 开启自定义文章形式
    add_theme_support('post-formats',array('aside','chat','gallery','image',
        'link','quote','status','video','audio'));

    add_theme_support( 'post-thumbnails' );


    /*
    * This theme supports custom background color and image,
    * and here we also set up the default background color.
    */
    add_theme_support( 'custom-background', array(
        'default-color' => 'e6e6e6',
    ) );

    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

    // Indicate widget sidebars can use selective refresh in the Customizer.
    add_theme_support( 'customize-selective-refresh-widgets' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );
}
add_action( 'after_setup_theme', 'PNP\\WpThemeBase\\Dashboard\\pnp_setup' );

/**
 * Add support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );
