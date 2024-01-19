<?php
/**
 * functions.php
 *
 * Helper functions for the ETP meal planner plugin.
 *
 * @package ETP Meal Planner
 * @author  Matt Shaw <matt@expandedfronts.com>
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers styles/scripts used in the plugin frontend.
 * @access public
 */
function etp_public_scripts() {
	wp_register_style( 'blaze-public-css', Blaze_MEAL_PLANNER_URL . 'assets/css/public.min.css', array(), Blaze_MEAL_PLANNER_VERSION, 'all' );
	//wp_register_script( 'etp-public-js', ETP_MEAL_PLANNER_URL . 'assets/js/etp-mp-public.min.js', array( 'jquery' ), time() );
	wp_enqueue_script('blaze-star-rating-js', Blaze_MEAL_PLANNER_URL . 'assets/js/star-rating.js', array('jquery'), false, false);
	wp_enqueue_script('blaze-public-js', Blaze_MEAL_PLANNER_URL . 'assets/js/blaze-mp-public.js', array('jquery'), false, false);
	wp_enqueue_script('blaze-mCustomScrollbar-js', Blaze_MEAL_PLANNER_URL . 'assets/js/jquery.mCustomScrollbar.concat.min.js', array('jquery'), false, false);
	wp_localize_script( 'blaze-public-js', 'etp_vars', array(
		'home_url' => get_home_url()
	) );
	
	wp_register_style( 'blaze-krajee-theme-css', Blaze_MEAL_PLANNER_URL . 'assets/themes/krajee-fas/theme.css', array(), Blaze_MEAL_PLANNER_VERSION, 'all' );
	wp_register_style( 'blaze-star-rating-css', Blaze_MEAL_PLANNER_URL . 'assets/css/star-rating.css', array(), Blaze_MEAL_PLANNER_VERSION, 'all' );

	
	//wp_enqueue_script('blaze-krajee-theme-js', Blaze_MEAL_PLANNER_URL . 'assets/themes/krajee-fas/theme.js', array('jquery'), false, false);
	

	$url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	wp_enqueue_style( 'blaze-public-css' );
	wp_enqueue_script( 'blaze-public-js' );
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_script( 'thickbox' );

	
	wp_enqueue_style( 'blaze-krajee-theme-css' );
	wp_enqueue_style( 'blaze-star-rating-css' );
	
	wp_enqueue_script( 'blaze-krajee-theme-js' );
	wp_enqueue_script( 'blaze-star-rating-js' );

	if ( strpos( $url, 'meal-planner' ) !== false || strpos( $url, 'shopping-list' ) !== false || strpos( $url, 'plan-recipes' ) !== false || strpos( $url, 'my-plans') !== false || strpos( $url, 'plan-details' ) !== false ) {
		wp_enqueue_style( 'blaze-public-css' );
		wp_enqueue_script( 'blaze-public-js' );
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_script( 'thickbox' );
	}
	if ( strpos( $url, 'meal-planner' ) !== false ){
		wp_enqueue_style( 'blaze-krajee-theme-css' );
		wp_enqueue_style( 'blaze-star-rating-css' );

		wp_enqueue_script( 'blaze-krajee-theme-js' );
		wp_enqueue_script( 'blaze-star-rating-js' );
	}
	/**
	 * if ( is_page( 'meal-planner' ) || is_page( 'shopping-list' ) || is_page( 'plan-recipes' ) || is_page( 'my-plans' || is_page( 'plan-details' ) ) ) {
	 * 	wp_enqueue_style( 'etp-public-css' );
	 * 	wp_enqueue_script( 'etp-public-js' );
	 * 	wp_enqueue_style( 'thickbox' );
	 * 	wp_enqueue_script( 'thickbox' );
	 *}
	 * This had to be replaced with above due to some conflict somewhere...
	 */
}
add_action( 'wp_enqueue_scripts', 'etp_public_scripts' );

/**
 * Registers styles/scripts used in the plugin admin screens.
 * @access public
 */
function etp_admin_scripts( $hook ) {

	global $post;

	if ( $hook == 'post-new.php' || $hook == 'post.php'  ) {

		if ( 'recipes' === $post->post_type ) {
			wp_register_style( 'blaze-admin-css', Blaze_MEAL_PLANNER_URL . 'assets/css/admin.min.css', array(), Blaze_MEAL_PLANNER_VERSION, 'all' );
			wp_register_script( 'blaze-admin-js', Blaze_MEAL_PLANNER_URL . 'assets/js/blaze-mp-admin.min.js', array(), Blaze_MEAL_PLANNER_VERSION );
			wp_register_script( 'blaze-admin-custom', Blaze_MEAL_PLANNER_URL . 'assets/js/blaze-admin-custom.js', array(), Blaze_MEAL_PLANNER_VERSION );
			wp_enqueue_style( 'blaze-admin-css' );
			wp_enqueue_script( 'blaze-admin-js' );
			wp_enqueue_script( 'blaze-admin-custom' );
		}

	}

}
add_action( 'admin_enqueue_scripts', 'etp_admin_scripts', 10, 1 );

