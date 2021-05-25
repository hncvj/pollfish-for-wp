<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.upwork.com/fl/hncvj
 * @since      1.0.0
 *
 * @package    Pollfish_For_Wordpress
 * @subpackage Pollfish_For_Wordpress/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
	<h2>PollFish for Wordpress - <a target="_blank" href="https://rzp.io/l/hncvj">☕ Buy me a Coffee</a></h2>
	<p>Setup all the parameters require for PollFish.</p>
	<p>Note: For MyCred Integration. You require to have MyCred Plugin installed and Activated.</p>
	<?php settings_errors(); ?>

	<form method="post" action="options.php">
		<?php
			settings_fields( 'Pollfish_For_Wordpress_option_group' );
			do_settings_sections( 'pollfish-for-wordpress-admin' );
			submit_button();
		?>
	</form>
</div>
