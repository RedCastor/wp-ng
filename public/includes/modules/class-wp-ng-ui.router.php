<?php

/**
 * The public-facing includes functionality Module UI.ROUTER.
 *
 * @link       http://redcastor.io
 * @since      1.7.0
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 */

/**
 *
 *
 * @package    Wp-Ng
 * @subpackage Wp-Ng/public/includes
 * @author     RedCastor <team@redcastor.io>
 */
final class Wp_Ng_Public_UI_Router {

  private static $cache_states = null;
  private static $resolve_list = array();
  private static $routed_post_types = array();
  private static $is_build_state = false;

  const T_STATES = 'wp-ng_router_states';

  /**
   * Init Hooks.
   */
  public static function init() {

    self::$routed_post_types = wp_ng_get_module_option( 'routed_post_types', 'ui.router', array());
    self::$resolve_list = self::get_ng_router_resolve_list();

    if ( wp_ng_is_module_active('ui.router') &&  !empty(self::$routed_post_types) ) {

      add_action('template_redirect', array(__CLASS__, 'template_redirect'), 5 );
      add_filter('page_link', array(__CLASS__, 'page_link'), 5, 3);
    }
  }


  /**
   *  Template Redirection for angular router
   */
  public static function template_redirect() {

    if ( $state = self::get_routed_state() ) {

      $state_url = $state['parentUrl'] . $state['url'];
      $redirect_url = wp_ng_get_base_url() . '#' . $state_url;

      wp_safe_redirect($redirect_url);
      exit();
    }
  }

  /**
   * Resolve permalink ui-router
   *
   * @param $permalink
   * @param $post
   * @param $leavename
   *
   * @return mixed
   */
  public static function page_link( $link, $post_id, $sample ) {

    if (self::$is_build_state) {
      return $link;
    }

    // Remove filter prevent rentry
    remove_filter('page_link', array(__CLASS__, 'page_link'), 5);

    $new_link = '';
    $is_routed_post = intval(get_post_meta( $post_id, '_is_ng_routed', true ));

    if ($is_routed_post) {
      $new_link = self::get_routed_url($post_id);
    }

    add_filter('page_link', array(__CLASS__, 'page_link'), 5, 3);

    return $new_link ? $new_link : $link;
  }

  public static function delete_cache () {

    self::$cache_states = null;

    return delete_transient(self::T_STATES);
  }
  /**
   * Get routed url by post id
   *
   * @param      $post_id
   * @param bool $relative
   *
   * @return bool|string
   */
  public static function get_routed_url ( $post_id, $relative = false ) {

    $states = self::get_ng_router_states();
    $i_state = array_search($post_id, array_column($states, 'id'));

    if ( $i_state !== false ) {
      $key = array_keys($states)[$i_state];
      $state = (object)$states[$key];

      $url = !$relative ? trailingslashit(wp_ng_get_base_url()) : '';
      $url .= "#{$state->parentUrl}{$state->url}";

      return $url;
    }

    return false;
  }

  /**
   * Get routed state for current request
   * @return bool|mixed
   */
  public static function get_routed_state() {
    global $wp;

    $pagename = isset($wp->query_vars['pagename']) ? $wp->query_vars['pagename'] : null;
    $current_url = wp_ng_get_current_url(true);

    /* UI Routed page */
    $states = self::get_ng_router_states();

    foreach ( $states as $state ) {

      if (isset($state['post']) && is_singular($state['post']['type']) && !empty($state['url'])) {

        if (isset($state['abstract']) && $state['abstract']) {

          if ($pagename === explode('.', $state['name'])[0]) {
            return $state;
          }

          continue;
        }
        elseif ($current_url === trailingslashit($state['parentUrl'] . $state['url'])) {

          return $state;
        }
      }
    }

    return false;
  }

  /**
   * Router controller list
   *
   * @since  1.0.0
   * @return array value
   */
  public static function get_ng_router_controller_list()
  {
    $choices = array(
      '' => __('Default', 'wp-ng'),
    );

    return apply_filters( 'wp_ng_get_ng_router_controller_list', $choices );
  }


  /**
   * Router resolve list
   *
   * @since  1.0.0
   * @return array value
   */
  public static function get_ng_router_resolve_list()
  {
    $choices = array(
      '' => array(
        'title' => __('None', 'wp-ng'),
        'service' => '',
        'redirect' => '',
      )
    );

    return apply_filters( 'wp_ng_get_ng_router_resolve_list', $choices );
  }


  /**
   * Return the router state by id or default
   *
   * @since  1.4.2
   * @param  int $id object id
   * @return array metadata values
   */
  public static function get_ng_router_state_fields( $post_id )
  {

    $ng_router_state = get_post_meta( $post_id, '_ng_router_state', true );

    if (!is_array($ng_router_state)) {
      $ng_router_state = array();
    }

    $default_ng_router_state = array(
      'controller' => '',
      'controllerAs' => '$' . get_post_type($post_id),
      'resolve' => array(
        'service' => '',
        'redirect' => '',
      )
    );

    return (object) array_replace_recursive($default_ng_router_state, $ng_router_state);
  }


