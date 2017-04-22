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
        'title' => $tabs['title'],
      );

      foreach ($tabs['sections'] as $section_key => $sections) {

        $sections_descriptor[$tab_key][] = array(
          'id'      => $section_key,
          'title'   => isset ($sections['title']) ? $sections['title'] : '',
          'desc'    => isset ($sections['desc']) ? $sections['desc'] : '',
          'display' => isset ($sections['display']) ? $sections['display'] : '',
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

  /**
   * Get the option with the prefix
   *
   * @param $option
   *
   * @return string
   */
  public function get_option_prefix ( $option ) {

    return $this->settings_prefix . '_' . $option;
  }

  /**
   * Define a option by replace dash to underscore and set upper case
   *
   * @param $option
   *
   * @return string
   */
  public function get_define_name ( $option ) {
    return strtoupper( str_replace('-', '_', $this->get_option_prefix($option) ) );
  }

  /**
   * Get option from theme support
   * @param $option
   *
   * @return mixed|string
   */
  public function get_option_support ( $option ) {

    $option_value = $this->get_option_defined( $option );
    if ( !empty($option_value) ) {
      return $option_value;
    }

    //Option plugin support
    $option_plugins = $this->get_option_plugin_supports( $option );

    //Option theme support
    $option_theme = $this->get_option_theme_supports( $option );

    // If is empty option theme return option plugins
    if ( empty($option_theme) ) {
      return $option_plugins;
    }

    //If 2 array merge.
    if (is_array($option_plugins) && is_array($option_theme)) {
      return  array_merge($option_plugins, $option_theme);
    }

    if ( !empty($option_plugins) ) {
      return $option_plugins;
    }

    if ( !empty($option_theme) ) {
      return $option_theme;
    }

    return '';
  }


  /**
   * Get option from theme support
   * @param $option
   *
   * @return mixed|string
   */
  public function get_option_plugin_supports ( $option ) {
    global $_wp_ng_plugin_features;

    $option_name = $this->get_option_prefix($option);

    if (isset($_wp_ng_plugin_features[ $option_name ][0])) {
      return $_wp_ng_plugin_features[ $option_name ][0];
    }

    return '';
  }

  /**
   * Get option from theme support
   * @param $option
   *
   * @return mixed|string
   */
  public function get_option_theme_supports ( $option ) {
    global $_wp_theme_features;

    $option_name = $this->get_option_prefix($option);

    if (isset($_wp_theme_features[ $option_name ][0])) {
      return $_wp_theme_features[ $option_name ][0];
    }

    return '';
  }

  /**
   * Get option from theme support
   * @param $option
   *
   * @return mixed|string
   */
  public function get_option_defined ( $option ) {

    if( defined( $this->get_define_name($option) ) ) {
      return constant($this->get_define_name($option));
    }

    return '';
  }

  /**
   * Is option disable
   *
   * @param $option
   *
   * @return bool
   */
  public function is_disabled ( $option, $global = true, $section_key = '' ) {

    if ($global === true) {
      $option_name = $this->get_option_prefix($option);

      if( defined($this->get_define_name($option)) ) {
        return true;
      }
      else if ( current_theme_supports( $option_name ) || wp_ng_plugin_supports( $option_name ) ) {
        if ( !empty( $this->get_option_support($option)) ) {
          return true;
        }
      }
    }
    else {
      $option_name = $this->get_option_prefix( $section_key );

      if ( current_theme_supports( $option_name ) || wp_ng_plugin_supports( $option_name ) ) {
        $options = $this->get_option_support($section_key);

        if ( !empty($options) && (in_array($option, $options) || array_key_exists($option, $options) ) ) {
          return true;
        }
      }
    }



    return false;
  }

  /**
   * Get Conditions
   *
   * @return array
   */
  public function get_conditions () {

    $conditions = array(
      'is_home'               => __('Is Home',                $this->settings_prefix),
      'is_front_page'         => __('Is Front page',          $this->settings_prefix),
      'is_home&is_front_page' => __('Is Home and Front page', $this->settings_prefix),
      'is_single'             => __('Is Single',              $this->settings_prefix),
      'is_sticky'             => __('Is Sticky',              $this->settings_prefix),
      'is_page'               => __('Is Page',                $this->settings_prefix),
      'is_page_template'      => __('Is Page Template',       $this->settings_prefix),
      'is_category'           => __('Is Category',            $this->settings_prefix),
      'is_tag'                => __('Is Tag',                 $this->settings_prefix),
      'is_tax'                => __('Is Taxonomy',            $this->settings_prefix),
      'is_author'             => __('Is Author ',             $this->settings_prefix),
      'is_archive'            => __('Is Archive',             $this->settings_prefix),
      'is_search'             => __('Is Search',              $this->settings_prefix),
      'is_404'                => __('Is 404',                 $this->settings_prefix),
      'is_singular'           => __('Is Singular',            $this->settings_prefix),
      'is_user_logged_in'     => __('Is User Logged In',      $this->settings_prefix),
    );

    //Get Page list with page id in string value
    foreach ( wp_list_pluck(get_pages(), 'post_title', 'ID') as $page_id => $page_title) {
      $conditions['is_page$' . strval($page_id)] = sprintf( '%s %s', __('Page', $this->settings_prefix), $page_title);
    }

    //Get all page templates list
    $templates = get_page_templates();
    foreach ( $templates as $template_name => $template_filename ) {
      $conditions[ 'is_page_template$' . $template_filename] = sprintf( '%s %s', __('Page Template ', $this->settings_prefix), $template_name);
    }

    //Get all post type list
    $post_types = get_post_types(
      array(
        'show_ui' => true,
      ),
      'objects'
    );

    foreach ( $post_types as $post_type ) {
      $conditions[$post_type->name] = sprintf( '%s %s', __('Post Type ', $this->settings_prefix), $post_type->name);
    }

    //Woocommerce conditions
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

      $conditions['is_woocommerce']       = __('Is Woocommerce',  $this->settings_prefix);
      $conditions['is_shop']              = __('Is Shop',         $this->settings_prefix);
      $conditions['is_product_category']  = __('Is Product Category', $this->settings_prefix);
      $conditions['is_product_tag']       = __('Is Product Tag',  $this->settings_prefix);
      $conditions['is_product']           = __('Is Product',      $this->settings_prefix);
      $conditions['is_cart']              = __('Is Cart',         $this->settings_prefix);
      $conditions['is_checkout']          = __('Is Checkout',     $this->settings_prefix);
      $conditions['is_account_page']      = __('Is Account Page', $this->settings_prefix);
      $conditions['is_wc_endpoint_url']   = __('Is Endpoint Url', $this->settings_prefix);
      $conditions['is_ajax']              = __('Is Ajax',         $this->settings_prefix);
    }

    return $conditions;
  }


  /**
   * Set defaulut field args
   *
   * @param $field_args
   * @param $tab_key
   * @param $section_key
   *
   * @return array
   */
  public function set_default_field_args( $field_args, $tab_key, $section_key ) {

    $type = isset($field_args['type']) ? $field_args['type'] : 'text';
    $conditions = isset($field_args['conditions']) ? $field_args['conditions'] : false;

    $disable = isset($field_args['disable']) ? boolval($field_args['disable']) : false;

    if ( isset($field_args['global']) && $field_args['global'] === true) {
      $disable = $this->is_disabled( $field_args['name'] ) ? true : $disable;
      $name_id = $this->get_option_prefix( $field_args['name'] );
    }
    else if ( isset($field_args['parent']) ) {
      $disable = $this->is_disabled( $field_args['name'], false, $section_key ) ? true : $disable;
      $name_id = $field_args['parent']['name_id'] . '[' . $field_args['name'] . ']';
    }
    else {
      $disable = $this->is_disabled( $field_args['name'], false, $section_key ) ? true : $disable;
      $name_id = $this->get_option_prefix($section_key . '[' . $field_args['name'] . ']');
    }

    $args = array(
      'id'          => $field_args['name'],
      'name_id'     => $name_id,
      'label_for'   => $args['label_for'] = "{$section_key}[{$field_args['name']}]",
      'desc'        => isset($field_args['desc']) ? $field_args['desc'] : '',
      'placeholder' => isset($field_args['placeholder']) ? $field_args['placeholder'] : '',
      'global'      => isset($field_args['global']) ? boolval($field_args['global']) : false,
      'label'       => isset($field_args['label']) ? $field_args['label'] : '',
      'title'       => isset($field_args['title']) ? $field_args['title'] : '',
      'tab'         => $tab_key,
      'section'     => $section_key,
      'parent'      => isset($field_args['parent']) ? $field_args['parent'] : false,
      'size'        => isset($field_args['size']) ? $field_args['size'] : null,
      'options'     => isset($field_args['options']) ? $field_args['options'] : '',
      'std'         => isset($field_args['default']) ? $field_args['default'] : '',
      'disable'     => $disable,
      'sanitize_callback' => isset($field_args['sanitize_callback']) ? $field_args['sanitize_callback'] : '',
      'type'        => $type,
      'sub_fields'  => ( $type === 'sub_fields' && isset($field_args['sub_fields']) ) ? $field_args['sub_fields'] : false,
      'display'     => (isset($field_args['display'])) ? $field_args['display'] : '',
      'conditions'  => $conditions
    );

    return $args;
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
        foreach ($field as $field_args) {

          $args = $this->set_default_field_args( $field_args, $tab_key, $section_key );

          if ($args['global'] === true) {
            register_setting($tab_key, $args['name_id'], (is_callable($args['sanitize_callback'])) ? $args['sanitize_callback'] : false);
          }

          add_settings_field($args['name_id'], $args['label'], array($this, 'callback_' . $args['type']), $tab_key, $section_key, $args);

          if ($args['sub_fields']) {

            foreach ( $args['sub_fields'] as $sub_field_args ) {
              $sub_field_args['parent'] = $args;
              $sub_args = $this->set_default_field_args( $sub_field_args, $tab_key, $section_key );

              add_settings_field($sub_args['name_id'], $sub_args['label'], array($this, 'callback_' . $sub_args['type']), $tab_key, $section_key, $sub_args);
            }

          }
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
   * Get field condition modal for display
   *
   * @param $args
   *
   * @return string
   */
  public function get_field_conditions_modal( $args ) {

    $name_id = $args['name_id'];
    $elment_id = str_replace( '.', '--', $name_id );
    $elment_id = str_replace( '[', '_', $elment_id );
    $elment_id = str_replace( ']', '', $elment_id );
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
      $args['disable'] = (isset( $args['parent']['disable'])) ? $args['parent']['disable'] : false;
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }

    $value = (isset($value['options']) && is_array($value['options'])) ? $value['options'] : array();
    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';


    $options = $this->get_conditions();

    $multiselect_html = sprintf( '<select multiple="multiple" class="%1$s-multi-select-field" name="%2$s[]" id="%3$s_conditions" %4$s>', $this->settings_prefix, $name_id, $elment_id, $disable );

    foreach ( $options as $key => $label ) {
      $selected = (is_array($value) && in_array( $key, $value )) ? $key : '0';
      $multiselect_html .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $selected, $key, false ), $label );
    }

    $multiselect_html .= sprintf( '</select>' );

    add_thickbox();

    $html = sprintf( '<a href="#TB_inline?&height=270&width=370&inlineId=wp_ng_modal_%1$s" title="%2$s" class="button button-conditions thickbox">%3$s</a>', $elment_id, __('Select your conditions', $this->settings_prefix), __('Conditions', $this->settings_prefix) );
    $html .= sprintf( '<div id="wp_ng_modal_%1$s" style="display:none;"><p>%2$s</p></div>', $elment_id, $multiselect_html );

    return $html;
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
  public function callback_sub_fields( $args ) {

    if ( $args['desc'] ) {
      echo $args['desc'];
    }

  }

  /**
   * Displays a text field for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_text( $args ) {

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
      $args['disable'] = (isset( $args['parent']['disable'])) ? $args['parent']['disable'] : false;
    }
    else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }

    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
    $type  = isset( $args['type'] ) ? $args['type'] : 'text';
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
   * Displays a hidden field for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_hidden( $args ) {
    $args['desc'] = '';
    $this->callback_text( $args );
  }

  /**
   * Displays a checkbox for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_checkbox( $args ) {

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
      $args['disable'] = (isset( $args['parent']['disable'])) ? $args['parent']['disable'] : false;
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }

    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';

    $html_condtions = '';

    if ( isset($args['conditions']) && $args['conditions'] === true ) {
      $name_id .= '[value]';
      $value = isset($value['value']) ? $value['value'] : 'off';
      $args['name_id'] .= '[options]';
      $html_condtions = $this->get_field_conditions_modal( $args );
    }

    $html = '<fieldset>';
    $html .= sprintf( '<label for="wpuf-%1$s">', $name_id );
    $html .= sprintf( '<input type="hidden" name="%1$s" value="off" />', $name_id );
    $html .= sprintf( '<input type="checkbox" class="checkbox" id="wpuf-%1$s" name="%1$s" value="on" %2$s %3$s/>', $name_id, checked( $value, 'on', false ), $disable );
    $html .= sprintf( '%1$s</label>', $args['desc'] );
    $html .= $html_condtions;
    $html .= '</fieldset>';

    echo $html;
  }

  /**
   * Displays a multicheckbox a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_multicheck( $args ) {

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
      $args['disable'] = (isset( $args['parent']['disable'])) ? $args['parent']['disable'] : false;
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }

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

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
      $args['disable'] = (isset( $args['parent']['disable'])) ? $args['parent']['disable'] : false;
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }

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

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
      $args['disable'] = (isset( $args['parent']['disable'])) ? $args['parent']['disable'] : false;
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }

    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
    $html  = sprintf( '<select class="%1$s" name="%2$s" id="%2$s" %3$s>', $size, $name_id, $disable );

    foreach ( $args['options'] as $key => $label ) {
      $html .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value, $key, false ), $label );
    }

    $html .= sprintf( '</select>' );
    $html .= $this->get_field_description( $args );

    echo $html;
  }

  /**
   * Displays a multi selectbox for a settings field
   *
   * @param array   $args settings field args
   */
  public function callback_multiselect( $args ) {

    $name_id = $args['name_id'];
    $elment_id = str_replace( '.', '--', $name_id );
    $elment_id = str_replace( '[', '_', $elment_id );
    $elment_id = str_replace( ']', '', $elment_id );
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
      $args['disable'] = (isset( $args['parent']['disable'])) ? $args['parent']['disable'] : false;
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }

    $disable = (isset( $args['disable'] ) && $args['disable'] === true) ? 'disabled' : '';
    $size  = isset( $args['size'] ) && !is_null( $args['size'] ) ? $args['size'] : 'regular';
    $html  = sprintf( '<select multiple="multiple" class="%1$s %2$s-multi-select-field" name="%3$s[]" id="%4$s" %5$s>', $size, $this->settings_prefix, $name_id, $elment_id, $disable );

    foreach ( $args['options'] as $key => $label ) {
      $html .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value, $key, false ), $label );
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

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
      $args['disable'] = (isset( $args['parent']['disable'])) ? $args['parent']['disable'] : false;
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }

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

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }
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

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }
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

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }
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

    $name_id = $args['name_id'];
    if ($args['parent']) {
      $value = $this->get_option( $args['parent']['id'], $args['section'], $args['std'], $args['global'] );
      $value = isset($value[$args['id']]) ? $value[$args['id']] : $args['std'];
    }else {
      $value = $this->get_option( $args['id'], $args['section'], $args['std'], $args['global'] );
    }
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
        return $this->get_option_support( $option );
      }
      $options[$option] = get_option( $option_name );
    }
    else {

      $option_name = $this->get_option_prefix( $section );

      //Return if $option is disabled
      if ( $this->is_disabled( $option, false,  $section) ) {
        $options = $this->get_option_support( $section );

        if ( isset($options[$option]) ) {
          return $options[$option];
        }

        return array('active' => 'on');
      }

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

        //Add Class active or inactive and disabled on display table section with checkbox active column
        $( '.wp-list-table .check-column .checkbox' ).parents('tr').addClass('inactive');
        $( '.wp-list-table .check-column .checkbox:checked' ).parents('tr').removeClass('inactive');
        $( '.wp-list-table .check-column .checkbox:checked' ).parents('tr').addClass('active');
        $( '.wp-list-table .check-column .checkbox:disabled' ).parents('tr').addClass('disabled');



        //Initiate Multi Select
        $('.<?php echo $this->settings_prefix; ?>-multi-select-field').multiSelect({
          selectableHeader: "<div class='custom-header'><?php _e( 'Conditions', $this->settings_prefix); ?></div>",
          selectionHeader: "<div class='custom-header'><?php _e( 'Selected Conditions', $this->settings_prefix); ?></div>"
        });

        //Display button condition
        $('fieldset .checkbox').parents('fieldset').find('a.button-conditions').css('display', 'none');
        $('fieldset .checkbox:checked').parents('fieldset').find('a.button-conditions').css('display', '');

        $('fieldset .checkbox').on('click', function (event) {
          $('fieldset .checkbox').parents('fieldset').find('a.button-conditions').css('display', 'none');
          $('fieldset .checkbox:checked').parents('fieldset').find('a.button-conditions').css('display', '');
        });

        //Initiate Color Picker
        $('.wp-color-picker-field').wpColorPicker();

        // Switches option sections
        $('.group').hide();
        var activetab = '';
        var activetab_id = "<?php echo $this->settings_prefix; ?>_activetab";
        if (typeof(localStorage) != 'undefined' ) {
          activetab = localStorage.getItem(activetab_id);
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
            localStorage.setItem(activetab_id, $(this).attr('href'));
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
              text: self.data('uploader_button_text')
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


  public function do_settings_fields_table( $page, $section ) {
    global $wp_settings_fields;

    if ( ! isset( $wp_settings_fields[ $page ][ $section ] ) ) {
      return;
    }


    foreach ( (array) $wp_settings_fields[ $page ][ $section ] as $field ) {
      if ( $field['args']['type'] === 'sub_fields' ) {
        $class = '';

        if ( ! empty( $tr_field['args']['class'] ) ) {
          $class = ' class="' . esc_attr( $tr_field['args']['class'] ) . '"';
        }

        echo "<tr{$class}>";


        //Active subfield for the group
        foreach ( (array) $wp_settings_fields[ $page ][ $section ] as $sub_field ) {
          if ( $sub_field['args']['parent']['name_id'] === $field['args']['name_id'] && $sub_field['args']['id'] === 'active' ) {
            echo '<th scope="row" class="check-column">';
            if ( ! empty( $sub_field['args']['label_for'] ) ) {
              echo '<label class="screen-reader-text" for="' . esc_attr( $sub_field['args']['label_for'] ) . '">' . $sub_field['title'] . '</label>';
              call_user_func( $sub_field['callback'], $sub_field['args'] );
            } else {
              echo $sub_field['title'];
              call_user_func( $sub_field['callback'], $sub_field['args'] );
            }
            echo '</th>';
          }
        }


        //Title
        echo '<td class="plugin-title column-primary">';

        if ( $field['title'] ) {

          if($field['title'] !== strip_tags($field['title'])) {
            echo $field['title'];
          }
          else {
            echo '<strong>' . $field['title'] . '</strong>';
          }
        }

        //Sub Title
        if ( $field['args']['title'] ) {

          $sub_title = $field['args']['title'];

          if($sub_title !== strip_tags($sub_title)) {
            echo $sub_title;
          }
          else {
            echo '<p>' . $sub_title . '</p>';
          }
        }



        echo '</td>';

        //Description callback field
        echo '<td class="column-description desc">';
        call_user_func($field['callback'], $field['args']);
        echo '</td>';


        //Options sub_fields
        echo '<td class="column-options">';
        foreach ( (array) $wp_settings_fields[$page][$section] as $sub_field ) {
          if ( $sub_field['args']['parent']['name_id'] === $field['args']['name_id'] && $sub_field['args']['id'] !== 'active' ) {
            call_user_func($sub_field['callback'], $sub_field['args']);
          }
        }
        echo '</td>';

        echo '</tr>';
      }
    }

  }


  function do_settings_sections( $page ) {
    global $wp_settings_sections, $wp_settings_fields;

    if ( ! isset( $wp_settings_sections[$page] ) )
      return;

    foreach ( (array) $wp_settings_sections[$page] as $section ) {
      if ( $section['title'] ) {
        echo "<h2>{$section['title']}</h2>\n";
      }


      if ( $section['callback'] ) {
        call_user_func( $section['callback'], $section );
      }

      if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) ) {
        continue;
      }

      $settings_section_key = array_search($section['id'], array_column($this->settings_sections[$page], 'id'));
      $display = '';

      if ($settings_section_key !== false && isset($this->settings_sections[$page][$settings_section_key]['display']) ) {
        $display = $this->settings_sections[$page][$settings_section_key]['display'];
      }

      switch ( $display ) {
        case 'table':
          echo '<table class="wp-list-table widefat plugins">';
          echo '<thead>';
          echo '<tr>';
          echo '<td id="cb" class="manage-column column-cb check-column">';
          echo __( 'Select', $this->settings_prefix);
          echo '</td>';
          echo '<th scope="col" id="name" class="manage-column column-name column-primary">' . __('Module', $this->settings_prefix) . '</th>';
          echo '<th scope="col" id="description" class="manage-column column-description">' . __('Description', $this->settings_prefix) . '</th>';
          echo '<th scope="col" id="options" class="manage-column column-options">' . __('Options', $this->settings_prefix) . '</th>';
          echo '</tr>';
          echo '</thead>';
          echo '<tbody id="the-list">';

          $this->do_settings_fields_table( $page, $section['id'] );

          echo '</tbody>';
          echo '</table>';
          break;
        default:
          echo '<table class="form-table">';

          do_settings_fields( $page, $section['id'] );

          echo '</table>';
      }
    }
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

            $this->do_settings_sections( $tab['id'] );

            do_action( 'wp_ng_settings_form_bottom_' . $tab['id'], $tab );
            ?>
            <div>
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
