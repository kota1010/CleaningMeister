<?php
	$post_id = get_the_ID();
	$mc_rank = get_field( 'mc_rank' );
	$terms = get_the_terms($post_id, 'machine_category');
	$author_id  = get_the_author_meta( 'ID' );
	$author_url = get_author_posts_url( $author_id );
	if($terms) {
		foreach($terms as $term) {
			$mc_cat_name = $term->name;
			$mc_cat_slug = $term->slug;
		}
	}
?>
<section class="machine_wrapper">
	<div class="slide_sec">
		<?php if( is_user_logged_in() ) {
			if( $mc_rank ) : ?>
				<div class="mc_rank rank_<?php echo strtolower( mb_convert_kana( $mc_rank, "r" ) ); ?>"><?php echo $mc_rank; ?>ランク</div>
			<?php endif;
		} ?>
		<div class="main_slide swiper mySwiper2">
			<div class="swiper-wrapper">
				<?php
					$images = get_field('mc_images');
					$size = 'full'; // (thumbnail, medium, large, full or custom size)

					$img01 = $images["mc_img01"];
					$img02 = $images["mc_img02"];
					$img03 = $images["mc_img03"];
					$img04 = $images["mc_img04"];
					$img05 = $images["mc_img05"];
					$img06 = $images["mc_img06"];

					if( $img01 ) :
						$img_cap01 = $img01['caption'];
					$img01_url = $img01[ 'url' ];
				?>
					<div class="swiper-slide">
						<a href="<?= $img01_url; ?>" class="slide_img_lnk" data-lightbox="machine-slide">
						<?= wp_get_attachment_image( $img01['id'], $size );
						if( $img_cap01 ) {
							echo '<p class="slide_cap">' . $img_cap01 . '</p>';
						} ?>
						</a>
					</div>
				<?php endif;
					if( $img02 ) :
						$img_cap02 = $img02['caption'];
					$img02_url = $img02[ 'url' ];
				?>
					<div class="swiper-slide">
						<a href="<?= $img02_url; ?>" class="slide_img_lnk" data-lightbox="machine-slide">
						<?= wp_get_attachment_image( $img02['id'], $size );
						if( $img_cap02 ) {
							echo '<p class="slide_cap">' . $img_cap02 . '</p>';
						} ?>
						</a>
					</div>
				<?php endif;
					if( $img03 ) :
						$img_cap03 = $img03['caption'];
					$img03_url = $img03[ 'url' ];
				?>
					<div class="swiper-slide">
						<a href="<?= $img03_url; ?>" class="slide_img_lnk" data-lightbox="machine-slide">
						<?= wp_get_attachment_image( $img03['id'], $size );
						if( $img_cap03 ) {
							echo '<p class="slide_cap">' . $img_cap03 . '</p>';
						} ?>
						</a>
					</div>
				<?php endif;
					if( $img04 ) :
						$img_cap04 = $img04['caption'];
					$img04_url = $img04[ 'url' ];
				?>
					<div class="swiper-slide">
						<a href="<?= $img04_url; ?>" class="slide_img_lnk" data-lightbox="machine-slide">
						<?= wp_get_attachment_image( $img04['id'], $size );
						if( $img_cap04 ) {
							echo '<p class="slide_cap">' . $img_cap04 . '</p>';
						} ?>
						</a>
					</div>
				<?php endif;
					if( $img05 ) :
						$img_cap05 = $img05['caption'];
					$img05_url = $img05[ 'url' ];
				?>
					<div class="swiper-slide">
						<a href="<?= $img05_url; ?>" class="slide_img_lnk" data-lightbox="machine-slide">
						<?= wp_get_attachment_image( $img05['id'], $size );
						if( $img_cap05 ) {
							echo '<p class="slide_cap">' . $img_cap05 . '</p>';
						} ?>
						</a>
					</div>
				<?php endif;
					if( $img06 ) :
						$img_cap06 = $img06['caption'];
					$img06_url = $img06[ 'url' ];
				?>
					<div class="swiper-slide">
						<a href="<?= $img06_url; ?>" class="slide_img_lnk" data-lightbox="machine-slide">
						<?= wp_get_attachment_image( $img06['id'], $size );
						if( $img_cap06 ) {
							echo '<p class="slide_cap">' . $img_cap06 . '</p>';
						} ?>
						</a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="swiper-pagination"></div>
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
	<div class="mdata_sec">
		<p class="fz14">掲載日：<?php the_time('Y/m/d'); ?></p>
		<p class="fz14">中古番号：No.<?php the_ID(); ?></p>
		<div class="mc_box__metas">
			<?php if( $mc_cat_name ) { echo '<a class="mc_box__meta cat" href="' . esc_url( home_url( '/machines/machine_category/' . $mc_cat_slug ) ) . '">' . esc_html( $mc_cat_name ) . '</a>'; } ?>
			<a class="mc_box__meta user" href="<?= $author_url; ?>"><?php the_author(); ?></a>
		</div>
		<?php
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
		<div class="mdata_status <?php echo esc_attr($status_class); ?>">
			<?php echo esc_html($status_txt); ?>
		</div>
		<div class="mdata_price__area">
			<div class="mdata_price__body">
				<p class="mdata_price__ttl">販売価格</p>
				<p class="mdata_price__price">
					<?php
					$mc_price = get_field('mc_price');
					$sell_price = '';
					$tax_price = '';
					if($mc_price) {
						$sell_price = number_format($mc_price);
						$tax_price = number_format($mc_price * 1.1);
					}
					if($sell_price) {
							echo '<span class="mdata_price__notax_price">&yen;' . esc_html($tax_price) . '</span><span class="mdata_price__notax">（税込）</span>';
					} ?>
				</p>
			</div>
		</div>
		<div class="mdata_datas">
			<table class="mdata_tbl tbl__body">
				<!--
				<tr>
					<th class="mdata_tbl__th">メーカー</th>
					<td class="mdata_tbl__td"></td>
				</tr>
				-->
				<tr>
					<th class="mdata_tbl__th">型式</th>
					<td class="mdata_tbl__td"><?php the_field('mc_format'); ?></td>
				</tr>
				<tr>
					<th class="mdata_tbl__th">製造No.</th>
					<td class="mdata_tbl__td"><?php the_field('mc_number'); ?></td>
				</tr>
				<tr>
					<th class="mdata_tbl__th">仕様</th>
					<td class="mdata_tbl__td spec">
						<?php
							$mc_spec = get_field( 'mc_spec' );
							if( $mc_spec ) :
								foreach( $mc_spec as $value ): ?>
							<span class="spec_value"><?= $value; ?></span>
						<?php endforeach; endif; ?>
					</td>
				</tr>
				<?php if( is_user_logged_in() ) : ?>
				<tr>
					<th class="mdata_tbl__th">状況</th>
					<td class="mdata_tbl__td"><?php the_field('mc_situ'); ?></td>
				</tr>
				<?php endif; ?>
			</table>
		</div>
		<div class="mdata_fav">
			<?php echo do_shortcode( '[ccc_my_favorite_select_button post_id="" style="0"]' ); ?>
			<p class="mdata_fav__desc">お気に入りボタンを押すと、お気に入りリストに商品ページが追加されます。検討中の商品ページをすぐに見直したい時などにお使いください。</p>
		</div>
	</div>
	<div class="mdata_cmnt"><?php the_field('mc_comment'); ?></div>
