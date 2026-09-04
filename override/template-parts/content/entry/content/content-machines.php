<?php
/**
 * @package snow-monkey
 * @author inc2734
 * @license GPL-2.0+
 * @version 10.8.0
 */

use Framework\Helper;
?>

<?php do_action( 'snow_monkey_before_entry_content' ); ?>

<div class="c-entry__content p-entry-content">
<?php do_action( 'snow_monkey_prepend_entry_content' ); ?>

<section class="slide_sec">
<div class="main_slide swiper mySwiper2">
<div class="swiper-wrapper">
<?php
$images = get_field('mc_images');
$size = 'full'; // (thumbnail, medium, large, full or custom size)
for( $i = 1; $i < 7; $i++ ) {
$img = $images["mc_img0{$i}"];
if( $img ) {
echo '<div class="swiper-slide">' . wp_get_attachment_image( $img['id'], $size ) . '</div>';
}
} ?>
</div>
</div>
<div thumbsSlider="" class="swiper mySwiper thums_slide">
<div class="swiper-wrapper">
<?php
$images = get_field('mc_images');
$size = 'medium'; // (thumbnail, medium, large, full or custom size)
for( $i = 1; $i < 7; $i++ ) {
$thum = $images["mc_img0{$i}"];
echo '<div class="swiper-slide">';
if( $thum ) {
	echo wp_get_attachment_image( $thum['id'], $size );
}
echo '</div>';
} ?>
</div>
</div>
</section>

<script>
var swiper = new Swiper(".mySwiper", {
slidesPerView: 6,
freeMode: true,
watchSlidesProgress: true,
});
var swiper2 = new Swiper(".mySwiper2", {
effect: 'fade',
thumbs: {
swiper: swiper,
},
});
</script>

<?php
// var_dump($images);
// $img01 = $images['mc_img01'];
// if( $img01 ) {
// 	echo wp_get_attachment_image( $img01['id'], $size );
// }
?>







<?php Helper::get_template_part( 'template-parts/content/link-pages' ); ?>

<?php do_action( 'snow_monkey_append_entry_content' ); ?>
</div>

<?php do_action( 'snow_monkey_after_entry_content' ); ?>
