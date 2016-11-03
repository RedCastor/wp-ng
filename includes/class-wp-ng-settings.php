<?php

/**
 * The file that defines the settings plugin class
 * based on https://github.com/tareq1988/wordpress-settings-api-class
 *
 * @link       http://redcastor.io
 * @since      1.0.0
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 */

/**
 * The Settings plugin class.
 *
 * @since      1.0.0
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Settings {


  private $settings_prefix = '';


  /**
   * settings sections array
   *
   * @var array
   */
  protected $settings_tabs = array();

  /**
   * settings sections array
   *
   * @var array
   */
  protected $settings_sections = array();

  /**
   * Settings fields array
   *
   * @var array
   */
  protected $settings_fields = array();

  /**
   * @var Singleton
   * @access private
   * @static
   */
  private static $_instance = array();


  /**
   * Get the default field
   *
   * @param $field
   * @return array
   */
  private function get_default_field( $field ) {

    $default_field = array(
      'global'            => isset($field['global']) ? $field['global'] : false,
      'name'              => $field['name'],
      'action'            => isset($field['action']) ? $field['action'] : '',
      'label'             => isset($field['label']) ? $field['label'] : str_replace('_', ' ', ucwords($field['name'], '_')),
      'desc'              => isset($field['desc']) ? $field['desc'] : '',
      'type'              => isset($field['type']) ? $field['type'] : 'text',
      'placeholder'       => isset($field['placeholder']) ? $field['placeholder'] : '',
      'default'           => isset($field['default']) ? $field['default'] : '',
      'sanitize_callback' => isset($field['sanitize_callback']) ? $field['sanitize_callback'] : '',
    );

    return $default_field;
  }

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $name  the name of the prefix options
   */
  public function __construct( $name, $version) {

    $this->settings_prefix = $name;


    $version_option = $this->settings_prefix . '_version';

    if( get_option($version_option) !== $version) {
      //Version
      $current_version    = get_option( $version_option, null );
      $major_version      = substr( $version, 0, strrpos( $version, '.' ) );

      delete_option( $version_option );
      add_option( $version_option, $version );
    }

    self::$_instance[$name]['version'] = $version;

    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
  }


  /**
   *
   * @param void
   * @return Singleton
   */
  public static function createInstance( $name, $version ) {

    if(!isset(self::$_instance[$name])) {
      self::$_instance[$name]['instance'] = new Wp_Ng_Settings( $name, $version );
    }

    return self::$_instance[$name]['instance'];
  }


  /**
   *
   * @param string name
   * @return Singleton
   */
  public static function getInstance( $name ) {

    if(!isset(self::$_instance[$name])) {
      return NULL;
    }

    return self::$_instance[$name]['instance'];
  }

  /**
   * Enqueue scripts and styles
   */
  public function admin_enqueue_scripts() {
    wp_enqueue_style( 'wp-color-picker' );

    wp_enqueue_media();
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script( 'jquery' );
  }


  /**
   * Register fields
   *
   * @param $fields
   */
  public function register_fields( $fields ) {

    foreach ($fields as $tab_key => $tabs) {

      $tabs_descriptor[] = array(
        'id' => $tab_key,
        'title' => $tabs['title']
      );

      foreach ($tabs['sections'] as $section_key => $sections) {

        $sections_descriptor[$tab_key][] = array(
          'id' => $section_key,
          'title' => $sections['title']
        );

        foreach ($sections['fields'] as $field ) {

          if ( !isset($field['name']) || empty($field['name']) ) {
            continue;
          }

          $default_field = $this->get_default_field( $field );
          $arg = wp_parse_args( $field, $default_field );

          $fields_descriptor[$tab_key][$section_key][] = $arg;
        };
      };
    };

    $this->register( $tabs_descriptor, $sections_descriptor, $fields_descriptor );
  }

  /**
   *  Register tabs, sections and fields
   *
   * @param $tabs
   * @param $sections
   * @param $fields
   */
  public function register( $tabs, $sections, $fields ) {

    $this->set_tabs( $tabs );
    $this->set_sections( $sections );
    $this->set_fields( $fields );
  }

  /**
   * Set settings tabs
   *
   * @param array   $tabs setting tabs array
   * @return $this
   */
  public function set_tabs( $tabs ) {
    $this->settings_tabs = $tabs;

    return $this;
  }

  /**
   * Get settings tabs
   *
   * @param array   $tabs getting tabs array
   * @return $this
   */
  public function get_tabs() {
    return $this->settings_tabs;
  }

  /**
   * Add a single tab
   *
   * @param array   $tab
   * @return $this
   */
  public function add_tab( $tab ) {
    $this->settings_tabs[] = $tab;

    return $this;
  }

  /**
   * Set settings sections
   *
   * @param array   $sections setting sections array
   * @return $this
   */
  public function set_sections( $sections ) {
    $this->settings_sections = $sections;

    return $this;
  }

  /**
   * Get settings sections
   *
   * @param array   $sections getting sections array
   * @return $this
   */
  public function get_sections() {
    return $this->settings_sections;
  }

  /**
   * Add a single section
   *
   * @param array   $section
   * @return $this
   */
  public function add_section( $section ) {
    $this->settings_sections[] = $section;

    return $this;
  }

  /**
   * Set settings fields
   *
   * @param array   $fields settings fields array
   * @return $this
   */
  public function set_fields( $fields ) {
    $this->settings_fields = $fields;

    return $this;
  }

  /**
   * Get settings fields
   *
   * @param array   $fields settings fields array
   * @return $this
   */
  public function get_fields() {
    return $this->settings_fields;
  }

  /**
   * Add Fields
   *
   * @param $section
   * @param $field
   * @return $this
   */
  public function add_field( $tab, $section, $field ) {

    $default_field = $this->get_default_field( $field );

    $arg = wp_parse_args( $field, $default_field );
    $this->settings_fields[$tab][$section][] = $arg;

    return $this;
  }

  public function get_option_prefix ( $option ) {
    return $this->settings_prefix . '_' . $option;
  }

  public function get_define_name ( $option ) {
    return strtoupper( str_replace('-', '_', $this->get_option_prefix($option) ) );
  }

  public function get_option_theme_support ( $option ) {
    global $_wp_theme_features;

    if( defined( $this->get_define_name($option) ) ) {
      return constant($this->get_define_name($option));
    }

    $option_name = $this->get_option_prefix($option);

    return ( isset($_wp_theme_features[ $option_name ][0]) && is_string($_wp_theme_features[ $option_name ][0]) ) ? $_wp_theme_features[ $option_name ][0] : '';

  }

  public function is_disabled ( $option ) {
    $option_name = $this->get_option_prefix($option);

    if( defined($this->get_define_name($option)) ) {
      return true;
    }
    else if ( current_theme_supports( $option_name ) ) {
      if ( !empty( $this->get_option_theme_support($option)) ) {
        return true;
      }
    }

    return false;
  }

  /**
   * Initialize and registers the settings sections and fileds to WordPress
   *
   * Usually this should be called at `admin_init` hook.
   *
   * This function gets the initiated settings sections and fields. Then
   * registers them to WordPress and ready for use.
   */
  public function admin_init() {
    //register settings sections
    foreach ( $this->settings_sections as $tab_key => $sections ) {
      foreach ($sections as $section){
        if ( false == get_option( $this->get_option_prefix($section['id']) ) ) {
          add_option( $this->get_option_prefix($section['id']) );
        }

        if ( isset($section['desc']) && !empty($section['desc']) ) {
          $section['desc'] = '<div class="inside">'.$section['desc'].'</div>';
          $callback = create_function('', 'echo "'.str_replace('"', '\"', $section['desc']).'";');
        } else if ( isset( $section['callback'] ) ) {
          $callback = $section['callback'];
        } else {
          $callback = null;
        }

        add_settings_section( $section['id'], $section['title'], $callback, $tab_key );
      }
    }

    //register settings fields
    foreach ( $this->settings_fields as $tab_key => $sections ) {
      foreach ($sections  as $section_key => $field ) {
        foreach ($field as $option) {

          $type = isset($option['type']) ? $option['type'] : 'text';

          $disable = isset($option['disable']) ? boolval($option['disable']) : false;
          $disable = (isset( $option['global']) && $option['global'] === true && $this->is_disabled( $option['name'] ) ) ? true : $disable;

          $args = array(
            'id'          => $option['name'],
            'label_for'   => $args['label_for'] = "{$section_key}[{$option['name']}]",
            'desc'        => isset($option['desc']) ? $option['desc'] : '',
            'placeholder' => isset($option['placeholder']) ? $option['placeholder'] : '',
            'global'      => isset($option['global']) ? boolval($option['global']) : false,
            'name'        => $option['label'],
            'section'     => $section_key,
            'size'        => isset($option['size']) ? $option['size'] : null,
            'options'     => isset($option['options']) ? $option['options'] : '',
            'std'         => isset($option['default']) ? $option['default'] : '',
            'disable'     => $disable,
            'sanitize_callback' => isset($option['sanitize_callback']) ? $option['sanitize_callback'] : '',
            'type'        => $type,
          );

          if ($args['global'] === true) {
            $setting_id = $this->get_option_prefix( $option['name'] );
            register_setting($tab_key, $setting_id, (isset($option['sanitize_callback']) && is_callable($option['sanitize_callback'])) ? $option['sanitize_callback'] : false);
          } else {
            $setting_id = $this->get_option_prefix( $section_key . '[' . $option['name'] . ']' );
          }

          add_settings_field($setting_id, $option['label'], array($this, 'callback_' . $type), $tab_key, $section_key, $args);
        }
      }
    }

    // creates our settings in the options table
    foreach ( $this->settings_sections as $tab_key => $sections ) {
      foreach ($sections as $section) {
        register_setting( $tab_key, $this->get_option_prefix( $section['id'] ), array( $this, 'sanitize_options' ) );
      }
    }

  }

  /**
   * Get field description for display
   *
   * @param array   $args settings field args
   */
  public function get_field_description( $args ) {
    if ( ! empty( $args['desc'] ) ) {
      $desc = sprintf( '<p class="description">%s</p>', $args['desc'] );
    } else {
      $desc = '';
    }

    return $desc;
  }

  /**
   * Displays a text field for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_text( $args ) {


    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] ) );
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
    $type  = isset( $args['type'] ) ? $args['type'] : 'text';
    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';
    $placeholder = isset( $args['placeholder'] ) ? $args['placeholder'] : '';

    $html  = sprintf( '<input type="%1$s" class="%2$s-text" id="%3$s" name="%3$s" value="%4$s" placeholder="%5$s" %6$s/>', $type, $size, $name_id, $value, $placeholder, $disable);
    $html  .= $this->get_field_description( $args );

    echo $html;
  }

  /**
   * Displays a url field for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_url( $args ) {
    $this->callback_text( $args );
  }

  /**
   * Displays a number field for a settings field
   *
   * @param array   $args settings field args
   */
  public  function callback_number( $args ) {
    $this->callback_text( $args );
  }

  /**
   * Displays a checkbox for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_checkbox( $args ) {

    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] ) );
    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';

    $html  = '<fieldset>';
    $html  .= sprintf( '<label for="wpuf-%1$s">', $name_id );
    $html  .= sprintf( '<input type="hidden" name="%1$s" value="off" />', $name_id );
    $html  .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s" name="%1$s" value="on" %2$s %3$s/>', $name_id, checked( $value, 'on', false ), $disable );
    $html  .= sprintf( '%1$s</label>', $args['desc'] );
    $html  .= '</fieldset>';

    echo $html;
  }

  /**
   * Displays a multicheckbox a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_multicheck( $args ) {

    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';
    $html  = '<fieldset>';

    foreach ( $args['options'] as $key => $label ) {
      $checked = isset( $value[$key] ) ? $value[$key] : '0';
      $html    .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $name_id, $key );
      $html    .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="%2$s" %3$s %4$s/>', $name_id, $key, checked( $checked, $key, false ), $disable );
      $html    .= sprintf( '%1$s</label><br>',  $label );
    }

    $html .= $this->get_field_description( $args );
    $html .= '</fieldset>';

    echo $html;
  }

  /**
   * Displays a multicheckbox a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_radio( $args ) {

    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';
    $html  = '<fieldset>';

    foreach ( $args['options'] as $key => $label ) {
      $html .= sprintf( '<label for="wpuf-%1$s[%2$s]">', $name_id, $key );
      $html .= sprintf( '<input type="radio" class="radio" id="wpuf-%1$s[%2$s]" name="%1$s" value="%2$s" %3$s %4$s/>', $name_id, $key, checked( $value, $key, false ), $disable );
      $html .= sprintf( '%1$s</label><br>', $label );
    }

    $html .= $this->get_field_description( $args );
    $html .= '</fieldset>';

    echo $html;
  }

  /**
   * Displays a selectbox for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_select( $args ) {

    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] ) );
    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
    $html  = sprintf( '<select class="%1$s" name="%2$s" id="%2$s" %3$s>', $size, $name_id, $disable );

    foreach ( $args['options'] as $key => $label ) {
      $html .= sprintf( '<option value="%s"%s>%s</option>', $key, selected( $value, $key, false ), $label );
    }

    $html .= sprintf( '</select>' );
    $html .= $this->get_field_description( $args );

    echo $html;
  }

  /**
   * Displays a textarea for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_textarea( $args ) {

    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = esc_textarea( $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] ) );
    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

    $html  = sprintf( '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s" name="%2$s" %4$s>%3$s</textarea>', $size, $name_id, $value, $disable );
    $html  .= $this->get_field_description( $args );

    echo $html;
  }

  /**
   * Displays a textarea for a settings field
   *
   * @param array   $args settings field args
   * @return string
   */
  private function callback_html( $args ) {
    echo $this->get_field_description( $args );
  }

  /**
   * Displays a rich text textarea for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_wysiwyg( $args ) {

    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : '500px';

    echo '<div style="max-width: ' . $size . ';">';

    $editor_settings = array(
      'teeny'         => true,
      'textarea_name' => $name_id,
      'textarea_rows' => 10
    );

    if ( isset( $args['options'] ) && is_array( $args['options'] ) ) {
      $editor_settings = array_merge( $editor_settings, $args['options'] );
    }

    wp_editor( $value, $args['section'] . '-' . $args['id'], $editor_settings );

    echo '</div>';

    echo $this->get_field_description( $args );
  }

  /**
   * Displays a file upload field for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_file( $args ) {

    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] ) );
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
    $id    = $args['section']  . '[' . $args['id'] . ']';
    $label = isset( $args['options']['button_label'] ) ? $args['options']['button_label'] : __( 'Choose File' );

    $html  = sprintf( '<input type="text" class="%1$s-text wpsa-url" id="%2$s" name="%2$s" value="%3$s"/>', $size, $name_id, $value );
    $html  .= '<input type="button" class="button wpsa-browse" value="' . $label . '" />';
    $html  .= $this->get_field_description( $args );

    echo $html;
  }

  /**
   * Displays a password field for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_password( $args ) {

    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] ) );
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

    $html  = sprintf( '<input type="password" class="%1$s-text" id="%2$s" name="%2$s" value="%3$s"/>', $size, $name_id, $value );
    $html  .= $this->get_field_description( $args );

    echo $html;
  }

  /**
   * Displays a color picker field for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_color( $args ) {

    $name_id =  ( isset($args['global']) && $args['global'] === true ) ? $this->get_option_prefix( '%2$s' ) : $this->get_option_prefix( '%1$s[%2$s]' );
    $name_id = sprintf( $name_id, $args['section'], $args['id'] );
    $value = esc_attr( $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] ) );
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';

    $html  = sprintf( '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s" name="%2$s" value="%3$s" data-default-color="%4$s" />', $size, $name_id, $value, $args['std'] );
    $html  .= $this->get_field_description( $args );

    echo $html;
  }

  /**
   * Sanitize callback for Settings API
   */
  public function sanitize_options( $options ) {

    $options_to_sanitize = $options;

    if( !is_array($options)) {
      $options_to_sanitize = array($options);
    }

    foreach( $options_to_sanitize as $option_slug => $option_value ) {
      $sanitize_callback = $this->get_sanitize_callback( $option_slug );

      // If callback is set, call it
      if ( $sanitize_callback ) {
        $options_to_sanitize[ $option_slug ] = call_user_func( $sanitize_callback, $option_value );
        continue;
      }
    }

    if( !is_array($options)) {
      return $options_to_sanitize[0];
    }

    return $options_to_sanitize;
  }

  /**
   * Get sanitization callback for given option slug
   *
   * @param string $slug option slug
   *
   * @return mixed string or bool false
   */
  public function get_sanitize_callback( $slug = '' ) {
    if ( empty( $slug ) ) {
      return false;
    }

    // Iterate over registered fields and see if we can find proper callback
    foreach( $this->settings_fields as $tab_key => $sections ) {
      foreach ($sections as $section_key => $field ) {
        foreach ( $field as $option ) {
          if ( $option['name'] != $slug ) {
            continue;
          }

          // Return the callback name
          return isset( $option['sanitize_callback'] ) && is_callable( $option['sanitize_callback'] ) ? $option['sanitize_callback'] : false;
        }
      }
    }

    return false;
  }

  /**
   * Get the value of a settings field
   *
   * @param string  $option  settings field name
   * @param string  $section the section name this field belongs to
   * @param string  $default default text if it's not found
   * @return string
   */
  public function get_option( $option, $section, $default = '', $global = false ) {

    if ( $global === true ) {

      $option_name = $this->get_option_prefix($option);

      //Return if $option is disabled
      if ( $this->is_disabled( $option ) ) {
        return $this->get_option_theme_support( $option );
      }
      $options[$option] = get_option( $option_name );
    }
    else {

      $option_name = $this->get_option_prefix( $section );

      $options = get_option( $option_name );
    }


    if ( isset($options[$option]) && $options[$option] ) {
      return $options[$option];
    }

    return $default;
  }

  /**
   * Tabbable JavaScript codes & Initiate Color Picker
   *
   * This code uses localstorage for displaying active tabs
   */
  private function script() {
    ?>
    <script>
      jQuery(document).ready(function($) {
        //Initiate Color Picker
        $('.wp-color-picker-field').wpColorPicker();

        // Switches option sections
        $('.group').hide();
        var activetab = '';
        if (typeof(localStorage) != 'undefined' ) {
          activetab = localStorage.getItem("activetab");
        }
        if (activetab != '' && $(activetab).length ) {
          $(activetab).fadeIn();
        } else {
          $('.group:first').fadeIn();
        }
        $('.group .collapsed').each(function(){
          $(this).find('input:checked').parent().parent().parent().nextAll().each(
            function(){
              if ($(this).hasClass('last')) {
                $(this).removeClass('hidden');
                return false;
              }
              $(this).filter('.hidden').removeClass('hidden');
            });
        });

        if (activetab != '' && $(activetab + '-tab').length ) {
          $(activetab + '-tab').addClass('nav-tab-active');
        }
        else {
          $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
        }
        $('.nav-tab-wrapper a').click(function(evt) {
          $('.nav-tab-wrapper a').removeClass('nav-tab-active');
          $(this).addClass('nav-tab-active').blur();
          var clicked_group = $(this).attr('href');
          if (typeof(localStorage) != 'undefined' ) {
            localStorage.setItem("activetab", $(this).attr('href'));
          }
          $('.group').hide();
          $(clicked_group).fadeIn();
          evt.preventDefault();
        });

        $('.wpsa-browse').on('click', function (event) {
          event.preventDefault();

          var self = $(this);

          // Create the media frame.
          var file_frame = wp.media.frames.file_frame = wp.media({
            title: self.data('uploader_title'),
            button: {
              text: self.data('uploader_button_text'),
            },
            multiple: false
          });

          file_frame.on('select', function () {
            attachment = file_frame.state().get('selection').first().toJSON();

            self.prev('.wpsa-url').val(attachment.url);
          });

          // Finally, open the modal
          file_frame.open();
        });
      });
    </script>

    <style type="text/css">
      /** WordPress 3.8 Fix **/
      .form-table th { padding: 20px 10px; }
      #wpbody-content .metabox-holder { padding-top: 5px; }
    </style>
    <?php
  }

  /**
   * Show navigations as tab
   *
   * Shows all the settings section labels as tab
   */
  public function show_navigation() {

    echo '<h1>' . esc_html( get_admin_page_title() ) . '</h1>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach ( $this->settings_tabs as $tab ) {
      printf( '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>', $tab['id'], $tab['title'] );
    }
    echo '</h2>';

    //settings_errors();

  }

  /**
   * Show the section settings forms
   *
   * This function displays every sections in a different form
   */
  public function show_forms() {
    ?>
    <div class="metabox-holder">
      <?php foreach ( $this->settings_tabs as $tab ) { ?>
        <div id="<?php echo $tab['id']; ?>" class="group" style="display: none;">
          <form method="post" action="options.php">
            <?php
            do_action( 'wp_ng_settings_form_top_' . $tab['id'], $tab );
            settings_fields( $tab['id'] );
            do_settings_sections( $tab['id'] );
            do_action( 'wp_ng_settings_form_bottom_' . $tab['id'], $tab );
            ?>
            <div style="padding-left: 10px">
              <?php submit_button(); ?>
            </div>
          </form>
        </div>
      <?php } ?>
    </div>
    <?php
    $this->script();
  }


  /**
   * Render settings page
   */
  public function render_settings_page() {

    echo '<div class="wrap wrap-plugin-settings">';

    $this->show_navigation();
    $this->show_forms();

    echo '</div>';
  }

}
