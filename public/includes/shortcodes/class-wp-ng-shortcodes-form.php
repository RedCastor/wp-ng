<?php
/**
 * Form Shortcodes
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.3.0
 */
class Wp_Ng_Shortcodes_Form {


  /**
   * Shortcode input form
   *
   * @param $atts
   *
   * @return string
   */
  public static function input( $atts ) {

    $html = '';

    //translation
    if (!empty($atts['type']) && ($atts['type'] === 'checkbox' || $atts['type'] === 'radio') ) {
      $translate_default = 'label';
    }
    else {
      $translate_default = 'placeholder';
    }
    $atts = wp_ng_apply_translation($atts, $translate_default);

    $_atts = shortcode_atts( array(
      'type'   => 'text',
      'name'   => null,
      'model'  => null,
      'label'  => null,
      'id'     => null,
      'class'  => null,
      'placeholder' => null,
      'value'     => null,
      'init'      => null,
      'change'    => null,
      'checked'   => null,
      'disabled'  => null,
      'required'  => null,
      'readonly'  => null,
      'pattern'   => null,
      'minlength' => null,
      'maxlength' => null,
      'checkbox_class' => null,
      'radio_class' => null,
    ), $atts );

    extract($_atts);

    if ( $name && $type) {

      if ( empty($model) ) {
        $model = $name;
      }
      else if ( $model !== 'false' ) {
        $model .=  (substr($model, -1, 1) === '.') ? $name : '.' . $name;
        $name = substr( $model, 0, 1) . ucwords($name);
      }



      //Label
      if( !empty($label) ) {
        //ID
        if ( !$id ) {
          $id = $type . '_' . strval(dechex(crc32(uniqid())));
        }

        $label = sprintf('<label for="%s">%s</label>', esc_attr($id), $label);
      }

      //Add More attribute not describe. (example for auto focus, or validation)
      $extra_attr = array_diff_key($atts, $_atts);

      $_attr_input['type'] = $type;
      $_attr_input['name'] = $name;
      $_attr_input['id'] = $id;
      $_attr_input['class'] = $class;
      $_attr_input['placeholder'] = $placeholder;
      $_attr_input['value'] = $value;
      $_attr_input['data-ng-disabled'] = $disabled;
      $_attr_input['data-ng-required'] = $required;
      $_attr_input['data-ng-readonly'] = $readonly;
      $_attr_input['data-ng-minlength'] = $minlength;
      $_attr_input['data-ng-maxlength'] = $maxlength;
      $_attr_input['data-ng-pattern'] = $pattern;
      $_attr_input['data-ng-change'] = $change;
      $_attr_input['data-ng-init'] = $init;

      //Initialize model
      if ( $model !== 'false' ) {
        $_attr_input['data-ng-model'] = $model;
      }

      $_attr_input = wp_parse_args($_attr_input, $extra_attr);

      $attr_input = array();

      //Special initialize input type
      switch ($type) {
        case 'checkbox':

          if ($value === true || $value === 'true' || $checked === '' || $checked === true || $checked === 'true' ) {
            $checked = true;
          }
          else {
            $checked = false;
          }

          if ($value === null) {

            if ($checked) {
              $value = !empty($_attr_input['ng-true-value']) ? $_attr_input['ng-true-value'] : 'true';
              $value = !empty($_attr_input['data-ng-true-value']) ? $_attr_input['data-ng-true-value'] : $value;
            }
            else {
              $value = !empty($_attr_input['ng-false-value']) ? $_attr_input['ng-false-value'] : 'false';
              $value = !empty($_attr_input['data-ng-false-value']) ? $_attr_input['data-ng-false-value'] : $value;
            }

            $value = str_replace("'", '', $value);
          }

          $_attr_input['data-ng-checked'] = $checked ? 'true' : 'false';

          if( $model !== 'false' && $value !== null) {
            $_attr_input['initial-value'] = $value;
          }
          break;
        case 'radio':

          if ($checked !== null) {
            if ($value === true || $value === 'true' || $checked === '' || $checked === true || $checked === 'true' ) {
              $checked = 'true';
            }
            else {
              $checked = 'false';
            }

            $_attr_input['data-ng-checked'] = $checked;

            if( $model !== 'false') {
              $_attr_input['initial-value'] = '';
            }
          }
          break;
        default:
          if ( $model !== 'false' && $value !== null ) {
            $_attr_input['initial-value'] = '';
          }
      }

      //Parse attributes for display
      foreach ($_attr_input as $attribute => $value) {
        if ( $value !== null) {
          if ( is_numeric($attribute) ) {
            $attr_input[] = (string) $value;
          }
          else {
            $attr_input[] = sprintf('%s="%s"', $attribute, htmlspecialchars($value, ENT_QUOTES));
          }
        }
      }

      switch ($type) {
        case 'textarea':

          $html = sprintf( '%s<textarea %s ></textarea> ', $label, implode(' ', $attr_input) );
          break;
        case 'checkbox':

          //Class for checkbox block
          $checkbox_class = 'checkbox ' . $checkbox_class;

          $html = sprintf( '<div class="%s"><input %s />%s</div>',
            $checkbox_class,
            implode(' ', $attr_input),
            $label
          );

          break;
        case 'radio':

          //Class for radio block
          $radio_class = 'radio ' . $radio_class;

          $html = sprintf( '<div class="%s"><input %s />%s</div>',
            $radio_class,
            implode(' ', $attr_input),
            $label
          );

          break;
        default:

          $html = sprintf( '%s<input %s /> ', $label, implode(' ', $attr_input) );
          break;

      }
    }

    return $html;
  }

