<?php

echo '<div class="mc_wrapper">';

$args = array(
	'post_type' => 'machines',
);
$the_query = new WP_Query( $args );
if ($the_query->have_posts()) :  while ($the_query->have_posts()) : $the_query->the_post(); ?>

	<?php echo do_shortcode('[my_php_include file="mc_box"]'); ?>

<?php endwhile; wp_reset_postdata(); else : ?>
	<p>記事はありません。</p>
<?php endif;

echo '</div>';
