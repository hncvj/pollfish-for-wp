<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.upwork.com/fl/hncvj
 * @since      1.0.0
 *
 * @package    Pollfish_For_Wordpress
 * @subpackage Pollfish_For_Wordpress/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Pollfish_For_Wordpress
 * @subpackage Pollfish_For_Wordpress/public
 * @author     Spanrig Technologies <hncvj@engineer.com>
 */
class Pollfish_For_Wordpress_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->Pollfish_For_Wordpress_options = get_option( 'Pollfish_For_Wordpress_option_name' );
		add_action( 'wp_head', array( $this, 'pollfish_print_config' ) );
		add_action( 'wp_footer',array( $this, 'pollfish_print_triggers' ) );
		add_action( 'wp_ajax_award_mycred_credits', array( $this, 'award_mycred_credits'));
	}

	public function generateRandomString($length = 10) {
	    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function pollfish_print_config(){
		$options = $this->Pollfish_For_Wordpress_options;

		$pollfishConfig  = array();
		$api_key = $indicator_position = $secret_key = $debug = $offerwall = '';
		$pollfishconf = 'var pollfishConfig = {';
		if(!empty($options['api_key'])){
			$pollfishconf .= '"api_key": "'.sanitize_text_field($options['api_key']).'",';
			
		}

		if(!empty($options['secret_key'])){
			$pollfishconf .= '"secret_key": "'.sanitize_text_field($options['secret_key']).'",';
		}

		if(!empty($options['indicator_position'])){
			$pollfishconf .= '"indicator_position": "'.sanitize_text_field($options['indicator_position']).'",';
		}

		if(!empty($options['debug'])){
			$pollfishconf .= '"debug": "'.sanitize_text_field($options['debug']).'",';

			if($debug && !empty($options['survey_format'])){
				$pollfishconf .= '"survey_format": "'.sanitize_text_field($options['survey_format']).'",';
			}
		}


		if(!empty($options['offerwall'])){
			$pollfishconf .= '"offerwall": "'.sanitize_text_field($options['offerwall']).'",';
		}

		if(!empty($options['rewardName'])){
			$pollfishConfig['rewardName'] = sanitize_text_field($options['rewardName']);
		}

		$pollfishConfig['clickId'] = $this->generateRandomString();

		if(!empty($options['rewardConversion'])){
			$pollfishConfig['rewardConversion'] = sanitize_text_field($options['rewardConversion']);

			

			if(!empty($pollfishConfig['rewardName']) && !empty($pollfishConfig['clickId']) && !empty($secret_key)){
				$pollfishConfig['sig'] =  base64_encode(hash_hmac("sha1" , $pollfishConfig['rewardConversion'].$pollfishConfig['rewardName'].$pollfishConfig['clickId'], $secret_key, true));
			}
			
		}

		if(is_user_logged_in()){
		
			$user = wp_get_current_user();
			$userdetails = array();

			$pollfishconf .= '"user_id": "'.$user->user_login.'",';
			$gender = $user->user_gender;


			if(!empty($gender)){
				$pollfishConfig['user']['gender'] = ($gender == 'Male') ? 1 : 0;
				
			}
			 	
		}		

		if(!empty($options['completion_redirection_page']) && $options['completion_redirection_page'] !== 'none'){
			$pollfishconf .= '"surveyCompletedCallback": pollfishsurveyCompletedCallback,';
		}
		
		if(!empty($options['noteligible_redirection_page']) && $options['noteligible_redirection_page'] !== 'none'){
			$pollfishconf .= '"userNotEligibleCallback": userNotEligibleCallbackCallback,';
		}
		
		if(!empty($options['nosurvey_redirection_page']) && $options['nosurvey_redirection_page'] !== 'none'){
			$pollfishconf .= '"surveyNotAvailable": surveyNotAvailableCallback';
		}
		$pollfishconf .= '};';
		echo "<script type='text/javascript'>".$pollfishconf;

		//Redirect after Completion
		if(!empty($options['completion_redirection_page']) && $options['completion_redirection_page'] !== 'none'){
			$slug = get_permalink($options['completion_redirection_page']);
			if(is_user_logged_in() && isset($options['set_mycred']) && !empty($options['set_mycred']) && $options['set_mycred']){ ?>
					function pollfishsurveyCompletedCallback(){
						setTimeout(function(){ 
							jQuery.ajax({
								type : "post",
								dataType : "json",
								url : pfwp_data.ajaxurl,
								data : {action: "award_mycred_credits", user_id : pfwp_data.user_id, nonce: pfwp_data.nonce},
								success: function(response) {
									window.location.href = '/<?php echo $slug;?>';
								}
							});
						}, 5000);

				    	
					}
		<?php }else{ ?>
					function pollfishsurveyCompletedCallback(){
						setTimeout(function(){ 
					    	window.location.href = '/<?php echo $slug;?>';
						}, 5000);
					}
		<?php } 
		}
		
		if(!empty($options['noteligible_redirection_page']) && $options['noteligible_redirection_page'] !== 'none'){
			$slug = get_permalink($options['noteligible_redirection_page']); ?>
					function userNotEligibleCallbackCallback(){
					    window.location.href = '/<?php echo $slug;?>';
					}  
		<?php }
		
		if(!empty($options['nosurvey_redirection_page']) && $options['nosurvey_redirection_page'] !== 'none'){
			$slug = get_permalink($options['nosurvey_redirection_page']); ?>
					function surveyNotAvailableCallback(){
					    window.location.href = '/<?php echo $slug;?>';
					}  
		<?php }

		echo "</script>";

		wp_enqueue_script( 'pollfish_min_js', 'https://storage.googleapis.com/pollfish_production/sdk/webplugin/pollfish.min.js', array( 'jquery' ), $this->version, false );
		if(is_user_logged_in()){
			wp_localize_script( 'pollfish_min_js', 'pfwp_data', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'user_id'=>$user->ID,'nonce'=>wp_create_nonce("award_mycred_credits_nonce")));
		}		

	}

	public function pollfish_print_triggers(){
		$options = $this->Pollfish_For_Wordpress_options;
		if(!empty($options['css_selector']) || !empty($options['page_landing_trigger'])){
			echo "<style>#pollfishIndicator{display:none !important;}</style>";
		}
		echo '
		<script>jQuery( document ).ready(function() {';
		
		//Css Selector Based Trigger
		if(!empty($options['css_selector'])){ 
			$selector = $options['css_selector']; ?>
			jQuery(document).on("click","<?php echo $selector;?>",function() {
			    jQuery("#pollfishIndicator").trigger('click');
			});
		<?php }

		//Page Based Trigger
		if(!empty($options['page_landing_trigger']) && $options['page_landing_trigger'] !== 'none'){ 
			global $post;
    		if(in_array( $post->ID, $options['page_landing_trigger'] )){ ?>
    			setTimeout(function(){ 
					jQuery("#pollfishIndicator").trigger('click');
				 }, 1000);
    		<?php }
		} 
		echo '});</script>';

	}



	public function award_mycred_credits(){

		$options = $this->Pollfish_For_Wordpress_options;

		if ( !wp_verify_nonce( $_REQUEST['nonce'], "award_mycred_credits_nonce")) {
			exit("No naughty business please");
		}  

		if(empty($_REQUEST["user_id"])){
			exit("No User ID Specified");
		}

		$user_id = intval($_REQUEST["user_id"]);

		$mycred = mycred('mycred_default');


		// Adjust balance with a log entry
		$addcred = $mycred->add_creds('survey',$user_id,$options['rewardConversion'],$options['mycred_reward_text']);

		if($addcred === false) {
			$result['type'] = "error";
		}else {
			$result['type'] = "success";
		}

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$result = json_encode($result);
			echo $result;
		}else {
			header("Location: ".$_SERVER["HTTP_REFERER"]);
		}
		die();
	}


	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pollfish-for-wordpress-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pollfish-for-wordpress-public.js', array( 'jquery' ), $this->version, false );

	}

}
