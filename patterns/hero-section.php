<?php
/**
 * Rise Local Hero Section Pattern
 * @package astra-rise
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

return array(
    'title'       => __( 'Rise Local Hero Section', 'astra-rise' ),
    'description' => __( 'A hero section with Rise Local branding', 'astra-rise' ),
    'categories'  => array( 'rise-local', 'header' ),
    'content'     => '<!-- wp:cover {"url":"","hasParallax":true,"gradient":"rise-blue-gradient","contentPosition":"center center","className":"rise-hero-section"} -->
<div class="wp-block-cover has-parallax rise-hero-section"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-100 has-background-dim wp-block-cover__gradient-background has-background-gradient"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"textAlign":"center","level":1,"textColor":"rise-white","style":{"typography":{"fontSize":"4.5rem","fontWeight":"800","fontFamily":"Montserrat"},"spacing":{"margin":{"bottom":"1.5rem"}}}} -->
<h1 class="has-text-align-center has-rise-white-color has-text-color" style="margin-bottom:1.5rem;font-size:4.5rem;font-weight:800;font-family:Montserrat">Welcome to Rise Local</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","textColor":"rise-white","style":{"typography":{"fontSize":"1.5rem","fontWeight":"200","fontFamily":"Montserrat"},"spacing":{"margin":{"bottom":"2rem"}}}} -->
<p class="has-text-align-center has-rise-white-color has-text-color" style="margin-bottom:2rem;font-size:1.5rem;font-weight:200;font-family:Montserrat">Empowering local businesses to reach new heights</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"center","className":"rise-brand-accent","textColor":"rise-orange-accent","style":{"typography":{"fontSize":"1.125rem","fontFamily":"Permanent Marker"},"spacing":{"margin":{"bottom":"2rem"}}}} -->
<p class="has-text-align-center rise-brand-accent has-rise-orange-accent-color has-text-color" style="margin-bottom:2rem;font-size:1.125rem;font-family:Permanent Marker">Modern marketing meets local charm</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"rise-orange-accent","style":{"border":{"radius":"8px"},"spacing":{"padding":{"left":"2rem","right":"2rem","top":"1rem","bottom":"1rem"}},"typography":{"fontFamily":"Montserrat","fontWeight":"600"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-rise-orange-accent-background-color has-background wp-element-button" style="border-radius:8px;padding-top:1rem;padding-right:2rem;padding-bottom:1rem;padding-left:2rem;font-family:Montserrat;font-weight:600">Get Started Today</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->'
);