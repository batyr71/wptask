<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
  
	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>
    
    <div class="cities">
      <h2>Города</h2>
      <?php 
        $cities = get_posts(array(
          'posts_per_page'	=> -1,
          'post_type'			=> 'cities',
        ));
      ?>
      <?php if( $cities ): ?>
      <ul>
        <?php 
          foreach( $cities as $post ): 
          setup_postdata( $post );     
        ?>

        <li>
          <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail();?>
            <?php the_title(); ?>
          </a>
        </li>
      
        <?php endforeach; ?>
      
      </ul>
      
      <?php wp_reset_postdata(); ?>

      <?php endif; ?>

    </div>

    <div class="properties">
      <h2>Объекты недвижимости</h2>
      <?php 
        $posts = get_posts(array(
          'posts_per_page'	=> -1,
          'post_type'			=> 'real_properties',
          'meta_key'		=> 'city',
        ));
           
        if( $posts ): ?>
              
      <ul>
                
      <?php foreach( $posts as $post ): 
        
        setup_postdata( $post );
        
      ?>
        <li>
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
      
      <?php wp_reset_postdata(); ?>

      <?php endif; ?>

    </div>


      <div>
        <form name="post-form" id="post-form">
          <label for="title">Title</label>
          <input type="text" name="title" id="title">
          
          <label for="status">Status</label>
          <select name="status" id="status">
              <option value="publish">Publish</option>
              <option value="draft">Draft</option>
          </select>
          
          <label for="content">Content</label>
          <textarea name="content" id="content"></textarea>
          
          <input type="submit" name="submit" value="Submit">
        </form>
      </div>
      <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
        <script>
          var postForm = $( '#post-form' );
          
          var jsonData = function( form ) {
              var arrData = form.serializeArray(),
                  objData = {};
                
              $.each( arrData, function( index, elem ) {
                  objData[elem.name] = elem.value;
              });
                
              return JSON.stringify( objData );
          };
            
          postForm.on( 'submit', function( e ) {
              e.preventDefault();
                
              $.ajax({
                  url: 'http://batyr7l2.beget.tech/wp-json/wp/v2/posts',
                  method: 'POST',
                  data: jsonData( postForm ),
                  crossDomain: true,
                  contentType: 'application/json',
                  beforeSend: function ( xhr ) {
                      xhr.setRequestHeader( 'Authorization', 'Basic admin:123456' );
                  },
                  success: function( data ) {
                      console.log( data );
                  },
                  error: function( error ) {
                      console.log( error );
                  }
              });
          });
        </script>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php edit_post_link( __( 'Edit', 'understrap' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
