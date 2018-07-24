<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();

$container   = get_theme_mod( 'understrap_container_type' );
?>

<head>
<title>Aurelia - новости без фейков</title>    
<meta name="description" content="Самые последние новости спорта, шоу-бизнеса и политики, планы по звахвату мира, звездные войны и печеньки">
<meta name="keywords" content="новости, спорт, шоу-бизнес, политика">
</head>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?/**php get_template_part( 'global-templates/left-sidebar-check' ); */?>

			<main class="site-main" id="main">
			    <?/*php
			    $important_list
			    $very_important_list
			    $2x_list
			    $3x_list
			    $4x_list*/
			    ?>

				<?php if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>

					<?php while ( have_posts() ) : the_post();?>
					<?php get_posts ($arg);?>
					<?php $args = array( 
	                    'posts_per_page' => 3,
                        'category' => 9 
                    	);
                        $iwposts = get_posts( $args );
                        foreach( $iwposts as $post ){ setup_postdata($post);  ?>
                    <div class="iw-get-post"><a  class="post-title-get-post" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    <?php   }
    wp_reset_postdata();  ?>
                        	<div style="width: 350px; height: 400px; float:left; 
                            margin:10px 20px 10px 10px; 
                            padding:20px 5px 20px 5px;
                            border: 1px solid;">
						<?php

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'loop-templates/content', get_post_format() );
						?>
                    </div>
					<?php endwhile; ?>
					<div style="clear: both;"></div>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<? /**php get_template_part( 'global-templates/right-sidebar-check' ); */?>
		

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
