<div class="area_box">
<h2 class="area_sttl">北海道エリア</h2>
<ul class="area_lst">
<?php
$users = get_users();
foreach($users as $index => $user) :
	$uid = $user->ID;
	$u_areaname = get_field( 'user_name2', "user_{$uid}" );
	$u_area = get_field( 'user_area', "user_{$uid}" );
	if( $u_area === "北海道エリア" ) :
?>
	<li class="area_itm"><a class="area_lnk" href="<?php echo esc_url( home_url( '/' ) ) . '?author=' . $uid; ?>"><?php the_field('user_name2', "user_{$uid}"); ?></a></li>
<?php endif; endforeach; ?>
</ul>
</div>