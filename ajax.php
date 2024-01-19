<?php
/**
 * etp-ajax.php
 *
 * Responds to AJAX calls.
 *
 * @package ETP Meal Planner
 * @author  Matt Shaw <matt@expandedfronts.com>
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Defines the ajaxurl in case it hasn't been already.
 * @access public
 */
function etp_ajaxurl() {
	?>

	<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
		//alert(ajaxurl);
	</script>

	<?php
}
add_action( 'wp_head','etp_ajaxurl' );

/**
 * Allows users to preview a recipe via Thickbox.
 * @access public
 */
function etp_preview_recipe() {

	// Get the recipe ID.
	$recipe_id = isset( $_REQUEST['recipe_id'] ) ? absint( $_REQUEST['recipe_id'] ) : 0;
	// if ( 0 === $recipe_id ) exit;

	// Display the recipe.
	echo etp_view_recipes( $recipe_id );
	exit;
}
add_action( 'wp_ajax_etp_preview_recipe', 'etp_preview_recipe' );
add_action( 'wp_ajax_nopriv_etp_preview_recipe', 'etp_preview_recipe' );

/**
 * The main function for returning the recipes via AJAX.
 * @access public
 */
function etp_get_recipes() {

	//echo "<pre>"; print_r($_POST);

	$paged = isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 1;

	//echo $paged;

	$args = array(
		'post_type' 			=> 'recipes',
		'post_status' 			=> 'publish',
		'posts_per_page' 		=> 20,
		'paged' 				=> $paged,
		'ignore_sticky_posts' 	=> 1,
		'category__not_in'    => 11
	);




	if ( isset( $_REQUEST['category'] ) &&  $_REQUEST['category'] != '' ) {

		$categorized 	= $_REQUEST['category'];
		$tagged 		= false;

		$args['tax_query'] = array(
			array(
				'taxonomy' 	=> 'recipe_categories',
				'field' 	=> 'name',
				'terms'	 	=> $categorized
			)
		);

	} elseif ( isset( $_REQUEST['tag'] ) && $_REQUEST['tag'] != '' ) {

		$categorized 	= false;
		$tagged 		= $_REQUEST['tag'];

		// $args['tax_query'] = array(
		// 	array(
		// 		'taxonomy' 	=> 'recipe_tags',
		// 		'field' 	=> 'name',
		// 		'terms'	 	=> $tagged
		// 	)
		// );

		$args = array(
			's' => $tagged, // Search by the provided tag or keyword
			'post_type' => 'recipes', // Assuming you're looking for regular posts
			// 'posts_per_page' => -1, // Retrieve all matching posts
		);

	} else {
		$categorized = false;
		$tagged = false;
	}

	//echo "<pre>"; print_r($args);
	$recipes_query 	= new WP_Query( $args );
	//echo "<pre>"; print_r($recipes_query);
	$content 		= '';

	// if ( $categorized ) {
	// 	echo '<h3>Meals in Category: ' . esc_html( $categorized ) . '<span style="font-size:13px;font-weight:normal; vertical-align:middle;margin-left: 5px;"><a class="remove-tags new-btton" href="javascript:void(0)" style="color:#0093bf;">Search Again</a></span></h3>';
	// 	echo '<input id="etp-current-cat" type="hidden" value="' . $categorized . '" />';
	// } elseif ( $tagged ) {
	// 	echo '<h3>Recipe Search: ' . esc_html( $tagged ) . '<span style="font-size:13px;font-weight:normal; vertical-align:middle;margin-left: 5px;"><a class="remove-tags new-btton" id =" blaze-recipe-search" href="javascript:void(0)" style="color:#0093bf;">Search Again</a></span></h3>';
	// 	echo '<input id="etp-current-tag" type="hidden" value="' . $tagged . '" />';
	// } else {
	// 	// Nothing to do here.
	// }

	if ( $recipes_query->have_posts() ) {

		

		// The main loop
		while( $recipes_query->have_posts() ) : $recipes_query->the_post();

			$recipe_id 		= get_the_ID();
			$recipe_meta 	= get_post_meta( $recipe_id );

			// The good stuff
			$content .= '
			<div class="grid__item blaze-grid-item" id="'.$recipe_id.'">
			<a class="blaze-remove-meal blaze-hidden" onclick="cus_call_r(this);"></a>
			<input type="hidden" class="blaze-recipe-id" name="blaze_recipe_id" value="' . $recipe_id . '" />
			<div class="etp-img-wrap">' . etp_get_the_post_thumbnail( $recipe_id, 'medium' ) . '<a class="thickbox blaze-preview-link newtwo" title="View Recipe" href="' . get_admin_url() . 'admin-ajax.php?action=etp_preview_recipe&ref=click_info_meal&recipe_id=' . $recipe_id . '"><span class="dashicons dashicons-info"></span></a></div>' .
			etp_get_recipe_macros( $recipe_id, true ) . '
			<div class="blaze-info-wrap">' .
			etp_get_recipe_title( $recipe_id ) .
			etp_get_recipe_macros( $recipe_id ) .						
			etp_get_recipe_tags( $recipe_id ) .
			etp_get_recipe_rating( $recipe_id ) .
			'</div>	
			</div>';

		endwhile; // end main loop
	}

	//return $content;

    // 	$big 	= 999999999; // need an unlikely integer
    // 	//echo esc_url( get_pagenum_link( $big ));
    // 	$links 	= paginate_links( array(
    // 		'base'		=> str_replace( $big, '%#%' ),
    // 		'format'	=> '?paged=%#%',
    // 		'current'	=> max( 1, $paged ),
    // 		'total'		=> $recipes_query->max_num_pages,
    // 	) );
    $big = 999999999; // need an unlikely integer
    //echo esc_url( get_pagenum_link( $big ));
    $links = paginate_links( array(
    	'base'     => str_replace( '%#%', '%s', esc_url( get_pagenum_link( $big ) ) ),
    	'format'   => '?paged=%#%',
    	'current'  => max( 1, $paged ),
    	'total'    => $recipes_query->max_num_pages,
    ) );

	

	$content .= '<div class="etp-mp-pagination">' . $links . '</div>';
	$content .='<script>jQuery(".page-numbers").attr("href", "#");
	jQuery(".etp-mp-pagination .page-numbers").on("click", function(e) {
		e.preventDefault(); // Prevent the default behavior of the link
		  
		  var inkal = jQuery(this).text();
		  var category = jQuery(".blaze-category.active").html();
		  var tag = jQuery("#blaze-recipe-search").val();
		  etp_get_recipes(paged=inkal,tag,category)
	  });</script>';
	echo $content;
	exit;
}
add_action( 'wp_ajax_etp_get_recipes', 'etp_get_recipes' );
add_action( 'wp_ajax_nopriv_etp_get_recipes', 'etp_get_recipes' );

