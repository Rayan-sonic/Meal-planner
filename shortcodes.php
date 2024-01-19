<?php
/**
 * etp-shortcodes.php
 *
 * Handles shortcodes for the ETP Meal Planner
 *
 * @package ETP Meal Planner
 * @author  Matt Shaw <matt@expandedfronts.com>
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$site_url = get_site_url();

/**
 * Displays the meal planner.
 * @return string
 */
function etp_render_meal_planner() {
//	wp_enqueue_script( 'etp-public-js' );
	
	wp_enqueue_script( 'blaze-public-js', plugin_dir_url(__FILE__).'/blaze-meal-planner/assets/js/blaze-mp-public.js' );
	$terms_recipe_categories = get_terms( 'recipe_categories', array(
		'hide_empty' => false,

	) );
// 	$recipe_terms = '';
// 	$count_recipe_categories = count( $terms_recipe_categories );
// 	if ( $count_recipe_categories > 0 ) {
// 		foreach ( $terms_recipe_categories as $key=>$term ) {
// 			$recipe_terms .= '<a href="javascript:void(0)" class="blaze-category" id="'. $term->slug . '">'. $term->name . '</a> ';
// 			if($key!=($count-1))
// 				$recipe_terms .= ' | ';
// 		}
// 	}
$recipe_terms = '';
$count_recipe_categories = count($terms_recipe_categories);
if ($count_recipe_categories > 0) {
    foreach ($terms_recipe_categories as $key => $term) {
        $recipe_terms .= '<a href="javascript:void(0)" class="blaze-category" id="' . $term->slug . '">' . $term->name . '</a> ';
        if ($key != ($count_recipe_categories - 1))
            $recipe_terms .= ' | ';
    }
}

	$plan_id = isset( $_GET['plan_id'] ) ? absint( $_GET['plan_id'] ) : 0;

	/*if ( $plan_id != 0 ) {
		$next_day = 8;
		$days = '
		<li><a class="blaze-day-1 active" onclick="blaze_load_day(1);">1</a></li>
		<li><a class="blaze-day-2" onclick="blaze_load_day(2);">2</a></li>
		<li><a class="blaze-day-3" onclick="blaze_load_day(3);">3</a></li>
		<li><a class="blaze-day-4" onclick="blaze_load_day(4);">4</a></li>
		<li><a class="blaze-day-5" onclick="blaze_load_day(5);">5</a></li>
		<li><a class="blaze-day-6" onclick="blaze_load_day(6);">6</a></li>
		<li><a class="blaze-day-7" onclick="blaze_load_day(7);">7</a></li>';
	} else {
		$next_day = 2;
		$days = '<li><a class="blaze-day-1 active" onclick="blaze_load_day(1);">1</a></li>';
	}*/

if ( $plan_id != 0 ) {
	$day_name = '';
 	/*switch($next_day) {
 		case 1:
 		$day_name = 'Monday';
 		break;
 		case 2:
 		$day_name = 'Tuesday';
 		break;
 		case 3:
 		$day_name = 'Wednesday';
 		break;
 		case 4:
 		$day_name = 'Thursday';
 		break;
 		case 5:
 		$day_name = 'Friday';
 		break;
 		case 6:
 		$day_name = 'Saturday';
 		break;
 		case 7:
 		$day_name = 'Sunday';
 		break;
 		default:
 		$day_name = $next_day;

 	}*/
		$next_day = 8;
		$days = '
		<li><a class="blaze-day-1 active" onclick="blaze_load_day(1);">Mon</a></li>
		<li><a class="blaze-day-2" onclick="blaze_load_day(2);">Tues</a></li>
		<li><a class="blaze-day-3" onclick="blaze_load_day(3);">Wed</a></li>
		<li><a class="blaze-day-4" onclick="blaze_load_day(4);">Thurs</a></li>
		<li><a class="blaze-day-5" onclick="blaze_load_day(5);">Fri</a></li>
		<li><a class="blaze-day-6" onclick="blaze_load_day(6);">Sat</a></li>
		<li><a class="blaze-day-7" onclick="blaze_load_day(7);">Sun</a></li>';
	} else {
		$next_day = 2;
		$days = '<li><a class="blaze-day-1 active" onclick="blaze_load_day(1);">Mon</a></li>';
	}

	$content = '';
	$content .= '<script src="' . Blaze_MEAL_PLANNER_URL . 'assets/js/modernizr.custom.js?v=' . Blaze_MEAL_PLANNER_VERSION . '"></script>';
	//$content .= '<div id="Blaze-mp-top-nav" class="menu-new"><span class="blaze-category-list"><a href="'. get_home_url() .'/meal-planner" class="blaze-category remove-tags active new-home">Home</a> | '.$recipe_terms.'</span>';
	$content .= '<div id="Blaze-mp-top-nav" class="menu-new"><span style="float:left;"><a href="'. get_home_url() .'/meal-planner" class="blaze-category remove-tags active new-home">Home</a> <a href="javascript:void(0)" class="blaze-category">Breakfast</a> <a href="javascript:void(0)" class="blaze-category">Lunch</a> <a href="javascript:void(0)" class="blaze-category">Dinner</a> <a href="javascript:void(0)" class="blaze-category">Snacks</a><a href="javascript:void(0)" class="blaze-category">Soups & Dips</a><a href="javascript:void(0)" class="blaze-category">Desserts</a> <a href="javascript:void(0)" class="blaze-category">Single Items</a> 
	
	
	
  <div class="navbar">
  <div class="dropdown">
    <button class="dropbtn"><a href="javascript:void(0)" class="blaze-category ">Specialty Meals</a> 
   
    </button>
    <div class="dropdown-content meal_menu">
      
      <div class="row">
        <div class="column">
        <a href="javascript:void(0)" class="blaze-category ">5 Ingredient Meals</a>
		<a href="javascript:void(0)" class="blaze-category">Vegetarian</a>
        </div>
        <div class="column">
          <a href="javascript:void(0)" class="blaze-category ">Crockpot / Instapot</a>
          <a href="javascript:void(0)" class="blaze-category">Gluten Free</a>
        </div>
        <div class="column">
          <a href="javascript:void(0)" class="blaze-category">Keto</a>
          <a href="javascript:void(0)" class="blaze-category">Low Carb</a>
        </div>
		<div class="column">
          <a href="javascript:void(0)" class="blaze-category">Paleo</a>
          <a href="javascript:void(0)" class="blaze-category">Vegan</a>
        </div>
      </div>
    </div>
  </div> 
</div></span>';
	
	
	$content .= '<input id="blaze-recipe-search" type="text" name="blaze_recipe_search" style="min-width:150px;" placeholder="Search..." /></div>';
	$content .= '<div id="grid" class="grid clearfix"></div>';

	$content .= '<div id="drop-area" class="drop-area">
	<a id="blaze-minimize-button" style="margin-right: 10px;" onclick="mini_my_dmeal(this)"" title="Minimize" class="blaze-save-plan-btn minimize-new"><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/minimize_icon.png" /></a>
	<div class="blaze-nav-wrap">

	<ul class="blaze-day-nav">

	' . $days;
	if($next_day!=8)
		$content .='<li><a class="next" onclick="blaze_add_day();">Add Day <i class="fa fa-plus-circle" aria-hidden="true"></i></a></li>';
	//$net_carb = 'Net Carbs: <span id="blaze-net-carbs-total" class="blaze-count">0</span>'
	$content .='</ul>

	<span id="blaze-count-p">Calories: <span id="blaze-cal-total" class="blaze-count">0</span>
	Fat: <span id="blaze-fat-total" class="blaze-count">0</span>
	Protein: <span id="blaze-protein-total" class="blaze-count">0</span>
	Carbs: <span id="blaze-carbs-total" class="blaze-count">0</span>
	</span>


	<a href="' . get_admin_url() . 'admin-ajax.php?action=etp_save_prompt&plan_id=' . $plan_id .'&width=400&height=250" title="Save Plan" class="blaze-save-plan-btn thickbox newclass"><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/save_icon.png" /> Save Plan</a>
	</div>

	<div id="blaze-box-container" class="content">
		<div class="scrollable-container">
			<div id="1" class="drop-area__item blaze-drop-area blaze-display-box">
				<div class="meal-snacks">
					<p>Meal</p>
				</div>
			</div>
			<div id="2" class="drop-area__item blaze-drop-area blaze-display-box">
				<div class="meal-snacks">
					<p>Snack</p>
				</div>
			</div>
			<div id="3" class="drop-area__item blaze-drop-area blaze-display-box">
				<div class="meal-snacks">
					<p>Meal</p>
				</div>
			</div>
			<div id="4" class="drop-area__item blaze-drop-area blaze-display-box">
				<div class="meal-snacks">
					<p>Snack</p>
				</div>
			</div>
			<div id="5" class="drop-area__item blaze-drop-area blaze-display-box">
				<div class="meal-snacks">
					<p>Meal</p>
				</div>
			</div>
			<div id="blaze-add-box" onclick="this_add_meal_r(this)" class="drop-area__item">
				<div class="blaze-info-wrap dropped-info">
					<p>Add More Meals</p>
				</div>
			</div>
		</div>
	</div>

	</div>
	<div class="drop-overlay"></div>
	<div id="data-store"></div>
	<div id="leftover-store"></div>
	<input id="blaze-current-day" type="hidden" value="1" />
	<input id="blaze-next-day" type="hidden" value="' . $next_day . '" />
	<input id="blaze-plan-id" type="hidden" value="' . $plan_id . '" />
	<script src="' . Blaze_MEAL_PLANNER_URL . 'assets/js/draggabilly.pkgd.min.js?v=' . Blaze_MEAL_PLANNER_VERSION . '"></script>
	<script src="' . Blaze_MEAL_PLANNER_URL . 'assets/js/dragdrop.js?v=' . Blaze_MEAL_PLANNER_VERSION . '"></script>';

	$content .= "
	<script>
	etp_get_recipes( paged='0', '', 'Home');
	</script>";

	return $content;
}

