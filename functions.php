<?php

function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/css/style.css' );
	
	// enqueue child styles
		wp_enqueue_style('child-style', get_stylesheet_directory_uri() .'/style.css', array('parent-style'));

}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', 100);


function fb_home_image( $tags ) {
    // Fix the default OpenGraph and Twitter card tags set by Jetpack
    unset( $tags['og:image'] );
	unset( $tags['og:image:width'] );
	unset( $tags['og:image:height'] );
	unset( $tags['twitter:image'] );
	unset( $tags['twitter:text:title'] );
	
 
	$fb_home_img = "https://pics.timtom.ch/wp-content/uploads/sites/6/2018/02/timtom-flickr-stuttgart01.jpg";
	
    $tags['og:image'] = esc_url( $fb_home_img );
    $tags['twitter:image'] = esc_url( $fb_home_img );
    //$tags['twitter:text:title'] = bloginfo('name');
	
	return $tags;
}
add_filter( 'jetpack_open_graph_tags', 'fb_home_image' );

?>