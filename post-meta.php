<?php
/**
 * etp-post-meta.php
 *
 * Responsible for configuring custom post meta
 * for the ETP Meal Planner plugin.
 *
 * @package ETP Meal Planner
 * @author  Matt Shaw <matt@expandedfronts.com>
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers the meta boxes with WordPress.
 * @access public
 */
function etp_add_meta() {
	add_meta_box( 'etp_recipe_ingredients', 'Recipe Ingredients', 'etp_recipe_ingredients', 'recipes', 'normal', 'high' );
	add_meta_box( 'etp_recipe_meta', 'Recipe Details', 'etp_recipe_meta', 'recipes', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'etp_add_meta' );

/**
 * Displays the ingredients metabox.
 * @access public
 */
function etp_recipe_ingredients() {
	$recipe_meta = array();
	$recipe_meta = get_post_meta( get_the_ID(), 'etp_recipe_meta' );
	if ( isset( $recipe_meta[0]['ingredients'] ) ) {
		$ingredients = $recipe_meta[0]['ingredients'];
	} else {
		$ingredients = array();
	}

	?>

	<table width="100%" cellspacing="5" class="etp-list-table ingredients">

		<thead>
			<tr>
				<th class="etp-sort">
					<span class="hide-if-js">Order</span>
					<div class="dashicons dashicons-sort hide-if-no-js"></div>
				</th>
				<th>Amount</th>
				<th>Unit</th>
				<th>Ingredient</th>
				<th>Category</th>
				<th></th>
			</tr>
		</thead>

		<tbody>

		<?php if ( ! empty( $ingredients ) ): ?>

			<?php foreach ( $ingredients as $key => $ingredient ) : ?>

			<tr class="etp-ingredient etp-row etp-loaded-from-meta">

				<?php
					$ingredient_id 		= isset( $ingredient['id'] ) ? $ingredient['id'] : 0;
					$ingredient_amt 	= isset( $ingredient['amount'] ) ? $ingredient['amount'] : '';
					$ingredient_unit	= isset( $ingredient['unit'] ) ? $ingredient['unit'] : '';
					$ingredient_name 	= isset( $ingredient['ingredient'] ) ? $ingredient['ingredient'] : '';
					$ingredient_cat 	= isset( $ingredient['category'] ) ? $ingredient['category'] : '';
					if ( $ingredient_name == '' ) continue;
				?>

				<td class="etp-sort">
					<input class="etp-order hide-if-js" style="width:100%;" type="text" name="recipe[ingredients][<?php echo absint( $key ); ?>][order]" value="<?php echo absint( $ingredient['order'] ); ?>" />
					<input class="etp-id" name="recipe[ingredients][<?php echo absint( $key ); ?>][id]" type="hidden" value="<?php echo absint( $ingredient_id ); ?>" />
					<span class="etp-sort-handle dashicons dashicons-menu hide-if-no-js"></span>
				</td>
				<td class="etp-amt">
					<input type="text" style="width:100%;" name="recipe[ingredients][<?php echo absint( $key ); ?>][amount]" value="<?php echo esc_html( $ingredient_amt ); ?>" placeholder="2" />
				</td>
				<!--<td class="etp-unit">
					<input type="text" name="recipe[ingredients][<?php echo absint( $key ); ?>][unit]" value="<?php echo esc_html( $ingredient_unit ); ?>" placeholder="" />
				</td>-->
				<td class="etp-unit">

					<select name="recipe[ingredients][<?php echo absint( $key ); ?>][unit]" style="width:100%;">
						<option value="tablespoon" <?php selected( $ingredient_unit, 'tablespoon' ); ?>>tbsp.</option>
						<option value="teaspoon" <?php selected( $ingredient_unit, 'teaspoon' ); ?>>tsp.</option>
						<option value="cup" <?php selected( $ingredient_unit, 'cup' ); ?>>C.</option>
						<option value="speck" <?php selected( $ingredient_unit, 'speck' ); ?>>spk.</option>
						<option value="pound" <?php selected( $ingredient_unit, 'pound' ); ?>>lb.</option>
						<option value="quart" <?php selected( $ingredient_unit, 'quart' ); ?>>qt.</option>
						<option value="minute" <?php selected( $ingredient_unit, 'minute' ); ?>>min.</option>
						<option value="piece" <?php selected( $ingredient_unit, 'piece' ); ?>>pc.</option>
						<option value="each" <?php selected( $ingredient_unit, 'each' ); ?>>ea.</option>
						<option value="peck" <?php selected( $ingredient_unit, 'peck' ); ?>>pk.</option>
						<option value="bushel" <?php selected( $ingredient_unit, 'bushel' ); ?>>bu.</option>
						<option value="ounce" <?php selected( $ingredient_unit, 'ounce' ); ?>>oz.</option>
						<option value="pint" <?php selected( $ingredient_unit, 'pint' ); ?>>pt.</option>
						<option value="moderate" <?php selected( $ingredient_unit, 'moderate' ); ?>>mod.</option>
						<option value="dozen" <?php selected( $ingredient_unit, 'dozen' ); ?>>doz.</option>
						<option value="hour" <?php selected( $ingredient_unit, 'hour' ); ?>>hr.</option>
						<option value="few grains" <?php selected( $ingredient_unit, 'few grains' ); ?>>f.g.</option>
					</select>

				</td>
				<td class="etp-desc">
					<input type="text" style="width:100%;" name="recipe[ingredients][<?php echo absint( $key ); ?>][ingredient]" value="<?php echo esc_html( $ingredient_name ); ?>" placeholder="onions, diced" />
				</td>

				<td class="etp-cat">

					<select name="recipe[ingredients][<?php echo absint( $key ); ?>][category]" style="width:100%;">
						<option value="other" <?php selected( $ingredient_cat, 'other' ); ?>>Other</option>
						<option value="baking" <?php selected( $ingredient_cat, 'baking' ); ?>>Baking/Spices</option>
						<option value="bread" <?php selected( $ingredient_cat, 'bread' ); ?>>Bread/Pasta</option>
						<option value="breakfast" <?php selected( $ingredient_cat, 'breakfast' ); ?>>Breakfast/Cereals</option>
						<option value="canned" <?php selected( $ingredient_cat, 'canned' ); ?>>Canned Goods</option>
						<option value="condiments" <?php selected( $ingredient_cat, 'condiments' ); ?>>Condiments</option>
						<option value="cookies" <?php selected( $ingredient_cat, 'cookies' ); ?>>Cookies/Crackers</option>
						<option value="dairy" <?php selected( $ingredient_cat, 'dairy' ); ?>>Dairy</option>
						<option value="asian" <?php selected( $ingredient_cat, 'asian' ); ?>>Ethnic - Asian</option>
						<option value="italian" <?php selected( $ingredient_cat, 'italian' ); ?>>Ethnic - Italian</option>
						<option value="mexican" <?php selected( $ingredient_cat, 'mexican' ); ?>>Ethnic - Mexican</option>
						<option value="meat" <?php selected( $ingredient_cat, 'meat' ); ?>>Meat/Poultry</option>
						<option value="organic" <?php selected( $ingredient_cat, 'organic' ); ?>>Organic</option>
						<option value="produce" <?php selected( $ingredient_cat, 'produce' ); ?>>Produce</option>
						<option value="snacks" <?php selected( $ingredient_cat, 'snacks' ); ?>>Snacks/Candy</option>
						<option value="supplements" <?php selected( $ingredient_cat, 'supplements' ); ?>>Supplements</option>
					</select>

				</td>

				<td class="etp-remove">
					<a href="#" class="etp-remove-row dashicons dashicons-no" data-type="ingredient" title="Remove"></a>
				</td>

			</tr>

			<?php endforeach; ?>


		<?php else : ?>

			<tr class="etp-ingredient etp-row">

				<td class="etp-sort">
					<input class="hide-if-js" style="width:100%;" type="text" name="recipe[ingredients][0][order]" value="0" />
					<span class="etp-sort-handle dashicons dashicons-menu hide-if-no-js"></span>
				</td>
				<td class="etp-amt">
					<input type="text" style="width:100%;" name="recipe[ingredients][0][amount]" value="" placeholder="2" />
				</td>
				<td class="etp-unit">
					<select name="recipe[ingredients][0][unit]" style="width:100%;">
						<option value="tablespoon" selected="selected">tbsp.</option>
						<option value="teaspoon">tsp.</option>
						<option value="cup">C.</option>
						<option value="speck">spk.</option>
						<option value="pound">lb.</option>
						<option value="quart">qt.</option>
						<option value="minute">min.</option>
						<option value="piece">pc.</option>
						<option value="each">ea.</option>
						<option value="peck">pk.</option>
						<option value="bushel">bu.</option>
						<option value="ounce">oz.</option>
						<option value="pint">pt.</option>
						<option value="moderate">mod.</option>
						<option value="dozen">doz.</option>
						<option value="hour">hr.</option>
						<option value="few grains">f.g.</option>
					</select>
					<!--<input type="text" name="recipe[ingredients][0][unit]" value="" placeholder="" />-->
				</td>
				<td class="etp-desc">
					<input type="text" style="width:100%;" name="recipe[ingredients][0][ingredient]" value="" placeholder="onions, diced" />
				</td>
				<td class="etp-cat">
					<select name="recipe[ingredients][0][category]" style="width:100%;">
						<option value="other" selected="selected">Other</option>
						<option value="baking">Baking/Spices</option>
						<option value="bread">Bread/Pasta</option>
						<option value="breakfast">Breakfast/Cereals</option>
						<option value="canned">Canned Goods</option>
						<option value="condiments">Condiments</option>
						<option value="cookies">Cookies/Crackers</option>
						<option value="dairy">Dairy</option>
						<option value="asian">Ethnic - Asian</option>
						<option value="italian">Ethnic - Italian</option>
						<option value="mexican">Ethnic - Mexican</option>
						<option value="meat">Meat/Poultry</option>
						<option value="organic">Organic</option>
						<option value="produce">Produce</option>
						<option value="snacks">Snacks/Candy</option>
						<option value="supplements">Supplements</option>
					</select>
					<!-- <input type="text" style="width:100%;" name="recipe[ingredients][0][category]" value="" placeholder="produce/dairy" /> -->
				</td>
				<td class="etp-remove">
					<a href="#" class="etp-remove-row dashicons dashicons-no" data-type="ingredient" title="Remove"></a>
				</td>

			</tr>

		<?php endif; ?>

			<tr class="etp-heading etp-row-hidden etp-row">
				<td class="etp-sort">
					<input class="hide-if-js" style="width:100%;" type="text" name="recipe[ingredients][9999][order]" value="0" />
					<span class="etp-sort-handle dashicons dashicons-menu hide-if-no-js"></span>
				</td>
				<td class="etp-amt">
						<input type="text" style="width:100%;" name="recipe[ingredients][9999][amount]" value="" placeholder="2" />
				</td>
				<td class="etp-unit">
					<select name="recipe[ingredients][9999][unit]" style="width:100%;">
						<option value="tablespoon" selected="selected">tbsp.</option>
						<option value="teaspoon">tsp.</option>
						<option value="cup">C.</option>
						<option value="speck">spk.</option>
						<option value="pound">lb.</option>
						<option value="quart">qt.</option>
						<option value="minute">min.</option>
						<option value="piece">pc.</option>
						<option value="each">ea.</option>
						<option value="peck">pk.</option>
						<option value="bushel">bu.</option>
						<option value="ounce">oz.</option>
						<option value="pint">pt.</option>
						<option value="moderate">mod.</option>
						<option value="dozen">doz.</option>
						<option value="hour">hr.</option>
						<option value="few grains">f.g.</option>
					</select>
					<!--<input type="text" name="recipe[ingredients][9999][unit]" value="" placeholder="" />-->
				</td>
				<td class="etp-desc">
					<input type="text" style="width:100%;" name="recipe[ingredients][9999][ingredient]" value="" placeholder="onions, diced" />
				</td>
				<td class="etp-cat">

					<select name="recipe[ingredients][9999][category]" style="width:100%;">
						<option value="other" selected="selected">Other</option>
						<option value="baking">Baking/Spices</option>
						<option value="bread">Bread/Pasta</option>
						<option value="breakfast">Breakfast/Cereals</option>
						<option value="canned">Canned Goods</option>
						<option value="condiments">Condiments</option>
						<option value="cookies">Cookies/Crackers</option>
						<option value="dairy">Dairy</option>
						<option value="asian">Ethnic - Asian</option>
						<option value="italian">Ethnic - Italian</option>
						<option value="mexican">Ethnic - Mexican</option>
						<option value="meat">Meat/Poultry</option>
						<option value="organic">Organic</option>
						<option value="produce">Produce</option>
						<option value="snacks">Snacks/Candy</option>
						<option value="supplements">Supplements</option>
					</select>
					<!-- <input type="text" style="width:100%;" name="recipe[ingredients][0][category]" value="" placeholder="produce/dairy" /> -->
				</td>
				<td class="etp-remove">
					<a href="#" class="etp-remove-row dashicons dashicons-no" data-type="heading" title="Remove"></a>
				</td>
			</tr>

		</tbody>

		<tfoot class="hide-if-no-js">
			<tr class="etp-actions">
				<td colspan="5">

					<a class="etp-add-row button" data-type="ingredient" href="#">
						<span class="dashicons dashicons-plus"></span>
						Add an Ingredient
					</a>

				</td>
			</tr>
		</tfoot>

	</table>

	<?php
}

/**
 * Displays the recipe metabox.
 * @access public
 */
function etp_recipe_meta() {

	$recipe_meta = array();
	$recipe_meta = get_post_meta( get_the_ID(), 'etp_recipe_meta' );

	?>

		<table class="vft-recipe-table form-table">

			<!-- Prep Time -->
			<tr>
				<td><label for="recipe_preptime"><strong><?php _e( 'Prep Time:', 'vft' ); ?></strong></label></td>
				<td>
					<input id="recipe_preptime" name="recipe[preptime]" class="regular-text" <?php if ( isset( $recipe_meta[0]['preptime'] ) ) { echo 'value="' . esc_html($recipe_meta[0]['preptime']) . '"'; } ?> />
					<p class="description"><?php _e( 'The length of time it takes to prepare the recipe.', 'vft' ); ?></p>
				</td>
			</tr>

			<!-- Cook Time -->
			<tr>
				<td><label for="recipe_cooktime"><strong><?php _e( 'Cook Time:', 'vft' ); ?></strong></label></td>
				<td>
					<input id="recipe_cooktime" name="recipe[cooktime]" class="regular-text" <?php if ( isset( $recipe_meta[0]['cooktime'] ) ) { echo 'value="' . esc_html($recipe_meta[0]['cooktime']) . '"'; } ?> />
					<p class="description"><?php _e( 'The time it takes to actually cook the dish.', 'vft' ); ?></p>
				</td>
			</tr>

			<!-- Yield -->
			<tr>
				<td><label for="recipe_yield"><strong><?php _e( 'Yield:', 'vft' );?></strong></label></td>
				<td>
					<input id="recipe_yield" name="recipe[yield]" class="regular-text" <?php if ( isset( $recipe_meta[0]['yield'] ) ) { echo 'value="' . esc_html($recipe_meta[0]['yield']) . '"'; } ?> />
					<p class="description"><?php _e( 'The quantity produced by the recipe (for example, number of people served, number of servings, etc).', 'vft' ); ?></p>
				</td>
			</tr>

			<!-- Serving Size -->
			<tr>
				<td><label for="recipe_servings"><strong><?php _e( 'Serving Size:', 'etp' ); ?></strong></label></td>
				<td>
					<input id="recipe_servings" name="recipe[servings]" class="regular-text" <?php if ( isset( $recipe_meta[0]['servings'] ) ) { echo 'value="' . esc_html( $recipe_meta[0]['servings'] ) . '"';} ?> />
					<p class="description"><?php _e( 'The size of each serving.', 'etp' ); ?></p>
				</td>
			</tr>

			<!-- Calories -->
			<tr>
				<td><label for="recipe_calories"><strong><?php _e( 'Calories', 'etp' ); ?></strong></label></td>
				<td>
					<input id="recipe_calories" name="recipe[calories]" class="regular-text" <?php if ( isset( $recipe_meta[0]['calories'] ) ) { echo 'value="' . esc_html( $recipe_meta[0]['calories'] ) . '"'; } ?> />
					<p class="desciption"><?php _e( 'Enter the amount of calories for this recipe.', 'etp' ); ?></p>
				</td>
			</tr>

			<!-- Fat -->
			<tr>
				<td><label for="recipe_fat"><strong><?php _e( 'Fat', 'etp' ); ?></strong></label></td>
				<td>
					<input id="recipe_fat" name="recipe[fat]" class="regular-text" <?php if ( isset( $recipe_meta[0]['fat'] ) ) { echo 'value="' . esc_html( $recipe_meta[0]['fat'] ) . '"'; } ?> />
					<p class="desciption"><?php _e( 'Enter the amount of fat for this recipe.', 'etp' ); ?></p>
				</td>
			</tr>

			<!-- Protein -->
			<tr>
				<td><label for="recipe_protein"><strong><?php _e( 'Protein', 'etp' ); ?></strong></label></td>
				<td>
					<input id="recipe_protein" name="recipe[protein]" class="regular-text" <?php if ( isset( $recipe_meta[0]['protein'] ) ) { echo 'value="' . esc_html( $recipe_meta[0]['protein'] ) . '"'; } ?> />
					<p class="desciption"><?php _e( 'Enter the amount of protein for this recipe.', 'etp' ); ?></p>
				</td>
			</tr>

			<!-- Carbs -->
			<tr>
				<td><label for="recipe_carbs"><strong><?php _e( 'Carbohydrates', 'etp' ); ?></strong></label></td>
				<td>
					<input id="recipe_carbs" name="recipe[carbs]" class="regular-text" <?php if ( isset( $recipe_meta[0]['carbs'] ) ) { echo 'value="' . esc_html( $recipe_meta[0]['carbs'] ) . '"'; } ?> />
					<p class="desciption"><?php _e( 'Enter the amount of carbohydrates for this recipe.', 'etp' ); ?></p>
				</td>
			</tr>			

			<!-- Fiber -->
			<tr>
				<td><label for="recipe_fiber"><strong><?php _e( 'Fiber', 'etp' ); ?></strong></label></td>
				<td>
					<input id="recipe_fiber" name="recipe[fiber]" class="regular-text" <?php if ( isset( $recipe_meta[0]['fiber'] ) ) { echo 'value="' . esc_html( $recipe_meta[0]['fiber'] ) . '"'; } ?> />
					<p class="desciption"><?php _e( 'Enter the amount of fiber for this recipe.', 'etp' ); ?></p>
				</td>
			</tr>

			<!-- Net Carbs -->
			<tr>
				<td><label for="recipe_net_carbs"><strong><?php _e( 'Net Carbs', 'etp' ); ?></strong></label></td>
				<td>
					<input id="recipe_net_carbs" name="recipe[net_carbs]" class="regular-text" <?php if ( isset( $recipe_meta[0]['net_carbs'] ) ) { echo 'value="' . esc_html( $recipe_meta[0]['net_carbs'] ) . '"'; } ?> readonly/>
					<p class="desciption"><?php _e( 'Auto calculate the amount of net carbohydrates for this recipe.', 'etp' ); ?></p>
				</td>
			</tr>
		</table>

	<?php
}

/**
 * Handles saving of post meta for recipes.
 * @access public
 */
function etp_save_recipe_meta() {
	$post_id = get_the_ID();
	if ( isset( $_POST['recipe'] ) ) {
		update_post_meta( $post_id, 'etp_recipe_meta', $_POST['recipe'] );
	}
}
add_action( 'save_post', 'etp_save_recipe_meta' );
add_action( 'publish_recipes', 'etp_save_recipe_meta' );

