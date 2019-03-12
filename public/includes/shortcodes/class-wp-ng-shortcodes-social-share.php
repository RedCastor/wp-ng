<?php
/**
 * Directive Shortcodes Social Share
 *
 * @author     RedCastor <team@redcastor.io>
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes/shortcodes
 * @version     1.7.0
 */
class Wp_Ng_Shortcodes_Social_Share {


  /**
   * [ng-social-share-links]
   *
   * Returns a formatted list item.
   * Works with angular socialLinks (https://github.com/fixate/angular-social-links).
   *
   * @return   string   HTML list item.
   */
  public static function links($atts)
  {

    $social_list = array(
      'facebook'  	=> "",
      'twitter'   	=> "",
      'google-plus'	=> "",
      'pinterest' 	=> "",
      'linkedin'  	=> "",
      'mail'     		=> "",
    );

    $combine_atts = array_merge(array(
      'class'         => "",
      'btn'           => "",
      'icon-prefix'   => "",
      'url'           => "",
      'mail-subject' => "",
      'mail-body'    => "",
      'media'         => "",
      'social-width'  => "",
      'social-height' => "",
    ),
      $social_list
    );

    $a = shortcode_atts($combine_atts, $atts);

    foreach($a as $key => $val){
      if (array_key_exists($key, $social_list)) {
        $social_list[$key] = $val;
      }

    }


    $social = '<ul class="social-share-group ' . $a['class'] . '">';

    foreach($social_list as $key => $val){
      if ($val !== '') {

        if ($key === 'google-plus') {
          $social_key = 'gplus';
        }
        else {
          $social_key = $key;
        }

        $social .= '<li class="social-share-group-item social-share-' . $key . '" >';

        if ($a['btn'] === '') {
          $social .= '<a social-' . $social_key . ' ';
        }
        else {
          $social .= '<a class="btn ' . $a['btn'] . '" social-' . $social_key . ' ';
        }


        if ($key === 'mail') {
          $social .= 'href="mailto:?';

          if ($a['mail-subject'] !== '') {
            $social .= '&subject=' . $a['mail-subject'];
          }
          if ($a['mail-body'] !== '') {
            $social .= '&body=' . $a['mail-body'] . '"';
          }
        }
        else {
          if ($a['social-width'] !== '') {
            $social .= 'social-width="' . $a['social-width'] . '" ';
          }

          if ($a['social-height'] !== '') {
            $social .= 'social-height="' . $a['social-height'] . '" ';
          }

          if ($a['url'] !== '') {
            $social .= 'custom-url="' . $a['url'] . '" ';
          }

          if ( $a['media'] !== '' && $key === 'pinterest' ) {
            $social .= 'media="' . $a['media'] . '" ';
          }
        }

        $social .=  '>';

        if ($a['icon-prefix']) {
          $social .= '<i class="'. $a['icon-prefix'] . ' ' . $a['icon-prefix'] . '-' . $key . '" ></i>';
        }

        $social .= ($val !== 'true') ? $val : '' . '</a>';
        $social .= '</li>';
      }
    }

    $social .= '</ul>';


    return $social;
  }

}
