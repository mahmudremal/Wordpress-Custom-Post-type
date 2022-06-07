<?php
/**
 * Plugin Name: Custom Post type by mahmud_remal
 * Plugin URI: https://www.fiverr.com/mahmud_remal
 * Description: Create your own custom post type seeing it. Here I explain every functions by commenting and if you need any further questions, let me know :-)
 * Version: 1.0.0
 * Author: mahmud_remal
 * Author URI: https://www.fiverr.com/mahmud_remal
 * Text Domain: mahmud_remal
 * Domain Path: /lang/
 * Requires at least: 3.7
 * Tested up to: 6.0
 * Requires PHP: 7.0
 *
 *
 * This program is created for open source purpose to creating a custom posts type on your plugin. Here I described how to create custom posts types and how it will work and tried to describe mostly customizing options on it. Make sure you do not declare directly register_post_type() function on outside of a hook.
 * For any further help, let me know.
 *
 * https://github.com/mahmudremal/Wordpress-Custom-Post-type.git
 * @package Custom post type
 */

 
class CUSTOM_POST_TYPE{
  /**
   * Construct is a function that autometically called by PHP before reading a classes other functions.
   * So you can configure any thing from here before functions execution
   */
  public function __construct() {
    /**
     * add_action() is a function where all plugins and themes functions stored and called according to an order.
     * "init" is a tag, means this CUSTOM_POST_TYPE::custom_post_type() function will called whenn WordPress starting initilizing.
     * "10" means priority or number of order of where this function will called.
     * "0" meant that, this "custom_post_type()" function accepts no arguments.
     * Here is the function syntex
     * add_action( tag, function_to_add(), priority, accepted_args )
     */
    add_action( 'init', [ $this, 'custom_post_type' ], 10, 0 );
    /**
     * change_local hook called when user switch to different language.
     * It is necessery to called this function again to load different language on language switchung event.
     */
    add_action( 'change_locale', [ $this, 'custom_post_type' ] );
    /**
     * add_new_menu() function is used to register or adding a new menu list on wordpress dashboard.
     * "admin_init" means it is only called when admin dashboard initialized.
     */
    add_action( 'admin_init', [ $this, 'add_new_menu' ], 10, 0 );
  }
  /**
   * When you use custom post on Wordpress, this will need to register this post type to work on WordPress, and get access to maintain it, and getting data.
   */
  public function custom_post_type() {
    $labels = array(
       /**
        * Name of basec post type which will display most of the time on menus, top bar, etc
        */
      'name' => _x( 'Post types', 'Post Type General Name', 'text_domain' ),
      /**
       * A singular name to display on 1 or singluar quantity
       */
      'singular_name' => _x( 'Post type', 'Post Type Singular Name', 'text_domain' ),
      /**
       * menu_name will display on Admin menu
       */
      'menu_name' => __( 'Post types', 'text_domain' ),
      /**
       * name_admin_bar will dispay on Admin top bar.
       */
      'name_admin_bar' => __( 'Post types', 'text_domain' ),
      /**
       * archives declare is there willl be archive or not. leave here false if you don't want to archive.
       */
      'archives' => __( 'Item Archives', 'text_domain' ),
      /**
       * This text will display on attributes field.
       */
      'attributes' => __( 'Item Attributes', 'text_domain' ),
      /**
       * Parent item name, leave false it there are not
       */
      'parent_item_colon' => __( 'Parent Item:', 'text_domain' ),
      /**
       * Optional, This is a langualge hook to see on "All items" place.
       */
      'all_items' => __( 'All Items', 'text_domain' ),
      /**
       * Add new link text
       */
      'add_new_item' => __( 'Add New Item', 'text_domain' ),
      /**
       * Add new button text
       */
      'add_new' => __( 'Add New', 'text_domain' ),
      /**
       * New items link text
       */
      'new_item' => __( 'New Item', 'text_domain' ),
      /**
       * Edit item link text
       */
      'edit_item' => __( 'Edit Item', 'text_domain' ),
      /**
       * Update items link text
       */
      'update_item' => __( 'Update Item', 'text_domain' ),
      /**
       * View item link text
       */
      'view_item' => __( 'View Item', 'text_domain' ),
      /**
       * View all items link text
       */
      'view_items' => __( 'View Items', 'text_domain' ),
      /**
       * Search items link text
       */
      'search_items' => __( 'Search Item', 'text_domain' ),
      /**
       * Will display if there are no entry or data exists
       */
      'not_found' => __( 'Not found', 'text_domain' ),
      /**
       * It will display on transt page if there are nothing eft
       */
      'not_found_in_trash' => __( 'Not found in Trash', 'text_domain' ),
      /**
       * it will display on featured images fied.
       */
      'featured_image' => __( 'Featured Image', 'text_domain' ),
      /**
       * Set freatured image button text
       */
      'set_featured_image' => __( 'Set featured image', 'text_domain' ),
      /**
       * Featured items remover button text
       */
      'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
      /**
       * Use featured items button text
       */
      'use_featured_image' => __( 'Use as featured image', 'text_domain' ),
      /**
       * Insert into items button text
       */
      'insert_into_item' => __( 'Insert into item', 'text_domain' ),
      /**
       * Aleart message when completed upload on it.
       */
      'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
      /**
       * Display all link text
       */
      'items_list' => __( 'Items list', 'text_domain' ),
      /**
       * All items pages Navigation link text
       */
      'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
      /**
       * Filtering items list
       */
      'filter_items_list' => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
      /**
       * This will show most of the time, including tab title, page title, post tyoe listing page title, and items list header
       */
      'label' => __( 'Post Type name', 'text_domain' ),
      /**
       * A short description for this post type
       */
      'description' => __( 'Post Type Description', 'text_domain' ),
      /**
       * All labels list are hooked here as an array.
       */
      'labels' => $labels,
      /** How many pist status will be on here, is declared here. "pending, saved-draft, publish etc are defaul, no need to mention here */
      'post_status'    => [ 'active', 'paid', 'subscribed', 'due' ],
      /**
       * This is for declaring menu icon. You can use dashicons, font awesome icons, image links, svgs etc.
       */
      'menu_icon' => 'dashicons-slides',
      /**
       * Supports is the field where you can declare which meta boxes are apear on new post edit page.
       */
      'supports' => [
        /**
         * Post title
         */
        'title',
        /**
         * This is for inputting post decriptions or big text
         */
        'editor',
        /**
         * for post exerpt, like for a short brief
         */
        'excerpt',
        /**
         * For getting post thumbnail
         */
        'thumbnail',
        /**
         * WordPress will autometically save a draft during editing on each savaral minutes to escape lost of datas on connection lost or any other problem.
         */
        'revisions',
        /**
         * It will save the post author ID.
         */
        'author',
        /**
         * The metabox where you can declare if there'll be comment on or not.
         */
        'comments',
        /**
         * for Declaring trackback
         */
        'trackbacks',
        /**
         * Sometimes we needed to get post attributes for vaarious purposes. This is for that
         */
        'page-attributes',
        /**
         * It is somthing link attributes, but there has a freedom to set custom fields.
         */
        'custom-fields',
      ],
      /**
       * Taxonomies is the declaration where you can group your custom posts
       */
      'taxonomies' => [ 'uncategorized' ],
      /**
       * Registering a custom metabox
       * custom_post_type_meta_box() is a function which supply the contents to display metabox contents.
       */
      'register_meta_box_cb' => 'custom_post_type_meta_box',
      /**
       * It will be seen on your front end URL, where this slug will visible when you preview any pposts of this post_type
       */
      'rewrite' => [ 'slug' => 'studies' ],
      /**
       * Enable the REST API
       */
      'show_in_rest' => true,
      /**
       * Change the REST base
       */
      'rest_base' => 'studies',
      /**
       * Declare Hirachical
       */
      'hierarchical' => false,
      /**
       * Decalre if it is publicly visible or not
       */
      'public' => true,
      /**
       * Show UI supports
       */
      'show_ui' => true,
      /**
       * Will it display on admin panel munu or not. (bool)
       */
      'show_in_menu' => true,
      /**
       * Decalre the expectated menu position on admin side. It si counting from the top of the menu item.
       */
      'menu_position' => 5,
      /**
       * It will decare if it is showing on Admin top bar menus.
       */
      'show_in_admin_bar' => true,
      /**
       * It will show or hide on nav bar menus.
       */
      'show_in_nav_menus' => true,
      /**
       * Decare if user can expost it or not.
       */
      'can_export' => true,
      /**
       * Declase if there will be archive on this post type or not.
       */
      'has_archive' => false,
      /**
       * If yes, that means, google can't find this post types custom posts to displa y on serch engin.
       */
      'exclude_from_search' => true,
      /**
       * Declace if it is publicly queryable.
       */
      'publicly_queryable' => true,
      /**
       * Declare which category people can get access to edit, delete, add or export this post typs data.
       * page, edit_post, read_post, delete_post, edit_posts, edit_others_posts, publish_posts, read_private_posts, read, delete_posts, delete_private_posts, delete_published_posts, delete_others_posts, edit_private_posts, edit_published_posts, create_posts
       */
      'capability_type' => 'page',
    );
    /**
     * register_post_type() is the function to register a new post type on your WordPress.
     * 'posts_type' is your custom_post_type slug, do not use spance, or anyother specail caracter except ( "-" and "_" ) on it.
     * $args is the array supplyed to declare all properties of this post type
     */
    register_post_type( 'posts_type', $args );
    /**
     * register_post_status() is declare post statuses for this post type
     */
    register_post_status(
      /**
       * Paid is a post stutes ID
       */
      'paid',
      /**
       * Arguments supplied for the properties of this post status
       */
      [
        /**
         * Label displaid on all items lists tabs link
         */
        'label'       => _x( 'Paid', "domain" ),
        /**
         * Will it seeen bu=y public?
         */
        'public'      => true,
        /**
         * Will it recognize as build in post_status?
         */
        '_builtin'    => true,
        /**
         * This html contexts supplied to show how many posts are apear on this post status.
         */
        'label_count' => _n_noop(
          'Status <span class="count">(%s)</span>',
          'Status <span class="count">(%s)</span>'
        )
      ]
    );
  }
  /**
   * add_new_menu() is called to add menu item onn admin panel toolbar or sidebar.
   */
  public function add_new_menu() {}
  
};
/**
 * Check if this custom_post_type_meta_box() function is not exists for avaid double calling conflicks.
 */
if( ! function_exists( 'custom_post_type_meta_box' ) ) {
  function custom_post_type_meta_box() {
    // Your metabox contents goes here.
  }
}


// Call custm post type functions
new  CUSTOM_POST_TYPE();