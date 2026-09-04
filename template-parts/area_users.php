<?php
$users = get_users();
$html = '<ul class="area_lst">';
$now_area = '地域名';
foreach($users as $index => $user) :
	$uid = $user->ID;
	$u_areaname = get_field( 'user_name2', "user_{$uid}" );
	$u_area = get_field( 'user_area', "user_{$uid}" );
	if( $u_area === "北海道エリア" ) :
		$now_area = $u_area;
		$html .= '<li><a href="' . esc_url( home_url( '/' ) ). '?author=' . $uid . '">' . get_field( 'user_name2', "user_{$uid}" ) . '</a></li>';
	endif;
endforeach; ?>
<div class="area_box">
	<h2 class="area_ttl"><?php echo esc_html( $now_area ); ?></h2>
	<?php echo $html; ?>
	</ul>
</div>
