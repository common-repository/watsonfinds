<?php

if (!defined('ABSPATH')) {
	exit;
}


class Watsonfinds
{
	private static $instance;

	static function getInstance()
	{
		if (!isset(self::$instance))
          {
              self::$instance = new self();
          }
          return self::$instance;
	}

	public static function activate() {
		
	}

	public static function deactivate() {
		
	}

	public function init()
	{
		add_action('admin_menu', array($this, 'add_menu'));
		add_action('add_meta_boxes', array($this, 'add_post_box') );
		add_action('admin_enqueue_scripts', array($this, 'load_scripts'));
		add_action('wp_ajax_watsonfinds', array($this, 'callAPI'));
		add_action('admin_head', array($this, 'custom_mce_button'));
		add_filter('wp_comment_reply', array($this, 'test_reply_comment_func'), 10, 2);
		
		
	}

	

	

	public function test_reply_comment_func($str, $input) {
		global $pagenow;
		if($pagenow == 'edit-comments.php')
		{
		    print   '<div class="wrap" id="watsonfinds">

						<h2 <span>Watsonfinds</span></h2>
						
			  				<hr>
						<p>
							<label for="watsonfinds-post-class">Insert your content to be analyzed</label>
							<br>
						</p>
						<div>
			                <textarea id="watsonfinds-textarea"  rows="10" placeholder="Insert your content here"></textarea>
					    </div>
					    <br/>
					    <a href="#" class="button button-primary button-large" id="watsonfinds-process-textarea">Analyze</a>
					    <a class="watsonfinds-go-premium-tabs" href="http://www.watsonfinds.com/wordpress-go-premium/" target="_blank">Go Premium</a>
							  
					</div>';
		}
	}


	

	public function add_post_box()
	{
		if (get_current_screen()->is_block_editor()){
			add_meta_box( 'watsonfinds', 'Watsonfinds', array($this, 'add_post_box_render'), array('post', 'product', 'page', 'comment'), $context = 'normal', $priority = 'high', $callback_args = null );
		}
		
	}

	public function add_post_box_render($object, $box)
	{
		?>

  			<?php wp_nonce_field( basename( __FILE__ ), 'smashing_post_class_nonce' ); ?>

			  <p>
			  	<!-- <label for="watsonfinds-post-class"><?php _e( INSERT_CONTENT, 'watsonfinds' ); ?></label>
				  <a href='#' class= "button button-primary button-large" id="watsonfinds-process-textarea"><?php _e( ANALYZE_CONTENT, 'watsonfinds' ); ?></a>
			    <br/>
			    <br/>
			    <div>
	                <textarea id="watsonfinds-textarea" cols="50" rows="10" placeholder="<?php _e( INSERT_PLACEHOLDER, 'watsonfinds' ); ?>"></textarea>
	            </div>
	            <br/> -->
	            <a href='#' class= "button button-primary button-large" id="watsonfinds-process-gutenberg"><?php _e( ANALYZE_BUTTON, 'watsonfinds' ); ?></a>
	            <a class="watsonfinds-go-premium-tabs" href="http://www.watsonfinds.com/wordpress-go-premium/" target="_blank">Go Premium</a>
			  </p>
		<?php 
	}

	public function add_menu() 
	{
			add_menu_page('Watsonfinds', 'Watsonfinds', 'edit_posts', 'watsonfinds-menu', array($this, 'render_menu_page'), 'dashicons-admin-generic', 6);
	}

	public function render_menu_page()
	{
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'about';
	?>
		<div class="wrap">
			<h1>Watsonfinds</h1>
			<strong style="font-style:italic;"><?php _e('Start making impact with your content.', 'watsonfinds' ); ?></strong>
			<br/>
			<br/>
			<div class="nav-tab-wrapper">
			    <a href="?page=watsonfinds-menu&tab=about" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>">About</a>
			    <a href="?page=watsonfinds-menu&tab=analyzer" class="nav-tab <?php echo $active_tab == 'analyzer' ? 'nav-tab-active' : ''; ?>">Analyze</a>
			</div>
			<br/>
	    </div>

	<?php
		if($active_tab== 'analyzer')
		{
			$this->render_menu_page_analyzer();
		}
		if($active_tab== 'about')
		{
			$this->render_menu_page_about();
		}
	}

	

