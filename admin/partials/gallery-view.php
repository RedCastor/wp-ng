<script type="text/html" id="tmpl-wp-ng-gallery-settings">

  <h2 style="float: left;"><?php _e('NG Gallery Settings', 'wp-ng'); ?></h2>

  <?php if( !empty($modules_gallery) ) : ?>
    <label id="ng_module_settings" class="setting" data-ng-modules="<?php echo wp_ng_json_encode($modules_gallery); ?>">
      <span><?php _e('Module', 'wp-ng'); ?></span>
      <select class="ng_module" name="ng_module" data-setting="ng_module">
        <option value="" <?php selected($module_handle, ''); ?>><?php _e( 'None', 'wp-ng') ?></option>
        <?php foreach ($modules_gallery as $module_gallery) : ?>
          <option value="<?php echo esc_attr($module_gallery['name']); ?>" <?php selected($module_gallery['name'], ''); ?>><?php echo esc_html($module_gallery['title']); ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  <?php endif; ?>

  <label id="ng_module_type" class="setting">
    <span><?php _e('Type', 'wp-ng'); ?></span>
    <select class="type" name="type" data-setting="type">
      <option value=""><?php _e( 'None', 'wp-ng') ?></option>
    </select>
  </label>

  <label id="ng_module_theme" class="setting">
    <span><?php _e('Theme', 'wp-ng'); ?></span>
    <select class="theme" name="theme" data-setting="theme">
      <option value=""><?php _e( 'None', 'wp-ng') ?></option>
    </select>
  </label>
</script>
