<?php
/**
 * unibz Theme Customizer.
 *
 * @package unibz
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function unibz_customize_register( $wp_customize ) {

  $wp_customize->remove_section('colors');
  $wp_customize->remove_section('background_image');
  $wp_customize->remove_control('site_icon');

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';


  $wp_customize->add_section(
    // ID
    'map_section',
    // Arguments array
    array(
      'title' => __( 'Map', 'my_theme' ),
      'capability' => 'edit_theme_options',
      'description' => __( 'Paste here the URL you got by Google Maps', 'my_theme' )
    )
  );

  $wp_customize->add_setting(
    'my_theme_settings[google_map]',
    array('type' => 'option')
  );

  $wp_customize->add_control(
    'map_control',
    array(
      'type' => 'text',
      'label' => __( 'URL', 'my_theme' ),
      'section' => 'map_section',
      'settings' => 'my_theme_settings[google_map]'
    )
  );

  $wp_customize->add_setting(
    'my_theme_settings[google_map_title]',
    array('type' => 'option')
  );

  $wp_customize->add_control(
    'map_title_control',
    array(
      'type' => 'text',
      'label' => __( 'Title', 'my_theme' ),
      'section' => 'map_section',
      'settings' => 'my_theme_settings[google_map_title]'
    )
  );  

  $wp_customize->add_setting(
    'my_theme_settings[google_map_address]',
    array('type' => 'option')
  );

  $wp_customize->add_control(
    'map_address_control',
    array(
      'type' => 'textarea',
      'label' => __( 'Address', 'my_theme' ),
      'section' => 'map_section',
      'settings' => 'my_theme_settings[google_map_address]'
    )
  );  
}
add_action( 'customize_register', 'unibz_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function unibz_customize_preview_js() {
	wp_enqueue_script( 'unibz_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'unibz_customize_preview_js' );
