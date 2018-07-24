<?php
/**
 * Understrap functions and definitions
 *
 * @package understrap
 */

/**
 * Initialize theme default settings
 */
require get_template_directory() . '/inc/theme-settings.php';

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom pagination for this theme.
 
*require get_template_directory() . '/inc/pagination.php';
*/
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Comments file.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
 * Load WooCommerce functions.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Load Editor functions.
 */
require get_template_directory() . '/inc/editor.php';

function kama_meta_description ($home_description='Самые последние новости спорта, шоу-бизнеса и политики',$maxchar=200){
	global $wp_query,$post;
	if (is_singular()){
		if ( $descript = get_post_meta($post->ID, "description", true) )
			$out = $descript;
		elseif ($post->post_excerpt!='')
			$out = trim(strip_tags($post->post_excerpt));
		else
			$out = trim(strip_tags($post->post_content));

		$char = iconv_strlen( $out, 'utf-8' );
		if ( $char > $maxchar ) {
			 $out = iconv_substr( $out, 0, $maxchar, 'utf-8' );
			 $words = split(' ', $out ); $maxwords = count($words) - 1; //убираем последнее слово, ибо оно в 99% случаев неполное
			 $out = join(' ', array_slice($words, 0, $maxwords)).' ...';
		 }
	}
	elseif (is_category() || is_tag()){
		$desc = $wp_query->queried_object->description;
		if ($desc) preg_match ('!\[description=(.*)\]!iU',$desc,$match);
		$out = $match[1]?$match[1]:'';
	}
	elseif (is_home()) $out=$home_description;
	if ($out){
		$out = str_replace( array("\n","\r"), ' ', strip_tags($out) );
		$out = preg_replace("@\[.*?\]@", '', $out); //удаляем шоткоды
		return print "<meta name='description' content='$out' />\n";
	}
	else return false;
}

function kama_meta_keywords ($home_keywords='новости, спорт, шоу-бизнес, политика',$def_keywords=''){
	global $wp_query,$post;
	if ( is_single() && !$out=get_post_meta($post->ID,'keywords',true) ){
		$out = '';
		$res = wp_get_object_terms( $post->ID, array('post_tag','category'), array('orderby' => 'none') ); // получаем категории и метки
		if ($res) foreach ($res as $tag) $out .= " {$tag->name}";
		$out = str_replace(' ',', ',trim($out));
		$out = "$out $def_keywords";
	}
	elseif (is_category() || is_tag()){
		$desc = $wp_query->queried_object->description;
		if ($desc) preg_match ('!\[keywords=(.*)\]!iU',$desc,$match);
		$out = $match[1]?$match[1]:'';
		$out = "$out $def_keywords";
	}
	elseif (is_home()){
		$out = $home_keywords;
	}
	if ($out) return print "<meta name='keywords' content='новости, спорт, шоу-бизнес, политика' />\n";
	return false;
}

add_filter( 'manage_edit-post_columns', 'true_add_post_columns_2', 10, 1 ); // manage_edit-{тип поста}_columns, то есть вы можете добавлять колонку не только для записей
add_action( 'manage_posts_custom_column', 'true_fill_post_columns_2', 10, 1 );
 
/* добавление колонки */
function true_add_post_columns_2( $my_columns ){
	$my_columns['priority'] = 'Приоритет';
	return $my_columns;
}
 
/* заполнение колонки*/
function true_fill_post_columns_2( $column ) {
	global $post;
	switch ( $column ) {
		case 'priority':
			echo ( $x = get_post_meta($post->ID, 'priority', true) ) ? $x : 0; // это простое условие, если произвольного поля не существует, то выводим 0
			break;
	}
}

