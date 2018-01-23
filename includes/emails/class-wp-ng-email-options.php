<?php

/**
 * The file that defines the email options class
 *
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/includes
 * @author     RedCastor <team@redcastor.io>
 */
class Wp_Ng_Email_Options {

  protected $enabled        = 0;
  protected $html           = 1;
  protected $recipient      = '';
  protected $from_name      = '';
  protected $from_address   = '';
  protected $headers        = '';
  protected $heading        = '';
  protected $subject        = '';
  protected $content_html   = '';
  protected $content_plain  = '';


  public function get_properties()
  {
    return get_object_vars($this);
  }

  public function set_properties( $properties )
  {
    foreach ($properties as $key => $value)
    {
      if ( property_exists($this, $key) ) {
        $this->$key = $value;
      }
    }
  }

  public function __get( $name ) {

    return $this->$name;
  }


  public function __set($name, $value)
  {
    $this->$name = $value;
  }

}