  /**
   * Shortcode checkbox form
   *
   * @param $atts
   *
   * @return string
   */
  public static function checkbox( $atts, $content = '' ) {

    $atts = wp_parse_args( $atts, array(
      'type' => 'checkbox',
      'label' => '',
    ) );

    if ( !empty($atts['label']) ) {
      $content = esc_html( $atts['label']  ) . ( empty( $content ) ? '' : ' ' ) . $content;
    }

    $atts['label'] = do_shortcode($content);

    return self::input( $atts );
  }

  /**
   * Shortcode radio form
   *
   * @param $atts
   *
   * @return string
   */
  public static function radio( $atts, $content = '' ) {

    $atts = wp_parse_args( $atts, array(
      'type' => 'radio',
      'label' => '',
    ) );

    if ( !empty($atts['label']) ) {
      $content = esc_html( $atts['label']  ) . ( empty( $content ) ? '' : ' ' ) . $content;
    }

    $atts['label'] = do_shortcode($content);

    return self::input( $atts );
  }

  /**
   * Shortcode select form
   *
   * @param $atts
   *
   * @return string
   */
  public static function select ( $atts ) {
    $html = '';

    //translation
    $atts = wp_ng_apply_translation($atts, 'placeholder');

    $_atts = shortcode_atts( array(
      'name'   => null,
      'model'  => null,
      'label'  => null,
      'id'     => null,
      'class'  => null,
      'placeholder' => null,
      'init'     => null,
      'change'   => null,
      'multiple' => null,
      'options'  => null,
      'selected' => null,
      'disabled'  => null,
      'required'  => null,
      'attr_size' => null,
    ), $atts );

    extract($_atts);

    if ( $name && $options) {

      //Model and Name
      if ( empty($model) ) {
        $model = $name;
      }
      else if ( $model !== 'false' ) {
        $model .= ( substr( $model, - 1 ) === '.' ) ? $name : '.' . $name;
        $name = substr( $model, 0, 1 ) . ucwords( $name );
      }

      //Options
      $options_decoded = wp_ng_json_decode($options);
      if ( !$options_decoded ) {
        $options_decoded = array();
      }

      //Selected
      if ( empty($selected) || !array_key_exists($selected, $options_decoded) ) {
        $selected = '';
      }

      //Placeholder
      if (!empty($placeholder)) {
        $placeholder = sprintf('<option value="" disabled hidden>%s</option>', esc_html($placeholder));
      }

      //Label
      if( !empty($label) ) {
        //ID
        if ( !$id ) {
          $id = 'select_' . strval(dechex(crc32(uniqid())));
        }

        $label = sprintf('<label for="%s">%s</label>', $id, esc_html($label));
      }

      //Add More attribute not describe. (example for auto focus, or validation)
      $extra_attr = array_diff_key($atts, $_atts);

      $_attr_select['name'] = $name;
      $_attr_select['id'] = $id;
      $_attr_select['class'] = $class;
      $_attr_select['data-ng-change'] = $change;
      $_attr_select['data-ng-disabled'] = $disabled;
      $_attr_select['data-ng-required'] = $required;
      $_attr_select['data-ng-attr-size'] = $attr_size;
      $_attr_select['data-ng-options'] = sprintf('key as value for (key, value) in %s', $name);

      //Model, Init, Value
      if ( $model !== 'false' ) {

        //Init
        if ( empty($init) ) {
          $init = '';
        }
        else {
          $init .= (substr($init, -1, 1) === ';') ? '' : ';';
        }

        $_attr_select['data-ng-init'] = sprintf("%s=%s;%s",$name, wp_ng_json_encode( $options_decoded ), $init);
        $_attr_select['data-ng-model'] = $model;
        $_attr_select['data-initial-value'] = esc_attr($selected);
      }

        $_attr_select = wp_parse_args($_attr_select, $extra_attr);

      $attr_select = array();

      foreach ($_attr_select as $attribute => $value) {
        if ( !empty($value) && $value !== 'false') {
          if ( is_numeric($attribute) ) {
            $attr_select[] = (string) $value;
          }
          else {
            $attr_select[] = sprintf('%s="%s"', $attribute, htmlspecialchars($value, ENT_QUOTES));
          }
        }
      }

      //multiple
      if( $multiple !== null ) {
        $multiple = 'multiple';
      }

      $html = sprintf( '%1$s<select %2$s %3$s >%4$s</select>',
        $label,
        implode(' ', $attr_select),
        $multiple,
        $placeholder
      );
    }

    return $html;
  }

