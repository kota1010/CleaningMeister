<?php
	$uid = get_the_author_meta('ID');
	$u_img = get_field( 'user_img', "user_{$uid}" );
	$u_address = get_field('user_address', "user_{$uid}");
	$u_tel = get_field('user_tel', "user_{$uid}");
	$u_url = get_the_author_meta('user_url');
	$u_cmnt = get_the_author_meta('user_description');
?>
<div class="mdata_company__box">
	<?php if( $u_img ) : ?>
		<figure class="mdata_company__fig">
			<img src="<?= $u_img['url'] ?>" alt="<?= $u_img['alt']; ?>" class="mdata_company__img">
		</figure>
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
					<?= $u_cmnt; ?>
				</div>
			<?php endif; ?>
		</div>
</div>