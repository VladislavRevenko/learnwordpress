<?php 
/*
Template Name: Мой шаблон страницы
*/
?>

<!-- Здесь html/php код шаблона -->
<?php get_header();
$container   = get_theme_mod( 'understrap_container_type' );
?>

<head>
<title>Aurelia - новости без фейков</title>    
<meta name="description" content="Самые последние новости спорта, шоу-бизнеса и политики, планы по звахвату мира, звездные войны и печеньки">
<meta name="keywords" content="новости, спорт, шоу-бизнес, политика">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta property="og:title" content="Новости"/>
</head>
<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

			<div class="row">

<style>
.image-box {
	text-align: center;
	height: 200px;
	line-height: 200px;
	margin-bottom: 10px;
}
.image-box img {
	max-height: 100%;
}
.title-box {
	height: 100px;
}
.title-box h5 {
	font-size: 1.1rem !important;
}
.content-box {
	font-size: 13px;
	height: 50px;
	overflow: hidden;
}
.news_block {

}
.breaking {
margin:0 auto;

}
.important {
margin:0 auto;
	
}
.news1x2 {
display: flex;
padding: 5px;
border: 1px solid;
}
.news1x3 {
display: flex;
padding: 5px;
border: 1px solid;
}
.news1x4 {
display: flex;
padding: 5px;
border: 1px solid;
}
.container {
margin: 0 auto;    
}
@media screen and (min-width:240px) and (max-width:720px) {
    .news1x2 {
    display: inline;    
    font-size: 0.5em;
    max-width: 100%;
    border: none;
    }
    .title_box {
    height: 80px;
    padding: 10px;
    }
}

</style>
			<main class="site-main" id="main">
			<?php
				$args =  array(
					'posts_per_page' => 20,
				);
				$q = new WP_Query($args);
				//Сортируем посты по приоритету
				$breaking = [];
				$important = [];
				$news1x2 = [];
				$news1x3 = [];
				$news1x4 = [];

				if ($q->have_posts()) {
					foreach($q->posts as $key => $post) {
						$q->posts[$key]->priority = intval(get_field('priority', $post->ID));
						$q->posts[$key]->news_type = get_field('news_type', $post->ID);
					}
					usort($q->posts, function($a, $b) {
						return $a->priority > $b->priority;
						// return intval(get_field('priority', $a->ID)) > intval(get_field('priority', $b->ID));
					});

					foreach($q->posts as $key => $post) {
						//echo $post->news_type.'<br/>';
						switch ($post->news_type) {
							case 'breaking':
								$breaking[] = $post;
								break;
							case 'important':
								$important[] = $post;
								break;
							case 'news1x2':
								if (empty($news1x2)) {
									$news1x2[] = [$post];
									break;
								}
								end($news1x2);
								$tmp_key = key($news1x2);
								if (count($news1x2[$tmp_key])<2) {
									$news1x2[$tmp_key][] = $post;
								} else {
									$news1x2[] = [$post];
								}
								break;

							case 'news1x3':
								if (empty($news1x3)) {
									$news1x3[] = [$post];
									break;
								}
								end($news1x3);
								$tmp_key = key($news1x3);
								if (count($news1x3[$tmp_key])<3) {
									$news1x3[$tmp_key][] = $post;
								} else {
									$news1x3[] = [$post];
								}
								break;

							case 'news1x4':
								if (empty($news1x4)) {
									$news1x4[] = [$post];
									break;
								}
								end($news1x4);
								$tmp_key = key($news1x4);
								if (count($news1x4[$tmp_key])<4) {
									$news1x4[$tmp_key][] = $post;
								} else {
									$news1x4[] = [$post];
								}
								break;

							default:
								$news1x4[] = $post;
								default;
						}						
					}
				}
			
			?>
			
		
			<?
				// echo '<pre>';
				// var_dump($breaking);
				//var_dump(count($important));
				//var_dump(count($news1x2));
				//var_dump(count($news1x3));
				//var_dump(count($news1x4));
				// echo '</pre>';
			?>
				
				
			<?php
				$c = 0;
				while (((!empty($breaking)) || (!empty($important)) || (!empty($news1x2)) || (!empty($news1x3)) || (!empty($news1x4))) && ($c<20)) {
					$post = array_shift($breaking);
					echo '<div class="news_block">';
					if (is_object($post)) {
					    echo '<div class="breaking"><h2>';
						    echo $post->post_title . '</h2><br/>';
						    echo '<div>' . get_the_post_thumbnail($post->ID, 'medium') . '</div>';
						    echo '<a class="gpr-button" href="' . get_permalink() . '">Читать далее</a>';
						echo '</div>';
					}

				    $post = array_shift($important);
					if (is_object($post)) {
					    echo '<div class="important"><h2>';
						    echo '<div class="title-box">' . $post->post_title . '</h2></div><br/>';
					    	echo '<div class="image-box">' . get_the_post_thumbnail($post->ID, 'medium') . '</div>';
						    echo '<div class="content-box"><a class="gpr-button" href="' . get_permalink() . '">Читать далее</a></div>';
						echo '</div>';
					}
                    
                    
                    //2 блока новостей
					$posts = array_shift($news1x2);
					if (is_array($posts)) {
						echo '<div class="news1x2">'; 
							foreach ($posts as $post) {
							    echo '<div class="container">';
							        
							        
                                    echo '<div class="image-box">' . get_the_post_thumbnail($post->ID, 'medium') . '</div>';
						            echo '<div class="title-box"><h4>'. $post->post_title. '</h4></div>';
						              echo '<div class="content-box"><a class="gpr-button" href="' . get_permalink() . '">Читать далее</a></div>';
					                //$link = get_permalink();
					                /*echo '<div class="content-box">
								    <a class="gpr-button" href="' . the_permalink($link) . '">Читать далее</a>'*/;
						          echo '</div>';
							  
							 	
						    }
					echo '</div><br/>';
					}
					
					
					//3 блока новостей
					$posts = array_shift($news1x3);
					if (is_array($posts)) {
						echo '<div class="news1x2">'; 
						foreach ($posts as $post) {
							    //$link = get_permalink();
							    echo '<div class="container">';
							               echo '<div  class="image-box">' . get_the_post_thumbnail($post->ID, 'medium') . '</div>';
						                  echo '<div class="title-box"><h5>'. $post->post_title. '</h5></div>';
						                  echo '<div class="content-box"><a class="gpr-button" href="' . get_permalink() . '">Читать далее</a></div>';
					               
					               /*echo '<div class="content-box">
								        <a class="gpr-button" href="' . the_permalink($link) . '">Читать далее</a>'*/;
						      echo '</div>';
							  
							 
							}	            
                       echo '</div><br/>';
					}
					
					
					//4 блока новостей
					$posts = array_shift($news1x4);
					if (is_array($posts)) {
						echo '<div class="news1x2">'; 
						foreach ($posts as $post) {
						    echo '<div class="container">';
						     
						        echo '<div class="image-box">' . get_the_post_thumbnail($post->ID, 'medium') . '</div>';
						        echo '<div class="title-box"><h6>' . $post->post_title. '</h6></div>';
						        echo '<div class="content-box"><a class="gpr-button" href="' . get_permalink() . '">Читать далее</a></div>';
					            
					            /*echo '<div class="content-box">
								<a class="gpr-button" href="' . the_permalink($link) . '">Читать далее</a>'*/;
						        echo '</div>';
							 
							
						}	            
                     echo '</div><br/>';
					}
					 
					$c++;
				}
			
			?>
				
				
		    
		    
			</main><!-- #main -->

		</div><!-- #primary -->

	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>