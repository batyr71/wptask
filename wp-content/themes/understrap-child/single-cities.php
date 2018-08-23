<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

get_header();
$container   = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">
      
			<!-- Do the left sidebar check -->

			<main class="site-main" id="main">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop-templates/content', 'single' ); ?>
        
          <div class="properties">
            
          <?php 
            $metavalue = get_post()->ID;
            $posts = get_posts(array(
              'posts_per_page'	=> 10,
              'post_type'			=> 'real_properties',
              'meta_key'		=> 'city',
              'meta_value'	=> $metavalue
            ));

            
            if( $posts ): ?>
              <h2>Объекты недвижимости в городе <?php the_title()?></h2>
              <ul>
                
              <?php foreach( $posts as $post ): 
                
                setup_postdata( $post );
                
                ?>
                <li style="width: 45%;">
                <a href="<?php the_permalink(); ?>">
                  <?php the_post_thumbnail();?>
                  <?php the_title(); ?>
                </a>
                <?php
                      //Get city name 
                      $city = get_field( "city" );
                      $cityname = $city->post_title;
                      $area = get_field( "area" );
                      $cost = get_field( "cost" );
                      $adress = get_field( "adress" );
                      $livingarea = get_field( "livingarea" );
                      $floor = get_field( "floor" );
                  ?>

                  <div class="properdty-details">
                    <h6>Характеристики</h6>
                    <p>Город: <?=$cityname?></p>
                    <p>Площадь: <?=$area?></p>
                    <p>Стоимость: <?=$cost?></p>
                    <p>Адрес: <?=$adress?></p>
                    <p>Жилая площадь: <?=$livingarea?></p>
                    <p>Этаж: <?=$floor?></p>
                  </div>
                  
                </li>
              
              <?php endforeach; ?>
              
              </ul>
              </div>

              <?php wp_reset_postdata(); ?>

              <?php else : ?>
              <h2> В этом городе нет доступной недвижимости </h2>

            <?php endif; ?>









						<?php understrap_post_nav(); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

		<!-- Do the right sidebar check -->
		
	</div><!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
