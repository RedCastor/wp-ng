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

    $_atts = shortcode_atts( array(
      'type'   => null,
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

      //Init
      if ( empty($init) ) {
        $init = '';
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

      //Model, Init, Value
      if ( $model !== 'false' ) {
        $_attr_input['data-ng-model'] = $model;

        if ( !empty($init) ) {
          $init .= (substr($init, -1, 1) === ';') ? '' : ';';
        }

        if ( !empty($value) ) {
          $init .= sprintf("%s='%s';", $model, $value);
        }

        if ( !empty($init) ) {
          $_attr_input['data-ng-init'] = $init;
        }
      }

      $_attr_input = wp_parse_args($_attr_input, $extra_attr);

      $attr_input = array();

      switch ($type) {
        case 'search':
        case 'number':
        case 'hidden':
        case 'text':
        case 'password':
        case 'email':
        case 'tel':
        case 'url':

          foreach ($_attr_input as $attribute => $value) {
            if ( $value !== null && $value !== 'false') {
              if ( is_numeric($attribute) ) {
                $attr_input[] = (string) $value;
              }
              else {
                $attr_input[] = sprintf('%s="%s"', $attribute, esc_attr($value));
              }
            }
          }

          $html = sprintf( '%s<input %s /> ', $label, implode(' ', $attr_input) );
          break;

        case 'checkbox':

          $checked = ($checked === true || $checked === 'true' ) ? 'true' : 'false';

          $_attr_input['data-ng-checked'] = $checked;

          if ( $model !== 'false' ) {
            $_attr_input['data-ng-init'] = sprintf('%s=%s;%s', $model, $checked, $init);
          }


          //Class for checkbox block
          $checkbox_class = 'checkbox ' . $checkbox_class;

          foreach ($_attr_input as $attribute => $value) {
            if ( !empty($value) && $value !== 'false') {
              $attr_input[] = sprintf('%s="%s"', $attribute, esc_attr($value));
            }
          }

          $html = sprintf( '<div class="%s"><input %s />%s</div>',
            $checkbox_class,
            implode(' ', $attr_input),
            $label
          );

          break;
        default:
          $html = '';
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
   * Shortcode select form
   *
   * @param $atts
   *
   * @return string
   */
  public static function select ( $atts ) {
    $html = '';

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
      $options_decoded = json_decode($options, true);
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
      $_attr_select['data-ng-model'] = $model;
      $_attr_select['data-ng-required'] = $required;
      $_attr_select['data-ng-attr-size'] = $attr_size;
      $_attr_select['data-ng-options'] = sprintf('key as value for (key, value) in %s', $name);

      //Model, Init, Value
      if ( $model !== 'false' ) {
        $_attr_input['data-ng-model'] = $model;

        //Init
        if ( empty($init) ) {
          $init = '';
        }
        else {
          $init .= (substr($init, -1, 1) === ';') ? '' : ';';
        }

        $_attr_select['data-ng-init'] = sprintf("%s=%s;%s='%s';%s",$name, json_encode($options_decoded), $model, $selected, $init);
      }

        $_attr_select = wp_parse_args($_attr_select, $extra_attr);

      $attr_select = array();

      foreach ($_attr_select as $attribute => $value) {
        if ( !empty($value) && $value !== 'false') {
          if ( is_numeric($attribute) ) {
            $attr_select[] = (string) $value;
          }
          else {
            $attr_select[] = sprintf('%s="%s"', $attribute, esc_attr($value));
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
          $attrs[] = sprintf('%s="%s"', $attribute, esc_attr($value));
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
      'options' => json_encode($languages),
    ) );

    return self::select( $atts );
  }
}
