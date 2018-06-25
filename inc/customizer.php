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

  // remove unused sections
  $wp_customize->remove_section('colors');
  $wp_customize->remove_section('background_image');
  $wp_customize->remove_control('site_icon');

  // ??
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

  // SECTION GOOGLE MAP
  $wp_customize->add_section(
    // ID
    'map_section',
    // Arguments array
    array(
      'title' => __( 'Map', 'my_theme' ),
      'capability' => 'edit_theme_options',
      'description' => __( 'Paste here the Embed Map code you got by Google Maps (width and height will be adapted)', 'my_theme' )
    )
  );

  // SETTING MAP URL
  $wp_customize->add_setting(
    'my_theme_settings[google_map]',
    array('type' => 'option')
  );

  $wp_customize->add_control(
    'map_control',
    array(
      'type' => 'text',
      'label' => __( 'Embed Map code (HTML)', 'my_theme' ),
      'section' => 'map_section',
      'settings' => 'my_theme_settings[google_map]'
    )
  );

  // SETTING MAP TITLE
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

  // SETTING MAP ADDRESS
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

  // SETTING MAP EMAIL
  $wp_customize->add_setting(
    'my_theme_settings[google_map_email]',
    array('type' => 'option')
  );

  $wp_customize->add_control(
    'map_email_control',
    array(
      'type' => 'text',
      'label' => __( 'E-mail address', 'my_theme' ),
      'section' => 'map_section',
      'settings' => 'my_theme_settings[google_map_email]'
    )
  );

  // END GOOGLE MAP SECTION

  // ---------------------------------------------------------------------------------

  // SECTION PICTOGRAM
  $wp_customize->add_section(
    // ID
    'pictogram_section',
    // Arguments array
    array(
      'title' => __( 'Pictogram', 'my_theme' ),
      'capability' => 'edit_theme_options',
      'description' => __( 'Upload an image with height 150px that can be repeated horizontally', 'my_theme' )
    )
  );

  // SETTING PICTOGRAM
  $wp_customize->add_setting(
    'my_theme_settings[pictogram]',
    array(
      'type' => 'option',
      'default' => 'arse',
      'capability' => 'edit_theme_options'
    )
  );

  $wp_customize->add_control(
    new WP_Customize_Upload_Control(
      $wp_customize,
      'pictogram_control',
      array(
        'label' => __( 'File', 'my_theme' ),
        'section' => 'pictogram_section',
        'settings' => 'my_theme_settings[pictogram]'
      )
    )
  );

  // END PICTOGRAM SECTION

  // ---------------------------------------------------------------------------------

  // SECTION FACULTY COLOR
  $wp_customize->add_section(
    // ID
    'faculty_color_section',
    // Arguments array
    array(
      'title' => __( 'Faculty Style', 'my_theme' ),
      'capability' => 'edit_theme_options',
      'description' => __( 'Select the faculty style for the website', 'my_theme' )
    )
  );

  // SETTING FACULTY COLOR
  $wp_customize->add_setting(
    'my_theme_settings[faculty_color]',
    array(
      'type' => 'option',
      'default' => 'none',
      'capability' => 'edit_theme_options'
    )
  );

  $wp_customize->add_control( 
    'faculty_color_control',
    array(
      'settings' => 'my_theme_settings[faculty_color]',
      'label'   => 'Choose',
      'section' => 'faculty_color_section',
      'type'    => 'select',
      'choices' => array(
        'none' => 'Default',
        'comp' => 'Computer Science',
        'dsgn' => 'Design and Art',
        'econ' => 'Economics and Management',
        'scitec' => 'Science and Technology',
        'edu' => 'Education',
        'library' => 'Library'
      )
    )
  );

  // END FACULTY COLOR SECTION

  // ---------------------------------------------------------------------------------
}
add_action( 'customize_register', 'unibz_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function unibz_customize_preview_js() {
	wp_enqueue_script( 'unibz_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'unibz_customize_preview_js' );
