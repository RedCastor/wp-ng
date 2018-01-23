<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

echo '<p class="description">';
  echo '<table>';
  foreach ( $email_help_vars as $key => $email_help_var) {
    printf( '<tr><td>%s:</td><td>%s</td></tr>', $email_help_var['title'], $email_help_var['desc'] );
  }
  echo '</table>';
echo '</p>';
