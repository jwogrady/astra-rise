<?php
/**
 * Customizer: Business Information & Editor Options
 *
 * Provides theme customization options for business contact information
 * and Gutenberg editor feature toggles.
 *
 * @package astra-rise
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer Panels & Sections
 *
 * Adds custom theme panel with business info and editor settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_customize_register( $wp_customize ) {
	/**
	 * Panel: Rise Local Branding
	 *
	 * Main panel containing all Rise Local theme customization options.
	 */
	$wp_customize->add_panel( 'rise_local_brand', array(
		'title'       => __( 'Rise Local Branding', 'astra-rise' ),
		'description' => __( 'Customize Rise Local brand elements, business info, and editor options.', 'astra-rise' ),
		'priority'    => 30,
	) );

	/**
	 * Section: Business Information
	 *
	 * Allows customization of contact details displayed throughout the site.
	 */
	$wp_customize->add_section( 'rise_business_info', array(
		'title'       => __( 'Business Information', 'astra-rise' ),
		'description' => __( 'Update your business contact details.', 'astra-rise' ),
		'panel'       => 'rise_local_brand',
		'priority'    => 10,
	) );

	/**
	 * Setting: Business Phone Number
	 *
	 * Stores and sanitizes business phone number.
	 */
	$wp_customize->add_setting( 'rise_business_phone', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
		'type'              => 'theme_mod',
	) );

	$wp_customize->add_control( 'rise_business_phone', array(
		'label'       => __( 'Business Phone', 'astra-rise' ),
		'description' => __( 'Primary business phone number', 'astra-rise' ),
		'section'     => 'rise_business_info',
		'type'        => 'tel',
	) );

	/**
	 * Setting: Business Email Address
	 *
	 * Stores and sanitizes business email address.
	 */
	$wp_customize->add_setting( 'rise_business_email', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'refresh',
		'type'              => 'theme_mod',
	) );

	$wp_customize->add_control( 'rise_business_email', array(
		'label'       => __( 'Business Email', 'astra-rise' ),
		'description' => __( 'Primary business email address', 'astra-rise' ),
		'section'     => 'rise_business_info',
		'type'        => 'email',
	) );

	/**
	 * Section: Editor Options
	 *
	 * Controls Gutenberg editor behavior and brand enforcement.
	 */
	$wp_customize->add_section( 'rise_editor_options', array(
		'title'    => __( 'Editor Options', 'astra-rise' ),
		'panel'    => 'rise_local_brand',
		'priority' => 20,
	) );

	/**
	 * Setting: Allow Custom Colors
	 *
	 * When disabled (default), editors can only use brand palette colors.
	 * When enabled, custom color picker is available.
	 */
	$wp_customize->add_setting( 'rise_allow_custom_colors', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
		'type'              => 'theme_mod',
	) );

	$wp_customize->add_control( 'rise_allow_custom_colors', array(
		'label'       => __( 'Allow Custom Colors', 'astra-rise' ),
		'description' => __( 'When enabled, users can override the brand color palette. Unchecked by default to enforce brand consistency.', 'astra-rise' ),
		'section'     => 'rise_editor_options',
		'type'        => 'checkbox',
	) );

	/**
	 * Setting: Allow Custom Gradients
	 *
	 * When disabled (default), editors can only use brand gradients.
	 * When enabled, custom gradient picker is available.
	 */
	$wp_customize->add_setting( 'rise_allow_custom_gradients', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
		'type'              => 'theme_mod',
	) );

	$wp_customize->add_control( 'rise_allow_custom_gradients', array(
		'label'       => __( 'Allow Custom Gradients', 'astra-rise' ),
		'description' => __( 'When enabled, users can override the brand gradient presets. Unchecked by default to enforce brand consistency.', 'astra-rise' ),
		'section'     => 'rise_editor_options',
		'type'        => 'checkbox',
	) );
}
add_action( 'customize_register', 'astra_rise_customize_register' );

