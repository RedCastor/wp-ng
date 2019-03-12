<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

?>

<?php do_action( 'wp_ng_metabox-before-ng_router', $is_routed, $state );?>

<input type="checkbox" name="is_ng_routed" id="is_ng_routed" value="1" <?php checked($is_routed , 1); ?> />&nbsp;
<label for="is_ng_routed"><?php _e( 'Is Routed', 'wp-ng' ); ?></label>

<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="ng_router_state_controller"><?php _e( 'Controller', 'wp-ng' ); ?></label></p>
<select id="ng_router_state_controller"  name="ng_router_state[controller]">
  <?php foreach( $controller_choices as $controller => $title ): ?>
    <option value="<?php echo $controller ?>" <?php selected($state->controller, $controller); ?>><?php echo $title ?></option>
  <?php endforeach; ?>
</select>

<?php if ( !empty($resolve_choices) ) : ?>

<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="ng_router_state_resolve_service"><?php _e( 'Resolve', 'wp-ng' ); ?></label></p>
<select id="ng_router_state_resolve_service"  name="ng_router_state[resolve][service]">
  <?php foreach( $resolve_choices as $key => $resolve ): ?>
    <option value="<?php echo $key ?>" <?php selected($state->resolve['service'], $key); ?>><?php echo $resolve['title'] ?></option>
  <?php endforeach; ?>
</select>

<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="ng_router_state_resolve_redirect"><?php _e( 'Redirect URL or Route name', 'wp-ng' ); ?></label></p>
<input type="text" name="ng_router_state[resolve][redirect]" id="ng_router_state_resolve_redirect" value="<?php echo $state->resolve['redirect']; ?>" />

<?php endif; ?>

<?php do_action( 'wp_ng_metabox-after-ng_router', $is_routed, $state );?>
