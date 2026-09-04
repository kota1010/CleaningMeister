<?php
	$u_areas = [
		'北海道･東北エリア' => 'hokkaido',
		'首都圏北部エリア' => 'n_tokyo',
		'首都圏西部エリア' => 'w_tokyo',
		'首都圏南部エリア' => 's_tokyo',
		'中部・信越エリア' => 'chubu',
		'関西エリア' => 'kansai',
		'中国・四国・九州エリア' => 'chugoku',
	];
?>

<ul class="btns_lst">
<?php foreach($u_areas as $key => $value): ?>
	<li class="b_lst__item"><a class="u-smooth-scroll b_lst__lnk" href="#<?= $value; ?>"><?= $key; ?></a></li>
<?php endforeach; ?>
</ul>

<div class="user_wrapper">
	<?php foreach($u_areas as $key => $value): ?>
		<div class="user_area">
			<h2 id="<?= $value; ?>" class="block_ttl"><?= $key; ?></h2>
			<?php
				$args = array(
					'role__in' => array( 'author' ),
					'meta_query' => array(
						array(
							'key' => 'user_area',
							'value' => $key,
							'compare' => 'LIKE',
						)
					),
				);
				$users = get_users($args);
				if( $users ) :
				foreach($users as $user):
					$uid = $user->ID;
					$u_img = get_field( 'user_img', "user_{$uid}" );
					$u_address = get_field('user_address', "user_{$uid}");
					$u_tel = get_field('user_tel', "user_{$uid}");
					$u_url = get_the_author_meta('user_url', $uid);
					$u_cmnt = get_field( 'user_cmnt', "user_{$uid}" );
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
									<p class="mdata_company__address"><?= esc_html($u_address); ?></p>
								<?php endif; ?>
								<?php if( $u_tel ) : ?>
									<p class="mdata_company__tel">TEL:<a href="tel:<?= esc_attr($u_tel); ?>"><?= esc_html($u_tel); ?></a></p>
								<?php endif; ?>
								<?php if( $u_url ) : ?>
									<p class="mdata_company__url"><a href="<?= esc_url($u_url); ?>" target="_blank"><?= esc_url($u_url); ?></a></p>
								<?php endif; ?>
								<?php if( $u_cmnt ) : ?>
									<div class="mdata_company__cmnt">
										<?= wp_kses_post( $u_cmnt ); ?>
									</div>
								<?php endif; ?>
							</div>
					</div>
					<div class="mdata_company__tolink">
						<a href="<?= get_author_posts_url( $uid ); ?>"><i class="fa-regular fa-circle-right"></i>この企業の出品中の商品を見る</a>
					</div>

			<?php endforeach; else : ?>
				<p>加盟企業はありません。</p>
			<?php endif; ?>
		</div>
	<?php endforeach; ?>
</div>