</section>
<div class="mdata_user">
	<div class="mdata_company__area">
	<h2 class="block_ttl">この商品の販売会社</h2>
	<?php
		$uid = get_the_author_meta('ID');
		$u_img = get_field( 'user_img', "user_{$uid}" );
		$u_address = get_field('user_address', "user_{$uid}");
		$u_tel = get_field('user_tel', "user_{$uid}");
		$u_url = get_the_author_meta('user_url');
		$u_cmnt = get_field('user_cmnt', "user_{$uid}");
	?>
	<div class="mdata_company__box">
		<?php if( $u_img ) : ?>
			<figure class="mdata_company__fig">
				<img src="<?= $u_img['url'] ?>" alt="<?= $u_img['alt']; ?>" class="mdata_company__img">
			</figure>
			<?php else : ?>
				<div class="no_img">NO<br>IMAGE</div>
			<?php endif; ?>
			<div class="mdata_company__desc">
				<p class="mdata_company__name"><?php the_author_meta( 'display_name', $uid ); ?></p>
				<?php if( $u_address ) : ?>
					<p class="mdata_company__address"><?php echo esc_html($u_address); ?></p>
				<?php endif; ?>
				<?php if( $u_tel ) : ?>
					<p class="mdata_company__tel">TEL:<a href="tel:<?php echo esc_attr($u_tel); ?>"><?php echo esc_html($u_tel); ?></a></p>
				<?php endif; ?>
				<?php if( $u_url ) : ?>
					<p class="mdata_company__url"><a href="<?php echo esc_url($u_url); ?>" target="_blank"><?php echo esc_url($u_url); ?></a></p>
				<?php endif; ?>
				<?php if( $u_cmnt ) : ?>
					<div class="mdata_company__cmnt">
						<?= wp_kses_post( $u_cmnt ); ?>
					</div>
				<?php endif; ?>
			</div>
	</div>
</div>
<section class="mform_sec">
	<header class="mform_head">
		<h2 class="mform_ttl">この商品についての<br>お問い合わせはこちら</h2>
		<p class="mform_lead">販売会社へ直接メールでお問い合わせが届きます。<br>確認次第、担当者よりご連絡いたします。</p>
		<picture>
			<source srcset="<?= plugins_url('my-snow-monkey/img'); ?>/chara-01.webp" type="image/webp">
			<img class="mform_chara" src="<?= plugins_url('my-snow-monkey/img'); ?>/chara-01.png" class="bnr_img">
		</picture>
	</header>
	<?php echo apply_shortcodes( '[contact-form-7 id="eaa4bc7" title="中古機器ページ掲載用問い合わせフォーム"]' ); ?>
</section>
<p class="to_machines"><a href="<?php echo esc_url( home_url( '/' ) ) . 'machines/'; ?>">一覧へ戻る</a></p>