add_shortcode( 'etp_meal_planner', 'etp_render_meal_planner' );

/**
 * Displays meals saved by the current user.
 * @access public
 */
function etp_render_saved_plans() {
	global $wpdb;
	$table 	= Blaze_Meal_Planner::table_name();
	$user 	= wp_get_current_user();
	$user 	= absint( $user->ID );
	$query 	= $wpdb->prepare( "SELECT id, meals, time, title FROM $table WHERE user_id = %d ORDER BY id DESC", $user );
	$plans 	= $wpdb->get_results( $query, ARRAY_A );
	$time 	= current_time( 'timestamp' );
	$return = '';

	$plan_detail_url = get_home_url() . '/plan-details/?plan=';



	foreach ( $plans as $plan ) {
			
		$recipe_get_first_id = get_recipe_ids( $plan['id'], true );
		$first_recipe_id = $recipe_get_first_id[0];

		//echo $first_recipe_id;
		if($first_recipe_id){
			$blaze_core_plan_img = wp_get_attachment_image_src( get_post_thumbnail_id($first_recipe_id), '' );
			$imagesa=$blaze_core_plan_img[0];
			if ($blaze_core_plan_img[0]=="") {
				$blaze_core_plan_img=Blaze_MEAL_PLANNER_URL .'assets/img/form.png';
			}else{
				//$blaze_core_plan_img=Blaze_MEAL_PLANNER_URL .'assets/img/form.png';
				$blaze_core_plan_img =$blaze_core_plan_img[0];
			}
			//$blaze_core_plan_img = Blaze_MEAL_PLANNER_URL .'assets/img/form.png';
		}else{
			$blaze_core_plan_img = Blaze_MEAL_PLANNER_URL .'assets/img/form.png';
		}
		
		$plan_time = strtotime( $plan['time'] );
		if ( $plan['title'] == '' ) {
			$plan['title'] = '(No Title)';
		}
		$plan['title'] = esc_html( $plan['title'] );
		$delete_svg_icon = Blaze_MEAL_PLANNER_URL .'assets/img/cancel-button_318-82535.jpg';
		$return .= '
		 
		<div class="sveplan cls_add" id="etp-plan-wrap-'. $plan['id'] . '"><a href="' . esc_url( get_admin_url() . 'admin-ajax.php?action=etp_delete_prompt&plan_id=' . $plan['id'] . '&width=375&height=200' ) . '" class="blaze-link thickbox" title="Delete Plan"><img src="'.$delete_svg_icon.'" class="dele_this_file" alt="Delete"></a><div class="viewicn"><a class="blaze-link" href="' . $plan_detail_url . $plan['id'] . '"><img class="blaze_core_img_by_plan" src="'.$blaze_core_plan_img.'"/></a></div><h3 style="margin-bottom: 0;"><a class="blaze-link" href="' . $plan_detail_url . $plan['id'] . '">' . $plan['title'] . '</a></h3>
		<a href="' . $plan_detail_url . $plan['id'] . '" class="blaze-link view-plan pprint--- pprints---'.$plan['id'].'" id="'.$plan['id'].'">View Plan</a>
		<p style="font-style:italic; font-size: 14px;">'.'<a class="blaze-link" href="' . get_home_url() . '/meal-planner/?plan_id=' . $plan['id'] .'">Edit</a> <a href="' . $plan_detail_url . $plan['id'] . '" class="blaze-link pprint--- pprints---'.$plan['id'].'" id="'.$plan['id'].'">Print</a> <a href="javascript:void(0);" class="blaze-link wait'.$plan['id'].'" style="display:none;">Wait</a> 
		
		
		
		<p class="tym">'. human_time_diff( $plan_time, $time ) . ' ago</p></div>';
	}

	return $return;

}
add_shortcode( 'etp_saved_plans', 'etp_render_saved_plans' );