  /**
   * return 2 states. The state and the abstact state
   *
   * @param $post
   */
  public static function get_ng_router_abstract_states( $post ) {

    $states = array();

    $is_routed_post = intval(get_post_meta( $post->ID, '_is_ng_routed', true ));
    $state = self::get_ng_router_state( $post );
    $state_abstract = (array)$state;

    $state_abstract['abstract'] = true;

    if ( !$is_routed_post ) {
      $state_abstract['template'] = '<ui-view/>';
    }

    //Add Abstract state
    unset($state_abstract['controller']);
    unset($state_abstract['controllerAs']);

    //Add abstract
    $states[$state_abstract['name']] = $state_abstract;

    //Add base if is routed
    if ( $is_routed_post ) {

      $state->name .= '.base';
      $state->url = '';
      unset($state->resolve);
      unset($state->post);

      $states[$state->name] = (array)$state;
    }

    return $states;
  }


  /**
   * Get router state
   *
   * @since  1.4.2
   * @param  int $id object id
   * @return array metadata values
   */
  public static function get_ng_router_state( $post )
  {
    self::$is_build_state = true;

    $ng_router_state = self::get_ng_router_state_fields( $post->ID );
    $state_resolve = $ng_router_state->resolve;

    $post_type_obj = get_post_type_object($post->post_type);
    $relative_url = untrailingslashit(str_replace(home_url(), '', get_permalink($post->ID)));

    $default_ng_router_state = array(
      'id' => $post->ID,
      'name' => implode('.', explode('/', substr($relative_url, 1))),
      'url' => '/' . $post->post_name,
      'controller' => $ng_router_state->controller,
      'controllerAs' => $ng_router_state->controllerAs,
      'resolve' => array(),
      'post'        => array(
        'id'        => $post->ID,
        'name'      => $post->post_name,
        'type'      => $post->post_type,
        'restBase'  => $post_type_obj->rest_base
      )
    );


    $default_ng_router_state['parentUrl'] = str_replace( ('/' . $post->post_name), '', $relative_url);

    //Resolve State
    if ( !empty($state_resolve['service']) && array_key_exists($state_resolve['service'], self::$resolve_list) ) {

      $state_resolve_service = self::$resolve_list[$state_resolve['service']];
      unset($state_resolve_service['title']);

      if(empty($state_resolve_service['redirect']) ){
        $state_resolve_service['redirect'] = $state_resolve['redirect'];
      }

      $default_ng_router_state['resolve'][$state_resolve['service']] = $state_resolve_service;
    }

    self::$is_build_state = false;

    return (object) $default_ng_router_state;
  }


  /**
   * Get router states
   *
   * @param bool $cache
   * @return array|null
   */
  public static function get_ng_router_states ( $cache = true ) {

    $states = array();

    if ( !is_array(self::$cache_states) ) {
      self::$cache_states = get_transient( self::T_STATES);
    }

    if ( !is_array(self::$cache_states) || !$cache ) {

      $posts = array();
      $post_types_obj = array();

      //Get Routed Posts
      foreach (self::$routed_post_types as $post_type) {

        if ($post_type === 'page') {
          //suppress_filters for wpml current language
          $posts = array_merge($posts, get_pages(array('hierarchical' => false, 'meta_key' => '_is_ng_routed', 'meta_value' => true, 'suppress_filters' => false)));
        }
        else {
          //suppress_filters for wpml current language
          $posts = array_merge($posts, get_posts(array('post_type' => $post_type, 'meta_key' => '_is_ng_routed', 'meta_value' => true, 'suppress_filters' => false)));
        }
      }

      $parent_ids = array();
      //Post states
      foreach ($posts as $index => $post) {

        $post_parent = null;

        if ($post->post_parent) {
          $post_parent_index = array_search($post->post_parent, array_column($posts, 'ID'));

          if ($post_parent_index) {
            $post_parent = $posts[$post_parent_index];
          }
          else {
            $post_parent = get_post($post->post_parent);
          }

          $parent_ids[] = $post_parent->ID;

          $abastract_states = self::get_ng_router_abstract_states( $post_parent );

          $states = array_merge($states, $abastract_states);
        }

        $ng_router_state = self::get_ng_router_state($post);

        //Create post types object array for create abstract states later
        if ( !isset($post_types_obj[$post->post_type])) {

          $post_types_obj[$post->post_type] = get_post_type_object( $post->post_type );
        }


        $states[$ng_router_state->name] = (array)$ng_router_state;
      }

      self::$cache_states = $states;

      set_transient( self::T_STATES, self::$cache_states);
    }
    else {
      $states = self::$cache_states;
    }


    return $states;
  }

}
