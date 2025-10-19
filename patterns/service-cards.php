<?php
/**
 * Rise Local Service Cards Pattern
 * @package astra-rise
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return array(
    'title'       => __( 'Rise Local Service Cards', 'astra-rise' ),
    'description' => __( 'Three-column service cards with Rise Local styling', 'astra-rise' ),
    'categories'  => array( 'rise-local', 'columns' ),
    'content'     => '<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}},"color":{"background":"#f6f7f9"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide has-background" style="background-color:#f6f7f9;padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center","level":2,"style":{"color":{"text":"#000000"},"spacing":{"margin":{"bottom":"3rem"}},"typography":{"fontSize":"4rem","fontWeight":"600","fontFamily":"Montserrat"}}} -->
<h2 class="has-text-align-center has-text-color" style="color:#000000;margin-bottom:3rem;font-size:4rem;font-weight:600;font-family:Montserrat">Our Services</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"8px"},"color":{"background":"#ffffff"}},"className":"rise-service-card"} -->
<div class="wp-block-column rise-service-card has-background" style="border-radius:8px;background-color:#ffffff;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:heading {"textAlign":"center","level":3,"style":{"color":{"text":"#3d86d5"},"typography":{"fontSize":"3.125rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<h3 class="has-text-align-center has-text-color" style="color:#3d86d5;font-size:3.125rem;font-weight:400;font-family:Montserrat">Digital Marketing</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#696a6d"},"typography":{"fontSize":"1rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<p class="has-text-align-center has-text-color" style="color:#696a6d;font-size:1rem;font-weight:400;font-family:Montserrat">Boost your online presence with our comprehensive digital marketing solutions.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"8px"},"color":{"background":"#ffffff"}},"className":"rise-service-card"} -->
<div class="wp-block-column rise-service-card has-background" style="border-radius:8px;background-color:#ffffff;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:heading {"textAlign":"center","level":3,"style":{"color":{"text":"#3d86d5"},"typography":{"fontSize":"3.125rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<h3 class="has-text-align-center has-text-color" style="color:#3d86d5;font-size:3.125rem;font-weight:400;font-family:Montserrat">Local SEO</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#696a6d"},"typography":{"fontSize":"1rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<p class="has-text-align-center has-text-color" style="color:#696a6d;font-size:1rem;font-weight:400;font-family:Montserrat">Get found by local customers with our targeted SEO strategies.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"8px"},"color":{"background":"#ffffff"}},"className":"rise-service-card"} -->
<div class="wp-block-column rise-service-card has-background" style="border-radius:8px;background-color:#ffffff;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:heading {"textAlign":"center","level":3,"style":{"color":{"text":"#3d86d5"},"typography":{"fontSize":"3.125rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<h3 class="has-text-align-center has-text-color" style="color:#3d86d5;font-size:3.125rem;font-weight:400;font-family:Montserrat">Social Media</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#696a6d"},"typography":{"fontSize":"1rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<p class="has-text-align-center has-text-color" style="color:#696a6d;font-size:1rem;font-weight:400;font-family:Montserrat">Engage with your audience through strategic social media management.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->'
);