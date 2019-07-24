<?php
/*
 * Plugin Name: Texonomy Post Tabs
 */

/**
 * Create a class first
 */
class WP_texonomy_post_tabs
{
	/**
 	 * Call to construct
 	 */
	function __construct()
	{
		add_shortcode('WP_texonomy_post_tabs', array($this, 'shortcode'));
		add_action('wp_enqueue_scripts', array($this, 'flat_ui_kit'));
	}

	function get_texonomy() {
		$category_id = get_cat_ID('new-cat');    // Pass the taxonomy slug name #new-cat
        $catquery = new WP_Query( 'cat=' .$category_id. '&posts_per_page=10' );
        ?>

        <div class="container">

        	<!----- Vertical Tabs --------->
		    <div class="vertical-tabs"> 
			    <ul class="nav nav-tabs" role="tablist">
			      	<?php
				      	$i=0;
				      	$postID = array();
			      	 ?>
			        <?php while($catquery->have_posts()) : $catquery->the_post(); ?>
			        	<li class="nav-item">
					    	<a class="nav-link <?php echo ($i==0)?'active':''; ?>" data-toggle="tab" href="#pag<?php echo get_the_ID();?>" role="tab" aria-controls="home"><?php the_title(); ?></a>
					    </li>
					<?php
						$postID[] =  get_the_ID();
						$i++;
					 ?>
					<?php endwhile; ?>		      
			    </ul>

			    <!----- All Tabs Contents --------->			    
		      	<div class="tab-content">
			      	<?php $J=0; ?>
			        <?php foreach ($postID as $posts) {
			        	?>
				        <div class="tab-pane <?php echo ($J==0)?'active':''; ?>" id="pag<?php echo $posts; ?>" role="tabpanel">
					        <div class="sv-tab-panel">
					            <p><?php echo get_the_post_thumbnail( $posts ); ?><p>	
					            <p><a href="<?php echo get_permalink( $posts ); ?> ">Read More</a></p>
					        </div>
				        </div>
				    <?php $J++; ?>
					<?php } ?>		          
		        </div>
		    </div>
		</div>
		<?php
	}

	/**
 	 * Enques jquery and CSS Files.
 	 */
	function flat_ui_kit() {
		wp_enqueue_style('bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
		wp_enqueue_style('custom-css', plugins_url('css/custom-style.css', __FILE__));
        wp_enqueue_script( 'jquery-script', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', array( 'jquery' ) );
        wp_enqueue_script( 'bootstrap-script', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ) );
        wp_enqueue_script( 'bootstrap-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js',  array( 'jquery' ) );
	}
	/**
 	 * Created the Shortcode 
 	 */
	function shortcode() {
		ob_start();		
		$this->get_texonomy();
		return ob_get_clean();
	}
}
new WP_texonomy_post_tabs;

?>