/**
 * Returns the HTML for the provided recipe ID.
 * @access public
 */
function etp_get_html() {

	$meals 	= isset( $_POST['meals'] ) ? $_POST['meals'] : array();
	$leftover 	= isset( $_POST['leftover'] ) ? $_POST['leftover'] : array();
	/*echo '<pre>';
	print_r($leftover);
	echo '</pre>';*/
	$return = array();

	foreach ( $meals as $k => $v ) {
		$checked = '';
		if($leftover[$v][$k]==1){
			$checked = 'checked';
		}
		$temp = $k+1;
		$meal = '';
		if($temp%2==0){
			$meal = '<div class="meal-snacks">
			<p>Snack</p>
			</div>';
		} else{
			$meal = '<div class="meal-snacks">
			<p>Meal</p>
			</div>';
		}
		//'test v='.$v." test k=".$k." leftover=".$leftover[$v][$k]. 
		$return[$k] =  '
		<a class="blaze-remove-meal" onclick="cus_call_r(this);"></a>
		<input type="hidden" class="blaze-recipe-id" name="blaze_recipe_id" value="' . $v . '" />
		<div class="etp-img-wrap">' . get_the_post_thumbnail( $v, 'thumbnail' ) . '<a class="thickbox blaze-preview-link newtwo" title="View Recipe" href="' . get_admin_url() . 'admin-ajax.php?action=etp_preview_recipe&recipe_id=' . $v . '"><span class="dashicons dashicons-info"></span></a></div>		
		<div class="blaze-info-wrap dropped-info testing">	
		'.$meal.'
		<span class="etp-recipe-name">' . etp_get_recipe_title( $v ) . '</span>
		<div class="etp-macro-leftover"><input type="checkbox" value="1" name="leftover" class="leftover_chkbox"  '.$checked.'/> <label class="leftover_label">Leftover</label></div>
		</div>'
		.
		etp_get_recipe_macros( $v, true );
	}

	echo json_encode( $return );
	exit;
}
add_action( 'wp_ajax_etp_get_html', 'etp_get_html' );
add_action( 'wp_ajax_nopriv_etp_get_html', 'etp_get_html' );

/**
 * Renders the form to save a plan.
 * @access public
 */
