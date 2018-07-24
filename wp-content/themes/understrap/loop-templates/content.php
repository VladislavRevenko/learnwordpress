<html prefix="og: http://ogp.me/ns#">
<head>
<title>The Title of Your Article</title>
<meta property="og:title" content="<?php the_title(); ?>" />
<meta property="og:type" content="<?php ?>" />
<meta property="og:url" content="<?php get_permalink(); ?>" />
<meta property="og:image" content="<?php get_the_post_thumbnail(); ?>" />
...
</head>
...
</html>

<?php
/**
 * Post rendering content according to caller of get_template_part.
 *
 * @package understrap
 */

?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
		'</a></h2>' ); ?>

		<?php if ( 'post' == get_post_type() ) : ?>

			<div class="entry-meta">
				<?php understrap_posted_on(); ?>
			</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php
		the_excerpt();
		?>
		<!--<p><a href="<?php /* the_permalink(); */?>" class="btn btn-primary test" >Читать новость</a></p>-->

		<?php
		wp_link_pages( array(
		'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div>


	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
