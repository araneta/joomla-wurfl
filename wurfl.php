<?php

defined('JPATH_BASE') or die;

class PlgSystemWurfl extends JPlugin
{
	private $wurflManager;
	private function init_config(){
		// Enable all error logging while in development
		//ini_set('display_errors', 'on');
		//error_reporting(E_ALL);

		//$wurflDir = dirname(__FILE__) . '/../../../WURFL';
		$wurflDir = $this->params->get('wurflDir');
		//$resourcesDir = dirname(__FILE__) . '/../../resources';
		$resourcesDir = $this->params->get('wurflResDir');

		require_once $wurflDir.'/Application.php';

		$persistenceDir = $resourcesDir.'/storage/persistence';
		$cacheDir = $resourcesDir.'/storage/cache';

		// Create WURFL Configuration
		$wurflConfig = new WURFL_Configuration_InMemoryConfig();

		// Set location of the WURFL File
		$wurflConfig->wurflFile($resourcesDir.'/wurfl.zip');

		// Set the match mode for the API ('performance' or 'accuracy')
		$wurflConfig->matchMode('performance');

		// Setup WURFL Persistence
		$wurflConfig->persistence('file', array('dir' => $persistenceDir));

		// Setup Caching
		$wurflConfig->cache('file', array('dir' => $cacheDir, 'expiration' => 36000));

		// Create a WURFL Manager Factory from the WURFL Configuration
		$wurflManagerFactory = new WURFL_WURFLManagerFactory($wurflConfig);

		// Create a WURFL Manager
		/* @var $wurflManager WURFL_WURFLManager */
		$this->wurflManager = $wurflManagerFactory->create();
	}
	public function onAfterInitialise()
	{
		$app = JFactory::getApplication();
		// Check that we are in the site application.
		if ($app->isAdmin())
		{
			return true;
		}		
		$this->init_config();
		$requestingDevice = $this->wurflManager->getDeviceForHttpRequest($_SERVER);
		$is_wireless = ($requestingDevice->getCapability('is_wireless_device') == 'true');
		$is_smarttv = ($requestingDevice->getCapability('is_smarttv') == 'true');
		$is_tablet = ($requestingDevice->getCapability('is_tablet') == 'true');
		$is_phone = ($requestingDevice->getCapability('can_assign_phone_number') == 'true');
		$is_mobile_device = ($is_wireless || $is_tablet);		
		
		$url = ''; 
		if (!$is_mobile_device) {
			if ($is_smarttv) {
				//echo "This is a Smart TV";
				$url = $this->params->get('smarttv');
			} else {
				//echo "This is a Desktop Web Browser";
				$url = $this->params->get('tablet');
			}
		} else {
			if ($is_tablet) {
				//echo "This is a Tablet";
				$url = $this->params->get('tablet');
			} else if ($is_phone) {
				//echo "This is a Mobile Phone";
				$url = $this->params->get('mobile_phone');
			} else {
				//echo "This is a Mobile Device";
				$url = $this->params->get('mobile_device');
			}
		}				
		if(!isset($_COOKIE['handheld_redirect']) ||
			(isset($_COOKIE['handheld_redirect']) && $_COOKIE['handheld_redirect']=='true')
		)
		{		
			if(!empty($url)){
				$this->display(array('url'=>$url));
				exit(0);
			}
		}
			
	}
	function display($params){
		$home = JURI::base();
		$base = $home .'/plugins/system/wurfl/tmpl/';
		extract($params);
		include dirname(__FILE__).'/tmpl/default.php';
	}
}
