<?php
/**
 * etp-post-types.php
 *
 * Responsible for registering and configuring
 * post types used by the ETP Meal Planner plugin.
 *
 * @package ETP Meal Planner
 * @author  Matt Shaw <matt@expandedfronts.com>
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers the "Recipes" custom post type.
 * @access public
 */
function etp_recipes() {
	$labels = array(
		'name'                => _x( 'Recipes', 'Post Type General Name', 'etp-meal-planner' ),
		'singular_name'       => _x( 'Recipe', 'Post Type Singular Name', 'etp-meal-planner' ),
		'menu_name'           => __( 'Recipes', 'etp-meal-planner' ),
		'name_admin_bar'      => __( 'Recipe', 'etp-meal-planner' ),
		'parent_item_colon'   => __( 'Parent Recipe:', 'etp-meal-planner' ),
		'all_items'           => __( 'All Recipes', 'etp-meal-planner' ),
		'add_new_item'        => __( 'Add New Recipe', 'etp-meal-planner' ),
		'add_new'             => __( 'Add New', 'etp-meal-planner' ),
		'new_item'            => __( 'New Recipe', 'etp-meal-planner' ),
		'edit_item'           => __( 'Edit Recipe', 'etp-meal-planner' ),
		'update_item'         => __( 'Update Recipe', 'etp-meal-planner' ),
		'view_item'           => __( 'View Recipe', 'etp-meal-planner' ),
		'search_items'        => __( 'Search Recipes', 'etp-meal-planner' ),
		'not_found'           => __( 'Recipe Not Found', 'etp-meal-planner' ),
		'not_found_in_trash'  => __( 'Recipe Not Found in Trash', 'etp-meal-planner' ),
	);
	$args = array(
		'label'               => __( 'recipes', 'etp-meal-planner' ),
		'description'         => __( 'Recipes for the ETP Meal Planner', 'etp-meal-planner' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions','page-attributes' ),
		'taxonomies'          => array( 'recipes_category', 'recipe_post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'			  => 'dashicons-carrot',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'show_in_menu' => true,
		'menu_order' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'page',
	);
	register_post_type( 'recipes', $args );
}
add_action( 'init', 'etp_recipes', 0 );

/**
 * Registers the "Recipe Categories" and "Recipe Tags" custom taxonomies.
 * @access public
 */
function etp_recipes_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Recipe Categories', 'Taxonomy General Name', 'etp-meal-planner' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'etp-meal-planner' ),
		'menu_name'                  => __( 'Recipe Categories', 'etp-meal-planner' ),
		'all_items'                  => __( 'All Categories', 'etp-meal-planner' ),
		'parent_item'                => __( 'Parent Categories', 'etp-meal-planner' ),
		'parent_item_colon'          => __( 'Parent Categories:', 'etp-meal-planner' ),
		'new_item_name'              => __( 'New Category', 'etp-meal-planner' ),
		'add_new_item'               => __( 'Add New Category', 'etp-meal-planner' ),
		'edit_item'                  => __( 'Edit Category', 'etp-meal-planner' ),
		'update_item'                => __( 'Update Category', 'etp-meal-planner' ),
		'view_item'                  => __( 'View Category', 'etp-meal-planner' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'etp-meal-planner' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'etp-meal-planner' ),
		'choose_from_most_used'      => __( 'Choose from the most used categories', 'etp-meal-planner' ),
		'popular_items'              => __( 'Popular Categories', 'etp-meal-planner' ),
		'search_items'               => __( 'Search Categories', 'etp-meal-planner' ),
		'not_found'                  => __( 'Category Not Found', 'etp-meal-planner' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'recipe_categories', array( 'recipes' ), $args );

		$labels = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name', 'etp-meal-planner' ),
		'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'etp-meal-planner' ),
		'menu_name'                  => __( 'Tags', 'etp-meal-planner' ),
		'all_items'                  => __( 'All Tags', 'etp-meal-planner' ),
		'parent_item'                => __( 'Parent Tag', 'etp-meal-planner' ),
		'parent_item_colon'          => __( 'Parent Tag:', 'etp-meal-planner' ),
		'new_item_name'              => __( 'New Tag', 'etp-meal-planner' ),
		'add_new_item'               => __( 'Add New Tag', 'etp-meal-planner' ),
		'edit_item'                  => __( 'Edit Tag', 'etp-meal-planner' ),
		'update_item'                => __( 'Update Tag', 'etp-meal-planner' ),
		'view_item'                  => __( 'View Tag', 'etp-meal-planner' ),
		'separate_items_with_commas' => __( 'Separate tags with commas', 'etp-meal-planner' ),
		'add_or_remove_items'        => __( 'Add or remove tags', 'etp-meal-planner' ),
		'choose_from_most_used'      => __( 'Choose from the most used tags', 'etp-meal-planner' ),
		'popular_items'              => __( 'Popular Tags', 'etp-meal-planner' ),
		'search_items'               => __( 'Search Tags', 'etp-meal-planner' ),
		'not_found'                  => __( 'Tag Not Found', 'etp-meal-planner' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'recipe_tags', array( 'recipes' ), $args );

}
add_action( 'init', 'etp_recipes_taxonomy', 0 );
