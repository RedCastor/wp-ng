<?php
/**
 * Is IE Template
 * Load on condition redirect
 *
 * This template can be overridden by copying it to yourtheme/wp-ng/is-ie.php.
 *
 * @package    Wp_Ng
 * @subpackage Wp_Ng/public/templates
 * @author     RedCastor <team@redcastor.io>
 * @since      1.6.3
 */


$asset_css = wp_ng_get_asset_path('styles/outdatedbrowser.css');
$asset_font = (is_ssl() ? 'https' : 'http') . '://fonts.googleapis.com/css?family=Lato';

$outdated_browser_link = 'http://outdatedbrowser.com/' . substr(get_locale(), 0, 2);


?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <title><?php _e('You are using an outdated browser.', 'wp-ng'); ?></title>
  <meta name="description" content="<?php _e('You are using an outdated browser.', 'wp-ng'); ?>">
  <!-- Styles -->
  <link rel="stylesheet" href="<?php echo esc_attr($asset_css) ?>">
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
  <style type="text/css">
    body {
      font-family: 'Lato', sans-serif; text-align: center;
      background-color: #fafafa; color: #0a0a0a; line-height: 1.5em;
    }
  </style>
</head>

<body>
  <div id="outdated">
    <h6>Your browser is out-of-date!</h6>
    <p>Update your browser to view this website correctly. <a id="btnUpdateBrowser" target="_blank" href="<?php echo esc_url($outdated_browser_link); ?>">Update my browser now </a></p>
  </div>
</body>
</html>