/**
 * Checks if the current user owns the plan.
 * @param  int $plan_id
 * @return boolean
 */
function etp_current_user_owns_plan( $plan_id ) {
	global $wpdb;

	$plan_id 	= absint( $plan_id );
	$user 		= wp_get_current_user();
	$table 		= Blaze_Meal_Planner::table_name();
	$query 		= $wpdb->prepare( "SELECT id FROM $table WHERE id = %d and user_id = %d", $plan_id, $user->ID );
	$result 	= $wpdb->get_results( $query );

	if ( $result ) {
		return true;
	}
	return false;
}

/**
 * Get the ingredients for a recipe.
 *
 * @since 1.0.0
 *
 * @return
 */
function etp_get_ingredients( $id = '' ) {

	if ( $id === '' ) {
		$id = get_the_ID();
	}

	$recipe_meta = get_post_meta( $id, 'etp_recipe_meta' );
	if ( isset( $recipe_meta[0]['ingredients'] ) ) {
		$ingredients = $recipe_meta[0]['ingredients'];
	} else {
		$ingredients = array();
	}

	return $ingredients;
}

/**
 * Helper function for retrieving an array of recipe IDs.
 * @access public
 * @return array
 */
function get_recipe_ids( $id = '', $unique = false ) {

	global $wpdb;

	if ( '' === $id ) {
		$id = isset( $_GET['plan'] ) ? $_GET['plan'] : 0;
	}

	// Grab the data.
	$id 	= absint( $id );
	$table 	= Blaze_Meal_Planner::table_name();
	$data 	= $wpdb->get_results( "SELECT id, meals, user_id, time FROM $table WHERE id = '$id'", ARRAY_A );
	$ids 	= array();

	if ( ! $data ) return $ids;

	$days = unserialize( $data[0]['meals'] );

	if(is_array($days) && count($days)>0){
		// Iterate through and grab all the Recipe IDs.
		foreach ( $days as $day => $meals ) {

			foreach ( $meals as $meal ) {
				$ids[] = $meal;
			}

		}
	}
	

	// Filter out duplicates if necessary.
	if ( true === $unique ) {
		return array_keys( array_flip( $ids ) );
	}

	return $ids;
}
function get_leftover_ids( $id = '', $unique = false ) {

	global $wpdb;

	if ( '' === $id ) {
		$id = isset( $_GET['plan'] ) ? $_GET['plan'] : 0;
	}

	// Grab the data.
	$id 	= absint( $id );
	$table 	= Blaze_Meal_Planner::table_name();
	$data 	= $wpdb->get_results( "SELECT id, leftover, user_id, time FROM $table WHERE id = '$id'", ARRAY_A );
	$ids 	= array();

	if ( ! $data ) return $ids;

	$days = unserialize( $data[0]['leftover'] );
	
	if(is_array($days) && count($days)>0){
	// Iterate through and grab all the Recipe IDs.
	foreach ( $days as $day => $leftovers ) {

		foreach ( $leftovers as $leftover ) {
			$ids[] = $leftover;
		}

	}
}
	// Filter out duplicates if necessary.
/*	if ( true === $unique ) {
		return array_keys( array_flip( $ids ) );
	}*/
	//array_filter($ids, function($value) { return !is_null($value) && $value !== '' && $value != 0; });
	return $days;
}
/**
 * Helper function for retrieving the recipe title.
 * @access public
 * @return string
 */
