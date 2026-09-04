<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 * @version 27.2.0
 */

use Framework\Helper;

$args = wp_parse_args(
	// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
	$args,
	// phpcs:enable
	array(
		'_entries_id'              => null,
		'_entries_layout'          => 'rich-media',
		'_entries_gap'             => null,
		'_excerpt_length'          => null,
		'_force_sm_1col'           => false,
		'_infeed_ads'              => false,
		'_item_thumbnail_size'     => 'medium_large',
		'_item_title_tag'          => 'h3',
		'_display_item_meta'       => true,
		'_display_item_terms'      => 'post' === $args['_name'] ? true : false,
		'_display_item_excerpt'    => false,
		'_category_label_taxonomy' => null,
		'_use_own_category_label'  => null,
		'_posts_query'             => false,
	)
);

if ( ! $args['_posts_query'] ) {
	return;
}

$args = wp_parse_args(
	$args,
	array(
		'_display_item_author'    => $args['_display_item_meta'],
		'_display_item_published' => $args['_display_item_meta'],
		'_display_item_modified'  => false,
		'_display_item_date_icon' => false,
	)
);

$data_infeed_ads = $args['_infeed_ads'] ? 'true' : 'false';
$force_sm_1col   = $args['_force_sm_1col'] ? 'true' : 'false';

$queried_object                 = $args['_posts_query']->get_queried_object();
$is_term_query                  = is_a( $queried_object, '\WP_Term' ) && 1 === count( $args['_posts_query']->tax_query->queried_terms ) && 1 === count( array_values( $args['_posts_query']->tax_query->queried_terms )[0]['terms'] );
$is_hierarchical_taxonomy_query = $is_term_query && is_taxonomy_hierarchical( $queried_object->taxonomy );

$classes   = array();
$classes[] = 'c-entries';
if ( $args['_entries_layout'] ) {
	$classes[] = 'c-entries--' . $args['_entries_layout'];
}
if ( $args['_entries_gap'] ) {
	$classes[] = 'c-entries--gap-' . $args['_entries_gap'];
}
?>

<div class="mc_wrapper">
	<?php while ( $args['_posts_query']->have_posts() ) : ?>
		<?php $args['_posts_query']->the_post(); ?>
		<?php echo do_shortcode('[my_php_include file="mc_box"]'); ?>
		<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</div>
