<ul class="side_lst user">
	<?php $users = get_users(
		array(
			'role' => "author",
		)
	); ?>
	<?php foreach($users as $user) { $uid = $user->ID; ?>
	<li class="side_lst__itm"><a href="<?php echo esc_url( home_url( '/' ) ) . '?author=' . $uid; ?>" class="side_lst__lnk"><?php echo $user->display_name; ?></a></li>
	<?php }; ?>
</ul>