/**
 * Displays all recipes in the provided plan.
 * @access public
 */
function etp_render_plan_recipes() {
	global $wpdb;
	$plan_id 			= isset( $_GET['plan'] ) ? $_GET['plan'] : 0;
	$plan_id 			= absint( $plan_id );
	$recipe_ids 		= get_recipe_ids( $plan_id, true );

	$table 	= Blaze_Meal_Planner::table_name();
	$user 	= wp_get_current_user();
	$user 	= absint( $user->ID );
	$query 	= $wpdb->prepare( "SELECT id, meals, time, title FROM $table WHERE user_id = %d AND id =$plan_id ORDER BY id DESC", $user );
	$plans 	= $wpdb->get_results( $query, ARRAY_A );
	$time 	= current_time( 'timestamp' );
	$site_url = get_site_url();
	echo '<div class="right_line newone"><p><a href="'.$site_url.'/plan-details/?plan='.$plan_id.'"><img class="wp-image-9880 alignleft" style="margin: 0;" src="' . Blaze_MEAL_PLANNER_URL .'assets/img/back-to-details.png" alt="back to my plans" width="175" height="50"></a><a href="javascript:void(0);"><img class="alignleft wp-image-9876" style="margin: 0;" src="' . Blaze_MEAL_PLANNER_URL .'assets/img/allprint-recipe.png" alt="Print Recipe" width="175" height="50"></a></p></div>';
	echo '<div class="intrtion"><p>Print each recipe individually using the print icon on each recipe card Or click the the button above to print one page containing all of the recipes show below.</p></div>';
	echo '<div class="plannme"><h2>'.$plans['0']['title'].'</h2></div>';

	$return = '';
	echo '<div class="content-newrpe">';
	foreach ( $recipe_ids as $id ) {
		$recipe 		= get_post( $id );
		$imagea = wp_get_attachment_image_src( get_post_thumbnail_id($id), '' );
		$imagesa=$imagea[0];
		if ($imagea[0]=="") {
			$imagesa="https://via.placeholder.com/150";
		}
		$ingredients 	= etp_get_ingredients( $id );
		$meta 			= get_post_meta( $id );
		if ( $meta ) {
			$meta = unserialize( $meta['etp_recipe_meta'][0] );
		} else {
			$meta = array();
		}
		//$return .=  the_ratings();
		$return .= '<div class="cnt-rap" id="'.$id.'">';
		$return .= '<div id="custom-bg1" style="background-image: url('.$imagesa.')"></div>';

		$return .= '<h2>' . ucwords( $recipe->post_title ) . '</h2>';
		
		$return .= '<div class="info-new"><ul><li><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/clock.png"/></li><li>Prep<span>' . $meta['preptime'] . '</span></li>';
		$return .= '<li>Cook Time<span>' . $meta['cooktime'] . '</span></li>';
		$return .= '<li>Yield<span>' . $meta['yield'] . '</span></li>';
		$return .= '<li>Servings<span>' . $meta['servings'] . '</span></li>';
		$return .= '<li><a class="viwprintsp" id="'.$id.'" href="javascript:void(0);"><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/prnt.jpg"/></a></li></ul></div>';
		$return .= etp_get_recipe_rating_readonly($id);
		$return .= '<h3>Ingredients</h3>';
		if ( is_array( $ingredients ) && ! empty( $ingredients ) ) {

			$return .= '<ul class="etp-recipe-ingredients">';

			
			$ingredients = $ingredients;

			foreach ($ingredients as $key => $value) {
				if ($key === 9999) {
					unset($ingredients[$key]);
				}
			}

			foreach ( $ingredients as $ingredient ) {
				$return .= '<li>' . $ingredient['amount'] . ' ' . $ingredient['unit'] . ' '  . $ingredient['ingredient'] . '</li>';
			}

			$return .= '</ul>';
		} else {
			$return .= '<p>No ingredients found</p>';
		}

		$return .= '<h3>Instructions</h3>';
		$return .= wpautop( $recipe->post_content );

		$return .= '</div>';

	}

	return $return;
}
add_shortcode( 'etp_plan_recipes', 'etp_render_plan_recipes' );

