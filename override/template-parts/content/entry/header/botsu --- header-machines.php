<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 * @version 19.0.0-beta1
 */

use Framework\Helper;

$args = wp_parse_args(
	// phpcs:disable VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable
	$args,
	// phpcs:enable
	array(
		'_display_title_top_widget_area' => false,
		'_display_entry_meta'            => false,
	)
);
?>

<header class="c-entry__header">
	<?php
	if ( $args['_display_title_top_widget_area'] ) {
		if ( Helper::is_active_sidebar( 'title-top-widget-area' ) ) {
			Helper::get_template_part(
				'template-parts/widget-area/title-top',
				$args['_name']
			);
		}
	}
	?>

	<h1 class="c-entry__title"><?php the_title(); ?></h1>
	<div class="c-entry__meta">
		<ul class="c-meta">
			<li class="c-meta__item item_date">掲載日：<?php the_time('Y/m/d'); ?>
			</li>
			<?php
			$terms = get_the_terms($post->ID, 'machine_category');
			if ( $terms ) {
				foreach ( $terms as $term ) {
					$term_link = get_term_link( $term );
					echo '<li class="c-meta__item item_cat"><a href="'.esc_url( $term_link ).'">'.$term->name.'</a></li>';
				}
			} ?>
			<li class="c-meta__item item_user"><?php the_author_posts_link(); ?></li>
		</ul>
	</div>
</header>