  /**
   * Shortcode Submit Form
   *
   * @param $atts
   *
   * @return string
   */
  public static function submit( $atts, $content = '' ) {

    $html = '';

    //translation
    $atts = wp_ng_apply_translation($atts, 'text');

    $_atts = shortcode_atts( array(
      'text'    => '',
      'id'      => null,
      'class'   => null,
      'disabled' => null,
    ), $atts );

    extract($_atts);

    if ( !empty( $text ) ) {
      $content = esc_html( $text  ) . ( empty( $content ) ? '' : ' ' ) . $content;
    }

    if ($content) {

      //Add More attribute not describe. (example for auto focus, or validation)
      $extra_attr = array_diff_key($atts, $_atts);

      $_attrs['id'] = $id;
      $_attrs['class'] = $class;
      $_attrs['data-ng-disabled'] = $disabled;

      $_attrs = wp_parse_args($_attrs, $extra_attr);

      $attrs = array();

      foreach ($_attrs as $attribute => $value) {
        if ( $value !== null) {
          $attrs[] = sprintf('%s="%s"', $attribute, htmlspecialchars($value, ENT_QUOTES));
        }
      }

      $html = sprintf( '<button %1$s type="submit">%2$s</button>', implode(' ', $attrs), do_shortcode( $content ) );
    }

    return $html;
  }

  /**
   * Shortcode Select Locale Language Available Form
   *
   * @param $atts
   *
   * @return string
   */
  public static function locale( $atts ) {

    require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
    $translations = wp_get_available_translations();

    $available_languages = array_merge( array( 'en_US' ), get_available_languages() );

    /*
	 * $args['languages'] should only contain the locales. Find the locale in
	 * $translations to get the native name. Fall back to locale.
	 */
    $languages = array();
    foreach ( $available_languages as $locale ) {
      if ( isset( $translations[ $locale ] ) ) {
        $translation = $translations[ $locale ];
        $languages[$locale] = $translation['native_name'];

        // Remove installed language from available translations.
        unset( $translations[ $locale ] );
      }
      else if ( $locale === 'en_US' ) {
        $languages[$locale] = 'English (United States)';
      }
      else {
        $languages[$locale] = $locale;
      }
    }

    $atts = wp_parse_args( $atts, array(
      'options' => wp_ng_json_encode( $languages),
    ) );

    return self::select( $atts );
  }


  /**
   * Shortcode Token
   *
   * @param $atts
   * @return string
   */
  public static function token ( $atts ) {

    $atts = wp_parse_args( $atts, array(
      'type'  => 'hidden',
      'name'  => 'token',
      'value' => 'form',
    ) );

    //Create Token
    $atts['value'] = wp_ng_create_onetime_nonce($atts['value']);

    return self::input( $atts );
  }