function etp_save_prompt() {
	$plan_id = isset( $_GET['plan_id'] ) ? absint( $_GET['plan_id'] ) : 0;
	?>

	<?php if ( 0 !== $plan_id && etp_current_user_owns_plan( $plan_id ) ) : ?>
		<script>
			function maybe_dislay_name(option) {
				//save_type = document.getElementById( 'etp-save-type' ).value;
				save_type = option;
				if ( 'save_new' == save_type ) {
					document.getElementById( 'etp-plan-name' ).style.display = 'block';
					document.getElementById( 'overwriteButton' ).style.display = 'none';
					document.getElementById( 'saveNewButton' ).style.display = 'none';
					document.getElementById( 'continue_plan_st' ).style.display = 'block';
					document.getElementById( 'continue_plan_st' ).setAttribute ('style', 'display: block !important;');
				} else {
					document.getElementById( 'etp-plan-name' ).style.display = 'none';
				}
			}
		</script>
		<p style="margin: 10px 0 5px 0;">Would you like to overwrite the existing plan or save it as a new one?</p>

		<!-- <select id="etp-save-type" onchange="maybe_dislay_name();" style="margin-top:12px;">
			<option value="overwrite">Overwrite plan</option>
			<option value="save_new">Save as a new plan...</option>
		</select> -->

		<div style="margin-top: 12px;">
			<div>
				<button id="overwriteButton" onclick="selectOption('overwrite')">Overwrite plan</button>
			</div>
			<div>
				<button id="saveNewButton" onclick="selectOption('save_new')">Save as a new plan...</button>
			</div>
		</div>

		<script>
			function selectOption(option) {
				if (option === 'overwrite') {
					maybe_dislay_name(option);
					console.log('Overwriting plan...');
					jQuery('.continue_plan_st').click();
				} else if (option === 'save_new') {
					maybe_dislay_name(option);
					console.log('Saving as a new plan...');
				}
			}

		</script>

		<input id="etp-plan-name" name="etp_plan_name" type="text" placeholder="Please enter a plan name..." style="display:none; margin-top: 20px;">
		<input id="blaze-plan-id" name="etp_plan_id" value="<?php echo $plan_id; ?>" type="hidden" />

		<button id="continue_plan_st" class="btn btn--primary continue_plan_st" style="background: #4ABB76; margin-top: 20px;" onclick="self.parent.etp_save_plan(<?php echo $plan_id; ?>);return false;">Submit</button>

		<?php else: ?>

			<p style="margin: 10px 0 5px 0;">Please enter a name for your plan to continue:</p>
			<input id="etp-plan-name" type="text" name="etp_plan_name" style="margin-top: 12px" />
			<button class="btn btn--primary" style="background: #4ABB76; margin-top: 20px;" onclick="self.parent.etp_save_plan();return false;">Save My Plan</button>

		<?php endif;
		exit;
	}
	add_action( 'wp_ajax_etp_save_prompt', 'etp_save_prompt' );
	add_action( 'wp_ajax_nopriv_etp_save_prompt', 'etp_save_prompt' );

/**
 * Renders the form to save a plan.
 * @access public
 */
function etp_delete_prompt() {
	?>

	<p style="margin-top:10px;">Are you sure you want to delete this plan?</p>
	<button class="btn btn--primary" style="background: #4ABB76;" onclick="self.parent.etp_delete_plan(<?php echo $_GET['plan_id']; ?>);return false;">Delete Plan</button>

	<?php
	exit;
}
add_action( 'wp_ajax_etp_delete_prompt', 'etp_delete_prompt' );
add_action( 'wp_ajax_nopriv_etp_delete_prompt', 'etp_delete_prompt' );

/**
 * Handles the request to save multiple days.
 * @access public
 */