/**
 * Displays a single recipe.
 * @access public
 */
function etp_view_recipe( $id = 0 , $ref ) {

	echo $ref;
	$return = '';

	$recipe_id 			= isset( $_GET['recipe'] ) ? $_GET['recipe'] : 0;
	$planId 			= isset( $_GET['planId'] ) ? $_GET['planId'] : 0;
	$planIds			= absint( $_GET['planId'] ) ? $_GET['planId'] : 0;
	$recipe_id 			= absint( $recipe_id );

	//echo $recipe_id;
	//echo $recipe_id;
	// Allows manual usage.
	// if ( $id != 0 ) {
	// 	$recipe_id = absint( $id );
	// }

		// Allows manual usage.
		if ( $id != 0 ) {
			$recipe_id = absint( $recipe_id );
		}


	//echo $recipe_id;
	// Get the recipe and its ingredients.
	$recipe 		= get_post($recipe_id);
	$recipe_meta 	= get_post_meta( $recipe_id );

	//echo "<pre>"; print_r($recipe);

	if ( $recipe_meta ) {
		$recipe_meta = unserialize( $recipe_meta['etp_recipe_meta'][0] );
	} else {
		$recipe_meta = array();
	}

	$ingredients = etp_get_ingredients( $recipe_id );
	$return .= '<p class="right_line newone"><a href="#"><img class="wp-image-9876 alignleft" style="margin: 0;" src="'. Blaze_MEAL_PLANNER_URL. 'assets/img/allprint-recipe.png" alt="Print Recipe" width="175" height="50" /></a> <a href="'.$site_url.'/plan-details/?plan='.$planIds.'"><img class="wp-image-9880 alignleft" style="margin: 0;" src="' . Blaze_MEAL_PLANNER_URL .'assets/img/back-to-details.png" alt="back to my plans" width="175" height="50" /></a></p>';

	 //$return .= '<h2>' . ucwords( $recipe->post_title ) . '</h2>';

	$return .= '<div class="leftimageAndcnt">';
	$return .= get_the_post_thumbnail( $recipe_id, 'medium' );
	//$return .=  the_ratings();

	if ( isset( $recipe_meta['preptime'] ) && $recipe_meta['preptime'] != '' ) {
		$return .= '<div class="info-new1"><h2>'.ucwords( $recipe->post_title ).'</h2><ul class="singlerpe"><li class="imagesfirdt"><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/clock.png"/> <strong>Times</strong></li>';
		$return .= '<li><strong>Prep Time:</strong> <span>' . $recipe_meta['preptime'] . '</span></li>';
	}
	if ( isset( $recipe_meta['cooktime'] ) && $recipe_meta['cooktime'] != '' ) {
		$return .= '<li><strong>Cook Time:</strong> <span>' . $recipe_meta['cooktime']. '<span></li>';
	}
	if ( isset( $recipe_meta['yield'] ) && $recipe_meta['yield'] != '' ) {
		$return .= '<li><strong>Yield:</strong> <span>' . $recipe_meta['yield'] . '<span></li>';
	}
	if ( isset( $recipe_meta['servings'] ) && $recipe_meta['servings'] != '' ) {
		$return .= '<li><strong>Servings:</strong> <span>' . $recipe_meta['servings'] . '<span></li>';
	}
	$return .= '</ul></div></div>';
	$return .= etp_get_recipe_rating_readonly($recipe_id);
	$return .= '<br/><h3>Ingredients</h3>';

	if ( is_array( $ingredients ) && ! empty( $ingredients ) ) {

		$return .= '<ul class="etp-recipe-ingredients">';

		$ingredients = $ingredients;

		foreach ($ingredients as $key => $value) {
			if ($key === 9999) {
				unset($ingredients[$key]);
			}
		}

		foreach ( $ingredients as $ingredient ) {
			$return .= '<li>' . $ingredient['amount'] . ' ' . $ingredient['unit'] . ' '  . $ingredient['ingredient'] . '</li>';
		}

		$return .= '</ul>';
	} else {
		$return .= '<p>No ingredients found</p>';
	}

	$return .= '</ul></div></div>';

	if(!empty(wpautop( $recipe->post_content ))){

	$return .= '<br/><h3>Instructions</h3>';
	$return .= wpautop( $recipe->post_content );

	}

	$return .= '<br><br>';

	// Return the recipe content.
	return $return;
}
add_shortcode( 'etp_view_recipe', 'etp_view_recipe' );

