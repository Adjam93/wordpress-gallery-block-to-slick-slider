<?php

/**
 * Plugin Name:       Gallery to Slick Slider
 * Plugin URI:        https://ajcode.net
 * Description:       Turns Gutenberg gallery block into a slider when a gallery and shortcode is present.
 * Version:           1.0.0
 * Author:            Adam James
 * Author URI:        https://ajcode.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gallery-to-slick
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
* Enqueue slick slider assests and slider settings js
*/
function load_slick_slider_assets(){
    
    wp_enqueue_style( "slick", plugin_dir_url( __FILE__ ) . 'assets/css/slick.css' );
    wp_enqueue_style( "slick-theme", plugin_dir_url( __FILE__ ) . 'assets/css/slick-theme.css' );
    wp_enqueue_style( "gallery-to-slick", plugin_dir_url( __FILE__ ) . 'assets/css/gallery-to-slick.css' );

    wp_enqueue_script( "slick-min", plugin_dir_url( __FILE__ ) . 'assets/js/slick.min.js', array('jquery'), '1.8.0', true );
    wp_enqueue_script( "gallery-slider", plugin_dir_url( __FILE__ ) . 'assets/js/gallery-to-slick-settings.js', array('jquery'), '1.0.0', true );

}

add_action( 'wp_enqueue_scripts', 'load_slick_slider_assets');

/**
* Get the ID of core gallery block added to page to match to shortcodes ID
*/
function get_block_id( $block ) {

    if ( $block['blockName'] !== 'core/gallery' ) {

        return;

    }

    $block_html = $block[ 'innerHTML' ];
    $id_start = strpos( $block_html, 'id="' ) + 4;

    if ( $id_start === false ) return;

    $id_end = strpos( $block_html, '"', $id_start );
    $block_id = substr( $block_html, $id_start, $id_end - $id_start );

    return $block_id;
}

/**
* Remove default gallery block markup
*/
function remove_gallery_block_html( $block_content, $block ) {

    global $post; 

    //if the block isn't a gallery block return normal block content
    if ( $block[ 'blockName' ]  !== 'core/gallery' ) {

        return $block_content;

    }

    //if the post contains the slick gallery shortcode, return just an empty string, removing the gallery markup 
    if ( has_shortcode( $post->post_content, 'slick-slider-gallery' ) ) {

        return '';

    }
    
    return $block_content;

}

add_filter( 'render_block', 'remove_gallery_block_html', 10, 2 );

/**
* Shortcode function which uses parse_blocks and extracts data from images within gallery to be used as the images for slider
*/
function gutenberg_gallery_slick_slider_shortcode( $atts ) {
    
    global $post; 
    
    $attributes = shortcode_atts( 
		array(

            'title' => 'Project Gallery',
			'gallery_id' => ''

		), $atts
	);

    if ( has_block( 'gallery', $post->post_content ) ) :

        ob_start(); 
        
        if ( ! empty( $attributes[ 'gallery_id'] ) ) : ?>

        <section id="gtss-project-gallery">

            <h2><?php echo esc_html__( $attributes[ 'title' ] ) ?></h2>
            
            <div class="gtss-gallery-img">
                
        <?php 
        
        endif;

            $post_blocks = parse_blocks( $post->post_content );

            foreach( $post_blocks as $block ) {

                if( $block['blockName'] == 'core/gallery' ) {

                    if( get_block_id( $block ) == $attributes[ 'gallery_id' ] ){

                        $ids = $block[ 'attrs' ][ 'ids' ];

                        foreach( $ids as $id ) {

                            $image = wp_get_attachment_image_src( $id, 'full' );
                            $image_alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
                            $image_caption = wp_get_attachment_caption( $id );
                            
                            echo '<div class="gtss-gallery-item"><img data-lazy="'. $image[0] .'" data-src="'. $image[0] .'" alt="'. $image_alt .'"><div class="gtss-img-caption"><h3>' .  $image_caption . '</h3></div></div>';

                        } 
                        
                    }
                    
                }

            }

        ?>

            </div>

        </section>

    <?php

        endif; 
        return ob_get_clean();

} // end gutenberg_gallery_slick_slider_shortcode function

add_shortcode ( 'slick-slider-gallery', 'gutenberg_gallery_slick_slider_shortcode' );