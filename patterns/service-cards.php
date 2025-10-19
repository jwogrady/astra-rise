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
    'content'     => '<!-- wp:group {"align":"wide","backgroundColor":"rise-background","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide has-rise-background-background-color has-background" style="padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center","level":2,"textColor":"rise-black","style":{"spacing":{"margin":{"bottom":"3rem"}},"typography":{"fontSize":"4rem","fontWeight":"600","fontFamily":"Montserrat"}}} -->
<h2 class="has-text-align-center has-rise-black-color has-text-color" style="margin-bottom:3rem;font-size:4rem;font-weight:600;font-family:Montserrat">Our Services</h2>
<!-- /wp:heading -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"8px"}},"backgroundColor":"rise-white","className":"rise-service-card"} -->
<div class="wp-block-column rise-service-card has-rise-white-background-color has-background" style="border-radius:8px;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:heading {"textAlign":"center","level":3,"textColor":"rise-blue","style":{"typography":{"fontSize":"3.125rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<h3 class="has-text-align-center has-rise-blue-color has-text-color" style="font-size:3.125rem;font-weight:400;font-family:Montserrat">Digital Marketing</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"rise-gray","style":{"typography":{"fontSize":"1rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<p class="has-text-align-center has-rise-gray-color has-text-color" style="font-size:1rem;font-weight:400;font-family:Montserrat">Boost your online presence with our comprehensive digital marketing solutions.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"8px"}},"backgroundColor":"rise-white","className":"rise-service-card"} -->
<div class="wp-block-column rise-service-card has-rise-white-background-color has-background" style="border-radius:8px;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:heading {"textAlign":"center","level":"3","textColor":"rise-blue","style":{"typography":{"fontSize":"3.125rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<h3 class="has-text-align-center has-rise-blue-color has-text-color" style="font-size:3.125rem;font-weight:400;font-family:Montserrat">Local SEO</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"rise-gray","style":{"typography":{"fontSize":"1rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<p class="has-text-align-center has-rise-gray-color has-text-color" style="font-size:1rem;font-weight:400;font-family:Montserrat">Get found by local customers with our targeted SEO strategies.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"style":{"spacing":{"padding":{"top":"2rem","right":"2rem","bottom":"2rem","left":"2rem"}},"border":{"radius":"8px"}},"backgroundColor":"rise-white","className":"rise-service-card"} -->
<div class="wp-block-column rise-service-card has-rise-white-background-color has-background" style="border-radius:8px;padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:heading {"textAlign":"center","level":"3","textColor":"rise-blue","style":{"typography":{"fontSize":"3.125rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<h3 class="has-text-align-center has-rise-blue-color has-text-color" style="font-size:3.125rem;font-weight:400;font-family:Montserrat">Social Media</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"rise-gray","style":{"typography":{"fontSize":"1rem","fontWeight":"400","fontFamily":"Montserrat"}}} -->
<p class="has-text-align-center has-rise-gray-color has-text-color" style="font-size:1rem;font-weight:400;font-family:Montserrat">Engage with your audience through strategic social media management.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->'
);