//----------------------------//
function etp_view_recipes( $id) {

	$return = '';

	$recipe_id 			= isset( $_GET['recipe'] ) ? $_GET['recipe'] : 0;
	$planId 			= isset( $_GET['planId'] ) ? $_GET['planId'] : 0;
	$planIds			= absint( $_GET['planId'] ) ? $_GET['planId'] : 0;
	$recipe_id 			= absint( $recipe_id );

	$recipe_id = $id;
	//echo $recipe_id;
	// Allows manual usage.
	// if ( $id != 0 ) {
	// 	$recipe_id = absint( $id );
	// }

		// Allows manual usage.
		// if ( $id != 0 ) {
		// 	$recipe_id = absint( $recipe_id );
		// }


	//echo $recipe_id;
	// Get the recipe and its ingredients.
	$recipe 		= get_post($recipe_id);
	$recipe_meta 	= get_post_meta( $recipe_id );

	//echo "<pre>"; print_r($recipe);

	if ( $recipe_meta ) {
		$recipe_meta = unserialize( $recipe_meta['etp_recipe_meta'][0] );
	} else {
		$recipe_meta = array();
	}

	$ingredients = etp_get_ingredients( $recipe_id );
	$return .= '<p class="right_line newone"><a href="#"><img class="wp-image-9876 alignleft" style="margin: 0;" src="'. Blaze_MEAL_PLANNER_URL. 'assets/img/allprint-recipe.png" alt="Print Recipe" width="175" height="50" /></a> <a href="'.$site_url.'/plan-details/?plan='.$planIds.'"><img class="wp-image-9880 alignleft" style="margin: 0;" src="' . Blaze_MEAL_PLANNER_URL .'assets/img/back-to-details.png" alt="back to my plans" width="175" height="50" /></a></p>';

	 //$return .= '<h2>' . ucwords( $recipe->post_title ) . '</h2>';

	$return .= '<div class="leftimageAndcnt">';
	$return .= get_the_post_thumbnail( $recipe_id, 'medium' );
	//$return .=  the_ratings();

	if ( isset( $recipe_meta['preptime'] ) && $recipe_meta['preptime'] != '' ) {
		$return .= '<div class="info-new1"><h2>'.ucwords( $recipe->post_title ).'</h2><ul class="singlerpe"><li class="imagesfirdt"><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/clock.png"/> <strong>Times</strong></li>';
		$return .= '<li><strong>Prep Time:</strong> <span>' . $recipe_meta['preptime'] . '</span></li>';
	}
	if ( isset( $recipe_meta['cooktime'] ) && $recipe_meta['cooktime'] != '' ) {
		$return .= '<li><strong>Cook Time:</strong> <span>' . $recipe_meta['cooktime']. '<span></li>';
	}
	if ( isset( $recipe_meta['yield'] ) && $recipe_meta['yield'] != '' ) {
		$return .= '<li><strong>Yield:</strong> <span>' . $recipe_meta['yield'] . '<span></li>';
	}
	if ( isset( $recipe_meta['servings'] ) && $recipe_meta['servings'] != '' ) {
		$return .= '<li><strong>Servings:</strong> <span>' . $recipe_meta['servings'] . '<span></li>';
	}
	$return .= '</ul></div></div>';
	$return .= etp_get_recipe_rating_readonly($recipe_id);
	$return .= '<br/><h3>Ingredients</h3>';

	if ( is_array( $ingredients ) && ! empty( $ingredients ) ) {

		$return .= '<ul class="etp-recipe-ingredients">';

		$ingredients = $ingredients;

		foreach ($ingredients as $key => $value) {
			if ($key === 9999) {
				unset($ingredients[$key]);
			}
		}

		foreach ( $ingredients as $ingredient ) {
			$return .= '<li>' . $ingredient['amount'] . ' ' . $ingredient['unit'] . ' '  . $ingredient['ingredient'] . '</li>';
		}

		$return .= '</ul>';
	} else {
		$return .= '<p>No ingredients found</p>';
	}

	$return .= '</ul></div></div>';

	if(!empty(wpautop( $recipe->post_content ))){

	$return .= '<br/><h3>Instructions</h3>';
	$return .= wpautop( $recipe->post_content );

	}

	$return .= '<br><br>';

	// Return the recipe content.
	return $return;
}
//-----------------------------//