function etp_save_plan() {
	global $wpdb;

	// Grab the data we need.
	$user 		= wp_get_current_user();
	$recipes 	= $_POST['recipes'];
	$leftover 	= $_POST['leftover'];
	$nutrient_val = $_POST['nutrient_val'];
	$table 		= Blaze_Meal_Planner::table_name();
	
	//echo $nutrient_val;

	$title 		= isset( $_POST['title'] ) ? $_POST['title'] : '';

	if ( isset( $_POST['save_type'] ) && 'overwrite' == $_POST['save_type'] ) {
		$plan_id 	= absint( $_POST['plan_id'] );
		$query 		= $wpdb->prepare( "UPDATE $table SET meals = %s, nutrients = %s, time = %s,leftover = %s WHERE id = %d AND user_id = %d", serialize( $recipes ), serialize($nutrient_val), current_time( 'mysql' ), serialize( $leftover ), $plan_id, $user->ID );
		$save 		= $wpdb->query( $query );

		if ( $save ) {
			$result = $plan_id;
		} else {
			$result = false;
		}

	} else {

		// Insert the data into the DB.
		$save = $wpdb->insert(
			Blaze_Meal_Planner::table_name(),
			array(
				'meals' 	=> serialize( $recipes ),
				'nutrients' 	=> serialize( $nutrient_val ),
				'leftover' 	=> serialize( $leftover ),
				'user_id' 	=> $user->ID,
				'time' 		=> current_time( 'mysql' ),
				'title'		=> $title
			),
			array(
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
				'%s'
			)
		);

		if ( $save ) {
			$result = $wpdb->insert_id;
		} else {
			$result = false;
		}

	}

	$wpdb->flush();

	// Let our JS know how things went.
	echo json_encode( array( $result ) );
	exit;
}
add_action( 'wp_ajax_etp_save_plan', 'etp_save_plan' );
add_action( 'wp_ajax_nopriv_etp_save_plan', 'etp_save_plan' );

function etp_delete_plan() {
	global $wpdb;

	// Grab the data we need.
	$user 		= wp_get_current_user();
	$plan_id 	= absint( $_POST['plan_id'] );

	// Insert the data into the DB.
	$table = Blaze_Meal_Planner::table_name();
	$query = $wpdb->prepare( "DELETE FROM $table WHERE id = %d AND user_id = %d", $plan_id, $user->ID );
	$result = $wpdb->query( $query );

	if ( $result ) {
		$result = true;
	} else {
		$result = false;
	}

	$wpdb->flush();

	// Let our JS know how things went.
	echo json_encode( array( $result ) );
	exit;
}
add_action( 'wp_ajax_etp_delete_plan', 'etp_delete_plan' );
add_action( 'wp_ajax_nopriv_etp_delete_plan', 'etp_delete_plan' );

/**
 * Retrieves an existing plan.
 * @access public
 */
function etp_get_plan_data() {
	global $wpdb;

	// Grab the data we need.
	$plan_id 	= absint( $_POST['plan_id'] );
	$table 		= Blaze_Meal_Planner::table_name();
	$query 		= $wpdb->prepare( "SELECT meals,leftover FROM $table WHERE id = %d", $plan_id );
	$result 	= $wpdb->get_results( $query, ARRAY_A );

	if ( ! $result ) {
		$result = array( false );
	}

	$wpdb->flush();

	$result['meals'] = unserialize( $result[0]['meals'] );
	$result['leftover'] = unserialize( $result[0]['leftover'] );

	// Let our JS know how things went.
	//wp_die( var_dump( $result  ) );

	echo json_encode( $result );

	exit;
}
add_action( 'wp_ajax_etp_get_plan_data', 'etp_get_plan_data' );
add_action( 'wp_ajax_nopriv_etp_get_plan_data', 'etp_get_plan_data' );

/**
 * Retrieves an existing plan.
 * @access public
 */
function etp_recipe_rating() {
	global $wpdb;

	// Grab the data we need.
	$recipe_id 	= absint( $_POST['recipe_id'] );
	$rating 	= $_POST['rating'];
	$user_id = get_current_user_id();
	global $wpdb;
	$table = 'wpah_custom_rating';
	//echo  "SELECT rating FROM $table WHERE post_id = '$recipe_id' AND user_id = '$user_id'";
	$data 	= $wpdb->get_results( "SELECT rating FROM $table WHERE post_id = '$recipe_id' AND user_id = '$user_id'", ARRAY_A );
	// Let our JS know how things went.
	//wp_die( var_dump( $result  ) );
	if(isset($data[0]['rating'])){
		$affected_row_count = $wpdb->update( 
			$table, 
			array( 
				'rating' => $rating,
			), 
			array( 'post_id' => $recipe_id,'user_id' =>  $user_id)
		);
	} else {
		$affected_row_count = $wpdb->insert($table, array(
			'post_id' => $recipe_id,
			'user_id' => $user_id,
			'rating' => $rating,
		));
	}

	$avg_rating_array 	= $wpdb->get_results( "SELECT avg(rating) as avg_rating FROM $table WHERE post_id = '$recipe_id'", ARRAY_A );
	$avg_rating = 0;
	if($avg_rating_array[0]['avg_rating'])
		echo json_encode($avg_rating_array[0]['avg_rating']);
	else 
		echo json_encode(0);
	exit;
}

add_action( 'wp_ajax_etp_recipe_rating', 'etp_recipe_rating' );
add_action( 'wp_ajax_nopriv_etp_recipe_rating', 'etp_recipe_rating' );