	public function render_menu_page_analyzer()
	{
	?>
		<div class="wrap">
			<p>
				<strong>Place your own content below to be analyzed.</strong>
				<br/>
				<br/>
				<span style="font-style:italic;color:grey;">You can find this functionality in every posts, products or comments pages and analyze its content right there.</span>
			</p>
        	<textarea id="watsonfinds-textarea" cols="50" rows="10" placeholder="<?php _e( INSERT_PLACEHOLDER, 'watsonfinds' ); ?>"></textarea>
        	<br/>
        	<br/>
        	<a href='#' class= "button button-primary button-large" id="watsonfinds-process-textarea"><?php _e( ANALYZE_BUTTON, 'watsonfinds' ); ?></a>
        	<a class="watsonfinds-go-premium-tabs" href="http://www.watsonfinds.com/wordpress-go-premium/" target="_blank">Go Premium</a>
        </div>
	<?php
	}

	

	public function render_menu_page_about()
	{
		?>
			<div class="wrap">
				<div style="max-width:700px;">

					<h2>About the Plugin</h2>
					<p>Be able to Improve the impact of your content on your audience by combining the power of artificial intelligence and scientific investigations of human behavior.</p>
					<p>This plugin will scan and analyze every single word of your content presenting you a set of insights such as emotion, language style and social tendencies to bring you an accurate prediction of how your message will be perceived.</p>
					<p>By using this tool you will enjoy the talent of delivering the exact idea, concept and feeling you want to transmit about your brand, campaigns, products or content.</p>
					<br />
					<a href="http://www.watsonfinds.com/about" target="_blank" class="button button-primary button-large">Learn More</a>
					<a class="watsonfinds-go-premium-tabs" href="http://www.watsonfinds.com/wordpress-go-premium/" target="_blank" >Go Premium</a>

					<br />
					<br />
					<hr />
					<br />

					<h2>Give Us Your Feedback</h2>

					<p>We focus on creating a great product, and the best way we can achieve that is by taking our user's feedbacks.</p>
					<br />
					<a href="http://www.watsonfinds.com/feedback" target="_blank" class="button button-primary button-large">Give Your Feedback</a>
				</div>
			</div>
		<?php
	}


	public function load_scripts($hook)
	{
		
		wp_register_style('watsonfinds-admin-css', WATSONFINDS_URI . 'includes/assets/css/style.css');
	    wp_enqueue_style('watsonfinds-admin-css');
	    wp_register_style('watsonfinds-modal-css', WATSONFINDS_URI . 'includes/assets/css/jquery.modal.css');
	    wp_enqueue_style('watsonfinds-modal-css');
	    // wp_register_style('watsonfinds-style-css', WATSONFINDS_URI . 'includes/assets/css/popup.css');
	    // wp_enqueue_style('watsonfinds-style-css');
	    wp_enqueue_script('watsonfinds', WATSONFINDS_URI . 'includes/assets/js/watsonfinds.js', array('jquery'), '1.0', true);
		wp_enqueue_script('watsonfinds-modal-js', WATSONFINDS_URI . 'includes/assets/js/jquery.modal.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('watsonfinds_tinyMCE', WATSONFINDS_URI . 'includes/assets/js/tinyMCE_plugin.js', array('jquery'), '1.0', true);
		global $post;
		global $pagenow;
		$type = '';
		if($post)
		{
			$type = $post->post_type;
		}
		wp_localize_script('watsonfinds', 'watsonfinds_vars', array('page' => $pagenow, 'type' => $type, 'wp_admin' => admin_url()));
	}


	public function callAPI()
	{
		$result = 'no Content';
		$content = $_POST['content'];
		$page = $_POST['page'];
		$type = $_POST['type'];
		if($content)
		{
			$response = $this->callService('content='.$content.'&page='. $page .'&type='. $type);
			if(isset($response['validate']))
			{
				$result = $this->callService('text='.$content, $response['validate']);
				$result = $this->callService('payload='.json_encode($result).'&page='. $page .'&type='. $type.'&content='.$content);
			}
			else
			{
				$result = $response;
			}
		}
		print $result;
		die();
	}

	private function callService($data, $url = WATSONFINDSURL)
	{
		$post_string = $data;
	    $curl = curl_init();
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_string );
	    
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	    $result = curl_exec($curl);
	    curl_close($curl);
		return json_decode($result, true);
	}
	

	public function custom_mce_button() 
	{
		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) 
		{
	    	return;
		}
		  // Check if WYSIWYG is enabled

	  	if ( 'true' == get_user_option( 'rich_editing' ) ) 
	  	{
	    	add_filter( 'mce_external_plugins', array($this, 'custom_tinymce_plugin') );
	    	add_filter( 'mce_buttons', array($this, 'register_mce_button' ));
	  	}
	}

	public function custom_tinymce_plugin( $plugin_array ) 
	{
  		$plugin_array['custom_mce_button'] = WATSONFINDS_URI . 'includes/assets/js/tinyMCE_plugin.js';
  		return $plugin_array;
	}

	public function register_mce_button( $buttons ) 
	{
  		array_push( $buttons, 'custom_mce_button' );
  		return $buttons;
	}

	

}	