<?php

/**
 * The file that defines the scripts fields option descriptor
 *
 * @link       team@redcastor.io
 * @since      1.5.1
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */


/**
 * Define scripts fields
 */
function wp_ng_scripts_fields( $fields )
{

  //Load list google fonts from dist
  $google_font_path = plugin_dir_path( dirname( __FILE__ ) ) . 'public/dist/fonts/google-fonts.json';
  $google_font_list = array();
  if (file_exists($google_font_path)) {
    $google_font_list = array_keys( json_decode(file_get_contents($google_font_path, true), true) );
  }

  $fields['wp_ng_load_scripts'] = array(
    'title' => __('Scripts', 'wp-ng'),
    'sections' => array(
      'scripts' => array(
        'title' => 'Load Scripts',
        'display'=> 'table',
        'actions' => array(
          array(
            'function_to_add' => array( 'Wp_Ng_Admin_Fields_Action', 'clean_wp_cache' ),
            'priority' => 100
          )
        ),
        'fields' => array(
          array(
            'name'        => 'WebFont',
            'label'       => __('Web Font Loader', 'wp-ng'),
            'title'       => 'WebFont',
            'desc'        => wp_ng_settings_sections_desc_html(
              'webfontloader',
              __( 'Web Font Loader gives you added control when using linked fonts via @font-face.', 'wp-ng'),
              '',
              'https://github.com/typekit/webfontloader',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields'  => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_primary',
                'label'       => 'Style Font Primary',
                'desc'        => __( 'Load style font primary.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'primary',
                'label'       => __( 'Primary font-family', 'wp-ng'),
                'desc'        => __( 'Primary font-family', 'wp-ng'),
                'placeholder' => 'Lato,sans-serif',
                'type'        => 'text',
                'default'     => ''
              ),
              array(
                'name'        => 'primary_fallback',
                'label'       => __( 'Primary font-family fallback', 'wp-ng'),
                'desc'        => __( 'Primary font-family fallback.', 'wp-ng'),
                'placeholder' => 'arial,sans-serif',
                'type'        => 'text',
                'default'     => 'arial,sans-serif'
              ),
              array(
                'name'        => 'google_families',
                'label'       => __( 'Google Families', 'wp-ng'),
                'desc'        => __( 'Google Families', 'wp-ng'),
                'type'        => 'multiselect',
                'default'     => '',
                'options'     => array_combine($google_font_list, $google_font_list),
              ),
              array(
                'name'        => 'typekit_edge',
                'label'       => 'Typekit Edge',
                'desc'        => __( 'Enable Typekit Edge.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'typekit_id',
                'label'       => __( 'Typekit Id (or Edge families)', 'wp-ng'),
                'desc'        => __( 'Typekit Id (or Edge families)', 'wp-ng'),
                'placeholder' => 'id kit or for edge: font1,font2',
                'type'        => 'text',
                'default'     => '',
              ),
              array(
                'name'        => 'custom_families',
                'label'       => __( 'Custom Families', 'wp-ng'),
                'desc'        => __( 'Custom Families', 'wp-ng'),
                'placeholder' => 'font1,font2',
                'type'        => 'text',
                'default'     => '',
              ),
              array(
                'name'        => 'custom_urls',
                'label'       => __( 'Custom Families', 'wp-ng'),
                'desc'        => __('One url per line.', 'wp-ng'),
                'placeholder' => '/font1.css,/font2.css',
                'type'        => 'text',
                'default'     => '',
              ),
              array(
                'name'        => 'timeout',
                'label'       => __( 'Timeout', 'wp-ng'),
                'desc'        => __( 'Timeout', 'wp-ng'),
                'type'        => 'number',
                'default'     => '0',
              ),
              array(
                'name'        => 'cdn_url',
                'label'       => __( 'CDN URL', 'wp-ng'),
                'desc'        => __('CDN Format ( //your-cdn.com/libs/webfontloader/%version%/%file% )', 'wp-ng'),
                'placeholder' => '//your-cdn.com/libs/%name%/%version%/%file%',
                'type'        => 'text',
                'default'     => '',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'        => 'objectFitImages',
            'label'       => __('Object Fit Images', 'wp-ng'),
            'title'       => 'objectFitImages',
            'desc'        => wp_ng_settings_sections_desc_html(
              'object-fit-images',
              __( 'Polyfill object-fit/object-position on <code>img</code>: IE9, IE10, IE11, Edge, Safari, ...', 'wp-ng'),
              '',
              'https://github.com/RedCastor/object-fit-images',
              ''
            ),
            'type'        => 'sub_fields',
            'sub_fields'  => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'        => 'aos',
            'label'       => __('AOS', 'wp-ng'),
            'title'       => 'AOS',
            'desc'        => wp_ng_settings_sections_desc_html(
              'aos',
              __( 'Small library to animate elements on your page as you scroll.', 'wp-ng'),
              '',
              'https://github.com/michalsnik/aos',
              'http://michalsnik.github.io/aos/'
            ),
            'type'        => 'sub_fields',
            'sub_fields'  => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'disable',
                'label'       => __('Disable animation', 'wp-ng'),
                'default'     => '',
                'type'        => 'select',
                'options'     => array(
                  '' => 'None',
                  'phone' => 'Phone',
                  'tablet' => 'Tablet',
                  'mobile' => 'Mobile',
                ),
              ),
              array(
                'name'        => 'offset',
                'label'       => __( 'Offset pixel', 'wp-ng'),
                'desc'        => __( 'Offset pixel', 'wp-ng'),
                'type'        => 'number',
                'default'     => 120,
              ),
              array(
                'name'        => 'delay',
                'label'       => __( 'Delay miliseconds', 'wp-ng'),
                'desc'        => __( 'Delay miliseconds', 'wp-ng'),
                'type'        => 'number',
                'default'     => 0,
              ),
              array(
                'name'        => 'duration',
                'label'       => __( 'Duration miliseconds', 'wp-ng'),
                'desc'        => __( 'Duration miliseconds', 'wp-ng'),
                'type'        => 'number',
                'default'     => 400,
              ),
              array(
                'name'        => 'once',
                'label'       => __('Animate only once', 'wp-ng'),
                'desc'        => __('Animate only once', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'mirror',
                'label'       => __('Animate out while scrolling past them', 'wp-ng'),
                'desc'        => __('Animate out while scrolling past them', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'easing',
                'label'       => __('Animation', 'wp-ng'),
                'default'     => 'ease',
                'type'        => 'select',
                'options'     => array(
                  'linear' => 'linear',
                  'ease' => 'ease',
                  'ease-in' => 'ease-in',
                  'ease-out' => 'ease-out',
                  'ease-in-out' => 'ease-in-out',
                  'ease-in-back' => 'ease-in-back',
                  'ease-out-back' => 'ease-out-back',
                  'ease-in-out-back' => 'ease-in-out-back',
                  'ease-in-sine' => 'ease-in-sine',
                  'ease-out-sine' => 'ease-out-sine',
                  'ease-in-out-sine' => 'ease-in-out-sine',
                  'ease-in-quad' => 'ease-in-quad',
                  'ease-out-quad' => 'ease-out-quad',
                  'ease-in-out-quad' => 'ease-in-out-quad',
                  'ease-in-cubic' => 'ease-in-cubic',
                  'ease-out-cubic' => 'ease-out-cubic',
                  'ease-in-out-cubic' => 'ease-in-out-cubic',
                  'ease-in-quart' => 'ease-in-quart',
                  'ease-out-quart' => 'ease-out-quart',
                  'ease-in-out-quart' => 'ease-in-out-quart',
                ),
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'        => 'aot',
            'label'       => __('AOT', 'wp-ng'),
            'title'       => 'AOT',
            'desc'        => wp_ng_settings_sections_desc_html(
              'aot',
              __( 'Small library to animate elements on your page as you trigger.', 'wp-ng'),
              '',
              'https://github.com/RedCastor/aot',
              'https://redcastor.github.io/aot/demo/'
            ),
            'type'        => 'sub_fields',
            'sub_fields'  => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style_animate',
                'label'       => 'Style',
                'desc'        => __( 'Load animate.css style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'        => 'animsition',
            'label'       => __('Animsition', 'wp-ng'),
            'title'       => 'animsition',
            'desc'        => wp_ng_settings_sections_desc_html(
              'animsition',
              __( 'A simple and easy jQuery plugin for CSS animated page transitions.', 'wp-ng'),
              '',
              'https://github.com/blivesta/animsition',
              'http://git.blivesta.com/animsition/'
            ),
            'type'        => 'sub_fields',
            'sub_fields'  => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'style',
                'label'       => 'Style',
                'desc'        => __( 'Load style.', 'wp-ng'),
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'load_inner',
                'label'       => __( 'Loading Image.', 'wp-ng'),
                'desc'        => __( 'Loading Image.', 'wp-ng'),
                'type'        => 'file',
                'default'     => '',
              ),
              array(
                'name'        => 'in_class',
                'label'       => __('Animation IN', 'wp-ng'),
                'default'     => 'fade-in',
                'type'        => 'select',
                'options'     => array(
                  'fade-in' => 'Fade In',
                  'fade-in-up-sm' => 'Fade In Up Sm',
                  'fade-in-up' => 'Fade In Up',
                  'fade-in-up-lg' => 'Fade In Up Lg',
                  'fade-in-down-sm' => 'Fade In Down Sm',
                  'fade-in-down' => 'Fade In Down',
                  'fade-in-down-lg' => 'Fade In Ddown Lg',
                  'fade-in-left-sm' => 'Fade In Left Sm',
                  'fade-in-left' => 'Fade In Left',
                  'fade-in-left-lg' => 'Fade In Left Lg',
                  'fade-in-right-sm' => 'Fade In Right Sm',
                  'fade-in-right' => 'Fade In Right',
                  'fade-in-right-lg' => 'Fade In Right Lg',
                  'rotate-in-sm' => 'Rotate In Sm',
                  'rotate-in' => 'Rotate In',
                  'rotate-in-lg' => 'Rotate In Lg',
                  'flip-in-x-fr' => 'Flip In X Fr',
                  'flip-in-x' => 'Flip In X',
                  'flip-in-x-nr' => 'Flip In X Nr',
                  'flip-in-y-fr' => 'Flip In Y Fr',
                  'flip-in-y' => 'Flip In Y',
                  'flip-in-y-nr' => 'Flip In Y Nr',
                  'zoom-in-sm' => 'Zoom In Sm',
                  'zoom-in' => 'Zoom In',
                  'zoom-in-lg' => 'Zoom In Lg',
                  'overlay-slide-in-top' => 'Overlay Slide In Top',
                  'overlay-slide-in-bottom' => 'Overlay Slide In Bottom',
                  'overlay-slide-in-left' => 'Overlay Slide In Left',
                  'overlay-slide-in-right' => 'Overlay Slide In Right',
                ),
              ),
              array(
                'name'        => 'out_class',
                'label'       => __('Animation OUT', 'wp-ng'),
                'default'     => 'fade-out',
                'type'        => 'select',
                'options'     => array(
                  'no-anim-out' => 'No Animation Out',
                  'fade-out' => 'Fade Out',
                  'fade-out-up-sm' => 'Fade Out Up Sm',
                  'fade-out-up' => 'Fade Out Up',
                  'fade-out-up-lg' => 'Fade Out Up Lg',
                  'fade-out-down-sm' => 'Fade Out Down Sm',
                  'fade-out-down' => 'Fade Out Down',
                  'fade-out-down-lg' => 'Fade Out Ddown Lg',
                  'fade-out-left-sm' => 'Fade Out Left Sm',
                  'fade-out-left' => 'Fade Out Left',
                  'fade-out-left-lg' => 'Fade Out Left Lg',
                  'fade-out-right-sm' => 'Fade Out Right Sm',
                  'fade-out-right' => 'Fade Out Right',
                  'fade-out-right-lg' => 'Fade Out Right Lg',
                  'rotate-out-sm' => 'Rotate Out Sm',
                  'rotate-out' => 'Rotate Out',
                  'rotate-out-lg' => 'Rotate Out Lg',
                  'flip-out-x-fr' => 'Flip Out X Fr',
                  'flip-out-x' => 'Flip Out X',
                  'flip-out-x-nr' => 'Flip Out X Nr',
                  'flip-out-y-fr' => 'Flip Out Y Fr',
                  'flip-out-y' => 'Flip Out Y',
                  'flip-out-y-nr' => 'Flip Out Y Nr',
                  'zoom-out-sm' => 'Zoom Out Sm',
                  'zoom-out' => 'Zoom Out',
                  'zoom-out-lg' => 'Zoom Out Lg',
                  'overlay-slide-out-top' => 'Overlay Slide Out Top',
                  'overlay-slide-out-bottom' => 'Overlay Slide Out Bottom',
                  'overlay-slide-out-left' => 'Overlay Slide Out Left',
                  'overlay-slide-out-right' => 'Overlay Slide Out Right',
                ),
              ),
              array(
                'name'        => 'in_duration',
                'label'       => __( 'In Duration', 'wp-ng'),
                'desc'        => __( 'In Duration', 'wp-ng'),
                'type'        => 'number',
                'default'     => 1500,
              ),
              array(
                'name'        => 'out_duration',
                'label'       => __( 'Out Duration', 'wp-ng'),
                'desc'        => __( 'Out Duration', 'wp-ng'),
                'type'        => 'number',
                'default'     => 800,
              ),
              array(
                'name'        => 'timeout',
                'label'       => __('Timeout', 'wp-ng'),
                'desc'        => __('Timeout', 'wp-ng'),
                'default'     => 'on',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'timeout_countdown',
                'label'       => __( 'Timeout Countdown', 'wp-ng'),
                'desc'        => __( 'Timeout Countdown', 'wp-ng'),
                'type'        => 'number',
                'default'     => 3000,
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
          array(
            'name'        => 'scrollify',
            'label'       => __('Scrollify', 'wp-ng'),
            'title'       => 'scrollify',
            'desc'        => wp_ng_settings_sections_desc_html(
              'Scrollify',
              __( 'A jQuery plugin that assists scrolling and snaps to sections. Touch optimised.', 'wp-ng'),
              '',
              'https://github.com/lukehaas/Scrollify',
              'https://projects.lukehaas.me/scrollify/#home'
            ),
            'type'        => 'sub_fields',
            'sub_fields'  => array(
              array(
                'name'        => 'active',
                'label'       => 'Active',
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'section',
                'label'       => __('Section Element', 'wp-ng'),
                'default'     => '[data-section-name]',
                'placeholder' => __('Section Element', 'wp-ng') . '( [data-section-name] )',
                'type'        => 'text',
              ),
              array(
                'name'        => 'section_name',
                'label'       => __('Section Name', 'wp-ng'),
                'default'     => 'section-name',
                'placeholder' => __('Section Name', 'wp-ng') . '( section-name )',
                'type'        => 'text',
              ),
              array(
                'name'        => 'interstitial_section',
                'label'       => __('Interstitial Section Element', 'wp-ng'),
                'default'     => '',
                'placeholder' => __('Interstitial Section Element', 'wp-ng') . ' ( .header,.footer )',
                'type'        => 'text',
              ),
              array(
                'name'        => 'move_click',
                'label'       => __('Click Move Element', 'wp-ng'),
                'default'     => '.scrollify-move',
                'placeholder' => __('Click Move Element', 'wp-ng') . ' ( .scrollify-move )',
                'type'        => 'text',
              ),
              array(
                'name'        => 'next_click',
                'label'       => __('Click Next Element', 'wp-ng'),
                'default'     => '.scrollify-next',
                'placeholder' => __('Click Next Element', 'wp-ng') . '( .scrollify-next )',
                'type'        => 'text',
              ),
              array(
                'name'        => 'offset',
                'label'       => __('Offset', 'wp-ng'),
                'desc'        => __('A distance in pixels to offset each sections position by', 'wp-ng'),
                'default'     => '0',
                'type'        => 'number',
              ),
              array(
                'name'        => 'touch_scroll',
                'label'       => __('Touch Scroll', 'wp-ng'),
                'desc'        => __('Enable Scrollify on touch device', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
              ),
              array(
                'name'        => 'scroll_speed',
                'label'       => __('Speed Scroll', 'wp-ng'),
                'desc'        => __('Speed Scroll', 'wp-ng'),
                'default'     => 1100,
                'type'        => 'text',
              ),
              array(
                'name'        => 'easing',
                'label'       => __('Easing Scroll', 'wp-ng'),
                'desc'        => __('Easing Scroll', 'wp-ng'),
                'default'     => 'easeOutExpo',
                'type'        => 'text',
              ),
              array(
                'name'        => 'conditions',
                'label'       => 'Conditions',
                'desc'        => __( 'Load on conditions.', 'wp-ng'),
                'default'     => 'off',
                'type'        => 'checkbox',
                'conditions'  => true,
              ),
            ),
          ),
        ),
      ),
    ),
  );

  return $fields;
}
add_filter('wp_ng_settings_fields', 'wp_ng_scripts_fields');