  /**
   * Shortcode Media Select
   *
   * @param $atts
   *
   * @return string
   */
  public static function media_select( $atts, $content ) {
    $html ='';

    $_atts = shortcode_atts( array(
      'id'      => null,
      'name'      => null,
      'class'   => null,
      'theme'   => null,
      'type'    => 'hidden',
      'template_url' => null,
      'onetime' => false,
      'single'  => false,
      'push'    => false,
      'media'   => null,
      'current_user' => false,
      'sources_query'     => null,
      'crop'              => true,
      'crop_keep_aspect'   => true,
      'crop_keep_aspect_ratio' => true,
      'crop_touch_radius' => 10,
      'crop_color'        => 'rgba(128, 128, 128, 1)',
      'crop_color_drag'   => 'rgba(128, 128, 128, 1)',
      'crop_color_bg'     => '#dddddd',
      'crop_color_crop_bg' => 'rgba(0, 0, 0, 0.6)',
      'upload_multiple' => false,
      'upload_filename' => '',
      'upload_fields'   => '{}',
      'upload_width'    => 300,
      'upload_height'   => 300,
      'upload_pattern'  => '.png,.jpg',
      'upload_accept'   => 'image/*',
      'upload_spinner'  => 'spinner:clock',
      'gallery_spinner' => 'spinner:ripple',
      'gallery_multiple'  => true,
      'gallery_order'     => 'date',
      'gallery_search_value' => '',
      'gallery_post' => null,
      'init_sources' => null,
      'text'         => '',

    ), $atts);

    extract($_atts);

    if ( !empty( $text ) ) {
      $content = esc_html( $text  ) . ( empty( $content ) ? '' : ' ' ) . $content;
    } else if ( empty( $content ) ) {
      $content = __('Add to Gallery', 'wp-ng');
    }

    //Convert to boolean
    $crop             = filter_var($crop, FILTER_VALIDATE_BOOLEAN);
    $crop_keep_aspect = filter_var($crop_keep_aspect, FILTER_VALIDATE_BOOLEAN);
    $crop_keep_aspect_ratio = filter_var($crop_keep_aspect_ratio, FILTER_VALIDATE_BOOLEAN);
    $onetime          = filter_var($onetime, FILTER_VALIDATE_BOOLEAN);
    $single           = filter_var($single, FILTER_VALIDATE_BOOLEAN);
    $push             = filter_var($push, FILTER_VALIDATE_BOOLEAN);
    $current_user     = filter_var($current_user, FILTER_VALIDATE_BOOLEAN);
    $upload_multiple  = filter_var($upload_multiple, FILTER_VALIDATE_BOOLEAN);

    $sources_query = wp_ng_json_decode($sources_query);

    if (!$sources_query) {
      $sources_query = array(
        "per_page" => 30,
      );
    }

    $user_id = get_current_user_id();

    if ($current_user && $user_id) {
      $sources_query['author'] = $user_id;
    }

    $gallery_post = intval($gallery_post);

    if ($gallery_post !== null && is_int($gallery_post)) {
      $sources_query['parent'] = $gallery_post;
    }


    $media_config = array(
      'sourceId' => 'id',
      'sourceUrl' => '',
      'sourceUrlKey' => 'source_url',
      'sourceTitle' => 'title.rendered',
      'returnModelType' => 'string',
      'returnModelKey' => 'id',
      'returnModelPush' => $push,
      'sourcesOffsetKey' => 'offset',
      'sourcesLimitKey' =>  'per_page',
      'sourcesSearchKey' => 'search',
      'sourcesQuery' => $sources_query,
      'deleteQuery' => array(
        "force" => true,
      ),
      'upload' => array(
        'crop'      => $crop,
        'multiple'  => $upload_multiple,
        'pattern'   => $upload_pattern,
        'accept'    => $upload_accept,
        'fileName'  => $upload_filename,
        'fields'    => wp_ng_json_decode( $upload_fields ),
        'minWidth'  => intval($upload_width),
        'minHeight' => intval($upload_height),
        'cropArea'  => array(
          'touchRadius' => intval($crop_touch_radius),
          'keepAspect'  => $crop_keep_aspect,
          'keepAspectRatio'  => $crop_keep_aspect_ratio,
          'color'       => $crop_color,
          'colorDrag'   => $crop_color_drag,
          'colorBg'     => $crop_color_bg,
          'colorCropBg' => $crop_color_crop_bg,
        ),
        'loadIcon' => $upload_spinner,
      ),
      'gallery' => array(
        'order'       => $gallery_order,
        'searchValue' => $gallery_search_value,
        'loadIcon'    => $gallery_spinner,
      ),
    );

    //Add More attribute not describe. (example for auto focus, or validation)
    $extra_attr = array_diff_key($atts, $_atts);

    $_attrs['rcm-onetime']  = $onetime === true ? 'true' : 'false';
    $_attrs['rcm-single']   = $single === true ? 'true': 'false';
    $_attrs['rcm-class']    = $class;
    $_attrs['rcm-id']       = $id;
    $_attrs['rcm-name']     = $name;
    $_attrs['rcm-type']     = $type;
    $_attrs['rcm-theme']    = $theme;
    $_attrs['rcm-template-url'] = $template_url;
    $_attrs['rcm-config']   = wp_ng_json_encode( $media_config );
    $_attrs['rcm-media']    = $media;
    $_attrs['rcm-init-sources'] = $init_sources;

    $_attrs = wp_parse_args($_attrs, $extra_attr);

    $attrs = array();

    foreach ($_attrs as $attribute => $value) {
      if ( $value !== null && $value !== 'null' ) {
        if ( is_numeric($attribute) ) {
          $attrs[] = (string) $value;
        }
        else {
          $attrs[] = sprintf('%s="%s"', $attribute, htmlspecialchars($value, ENT_QUOTES));
        }
      }
    }

    $html .= sprintf('<rcm-select %1$s  >%2$s</rcm-select>',
      implode(' ', $attrs),
      $content
    );

    return $html;
  }


}
