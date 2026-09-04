<?php
/**
 * Plugin name: My Snow Monkey
 * Description: このプラグインに、あなたの Snow Monkey 用カスタマイズコードを書いてください。
 * Version: 0.2.5
 * Update URI: https://snow-monkey.2inc.org
 *
 * @package my-snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 */

/**
 * Snow Monkey 以外のテーマを利用している場合は有効化してもカスタマイズが反映されないようにする
 */
$theme = wp_get_theme( get_template() );
if ( 'snow-monkey' !== $theme->template && 'snow-monkey/resources' !== $theme->template ) {
	return;
}

/**
 * Directory url of this plugin
 *
 * @var string
 */
define( 'MY_SNOW_MONKEY_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Directory path of this plugin
 *
 * @var string
 */
define( 'MY_SNOW_MONKEY_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

/**
 * Display message in console.log if this plugin is enabled.
 */
add_action(
	'wp_footer',
	function () {
		if ( is_user_logged_in() ) :
			?>
			<script>console.log( 'My Snow Monkey plugin is active' );</script>
			<?php
		endif;
	}
);
if ( ! function_exists( 'my_snow_monkey_plugin_last_load' ) ) :
/*
 * my-plugin を最後に読み込むようにする。
 *
 * License: GPLv2 or later
*/
function my_snow_monkey_plugin_last_load() {
    $this_activeplugin  = '';
    $this_plugin        = 'my-snow-monkey/my-snow-monkey.php';    //最後に読み込みたいプラグイン
    $active_plugins     = get_option( 'active_plugins' );
    $new_active_plugins = array();
    foreach ( $active_plugins as $plugins ) {
        if( $plugins != $this_plugin ){
            $new_active_plugins[] = $plugins;
        }else{
            $this_activeplugin = $this_plugin;
        }
    }
    if( $this_activeplugin ){
        $new_active_plugins[] = $this_activeplugin;
    }
    if( ! empty( $new_active_plugins ) ){
        update_option( 'active_plugins' ,  $new_active_plugins );
    }
}
add_action( 'activated_plugin', 'my_snow_monkey_plugin_last_load' );
endif; // my_snow_monkey_plugin_last_load

// 実際のページ用の CSS 読み込み
add_action(
	'wp_enqueue_scripts',
	function() {
		wp_enqueue_style(
			'my-snow-monkey',
			MY_SNOW_MONKEY_URL . '/css/style.css',
			[ Framework\Helper::get_main_style_handle() ],
			filemtime( MY_SNOW_MONKEY_PATH . '/css/style.min.css' )
		);
	}
);
// エディター用の CSS 読み込み
// クラシックエディターとブロックエディターの両方に CSS が読み込まれます。
// ブロックエディターの場合は自動的に .editor-styles-wrapper でラップされます。
// 依存関係は指定できません。
add_action(
	'after_setup_theme',
	function() {
		add_theme_support( 'editor-styles' );
		add_editor_style( '/../../plugins/my-snow-monkey/css/style.min.css' );
	}
);

function my_filter_theme_json_theme2( $theme_json ) {
	// theme.json の内容を一旦配列で変数に格納.
	$get_data = $theme_json->get_data();
	/* 追加するカラーパレット */
	$add_color_array = array(
		array(
			'slug'  => 'skyblue',
			'color' => '#f0f8fd',
			'name'  => __( 'Sky Blue', 'theme-domain' ),
		),
		array(
			'slug'  => 'skyblue03',
			'color' => '#dcf3fc',
			'name'  => __( 'Sky Blue 03', 'theme-domain' ),
		),
		array(
			'slug'  => 'fluorescence-yellow',
			'color' => '#fde64d',
			'name'  => __( '蛍光（黄）', 'theme-domain' ),
		),
	);
	// カラーパレットをマージ.
	$add_data = array_merge(
		// マージ対象は theme や default など必要に応じて変更.
		$get_data['settings']['color']['palette']['theme'],
		$add_color_array
	);
	$new_data = array(
		'version'  => 2,
		'settings' => array(
			'color' => array(
				'palette' => $add_data,
			),
		),
	);
	return $theme_json->update_with( $new_data );
}
add_filter( 'wp_theme_json_data_theme', 'my_filter_theme_json_theme2' );

// PCヘッダーロゴ右に「お気に入り」と「買取を依頼する」を追加
add_action(
	'snow_monkey_after_header_site_branding_column',
	function() {
		?>
		<a class="c-row__btn fav" href="<?php echo esc_url( home_url( '/' ) ); ?>favorites/"><i class="fa-solid fa-heart"></i>お気に入り</a>
		<a class="c-row__btn kaitori" href="<?php echo esc_url( home_url( '/' ) ); ?>kaitori/">買取を依頼する</a>
		<?php
	}
);

// トップページにメインヴィジュアルエリアを挿入
add_action(
    'snow_monkey_before_contents_inner',
    function() {
		if( is_front_page() ) {
        ?>
        <section class="mv_area">
			<div class="mv_bak_yllw"></div>
			<picture>
				<source srcset="<?php echo plugin_dir_url(__FILE__); ?>img/mv_txt_pc2.webp" media="(min-width:1024px)" type="image/webp" />
				<source srcset="<?php echo plugin_dir_url(__FILE__); ?>img/mv_txt_pc.jpg" media="(min-width:1024px)" />
				<source srcset="<?php echo plugin_dir_url(__FILE__); ?>img/mv_txt_sp.webp" type="image/webp" />
				<img src="<?php echo plugin_dir_url(__FILE__); ?>img/mv_txt_sp.jpg" alt="全国の商社ネットワークで効率的に在庫検索！ 業務用洗濯の中古機械 業界在庫数No.1 各メーカーの中古製品を豊富に取り扱っています" class="mv_img" />
			</picture>
		</section>
        <?php
		}
    }
);

// ヘッダーナビ下にタイトルエリアを追加
add_action(
    'snow_monkey_prepend_contents',
    function() {
		if( is_singular( 'machines' )) : ?>
			<div class="page_ttl_wrapper">
				<div class="page_ttl_header">
					<div class="c-container">
							<h1 class="page_name"><?php the_title(); ?></h1>
					</div>
				</div>
			</div>
		<?php elseif ( is_post_type_archive( 'machines' ) ) : ?>
			<div class="page_ttl_wrapper">
				<div class="page_ttl_header">
					<div class="c-container">
							<h1 class="page_name">新着中古機械一覧</h1>
					</div>
				</div>
			</div>
		<?php elseif ( is_tax( 'machine_category' ) ) : ?>
			<div class="page_ttl_wrapper">
				<div class="page_ttl_header">
					<div class="c-container">
							<h1 class="page_name"><?php single_term_title(); ?></h1>
					</div>
				</div>
			</div>
		<?php elseif ( is_page() && !is_page( 'kaitori' ) && !is_front_page() ) : ?>
			<div class="page_ttl_wrapper">
				<div class="page_ttl_header">
					<div class="c-container">
							<h1 class="page_name"><?php the_title(); ?></h1>
					</div>
				</div>
			</div>
		<?php elseif ( is_author() ) : ?>
			<div class="page_ttl_wrapper">
				<div class="page_ttl_header">
					<div class="c-container">
							<h1 class="page_name"><?php the_author_meta( 'display_name' ); ?>の在庫一覧</h1>
					</div>
				</div>
			</div>
		<?php endif;
	}
);

// パンくずリストのホームをアイコンに変更
add_filter(
	'snow_monkey_breadcrumbs',
	function( $items ) {
		if ( isset( $items[0] ) ) {
			$items[0] = [
				'title' => '<i class="fa-solid fa-house"></i>',
				'link'  => $items[0]['link'],
			];
		}
		return $items;
	}
);
// ユーザーページのパンくずリストに「販売会社」リンクを追加
add_filter(
	'snow_monkey_breadcrumbs',
	function( $items ) {
		if( is_author() ) {
			$array = [
				$items[2] = [
					'title' => '販売会社',
					'link' => get_home_url() . '/members-list/',
				]
			];
			array_splice( $items, 2, 0, $array );
		}
		return $items;
	}
);

// 買取ページのパンくずを非表示
add_filter(
    'snow_monkey_breadcrumbs',
    function( $items ) {
		if( is_page( 'kaitori' ) ) {
			$items = array();
		}
        return $items;
    }
);

// My Snow Monkey の中でテンプレートを追加できるようにする

// 参考 https://snow-monkey.2inc.org/manual/manual-advanced/add-template-root/

// 機械個別ページの記事内ヘッダーを差し替え
add_filter(
	'snow_monkey_template_part_root_hierarchy_template-parts/content/entry/header/header',
	function( $hierarchy, $name, $vars ) {
		$name = 'machines';
		$hierarchy[] = __DIR__ . '/override';
		return $hierarchy;
	},
	10,
	4
);
// 機械アーカイブページの記事内ヘッダーを差し替え
add_filter(
	'snow_monkey_template_part_root_hierarchy_template-parts/archive/entry/header/header',
	function( $hierarchy, $name, $vars ) {
		$name = 'machines';
		$hierarchy[] = __DIR__ . '/override';
		return $hierarchy;
	},
	10,
	4
);
// 固定ページの記事内ヘッダーを差し替え
add_filter(
	'snow_monkey_template_part_root_hierarchy_template-parts/content/entry/header/header',
	function( $hierarchy, $name, $vars ) {
		$name = 'page';
		$hierarchy[] = __DIR__ . '/override';
		return $hierarchy;
	},
	10,
	4
);
// 機械アーカイブページの本文部分を差し替え
add_filter(
	'snow_monkey_template_part_root_hierarchy_template-parts/common/entries/entries/posts',
	function( $hierarchy, $name, $vars ) {
		$name = 'machines';
		$hierarchy[] = __DIR__ . '/override';
		return $hierarchy;
	},
	10,
	4
);

// キタジマさんからの回答例
/**
 * 著者ページのメインクエリを書き換える
 */
add_action(
	'pre_get_posts',
	function( $query ) {
		if ( is_author() && $query->is_main_query() ) {
			$query->set( 'post_type', 'machines' );
		}
	}
);
// 著者ページ内のメインクエリ内のテンプレートパーツを差し替え
add_filter(
	'snow_monkey_template_part_root_hierarchy_template-parts/loop/entry-summary',
	function( $hierarchy, $name, $vars ) {
		if( is_author() || is_post_type_archive( 'machines' ) || is_tax( 'machine_category' ) ) {
			$name = 'machines';
			$hierarchy[] = __DIR__ . '/override';
			return $hierarchy;
		}
		return $hierarchy;
	},
	10,
	4
);
// 著者ページのコンテンツの最後にプロフィールを表示
add_action(
	'snow_monkey_append_archive_entry_content',
	function() {
		if ( is_author() ) {
			$uid = get_query_var( 'author' );
			$user = get_userdata( $uid );
			$u_address = get_field('user_address', "user_{$uid}");
			$u_tel = get_field('user_tel', "user_{$uid}");
			$u_url = get_the_author_meta('user_url');
			$u_img = get_field('user_img', "user_{$uid}");
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
					<p class="mdata_company__name"><?php the_author_meta( 'display_name' ); ?></p>
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
		<?php }
	}
);

// 中古機械個別ページのbody部分読み込み
add_action(
	'snow_monkey_prepend_entry_content',
	function() {
		if( is_singular( 'machines' ) ) {
			echo do_shortcode('[my_php_include file="machine-body"]');
		}
	}
);

// サイドバーのエリア別リストのショートコード
add_shortcode( 'my_side_users', function( $atts ){
	$atts = shortcode_atts( array(
	  'user_area' => ''
	), $atts );
	$user_area = $atts['user_area'];
	$args = array(
		'role__in' => array( 'author' ),
		'meta_query' => array(
			array(
				'key' => 'user_area',
				'value' => $user_area,
				'compare' => 'LIKE',
			)
		),
	);
	$users = get_users($args);
	$html = '<ul class="menu">';
	foreach($users as $user) {
		$user_id = $user->ID;
		$html .= '<li class="menu-item"><a href="' .esc_url( home_url( '/' ) ). '?author=' . $user_id . '">' . get_field( 'user_name2', "user_{$user_id}" ) . '</a></li>';
	}
	$html .= '</ul>';
	return $html;
});

// フッター上にバナーエリア、お知らせ（トップのみ）を挿入
add_action(
	'snow_monkey_append_contents',
	function() {
		if ( is_front_page() ) :
		?>
		<section class="info_sec">
			<div class="info_inner c-container">
				<h2 class="block_ttl">お知らせ</h2>
				<p class="info_lead">全国クリーニング機械トータルネットワークグループ会員企業の展示会・講習会情報などのお知らせ</p>
				<ul class="info_lst">
		<?php
			$args = array(
				'posts_per_page' => 5,
			);
			$the_query = new WP_Query( $args );
			if ($the_query->have_posts()) :  while ($the_query->have_posts()) : $the_query->the_post(); ?>
				<li class="wp-block-post">
					<div class="info_news__date"><time datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y.n.j'); ?></time></div>
					<h3 class="info_news__ttl">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
				</li>
			<?php
				endwhile;
				wp_reset_postdata();
				else :
			?>
				<li>記事はありません。</li>
			<?php endif; ?>
				</ul>
				<p class="lnk_to_news"><a href="<?php echo esc_url( home_url( '/' ) ); ?>news/"><i class="fa-regular fa-circle-right"></i>お知らせ一覧</a></p>
			</div>
		</section>
		<?php endif; ?>
		<?php if( !( is_page( 'kaitori' ) || is_page( 'contact' ) ) ) : ?>
			<section class="bnr_sec c-container">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>kaitori/" class="bnr_lnk">
					<picture>
						<source srcset="<?php echo plugin_dir_url(__FILE__); ?>img/bnr_satei2.webp" type="image/webp">
						<img src="<?php echo plugin_dir_url(__FILE__); ?>img/bnr_satei.png" class="bnr_img">
					</picture>
				</a>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>contact/" class="bnr_lnk">
					<picture>
						<source srcset="<?php echo plugin_dir_url(__FILE__); ?>img/bnr_member2.webp" type="image/webp">
						<img src="<?php echo plugin_dir_url(__FILE__); ?>img/bnr_member.png" class="bnr_img">
					</picture>
				</a>
			</section>
		<?php endif; ?>
		<?php
	}
);

// 投稿ページのヘッダーの著者名を削除
add_action(
	'snow_monkey_entry_meta_items',
	function() {
		remove_action( 'snow_monkey_entry_meta_items', 'snow_monkey_entry_meta_items_author', 30 );
	},
	9	// 優先度は9必須
);

// お気に入りページで独自テンプレを読み込み
function ccc_my_favorite_list_custom_template( $my_favorite_post_id ) {
	$my_favorite_post_id = array_filter( $my_favorite_post_id );
    if ( empty( $my_favorite_post_id ) ) {
        echo '<p>お気に入りには登録がありません。</p>';
        return;
	}

	$template = WP_PLUGIN_DIR . '/my-snow-monkey/template-parts/mc_box.php';

	?>

	<div class="mc_wrapper">

	<?php
    foreach ( $my_favorite_post_id as $post_id ) {
        global $post;
        $post = get_post( $post_id );
        setup_postdata( $post );

        include $template;
    }

    // ループ後にリセット（重要）
    wp_reset_postdata();

	?>

	</div>

	<?php
}

/**
 * 記事下の「古い投稿」のテキストを英語元データから変更する
 */
add_filter(
    'gettext',
    function( $translation, $text, $domain ) {
        if ( 'snow-monkey' === $domain ) {
            if ( 'Old post' === $text ) {
                return '前の投稿';
            }
			if ( 'New post' === $text ) {
                return '次の投稿';
            }
        }
        return $translation;
    },
    10,
    3
);

/**
 * プロフィール編集画面から Snow Monkey の YouTube と LINE だけを残す（https://snow-monkey.2inc.org/forums/topic/%e3%83%a6%e3%83%bc%e3%82%b6%e3%83%bc%e3%83%97%e3%83%ad%e3%83%95%e3%82%a3%e3%83%bc%e3%83%ab%e7%b7%a8%e9%9b%86%e7%94%bb%e9%9d%a2%e3%81%8b%e3%82%89%e5%90%84%e7%a8%aesns%e5%85%a5%e5%8a%9b%e6%ac%84/#post-144673）
 */
// function my_customize_sns_accounts( $accounts ) {
//     $custom_accounts = array();
    // YouTube と LINE だけを保持
    // if ( isset( $accounts['youtube'] ) ) {
        // $custom_accounts['youtube'] = $accounts['youtube'];
    // }
    // if ( isset( $accounts['line'] ) ) {
        // $custom_accounts['line'] = $accounts['line'];
//     }
//     return $custom_accounts;
// }
// add_filter( 'inc2734_wp_profile_box_sns_accounts', 'my_customize_sns_accounts', 99 );

/**
 * すべてのSNSアカウント入力欄を削除
 */
// function my_remove_all_sns_accounts( $accounts ) {
//     return array(); // 空の配列を返すことですべてのSNSアカウント入力欄を削除
// }
// add_filter( 'inc2734_wp_profile_box_sns_accounts', 'my_remove_all_sns_accounts', 99 );