function etp_get_recipe_title( $id = '' ) {

	// Allow usage from within The Loop.
	if ( $id === '' ) {
		$id = get_the_ID();
	}

	$title = get_the_title( $id );

	return '<p class="etp-recipe-name">' . esc_html( $title ) . '</p>';
}
function etp_get_recipe_rating( $id = '', $hidden = false ) {

	// Allow usage from within The Loop.
	if ( $id === '' ) {
		$id = get_the_ID();
	}
	$user_id = get_current_user_id();
	global $wpdb;
	$table = 'wpah_custom_rating';
	$filled_star_array 	= $wpdb->get_results( "SELECT rating FROM $table WHERE post_id = '$id' AND user_id = '$user_id'", ARRAY_A );
	$filled_star = 0;
	if(isset($filled_star_array[0]['rating'])){
		$filled_star = $filled_star_array[0]['rating'];
	}
	$avg_rating_array 	= $wpdb->get_results( "SELECT avg(rating) as avg_rating FROM $table WHERE post_id = '$id'", ARRAY_A );
	$avg_rating = 0;
	if(isset($avg_rating_array[0]['avg_rating'])){
		$avg_rating = number_format($avg_rating_array[0]['avg_rating'],1);
	}
	$meta 	= get_post_meta( $id );
	$meta 	= @unserialize( $meta['etp_recipe_meta'][0] );
	$return = '';	
	$return .= '<div class="etp-macro-avg-rating" title="Average Rating">(<span id="avg_'.$id.'">'.$avg_rating.'</span>)</div><div class="recipe_rating" title="Your rating"><input id="input-2-ltr-star-xs" name="input-2-ltr-star-xs" class="kv-ltr-theme-fas-star rating-loading input-rating" value="'.$filled_star.'" dir="ltr" data-size="xs" data-recipe_id="'.$id.'"></div>';
	return $return;
}
function etp_get_recipe_rating_readonly( $id = '', $hidden = false ) {

	// Allow usage from within The Loop.
	if ( $id === '' ) {
		$id = get_the_ID();
	}
	
	global $wpdb;
	$table = 'wpah_custom_rating';
	
	$avg_rating_array 	= $wpdb->get_results( "SELECT avg(rating) as avg_rating FROM $table WHERE post_id = '$id'", ARRAY_A );
	$avg_rating = 0;
	if(isset($avg_rating_array[0]['avg_rating'])){
		$avg_rating = number_format($avg_rating_array[0]['avg_rating'],1);
	}
	$meta 	= get_post_meta( $id );
	$meta 	= @unserialize( $meta['etp_recipe_meta'][0] );
	$return = '';	
	$return .= '<div class="recipe_rating" title="Average Rating"><input id="input-2-ltr-star-xs" name="input-2-ltr-star-xs" class="kv-ltr-theme-fas-star rating-loading avg-rating" value="'.$avg_rating.'" dir="ltr" data-size="xs" data-recipe_id="'.$id.'"></div>';
	return $return;
}
/**
 * Helper function for retrieving the recipe macros.
 * @access public
 * @return string
 */
function etp_get_recipe_macros( $id = '', $hidden = false ) {

	// Allow usage from within The Loop.
	if ( $id === '' ) {
		$id = get_the_ID();
	}

	$meta 	= get_post_meta( $id );
	$meta 	= @unserialize( $meta['etp_recipe_meta'][0] );

	$return = '';

	// Calories
	if ( isset( $meta['calories'] ) && $meta['calories'] != 0 ) {

		if ( true === $hidden ) {
			$return .= '<input  class="etp-macro-input etp-calories"type="hidden" name="etp_calories" value="' . $meta['calories'] . '" />';
		} else {
			$return .= 'Cal: ' . absint( $meta['calories'] ) . ' ';
		}

	}
	// Fat
	if ( isset( $meta['fat'] ) && $meta['fat'] != 0 ) {

		if ( true === $hidden ) {
			$return .= '<input  class="etp-macro-input etp-fat"type="hidden" name="etp_fat" value="' . $meta['fat'] . '" />';
		} else {
			$return .= 'Fat: ' .$meta['fat'] . ' ';
		}

	}

	// Protein
	if ( isset( $meta['protein'] ) && $meta['protein'] != 0 ) {

		if ( true === $hidden ) {
			$return .= '<input  class="etp-macro-input etp-protein"type="hidden" name="etp_protein" value="' . $meta['protein'] . '" />';
		} else {
			$return .= 'Protein: ' .$meta['protein']. ' ';
		}

	}

	// Carbohydrates
	if ( isset( $meta['carbs'] ) && $meta['carbs'] != 0 ) {

		if ( true === $hidden ) {
			$return .= '<input  class="etp-macro-input etp-carbs"type="hidden" name="etp_carbs" value="' . $meta['carbs'] . '" />';
		} else {
			$return .= 'Carbs: ' . $meta['carbs'] . ' ';
		}

	}	

	// Fiber
	if ( isset( $meta['fiber'] ) && $meta['fiber'] != 0 ) {

		if ( true === $hidden ) {
			$return .= '<input  class="etp-macro-input etp-fiber" type="hidden" name="etp_fiber" value="' . $meta['fiber'] . '" />';
		} else {
			//$return .= 'Fiber: ' . absint( $meta['fiber'] ). ' ';
		}

	}

	// Net Carbs
	if ( isset( $meta['net_carbs'] ) && $meta['net_carbs'] != 0 ) {

		if ( true === $hidden ) {
			$return .= '<input  class="etp-macro-input etp-net_carbs" type="hidden" name="etp_net_carbs" value="' . $meta['net_carbs'] . '" />';
		} else {
			$return .= '<p class="etp-macro-net-carbs">Net Carbs: ' . $meta['net_carbs']. '</p> ';
		}

	}

	// Return the results.
	if ( true === $hidden ) {
		return $return;
	}
	return '<p class="etp-macro-info">' . $return . '</p>';
}

