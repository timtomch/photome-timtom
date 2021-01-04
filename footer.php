<?php
/**
 * The template for displaying the footer.
 * Tweaked for fotome-timtom child theme.
 *
 * @package WordPress
 */
?>

<?php
	//Check if blank template
	global $is_no_header;
	global $screen_class;
	
	if(!is_bool($is_no_header) OR !$is_no_header)
	{

	global $pp_homepage_style;
	
	//If display photostream
	$pp_photostream = get_option('pp_photostream');
	if(THEMEDEMO && isset($_GET['footer']) && !empty($_GET['footer']))
	{
		$pp_photostream = 0;
	}

	if(!empty($pp_photostream))
	{
		$photos_arr = array();
	
		if($pp_photostream == 'flickr')
		{
			$pp_flickr_id = get_option('pp_flickr_id');
			$photos_arr = get_flickr(array('type' => 'user', 'id' => $pp_flickr_id, 'items' => 10));
            
			//TT mod
			$tt_widget_title = ucfirst($pp_photostream);
		}
		else
		{
			$pp_instagram_username = get_option('pp_instagram_username');
			$is_instagram_authorized = photome_check_instagram_authorization();
			
			if(is_bool($is_instagram_authorized) && $is_instagram_authorized)
			{
				$photos_arr = photome_get_instagram_using_plugin('photostream');
			}
			else
			{
				echo $is_instagram_authorized;
			}
            
			//TT mod
			$tt_widget_title = "<a href=\"https://www.instagram.com/".$pp_instagram_username."\">Follow @".$pp_instagram_username." on Instagram</a>";

		}
		
		if(!empty($photos_arr) && $screen_class != 'split' && $pp_homepage_style != 'fullscreen' && $pp_homepage_style != 'flow')
		{
?>
<br class="clear"/>
<div class="footer_photostream_wrapper">
	<h2 class="widgettitle"><span><?php echo $tt_widget_title; ?></span></h2>
	<ul class="footer_photostream">
		<?php
			$count_photo = 0;
			
			foreach($photos_arr as $photo)
			{
				if(isset($photo['thumb_url']) && !empty($photo['thumb_url']))
				{
		?>
			<li style="background-image:url(<?php echo esc_url($photo['thumb_url']); ?>);"><a target="_blank" href="<?php echo esc_url($photo['link']); ?>"></a></li>
		<?php
					$count_photo++;
					
					if($count_photo == 10)
					{
						break;
					}
				}
			}
		?>
	</ul>
</div>
<?php
		}
	}
?>

<?php
	//Get Footer Sidebar
	$tg_footer_sidebar = kirki_get_option('tg_footer_sidebar');
	if(THEMEDEMO && isset($_GET['footer']) && !empty($_GET['footer']))
	{
	    $tg_footer_sidebar = 0;
	}
?>
<div class="footer_bar <?php if(isset($pp_homepage_style) && !empty($pp_homepage_style)) { echo esc_attr($pp_homepage_style); } ?> <?php if(!empty($screen_class) && $screen_class == 'split') { ?>split<?php } ?> <?php if(empty($tg_footer_sidebar)) { ?>noborder<?php } ?>">

	<?php
	    if(!empty($tg_footer_sidebar))
	    {
	    	$footer_class = '';
	    	
	    	switch($tg_footer_sidebar)
	    	{
	    		case 1:
	    			$footer_class = 'one';
	    		break;
	    		case 2:
	    			$footer_class = 'two';
	    		break;
	    		case 3:
	    			$footer_class = 'three';
	    		break;
	    		case 4:
	    			$footer_class = 'four';
	    		break;
	    		default:
	    			$footer_class = 'four';
	    		break;
	    	}
	    	
	    	global $pp_homepage_style;
	?>
	<div id="footer" class="<?php if(isset($pp_homepage_style) && !empty($pp_homepage_style)) { echo esc_attr($pp_homepage_style); } ?>">
	<ul class="sidebar_widget <?php echo esc_attr($footer_class); ?>">
	    <?php dynamic_sidebar('Footer Sidebar'); ?>
	</ul>
	</div>
	<br class="clear"/>
	<?php
	    }
	?>

	<div class="footer_bar_wrapper <?php if(isset($pp_homepage_style) && !empty($pp_homepage_style)) { echo esc_attr($pp_homepage_style); } ?>">
		<?php
			//Check if display social icons or footer menu
			$tg_footer_copyright_right_area = kirki_get_option('tg_footer_copyright_right_area');
			
			if($tg_footer_copyright_right_area=='social')
			{
				if($pp_homepage_style!='flow' && $pp_homepage_style!='fullscreen' && $pp_homepage_style!='carousel' && $pp_homepage_style!='flip' && $pp_homepage_style!='fullscreen_video')
				{	
					//Check if open link in new window
					$tg_footer_social_link = kirki_get_option('tg_footer_social_link');
			?>
			<div class="social_wrapper">
			    <ul>
			    	<?php
			    		$pp_facebook_url = get_option('pp_facebook_url');
			    		
			    		if(!empty($pp_facebook_url))
			    		{
			    	?>
			    	<li class="facebook"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> href="<?php echo esc_url($pp_facebook_url); ?>"><i class="fa fa-facebook"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_twitter_username = get_option('pp_twitter_username');
			    		
			    		if(!empty($pp_twitter_username))
			    		{
			    	?>
			    	<li class="twitter"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> href="https://twitter.com/<?php echo esc_attr($pp_twitter_username); ?>"><i class="fa fa-twitter"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_flickr_username = get_option('pp_flickr_username');
			    		
			    		if(!empty($pp_flickr_username))
			    		{
			    	?>
			    	<li class="flickr"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Flickr" href="https://flickr.com/people/<?php echo esc_attr($pp_flickr_username); ?>"><i class="fa fa-flickr"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_youtube_url = get_option('pp_youtube_url');
			    		
			    		if(!empty($pp_youtube_url))
			    		{
			    	?>
			    	<li class="youtube"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Youtube" href="<?php echo esc_url($pp_youtube_url); ?>"><i class="fa fa-youtube"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_vimeo_username = get_option('pp_vimeo_username');
			    		
			    		if(!empty($pp_vimeo_username))
			    		{
			    	?>
			    	<li class="vimeo"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Vimeo" href="https://vimeo.com/<?php echo esc_attr($pp_vimeo_username); ?>"><i class="fa fa-vimeo-square"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_tumblr_username = get_option('pp_tumblr_username');
			    		
			    		if(!empty($pp_tumblr_username))
			    		{
			    	?>
			    	<li class="tumblr"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Tumblr" href="https://<?php echo esc_attr($pp_tumblr_username); ?>.tumblr.com"><i class="fa fa-tumblr"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_dribbble_username = get_option('pp_dribbble_username');
			    		
			    		if(!empty($pp_dribbble_username))
			    		{
			    	?>
			    	<li class="dribbble"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Dribbble" href="https://dribbble.com/<?php echo esc_attr($pp_dribbble_username); ?>"><i class="fa fa-dribbble"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			    		$pp_linkedin_url = get_option('pp_linkedin_url');
			    		
			    		if(!empty($pp_linkedin_url))
			    		{
			    	?>
			    	<li class="linkedin"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Linkedin" href="<?php echo esc_url($pp_linkedin_url); ?>"><i class="fa fa-linkedin"></i></a></li>
			    	<?php
			    		}
			    	?>
			    	<?php
			            $pp_pinterest_username = get_option('pp_pinterest_username');
			            
			            if(!empty($pp_pinterest_username))
			            {
			        ?>
			        <li class="pinterest"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Pinterest" href="https://pinterest.com/<?php echo esc_attr($pp_pinterest_username); ?>"><i class="fa fa-pinterest"></i></a></li>
			        <?php
			            }
			        ?>
			        <?php
			        	$pp_instagram_username = get_option('pp_instagram_username');
			        	
			        	if(!empty($pp_instagram_username))
			        	{
			        ?>
			        <li class="instagram"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Instagram" href="https://instagram.com/<?php echo esc_attr($pp_instagram_username); ?>"><i class="fa fa-instagram"></i></a></li>
			        <?php
			        	}
			        ?>
			        <?php
			        	$pp_behance_username = get_option('pp_behance_username');
			        	
			        	if(!empty($pp_behance_username))
			        	{
			        ?>
			        <li class="behance"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="Behance" href="https://behance.net/<?php echo esc_attr($pp_behance_username); ?>"><i class="fa fa-behance-square"></i></a></li>
			        <?php
			        	}
			        ?>
			        <?php
			        	$pp_500px_username = get_option('pp_500px_username');
			        	
			        	if(!empty($pp_500px_username))
			        	{
			        ?>
			        <li class="500px"><a <?php if(!empty($tg_footer_social_link)) { ?>target="_blank"<?php } ?> title="500px" href="https://500px.com/<?php echo esc_html($pp_500px_username); ?>"><i class="fa fa-500px"></i></a></li>
			        <?php
			        	}
			        ?>
			    </ul>
			</div>
		<?php
				}
			} //End if display social icons
			else
			{
				if ( has_nav_menu( 'footer-menu' ) ) 
			    {
				    wp_nav_menu( 
				        	array( 
				        		'menu_id'			=> 'footer_menu',
				        		'menu_class'		=> 'footer_nav',
				        		'theme_location' 	=> 'footer-menu',
				        	) 
				    ); 
				}
			}
		?>
	    <?php
	    	//Display copyright text
	        $tg_footer_copyright_text = kirki_get_option('tg_footer_copyright_text');

	        if(!empty($tg_footer_copyright_text))
	        {
	        	echo '<div id="copyright">'.wp_kses_post(wp_specialchars_decode($tg_footer_copyright_text)).'</div><br class="clear"/>';
	        }
	    ?>
	    
	    <?php
	    	//Check if display to top button
	    	$tg_footer_copyright_totop = kirki_get_option('tg_footer_copyright_totop');
	    	
	    	if(!empty($tg_footer_copyright_totop))
	    	{
	    ?>
	    	<a id="toTop"><i class="fa fa-angle-up"></i></a>
	    <?php
	    	}
	    ?>
	</div>
</div>

</div>

<?php
    } //End if not blank template
?>

<div id="overlay_background">
	<?php
		$tg_global_sharing = kirki_get_option('tg_global_sharing');
	
		if(is_single() OR !empty($tg_global_sharing))
		{
	?>
	<div id="fullscreen_share_wrapper">
		<div class="fullscreen_share_content">
	<?php
			get_template_part("/templates/template-share");
	?>
		</div>
	</div>
	<?php
		}
	?>
</div>

<?php
    //Check if theme demo then enable layout switcher
    if(THEMEDEMO)
    {
?>
    <div id="option_wrapper">
    <div class="inner">
    	<div style="text-align:center">
    	<h6>PREDEFINED DEMOS</h6>
    	<p>
    	Photo Me is so powerful theme allow you to easily create your own style of creative photography site. Here are example that can be imported with one click.</p>
    	<ul class="demo_list">
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen1.jpg" alt="Classic"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>Classic</h6>
    	    	    		<a href="<?php echo site_url(); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen2.jpg" alt="Top Bar Enabled"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>Top Bar Enabled</h6>
    	    	    		<a href="<?php echo site_url('/galleries/flow-gallery/?topbar=1'); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen8.jpg" alt="Left Menu"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>Left Menu</h6>
    	    	    		<a href="<?php echo site_url('/home/home-parallax/?menulayout=leftmenu'); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen4.jpg" alt="White Frame"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>White Frame</h6>
    	    	    		<a href="<?php echo site_url('/gallery-archive/gallery-archive-fullscreen/?frame=1'); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen5.jpg" alt="Black Frame & One Page"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>Black Frame & One Page</h6>
    	    	    		<a href="<?php echo site_url('/home/home-one-page/?frame=1&frame_color=black'); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen6.jpg" alt="Boxed Layout"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>Boxed Layout</h6>
    	    	    		<a href="<?php echo site_url('/home/home-portfolio/?boxed=1'); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen7.jpg" alt="Minimal Menu & Footer"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>Minimal Menu & Footer</h6>
    	    	    		<a href="<?php echo site_url('/galleries/horizontal-gallery/?menu=1&footer=1'); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen3.jpg" alt="Side Menu Only"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>Side Menu Only</h6>
    	    	    		<a href="<?php echo site_url('/home/home-creative/?menu=1'); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen9.jpg" alt="Fullscreen Video"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>Fullscreen Video</h6>
    	    	    		<a href="<?php echo site_url('/home/home-revolution-slider'); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    		<li>
        		<img src="<?php echo get_template_directory_uri(); ?>/cache/demos/screen10.jpg" alt="Photo Blog"/>
        		<div class="demo_thumb_hover_wrapper">
        		    <div class="demo_thumb_hover_inner">
        		    	<div class="demo_thumb_desc">
    	    	    		<h6>Photo Blog</h6>
    	    	    		<a href="<?php echo site_url('/photo-blog/?slider=3cols-slider'); ?>" target="_blank" class="button white">Launch</a>
        		    	</div> 
        		    </div>	   
        		</div>		   
    		</li>
    	</ul>
    	</div>
    </div>
    </div>
    <div id="option_btn">
    	<a href="javascript:;" class="demotip" title="Choose Theme Demo"><i class="fa fa-cog"></i></a>
    	<a href="https://themes.themegoods.com/photome/doc" class="demotip" title="Theme Documentation" target="_blank"><i class="fa fa-book"></i></a>
    	<a href="https://1.envato.market/7kGN3" class="demotip" title="Purchase Theme" target="_blank"><i class="fa fa-shopping-basket"></i></a>
    </div>
<?php
    	wp_enqueue_script("jquery.cookie", get_template_directory_uri()."/js/jquery.cookie.js", false, THEMEVERSION, true);
    	wp_enqueue_script("script-demo", get_template_directory_uri()."/templates/script-demo.php", false, THEMEVERSION, true);
    }
?>

<?php
    $tg_frame = kirki_get_option('tg_frame');
    if(THEMEDEMO && isset($_GET['frame']) && !empty($_GET['frame']))
    {
	    $tg_frame = 1;
    }
    
    if(!empty($tg_frame))
    {
    	wp_enqueue_style("tg_frame", get_template_directory_uri()."/css/tg_frame.css", false, THEMEVERSION, "all");
?>
    <div class="frame_top"></div>
    <div class="frame_bottom"></div>
    <div class="frame_left"></div>
    <div class="frame_right"></div>
<?php
    }
    if(THEMEDEMO && isset($_GET['frame_color']) && !empty($_GET['frame_color']))
    {
?>
<style>
.frame_top, .frame_bottom, .frame_left, .frame_right { background: <?php echo esc_html($_GET['frame_color']); ?> !important; }
</style>
<?php
	}
?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
