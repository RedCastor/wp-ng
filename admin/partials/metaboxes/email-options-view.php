<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

$id = $opts['id'];
$simple = $opts['simple'];
?>

<?php do_action( 'wp_ng_metabox-before-email-options', $id, $opts );?>

<label class="wp-ng-strong"><?php _e( 'Enable email', 'wp-ng' ); ?>&nbsp;<?php echo (is_int($id) ? $id + 1 : $id); ?></label>
&nbsp;&nbsp;
<span>
  <input onclick="jQuery('#wp_ng_email_enabled_<?php echo $id; ?>').slideDown();return true;" type="radio" name="email_options[<?php echo $id?>][enabled]" value="1" <?php checked($opts['enabled'], 1); ?> /> <?php _e( 'Yes' ); ?>
  &nbsp;&nbsp;
  <input onclick="jQuery('#wp_ng_email_enabled_<?php echo $id; ?>').slideUp();return true;" type="radio" name="email_options[<?php echo $id?>][enabled]" value="0" <?php checked($opts['enabled'], 0); ?> /> <?php _e( 'No' ); ?>
</span>
<div class="wp-ng-divider"></div>
<div id="wp_ng_email_enabled_<?php echo $id; ?>" class="wp-ng-email-options-wrapper meta-options" <?php echo ($opts['enabled'] ? '' : 'style="display: none;"'); ?>>
  <label class="wp-ng-strong"><?php _e( 'Html', 'wp-ng' ); ?></label>
  &nbsp;&nbsp;
  <span>
    <input onclick="jQuery('#wp_ng_email_html_enabled_<?php echo $id; ?>').slideDown();jQuery('#wp_ng_email_plain_enabled_<?php echo $id; ?>').slideUp();return true;" type="radio" name="email_options[<?php echo $id;?>][html]" value="1" <?php checked($opts['html'], 1); ?> /> <?php _e( 'Yes' ); ?>
    &nbsp;&nbsp;
    <input onclick="jQuery('#wp_ng_email_html_enabled_<?php echo $id; ?>').slideUp();jQuery('#wp_ng_email_plain_enabled_<?php echo $id; ?>').slideDown();return true;" type="radio" name="email_options[<?php echo $id; ?>][html]" value="0" <?php checked($opts['html'], 0); ?> /> <?php _e( 'No' ); ?></label> &nbsp;
  </span>
  <div class="wp-ng-divider"></div>
  <?php if (!$simple) : ?>
  <label class="wp-ng-block wp-ng-strong"><?php _e('Recipient', 'wp-ng') ?></label>
  <input type="text" class="wp-ng-full-width" name="email_options[<?php echo $id?>][recipient]" value="<?php echo $opts['recipient']; ?>" >
  <br>
  <label class="wp-ng-block wp-ng-strong"><?php _e('From Name', 'wp-ng') ?></label>
  <input type="text" class="wp-ng-full-width" name="email_options[<?php echo $id?>][from_name]" value="<?php echo $opts['from_name']; ?>" >
  <br>
  <label class="wp-ng-block wp-ng-strong"><?php _e('From Address', 'wp-ng') ?></label>
  <input type="text" class="wp-ng-full-width" name="email_options[<?php echo $id?>][from_address]" value="<?php echo $opts['from_address']; ?>" >
  <br>
  <?php endif; ?>
  <label class="wp-ng-block wp-ng-strong"><?php _e('Headers', 'wp-ng') ?></label>
  <textarea rows="4" class="wp-ng-full-width" name="email_options[<?php echo $id?>][headers]"><?php echo $opts['headers']; ?></textarea>
  <br>
  <label class="wp-ng-block wp-ng-strong"><?php _e('Heading', 'wp-ng') ?></label>
  <input type="text" class="wp-ng-full-width" name="email_options[<?php echo $id?>][heading]" value="<?php echo $opts['heading']; ?>" >
  <br>
  <label class="wp-ng-block wp-ng-strong"><?php _e('Subject', 'wp-ng') ?></label>
  <input type="text" class="wp-ng-full-width" name="email_options[<?php echo $id?>][subject]" value="<?php echo $opts['subject']; ?>" >
  <br>
  <div id="wp_ng_email_html_enabled_<?php echo $id; ?>" class="email-content-html-wrapper" <?php echo ($opts['html'] ? '' : 'style="display: none;"'); ?>>
    <label class="wp-ng-block wp-ng-strong"><?php _e('Html Content', 'wp-ng') ?></label>
    <?php wp_editor(
      htmlspecialchars_decode($opts['content_html']),
      'wp_ng_email_option_content_html_' . $id,
      apply_filters(
        'wp_ng_email_wpeditor_email_init',
        array(
          'textarea_name' => 'email_options[' . $id . '][content_html]',
          'tinymce' => apply_filters( 'wp_ng_email_tiny_mce_mail_init', array()),
        )
      ) );
    ?>
  </div>

  <div id="wp_ng_email_plain_enabled_<?php echo $id; ?>" class="email-content-plain-wrapper" <?php echo (!$opts['html'] ? '' : 'style="display: none;"'); ?>>
    <label class="wp-ng-block wp-ng-strong"><?php _e('Plain Text Content', 'wp-ng') ?></label>
    <textarea rows="4" class="wp-ng-full-width" name="email_options[<?php echo $id?>][content_plain]"><?php echo $opts['content_plain']; ?></textarea>
  </div>
</div>

<?php do_action( 'wp_ng_metabox-after-email-options', $id, $opts );?>