/**
 * Helper function for retrieveing the recipe tags.
 * @access public
 * @return string
 */
function etp_get_recipe_tags( $id = '' ) {

	// Allow usage from within The Loop.
	if ( $id === '' ) {
		$id = get_the_ID();
	}

	$id 	= absint( $id );
	$tags 	= get_the_terms( $id, 'recipe_tags' );
	$return = array();

	if ( is_array( $tags ) ) {

		foreach ( $tags as $tag ) {
			$return[] = '<a class="etp-tag" href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a>';
		}

	}
	if(!empty($return)){
		return '<p class="etp-recipe-tags">' . implode( ', ', $return ) . '</p>';
	}
}

/**
 * Helper function for retreiving the recipe image/thumbnail.
 * @access public
 * @return string
 */
function etp_get_the_post_thumbnail( $id, $size ) {
	if ( get_the_post_thumbnail( $id, $size ) ) {
		return get_the_post_thumbnail( $id, $size );
	}
}

function csv_to_array( $filename = '', $delimiter = ',' ) {
	if(!file_exists($filename) || !is_readable($filename))
		return FALSE;

	$header = NULL;
	$data = array();
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else
				$data[] = array_combine($header, $row);
		}
		fclose($handle);
	}
	return $data;
}

/**
 * Runs an import on the CSV.
 * @access public
 */
function etp_run_import() {

	if ( ! isset( $_GET['etp_process_import'] ) ) {
		return;
	}

	@set_time_limit(180);
	@ini_set('auto_detect_line_endings', TRUE);

	$file = Blaze_MEAL_PLANNER_PATH . 'assets/etp.csv';

	if ( ! file_exists( $file ) ) {
		wp_die( 'File not found' );
	}

	$rows = csv_to_array( $file , ',' );
	$rows = array_reverse( $rows );

	foreach ( $rows as $line ) {

		if ( $line['Name of Dish'] != '' ) {

			$post_args = array(
				'post_title' => $line['Name of Dish'],
				'post_content' => $line['Measures and Meal INGREDIENTS'],
				'post_status' => 'publish',
				'post_type'	=> 'recipes'
			);

			$post_id = wp_insert_post( $post_args );

			if ( $line['Day'] != '' ) {
				wp_set_object_terms( $post_id, $line['Day'], 'recipe_tags' );
			}

			if ( $line['Meal Category'] != '' ) {
				wp_set_object_terms( $post_id, $line['Meal Category'], 'recipe_categories' );
			}

			$meta = array(
				'protein' => $line['Protein'],
				'fiber' => $line['Fiber'],
				'net_carbs' => $line['Net Carbs'],
				'carbs' => $line['Carbs'],
				'fat' => $line['Fat'],
				'calories' => $line['Calories']
			);

			add_post_meta( $post_id, 'etp_recipe_meta', $meta );

			if ( $line['image'] != 'via email' ) {

				$line['image'] = explode( '/', $line['image'] );
				$line['image'] = end( $line['image'] );
				$line['image'] = Blaze_MEAL_PLANNER_URL . 'assets/imported/' . $line['image'];

				$media = media_sideload_image($line['image'], $post_id);

				if(!empty($media) && !is_wp_error($media)){
					$args = array(
						'post_type' => 'attachment',
						'posts_per_page' => -1,
						'post_status' => 'any',
						'post_parent' => $post_id
					);

				    // reference new image to set as featured
					$attachments = get_posts($args);

					if(isset($attachments) && is_array($attachments)){
						foreach($attachments as $attachment){
				            // grab source of full size images (so no 300x150 nonsense in path)
							$image = wp_get_attachment_image_src($attachment->ID, 'full');
				            // determine if in the $media image we created, the string of the URL exists
							if(strpos($media, $image[0]) !== false){
				                // if so, we found our image. set it as thumbnail
								set_post_thumbnail($post_id, $attachment->ID);
				                // only want one image
								break;
							}
						}
					}
				}
			}

		}
	}

}
add_action( 'admin_init', 'etp_run_import' );
// Add the custom columns to the book post type:
add_filter( 'manage_recipes_posts_columns', 'set_custom_edit_recipes_columns' );
function set_custom_edit_recipes_columns($columns) {
//	unset( $columns['author'] );
	$columns['recipes_rating'] = __( 'Average Rating', 'your_text_domain' );   
	return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_recipes_posts_custom_column' , 'custom_recipes_column', 10, 2 );
function custom_recipes_column( $column, $post_id ) {
	global $wpdb;
	$table = 'wpah_custom_rating';
	$data 	= $wpdb->get_results( "SELECT avg(rating) as avg_rating FROM $table WHERE post_id = '$post_id'", ARRAY_A );
	switch ( $column ) {        
		case 'recipes_rating':   	
		echo number_format($data[0]['avg_rating'],1); 
		break;
	}
}