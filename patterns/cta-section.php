<?php
/**
 * Rise Local Call-to-Action Pattern
 * @package astra-rise
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return array(
    'slug'        => 'astra-rise/cta-section',
    'title'       => __( 'Rise Local Call-to-Action', 'astra-rise' ),
    'description' => __( 'A compelling call-to-action section with Rise Local branding', 'astra-rise' ),
    'categories'  => array( 'rise-local', 'call-to-action' ),
    'content'     => '<!-- wp:group {"align":"full","backgroundColor":"rise-blue","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem","left":"2rem","right":"2rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-rise-blue-background-color has-background" style="padding-top:4rem;padding-right:2rem;padding-bottom:4rem;padding-left:2rem"><!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"textAlign":"center","level":2,"textColor":"rise-white","style":{"spacing":{"margin":{"bottom":"1rem"}},"typography":{"fontSize":"4rem","fontWeight":"600","fontFamily":"Montserrat"}}} -->
<h2 class="has-text-align-center has-rise-white-color has-text-color" style="margin-bottom:1rem;font-size:4rem;font-weight:600;font-family:Montserrat">Ready to Grow Your Business?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"rise-white","style":{"typography":{"fontSize":"1.5rem","fontWeight":"200","fontFamily":"Montserrat"},"spacing":{"margin":{"bottom":"1rem"}}}} -->
<p class="has-text-align-center has-rise-white-color has-text-color" style="margin-bottom:1rem;font-size:1.5rem;font-weight:200;font-family:Montserrat">Let Rise Local help you reach more customers and increase your revenue.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","className":"rise-brand-accent","textColor":"rise-orange-accent","style":{"typography":{"fontSize":"1.125rem","fontFamily":"Permanent Marker"},"spacing":{"margin":{"bottom":"2rem"}}}} -->
<p class="has-text-align-center rise-brand-accent has-rise-orange-accent-color has-text-color" style="margin-bottom:2rem;font-size:1.125rem;font-family:Permanent Marker">Your success story starts here!</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"rise-white","textColor":"rise-blue","style":{"border":{"radius":"8px"},"spacing":{"padding":{"left":"2rem","right":"2rem","top":"1rem","bottom":"1rem"}},"typography":{"fontFamily":"Montserrat","fontWeight":"600"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-rise-blue-color has-rise-white-background-color has-text-color has-background wp-element-button" style="border-radius:8px;padding-top:1rem;padding-right:2rem;padding-bottom:1rem;padding-left:2rem;font-family:Montserrat;font-weight:600">Contact Us Today</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->'
);