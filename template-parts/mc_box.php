<?php
	$mc_rank = get_field('mc_rank');
	$mc_images = get_field('mc_images');
	if ( !empty($mc_images) && isset($mc_images['mc_img01']['url']) ) {
		$mc_img01 = $mc_images['mc_img01']['url'];
	} else {
		$mc_img01 = false; // 空の場合は false を入れておく
	}
	$post_id = get_the_ID();
	$terms = get_the_terms($post_id, 'machine_category');
	if($terms) {
		foreach($terms as $term) {
			$mc_cat_name = $term->name;
		}
	}
	$mc_price_select = get_field('mc_price_select');
	$mc_price = get_field('mc_price');
	$sell_price = '';
	$tax_price = '';
	if($mc_price) {
		$sell_price = number_format($mc_price);
		$tax_price = number_format($mc_price * 1.1);
	}
	$mc_comment = get_field( 'mc_comment' );
	$mc_format = get_field( 'mc_format' );
	$mc_number = get_field( 'mc_number' );
	$mc_specs = get_field( 'mc_spec' );
	$mc_situ = get_field( 'mc_situ' );
	$status = get_field('mc_status');
	$status_class = '';
	$status_txt = '';
	if ( isset($status) ) {
		if( $status == 0 ) {
			$status_class = "on_sale";
			$status_txt = "販売中";
		} elseif ( $status == 1 ) {
			$status_class = "under_nego";
			$status_txt = "商談中";
		} else {
			$status_class = "sold";
			$status_txt = "売約済み";
		}
	}
?>

<a href="<?php the_permalink(); ?>" class="mc_lnk">
	<article class="mc_box">
		<div class="mc_box__left">
			<?php if( is_user_logged_in() ) : ?>
				<div class="mc_rank rank_<?php echo strtolower( mb_convert_kana( $mc_rank, "r" ) ); ?>"><?php echo $mc_rank; ?>ランク</div>
			<?php endif; ?>
			<figure class="mc_box__fig">
				<?php if( $mc_img01 ) : ?>
					<img src="<?php echo esc_url( $mc_img01 ); ?>" alt="<?php the_title(); ?>" class="mc_box__img">
				<?php endif; ?>
			</figure>
		</div>
		<h2 class="mc_box__sttl"><?php the_title(); ?></h2>
		<div class="mc_box__body">
			<div class="mc_box__metas">
				<?php if( $mc_cat_name ) { echo '<p class="mc_box__meta cat">' . esc_html( $mc_cat_name ) . '</p>'; } ?>
				<p class="mc_box__meta user"><?php the_author(); ?></p>
			</div>
			<div class="mdata_status <?php echo esc_attr($status_class); ?>">
				<?php echo esc_html($status_txt); ?>
			</div>
			<div class="mc_price_box">
				<span class="small">販売価格</span>
				<?php if($sell_price) { echo '<span class="tax_price">&yen;' . esc_html($tax_price) . '<span class="small">（税込）</span></span>'; } ?>
			</div>
			<?php if($mc_comment) : ?>
				<div class="mc_box__cmnt">
					<?php echo sanitize_text_field( $mc_comment ); ?>
				</div>
			<?php endif; ?>
		</div>
		<table class="mdata_tbl">
			<tr>
				<th class="mdata_tbl__th">型式</th>
				<td class="mdata_tbl__td"><?php if($mc_format) { echo esc_html($mc_format); } ?></td>
			</tr>
			<tr>
				<th class="mdata_tbl__th">製造No.</th>
				<td class="mdata_tbl__td"><?php if($mc_number) { echo esc_html($mc_number); } ?></td>
			</tr>
			<tr>
				<th class="mdata_tbl__th">仕様</th>
				<td class="mdata_tbl__td spec">
					<?php if($mc_specs) :
						foreach( $mc_specs as $mc_spec ) : ?>
							<span class="spec_value"><?php echo $mc_spec; ?></span>
					<?php endforeach; endif; ?>
				</td>
			</tr>
			<?php if( is_user_logged_in() ) : ?>
			<tr>
				<th class="mdata_tbl__th">状況</th>
				<td class="mdata_tbl__td">
					<?php if($mc_situ) { echo esc_html($mc_situ); } ?>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		<footer class="mc_box__footer">
			<p class="mc_box__date">掲載日：<?php the_time('Y/m/d'); ?></p>
			<p class="mc_box__id">No.<?php the_ID(); ?></p>
		</footer>
	</article>
</a>