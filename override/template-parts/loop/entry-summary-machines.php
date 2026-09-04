<?php
	$mc_images = get_field('mc_images');
	$mc_img01 = $mc_images['mc_img01']['url'];
	$post_id = get_the_ID();
	$terms = get_the_terms($post_id, 'machine_category');
	if($terms) {
		foreach($terms as $term) {
			$mc_cat_name = $term->name;
		}
	}
	$mc_price_select = get_field('mc_price_select');
	$mc_price = get_field('mc_price');
	if($mc_price) {
		$sell_price = number_format($mc_price);
		$tax_price = number_format($mc_price * 1.1);
	}
	$mc_comment = get_field( 'mc_comment' );
	$mc_format = get_field( 'mc_format' );
	$mc_number = get_field( 'mc_number' );
	$mc_spec = get_field( 'mc_spec' );
?>
<a href="<?php the_permalink(); ?>" class="mc_lnk">
	<article class="mc_box">
		<!-- <?php var_dump( $mc_img01 ); ?> -->
		<?php if( $mc_img01 ) : ?>
			<figure class="mc_box__fig">
				<img src="<?php echo esc_url( $mc_img01 ); ?>" alt="<?php the_title(); ?>" class="mc_box__img">
			</figure>
		<?php endif; ?>
		<header class="mc_box__header">
			<h2 class="mc_box__sttl"><?php the_title(); ?></h2>
			<div class="mc_box__metas">
				<?php if( $mc_cat_name ) { echo '<p class="mc_box__meta cat">' . esc_html( $mc_cat_name ) . '</p>'; } ?>
				<p class="mc_box__meta user"><?php the_author(); ?></p>
			</div>
		</header>
		<div class="mc_box__body">
			<div class="mc_price_box">
				<span class="small">販売価格（税別）</span>
				<?php if ( $mc_price_select === "1" ) {
					echo '<span class="main_price">お問い合わせ</span>';
				} elseif ( $mc_price_select === "2" ) {
					if($sell_price) { echo '<span class="main_price">&yen;' . esc_html($sell_price) . '</span><span class="tax_price">（税込&yen;' . esc_html($tax_price) . '）</span>'; }
				} ?>
			</div>
			<?php if($mc_comment) : ?>
				<div class="mc_box__cmnt">
					<?php echo wp_kses_post( $mc_comment ); ?>
				</div>
			<?php endif; ?>
			<table class="mc_box__tbl">
				<tr>
					<th class="mc_box__th">型式</th>
					<td class="mc_box__td"><?php if($mc_format) { echo esc_html($mc_format); } ?></td>
				</tr>
				<tr>
					<th class="mc_box__th">製造No.</th>
					<td class="mc_box__td"><?php if($mc_number) { echo esc_html($mc_number); } ?></td>
				</tr>
				<tr>
					<th class="mc_box__th">仕様</th>
					<td class="mc_box__td">
						<?php
							$mc_spec = get_field( 'mc_spec' );
							if( $mc_spec ) :
								foreach( $mc_spec as $value ): ?>
							<span class="spec_value"><?php echo $value; ?></span>
						<?php endforeach; endif; ?>
					</td>
				</tr>
			</table>
		</div>
		<footer class="mc_box__footer">
			<p class="mc_box__date">掲載日：<?php the_time('Y/m/d'); ?></p>
			<p class="mc_box__id">No.<?php the_ID(); ?></p>
		</footer>
	</article>
</a>