/**
 * Displays the shopping list for the provided plan.
 * @access public
 */
function etp_render_shopping_list() {
	$plan_id 			= isset( $_GET['plan'] ) ? $_GET['plan'] : 0;
	$plan_id 			= absint( $plan_id );
	$recipe_ids 		= get_recipe_ids( $plan_id );
	$leftover_ids 		= get_leftover_ids( $plan_id );
	/*array_filter($leftover_ids, function($value) { return !is_null($value) && $value !== '' && $value != 0; });*/

	/*echo '<pre>';
	print_r($leftover_ids);
	echo '</pre>';*/

	
	$all_ingredients 	= array();
	$return 			= '';
	$should_exclude 	= false;

	if ( ! is_array( $recipe_ids ) ) return;
	$temp_recipe_ids = $recipe_ids;
	$temp_r = array();
	/*echo '<pre>';
	print_r($temp_recipe_ids);
	echo '</pre>';*/
	/*foreach ( $temp_recipe_ids as $rkey=>$recipe_id ) {
		foreach ($leftover_ids as $lkey => $lvalue) {
			
			foreach ($lvalue as $key => $value) {
				
				if($key==$recipe_id){
					foreach ($lvalue as $skey => $svalue) {
						
						foreach ($svalue as $pkey => $pvalue) {
							if($pvalue==0){
								continue;
							}
							else if($pvalue==1)
							{
								
								unset($leftover_ids[$lkey][$lkey]);
								//print_r($lvalue[$recipe_id]);
								$temp_r[] = $recipe_id;
							}
							else{
								continue;
							}
						}
						
					}
				}
				
			}
		}
	}*/
	$count1 = array();
	$count0 = array();
	if(is_array($leftover_ids) && count($leftover_ids) >0){
		foreach ($leftover_ids as $key1 => $value1) {
			if(is_array($value1) && count($value1) >0){
				foreach ($value1 as $key2 => $value2) {
					if(is_array($value2) && count($value2) >0){
						foreach ($value2 as $key3 => $value3) {
							if($value3=='1') {
								$count1[] = $key2;
							} else if($value3=='0'){
								$count0[] = $key2;
							} else {

							}

						}
					}
				}
			}
		}
	}
	

	/*echo '<pre>';
	print_r($count0);
	echo '</pre>';
	echo '<pre>';
	print_r($count1);
	echo '</pre>';*/
	

	foreach ( $count0 as $recipe_id ) {
		/*if(in_array( $recipe_id, $leftover_ids))
		continue;*/
		$ingredients = etp_get_ingredients( $recipe_id );
		// print_r($ingredients);
		if ( !is_array( $ingredients ) ) {
			$ingredients = array();
		}

		foreach ( $ingredients as $ingredient ) {

			$c = 0;
			foreach ( $all_ingredients as $sub_ingredient ) {
				
				if ( in_array( $ingredient['ingredient'], array_values( $sub_ingredient ) ) ) {

					if ( $ingredient['unit'] == $sub_ingredient['unit'] ) {

						if ( strpos($ingredient['amount'], '/') === false && strpos($sub_ingredient['amount'], '/') === false ) {
							if (is_numeric($sub_ingredient['amount']) && is_numeric($ingredient['amount'])) {
								$all_ingredients[$c]['amount'] = $sub_ingredient['amount'] + $ingredient['amount'];
								$should_exclude = true;
								break;
							}
						}

					}

				}

				$c++;
			}
// print_r($all_ingredients);
			if ( false === $should_exclude ) {
				$all_ingredients[] = $ingredient;
			} else {
				$should_exclude = false;
			}

		}
	}

	function etp_usort( $a, $b ) {
		return strcmp( $a['category'], $b['category'] );
	}
	
	usort( $all_ingredients, 'etp_usort' );
	function float2rat($n, $tolerance = 1.e-6) {
		$h1=1; $h2=0;
		$k1=0; $k2=1;
		$b = 1/$n;
		do {
			$b = 1/$b;
			$a = floor($b);
			$aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
			$aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
			$b = $b-$a;
		} while (abs($n-$h1/$k1) > $n*$tolerance);
		return "$h1/$k1";
	}

	$c 		= 0;
	$cat 	= '';
	$strArray = array();
	foreach ( $all_ingredients as $ingredient ) {

		$string =  $ingredient['ingredient'];
		$amount =  $ingredient['amount'];

		$str_arr = explode (",", $string);

		$amVlaue_space = explode (" ", $amount);
		$amVlaue_space_first = $amVlaue_space[0];
		$amVlaue_space_second = $amVlaue_space[1];

		if(count($amVlaue_space) == 2){
			$amVlaue = explode ("/", $amVlaue_space_second);
			if($amVlaue[1] > 0){
				 $actualvalue = (float)$amVlaue[0]/(float)$amVlaue[1];
				 $actualvalue = (float)$amVlaue_space_first+(float)$actualvalue;
				 
			}else{
				$actualvalue = (int)$amVlaue[0]/1;
			}
		}else{
		    $amVlaue = explode ("/", $amVlaue_space_first);
			if($amVlaue[1] > 0){
				 $actualvalue = (float)$amVlaue[0]/(float)$amVlaue[1];
			}else{
				$actualvalue = (int)$amVlaue[0]/1;
			}
			
		}
		if (array_key_exists($str_arr['0'],$strArray))
		{
			$newamount = $strArray[$str_arr['0']]['amount'] + $actualvalue;
			$strArray[$str_arr['0']] = array('string' => $ingredient,'amount' => $newamount);
		}
		else
		{
			$strArray[$str_arr['0']] = array('string' => $ingredient,'amount' => $actualvalue );
		}
	}

	foreach ( $strArray as $ingredientValue ) {
		if (is_float($ingredientValue['amount']))
		{
					$whole = floor($ingredientValue['amount']);      // 1
					$fraction = $ingredientValue['amount'] - $whole; // .25
					if((int)$ingredientValue['amount'] > 0){
						if($fraction != 0){
							$amo = (int)$ingredientValue['amount'].' '.float2rat($fraction);
						}else{
							$amo = (int)$ingredientValue['amount'];
						}
					}else{
						$amo = float2rat($fraction);
					}
				}else{
					$amo = $ingredientValue['amount'];
				}
				if ( $ingredientValue['string']['ingredient'] != '' ) {
					if ( $c === 0 ) {
						$cat 	= $ingredientValue['string']['category'];
						$return .= '<div class="selectAllNew"><input type="checkbox" onClick="toggle(this)" class="" id="slet"/> Select All</div><div class="allwithoutcheck" id="allChekList">';
						$return .= '<div id="'.str_replace(" ", "_", strtolower($cat)).'" class="cat_group">';
						$return .= '<h3 class="cat_name no-print">' . ucwords( $cat ) . '</h3>';
						$return .= '<h3><input type="checkbox" class="ask no-print" value="----'. ucwords( $cat ) .'----" name="selectall"></h3>';
						$return .= "<ul class='etp-shopping-list'>";
						$return .= "<li class='no-print'><input id='etp-ingredient-$c' name='selectall' value='". $amo . ' ' . $ingredientValue['string']['unit'] . ' ' . $ingredientValue['string']['ingredient'] . "' type='checkbox' class='etp-ingredient-cb'  /><label class='etp-ingredient-label' for='etp-ingredient-$c'>" . $amo . ' ' . $ingredientValue['string']['unit'] . ' ' . $ingredientValue['string']['ingredient'] . "</label></li>";
					} elseif ( $cat != $ingredientValue['string']['category'] ) {
						$cat = $ingredientValue['string']['category'];
						$return .= '</ul>';
						$return .= '</div>';
						$return .= '<div id="'.str_replace(" ", "_", strtolower($cat)).'" class="cat_group">';
						$return .= '<h3 class="cat_name no-print">' . ucwords( $cat ) . '</h3>';
						$return .= '<h3><input type="checkbox" class="ask no-print" value="----'. ucwords( $cat ) .'----" name="selectall"></h3>';
						$return .= '<ul class="etp-shopping-list">';
						$return .= "<li class='no-print'><input id='etp-ingredient-$c' name='selectall' value='". $amo . ' ' . $ingredientValue['string']['unit'] . ' ' . $ingredientValue['string']['ingredient'] . "' type='checkbox' class='etp-ingredient-cb'  /><label class='etp-ingredient-label' for='etp-ingredient-$c'>" . $amo . ' ' . $ingredientValue['string']['unit'] . ' ' . $ingredientValue['string']['ingredient'] . "</label></li>";
					} else {
						$return .= "<li class='no-print'><input id='etp-ingredient-$c' value='". $amo . ' ' . $ingredientValue['string']['unit'] . ' ' . $ingredientValue['string']['ingredient'] . "' name='selectall' type='checkbox' class='etp-ingredient-cb'  /><label class='etp-ingredient-label' for='etp-ingredient-$c'>" . $amo . ' ' . $ingredientValue['string']['unit'] . ' ' . $ingredientValue['string']['ingredient'] . "</label></li>";
					}

				}

				$c++;

			}
			$return .= '</ul></div></div>';

			return $return;
		}
		add_shortcode( 'etp_render_shopping_list', 'etp_render_shopping_list' );

