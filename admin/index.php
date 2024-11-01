<?php
	if(!class_exists('WatsonfindsPro'))
	{

		define( 'WATSONFINDS_URI' , plugin_dir_url(__FILE__) . "/");

		
		define('WATSONFINDSURL', 'https://www.watsonfinds.com/api/wordpress/watsonfinds.php');
		

		define('INSERT_CONTENT', 'Use this section if you cannot analyze the content with the standard wordpress text editor');
		define('INSERT_PLACEHOLDER', "Insert your content here");
		define('ANALYZE_BUTTON', "Analyze");

		require(dirname(__FILE__) . '/includes/watsonfinds_class.php');

		$watsonfinds = Watsonfinds::getInstance();
		add_action('plugins_loaded', array($watsonfinds, 'init'), 10);

	}


?>