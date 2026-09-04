<ul class="side_lst mcat">
<?php
$terms = get_terms( array(
	'taxonomy'   => 'machine_category',
	'hide_empty' => false,
) );
foreach ( $terms as $term ) {
	echo '<li class="side_lst__itm"><a class="side_lst__lnk" href="'.get_term_link($term).'">'.$term->name.'</a></li>';
} ?>
</ul>