/**
 * Displays the plan summary page.
 * @access public
 */
function etp_render_plan_summary() {
	global $wpdb;

	$plan_id 	= isset( $_GET['plan'] ) ? $_GET['plan'] : 0;
	$plan_id 	= absint( $plan_id );
	$table 		= Blaze_Meal_Planner::table_name();
	$data 		= $wpdb->get_results( "SELECT id, meals, user_id, nutrients, time FROM $table WHERE id = '$plan_id'", ARRAY_A );

	if ( ! $data ) return;

	$days = unserialize( $data[0]['meals'] );
	$nutrientsdata = unserialize( $data[0]['nutrients'] );
	
	//echo "<pre>"; print_r($nutrientsdata);

	// Access elements of the array
	$nutrients_calories = $nutrientsdata['Calories'];
	$nutrients_fat = $nutrientsdata['Fat'];
	$nutrients_protein = $nutrientsdata['Protein']; 
	$nutrients_carbs = $nutrientsdata['Carbs']; 
	$nutrients_net_carbs = $nutrientsdata['Net Carbs']; 

	$calories = 'Calories: '.$nutrients_calories;
	$fat = '<span class="nutrients_data">Fat: '.$nutrients_fat.'<span>';
	$protein = '<span class="nutrients_data">Protein: '.$nutrients_protein.'<span>';
	$carbs = '<span class="nutrients_data">Carbs: '.$nutrients_carbs.'<span>';
	// $net_carbs = '<span class="nutrients_data">Net Carbs: '.$nutrients_net_carbs.'<span>';

	$return = '<p class="right_line"> <a class="blaze-link" href="' . get_home_url() . '/shopping-list/?plan=' . $plan_id . '"><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/view-shopping-list.png" /></a>  
	
	<a class="blaze-link" href="' . get_home_url() . '/plan-recipes/?plan=' . $plan_id . '"><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/view-recipe-list.png" /></a> 
	<a class="blaze-link" href="' . get_home_url() . '/meal-planner/?plan_id=' . $plan_id . '"><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/edit-plan.png"></a> 
	
	<a class="blaze-link" href="' . get_home_url() . '/my-plans/"><img src="' . Blaze_MEAL_PLANNER_URL .'assets/img/view-saved-plans.png" style="width:175px;"/></a></p><div class="intrtion"><p>To view or print your recipe, click on the recipe image.</p></div>';
	if(!is_array($days) || !count($days))
		return $return ;
	foreach ( $days as $day => $meals ) {
		switch($day) {
 		case 1:
 		$day_name = 'Mon';
 		break;
 		case 2:
 		$day_name = 'Tues';
 		break;
 		case 3:
 		$day_name = 'Wednes';
 		break;
 		case 4:
 		$day_name = 'Thurs';
 		break;
 		case 5:
 		$day_name = 'Fri';
 		break;
 		case 6:
 		$day_name = 'Satur';
 		break;
 		case 7:
 		$day_name = 'Sun';
 		break;
 		default:
 		$day_name = $day;

 	}
	$day_names = $day_name.'day';
		$return .= "<div class='day_box_allc'><h4>$day_names</h4></div>";
		$return .= "<div class='all_nutrients_show_plan'><p class='ntr_p_color' style='font-family: Montserrat !important;'><span class='ntr_sp_cls'>$calories</span>&nbsp;&nbsp;<span>$fat</span>&nbsp;&nbsp;<span>$protein</span>&nbsp;&nbsp;<span>$carbs</span>&nbsp;&nbsp;<span>$net_carbs</span></p></div>";
		$return .= "<div class='allcont'>";
		//$return .=$day_name;
		$return .= "<div class='dysall' style='display:none;'>";

		// $return .= "<div class='allcont'><h4>";
		// $return .=$day_name;
		// $return .= "day </h4><div class='dysall' style='display:none;'>";
		

		$meals = array_keys( array_flip( $meals ) );

		foreach ( $meals as $meal_id ) {
			$return .="<p><a class='blaze-link' href='" . get_home_url() . '/view-recipe/?recipe=' . $meal_id . "'>View/Print Recipe for " . get_the_title( $meal_id ) . "</a></p>";
		}
		$return .="</div><div class='alsrpt'>";
		foreach ( $meals as $meal_ids ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id($meal_ids), '' );
			$images=$image[0];
			if ($image[0]=="") {
				$images="https://via.placeholder.com/200x200.png";
			}
			$return .="<div class='newdtails'><a class='blaze-link' href='" . get_home_url() . '/view-recipe/?recipe='. $meal_ids.'&planId='.$plan_id."'><div id='custom-bg' style='background-image: url(".$images.")'></div></a><p>" . get_the_title( $meal_ids ) . "</p></div>";
		}
		$return .="</div></div>";

	}

	return $return;
}
add_shortcode( 'etp_render_plan_summary', 'etp_render_plan_summary' );