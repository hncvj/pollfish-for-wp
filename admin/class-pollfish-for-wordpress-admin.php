<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.upwork.com/fl/hncvj
 * @since      1.0.0
 *
 * @package    Pollfish_For_Wordpress
 * @subpackage Pollfish_For_Wordpress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pollfish_For_Wordpress
 * @subpackage Pollfish_For_Wordpress/admin
 * @author     Spanrig Technologies <hncvj@engineer.com>
 */
class Pollfish_For_Wordpress_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $Pollfish_For_Wordpress_options    All the options of this plugin.
	 */

	private $Pollfish_For_Wordpress_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->Pollfish_For_Wordpress_options = get_option( 'Pollfish_For_Wordpress_option_name' );

		add_action( 'admin_menu', array( $this, 'Pollfish_For_Wordpress_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'Pollfish_For_Wordpress_page_init' ) );
		add_filter( 'plugin_action_links_pollfish-for-wordpress', 'pollfish_for_wordpress_action_links',10,1 );

	}



	public function pollfish_for_wordpress_action_links($links) { 
		$settings_link = '<a href="options-general.php?page=pollfish-for-wordpress.php">Settings</a>'; 
		$donate_link = '<a target="_blank" href="https://rzp.io/l/hncvj">Donate</a>';
		array_unshift($links, $donate_link);
		array_unshift($links, $settings_link); 
		return $links; 
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pollfish_For_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pollfish_For_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pollfish-for-wordpress-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pollfish_For_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pollfish_For_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pollfish-for-wordpress-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function Pollfish_For_Wordpress_add_plugin_page() {
		add_options_page(
			'PollFish for Wordpress', // page_title
			'PollFish for Wordpress', // menu_title
			'manage_options', // capability
			'pollfish-for-wordpress', // menu_slug
			array( $this, 'Pollfish_For_Wordpress_create_admin_page' ) // function
		);
	}


	public function Pollfish_For_Wordpress_create_admin_page() {

		require_once 'partials/'.$this->plugin_name.'-admin-display.php';
		 
	}
	

	public function Pollfish_For_Wordpress_page_init() {
		register_setting(
			'Pollfish_For_Wordpress_option_group', // option_group
			'Pollfish_For_Wordpress_option_name', // option_name
			array( $this, 'Pollfish_For_Wordpress_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'Pollfish_For_Wordpress_setting_section', // id
			'Settings', // title
			array( $this, 'Pollfish_For_Wordpress_setting_section' ), // callback
			'pollfish-for-wordpress-admin' // page
		);

		add_settings_field(
			'api_key', // id
			'API KEY*', // title
			array( $this, 'api_key_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section'  // section
		);

		add_settings_field(
			'secret_key', // id
			'Secret Key*', // title
			array( $this, 'secret_key_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section'  // section
		);

		add_settings_field(
			'indicator_position', // id
			'Indicator Position (Optional)', // title
			array( $this, 'indicator_position_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);

		
		add_settings_field(
			'rewardName', // id
			'Reward name (For Pollfish)', // title
			array( $this, 'rewardName_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section'  // section
		);
		
		add_settings_field(
			'set_mycred', // id
			'Enable MyCred Integration', // title
			array( $this, 'set_mycred_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);
		
		add_settings_field(
			'rewardConversion', // id
			'Reward Conversion/MyCred Reward Points', // title
			array( $this, 'rewardConversion_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section'  // section
		);
		
		
		add_settings_field(
			'mycred_reward_text', // id
			'MyCred Reward Text*', // title
			array( $this, 'mycred_reward_text_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section'  // section
		);
		

		add_settings_field(
			'offerwall', // id
			'Offerwall (Optional)', // title
			array( $this, 'offerwall_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);

		add_settings_field(
			'survey_format', // id
			'Survey Format (Optional)', // title
			array( $this, 'survey_format_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);

		add_settings_field(
			'css_selector', // id
			'CSS Selector trigger (Optional)', // title
			array( $this, 'css_selector_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);

		add_settings_field(
			'completion_redirection_page', // id
			'Completion Redirection Page', // title
			array( $this, 'completion_redirection_page_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);
		
		add_settings_field(
			'noteligible_redirection_page', // id
			'Not Eligible Redirection Page', // title
			array( $this, 'noteligible_redirection_page_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);
		
		add_settings_field(
			'nosurvey_redirection_page', // id
			'No Survey available Redirection Page', // title
			array( $this, 'nosurvey_redirection_page_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);

		add_settings_field(
			'page_landing_trigger', // id
			'Trigger on Page (Optional)', // title
			array( $this, 'page_landing_trigger_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);
		
		add_settings_field(
			'debug', // id
			'Debug (Optional)', // title
			array( $this, 'debug_callback' ), // callback
			'pollfish-for-wordpress-admin', // page
			'Pollfish_For_Wordpress_setting_section' // section
		);

		
	}

	public function Pollfish_For_Wordpress_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['api_key'] ) ) {
			$sanitary_values['api_key'] = sanitize_text_field($input['api_key']);
		}

		if ( isset( $input['secret_key'] ) ) {
			$sanitary_values['secret_key'] = sanitize_text_field($input['secret_key']);
		}

		if ( isset( $input['indicator_position'] ) ) {
			$sanitary_values['indicator_position'] = sanitize_text_field($input['indicator_position']);
		}
		
		
		if ( isset( $input['rewardConversion'] ) ) {
			$sanitary_values['rewardConversion'] = sanitize_text_field($input['rewardConversion']);
		}
		
		if ( isset( $input['rewardName'] ) ) {
			$sanitary_values['rewardName'] = sanitize_text_field($input['rewardName']);
		}
		
		if ( isset( $input['set_mycred'] ) ) {
			$sanitary_values['set_mycred'] = sanitize_text_field($input['set_mycred']);
		}
		
		if ( isset( $input['mycred_reward_text'] ) ) {
			$sanitary_values['mycred_reward_text'] = sanitize_text_field($input['mycred_reward_text']);
		}
		
		if ( isset( $input['debug'] ) ) {
			$sanitary_values['debug'] = sanitize_text_field($input['debug']);
		}

		if ( isset( $input['offerwall'] ) ) {
			$sanitary_values['offerwall'] = sanitize_text_field($input['offerwall']);
		}

		if ( isset( $input['survey_format'] ) ) {
			$sanitary_values['survey_format'] = sanitize_text_field($input['survey_format']);
		}

		if ( isset( $input['css_selector'] ) ) {
			$sanitary_values['css_selector'] = sanitize_text_field($input['css_selector']);
		}

		if ( isset( $input['completion_redirection_page'] ) ) {
			$sanitary_values['completion_redirection_page'] = sanitize_text_field($input['completion_redirection_page']);
		}
		
		if ( isset( $input['noteligible_redirection_page'] ) ) {
			$sanitary_values['noteligible_redirection_page'] = sanitize_text_field($input['noteligible_redirection_page']);
		}
		
		if ( isset( $input['nosurvey_redirection_page'] ) ) {
			$sanitary_values['nosurvey_redirection_page'] = sanitize_text_field($input['nosurvey_redirection_page']);
		}

		if ( isset( $input['page_landing_trigger'] ) ) {
			$sanitary_values['page_landing_trigger'] = sanitize_text_field($input['page_landing_trigger']);
		}


		return $sanitary_values;
	}

	public function Pollfish_For_Wordpress_setting_section() {
		
	}

	public function api_key_callback() {		
		printf(
			'<input class="regular-text" type="text" name="Pollfish_For_Wordpress_option_name[api_key]" id="api_key" value="%s" required>',
			isset( $this->Pollfish_For_Wordpress_options['api_key'] ) ? esc_attr( $this->Pollfish_For_Wordpress_options['api_key']) : ''
		);
	}

	public function secret_key_callback() {		
		printf(
			'<input class="regular-text" type="text" name="Pollfish_For_Wordpress_option_name[secret_key]" id="secret_key" value="%s" required>',
			isset( $this->Pollfish_For_Wordpress_options['secret_key'] ) ? esc_attr( $this->Pollfish_For_Wordpress_options['secret_key']) : ''
		);
	}


	public function indicator_position_callback() {
		?> <select name="Pollfish_For_Wordpress_option_name[indicator_position]" id="indicator_position">
			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['indicator_position'] ) && $this->Pollfish_For_Wordpress_options['indicator_position'] === 'TOP_LEFT') ? 'selected' : '' ; ?>
			<option value="TOP_LEFT" <?php echo $selected; ?>>TOP LEFT</option>

			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['indicator_position'] ) && $this->Pollfish_For_Wordpress_options['indicator_position'] === 'TOP_RIGHT') ? 'selected' : '' ; ?>
			<option value="TOP_RIGHT" <?php echo $selected; ?>>TOP RIGHT</option>

			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['indicator_position'] ) && $this->Pollfish_For_Wordpress_options['indicator_position'] === 'BOTTOM_LEFT') ? 'selected' : '' ; ?>
			<option value="BOTTOM_LEFT" <?php echo $selected; ?>>BOTTOM LEFT</option>

			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['indicator_position'] ) && $this->Pollfish_For_Wordpress_options['indicator_position'] === 'BOTTOM_RIGHT') ? 'selected' : '' ; ?>
			<option value="BOTTOM_RIGHT" <?php echo $selected; ?>>BOTTOM RIGHT</option>
		</select> <?php
	}
	
	public function debug_callback() {
		?> <select name="Pollfish_For_Wordpress_option_name[debug]" id="debug">
			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['debug'] ) && $this->Pollfish_For_Wordpress_options['debug'] === 'false') ? 'selected' : '' ; ?>
			<option value="false" <?php echo $selected; ?>>False</option>
			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['debug'] ) && $this->Pollfish_For_Wordpress_options['debug'] === 'true') ? 'selected' : '' ; ?>
			<option value="true" <?php echo $selected; ?>>True</option>
		</select> <?php
	}
	
	public function set_mycred_callback() {
		?> <select name="Pollfish_For_Wordpress_option_name[set_mycred]" id="set_mycred">
			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['set_mycred'] ) && $this->Pollfish_For_Wordpress_options['set_mycred'] !== 'true' && !is_plugin_active( 'mycred/mycred.php' )) ? 'selected' : '' ; ?>
			<option value="false" <?php echo $selected; ?>>No</option>
			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['set_mycred'] ) && $this->Pollfish_For_Wordpress_options['set_mycred'] === 'true' && is_plugin_active( 'mycred/mycred.php' )) ? 'selected' : '' ; ?>
			<option value="true" <?php echo $selected; ?>>Yes</option>
		</select> <?php
	}

	public function offerwall_callback() {
		?> <select name="Pollfish_For_Wordpress_option_name[offerwall]" id="offerwall">
			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['offerwall'] ) && $this->Pollfish_For_Wordpress_options['offerwall'] === 'false') ? 'selected' : '' ; ?>
			<option value="false" <?php echo $selected; ?>>False</option>
			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['offerwall'] ) && $this->Pollfish_For_Wordpress_options['offerwall'] === 'true') ? 'selected' : '' ; ?>
			<option value="true" <?php echo $selected; ?>>True</option>
		</select> <?php
	}
	

	public function survey_format_callback() {
		?> <select name="Pollfish_For_Wordpress_option_name[survey_format]" id="survey_format">
			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['survey_format'] ) && $this->Pollfish_For_Wordpress_options['survey_format'] === '0') ? 'selected' : '' ; ?>
			<option value="0" <?php echo $selected; ?>>Basic</option>

			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['survey_format'] ) && $this->Pollfish_For_Wordpress_options['survey_format'] === '1') ? 'selected' : '' ; ?>
			<option value="1" <?php echo $selected; ?>>Playful</option>

			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['survey_format'] ) && $this->Pollfish_For_Wordpress_options['survey_format'] === '2') ? 'selected' : '' ; ?>
			<option value="2" <?php echo $selected; ?>>Random</option>

			<?php $selected = (isset( $this->Pollfish_For_Wordpress_options['survey_format'] ) && $this->Pollfish_For_Wordpress_options['survey_format'] === '3') ? 'selected' : '' ; ?>
			<option value="3" <?php echo $selected; ?>>3rd-party</option>
		</select> <?php
	}

	public function rewardConversion_callback() {		
		printf(
			'<input class="regular-text" type="text" name="Pollfish_For_Wordpress_option_name[rewardConversion]" id="rewardConversion" value="%s">',
			isset( $this->Pollfish_For_Wordpress_options['rewardConversion'] ) ? esc_attr( $this->Pollfish_For_Wordpress_options['rewardConversion']) : '5'
		);
	}

	public function rewardName_callback() {		
		printf(
			'<input class="regular-text" type="text" name="Pollfish_For_Wordpress_option_name[rewardName]" id="rewardName" value="%s">',
			isset( $this->Pollfish_For_Wordpress_options['rewardName'] ) ? esc_attr( $this->Pollfish_For_Wordpress_options['rewardName']) : 'Credits'
		);
	}

	public function mycred_reward_text_callback() {		
		printf(
			'<input class="regular-text" type="text" name="Pollfish_For_Wordpress_option_name[mycred_reward_text]" id="mycred_reward_text" value="%s" required>',
			isset( $this->Pollfish_For_Wordpress_options['mycred_reward_text'] ) ? esc_attr( $this->Pollfish_For_Wordpress_options['mycred_reward_text']) : 'Rewarded for Completion Survey.'
		);
	}

	public function css_selector_callback() {		
		printf(
			'<input class="regular-text" type="text" name="Pollfish_For_Wordpress_option_name[css_selector]" id="css_selector" value="%s">',
			isset( $this->Pollfish_For_Wordpress_options['css_selector'] ) ? esc_attr( $this->Pollfish_For_Wordpress_options['css_selector']) : ''
		);
	}


	public function completion_redirection_page_callback(){
		echo '<select name="Pollfish_For_Wordpress_option_name[completion_redirection_page]" id="completion_redirection_page">';
			$selected = (isset( $this->Pollfish_For_Wordpress_options['completion_redirection_page'] ) && $this->Pollfish_For_Wordpress_options['completion_redirection_page'] === 'none') ? 'selected' : '' ;
			echo '<option value="none" '.$selected.'>None</option>';
			$pages = get_pages(); 
			foreach ( $pages as $page ) {
				$selected = (isset( $this->Pollfish_For_Wordpress_options['completion_redirection_page'] ) && $this->Pollfish_For_Wordpress_options['completion_redirection_page'] == $page->ID) ? 'selected' : '' ;
				echo '<option value="' .$page->ID. '" '.$selected.'>'.$page->post_title.'</option>';
			}
		echo '</select>';
	}
	
	public function noteligible_redirection_page_callback(){
		echo '<select name="Pollfish_For_Wordpress_option_name[noteligible_redirection_page]" id="noteligible_redirection_page">';
			$selected = (isset( $this->Pollfish_For_Wordpress_options['noteligible_redirection_page'] ) && $this->Pollfish_For_Wordpress_options['noteligible_redirection_page'] === 'none') ? 'selected' : '' ;
			echo '<option value="none" '.$selected.'>None</option>';
			$pages = get_pages(); 
			foreach ( $pages as $page ) {
				$selected = (isset( $this->Pollfish_For_Wordpress_options['noteligible_redirection_page'] ) && $this->Pollfish_For_Wordpress_options['noteligible_redirection_page'] == $page->ID) ? 'selected' : '' ;
				echo '<option value="' .$page->ID. '" '.$selected.'>'.$page->post_title.'</option>';
			}
		echo '</select>';
	}
	
	public function nosurvey_redirection_page_callback(){
		echo '<select name="Pollfish_For_Wordpress_option_name[nosurvey_redirection_page]" id="nosurvey_redirection_page">';
			$selected = (isset( $this->Pollfish_For_Wordpress_options['nosurvey_redirection_page'] ) && $this->Pollfish_For_Wordpress_options['nosurvey_redirection_page'] === 'none') ? 'selected' : '' ;
			echo '<option value="none" '.$selected.'>None</option>';
			$pages = get_pages(); 
			foreach ( $pages as $page ) {
				$selected = (isset( $this->Pollfish_For_Wordpress_options['nosurvey_redirection_page'] ) && $this->Pollfish_For_Wordpress_options['nosurvey_redirection_page'] == $page->ID) ? 'selected' : '' ;
				echo '<option value="' .$page->ID. '" '.$selected.'>'.$page->post_title.'</option>';
			}
		echo '</select>';
	}

	public function page_landing_trigger_callback(){
		echo '<select style="min-height:400px;" multiple="multiple" name="Pollfish_For_Wordpress_option_name[page_landing_trigger][]" id="page_landing_trigger">';
			$pages = get_pages(); 
			foreach ( $pages as $page ) {
				$selected = '';
				if (is_array($this->Pollfish_For_Wordpress_options['page_landing_trigger']) && !is_null($this->Pollfish_For_Wordpress_options['page_landing_trigger'])) {
					$selected = in_array( $page->ID, $this->Pollfish_For_Wordpress_options['page_landing_trigger'] ) ? ' selected="selected" ' : '';
				}
				echo '<option value="' .$page->ID. '" '.$selected.'>'.$page->post_title.'</option>';
				
			}
			
		echo '</select>';
	}

}