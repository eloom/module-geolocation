<?php
/**
* 
* Geolocation para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Geolocation
* @copyright    Copyright (c) 2025 elOOm (https://eloom.com.br)
* @version      1.0.0
* @license      https://eloom.com.br/license/
*
*/
declare(strict_types=1);

namespace Eloom\Geolocation\Helper;

use Eloom\Geolocation\Model\Config\Backend\DbIpUpload;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {
	
	const XML_PATH_GEOLOCATION_ACTIVE = 'eloom_geolocation/geolocation/active';
	
	const XML_PATH_GEOIP_FILENAME = 'eloom_geolocation/geolocation/file_name';
	
	const XML_PATH_HERE_REST_API = 'eloom_geolocation/geolocation/here_api_key';
	
	private $varDirectory;

	public function __construct(Context $context, DirectoryList $directoryList) {
		$this->varDirectory = $directoryList->getPath(DirectoryList::VAR_DIR);

		parent::__construct($context);
	}

	public function getGeoIpFileName() {
		return $this->scopeConfig->getValue(self::XML_PATH_GEOIP_FILENAME, ScopeInterface::SCOPE_STORE, $storeId = 0);
	}

	public function getGeoIpFilePath() {
		$file = $this->varDirectory . DIRECTORY_SEPARATOR . DbIpUpload::BASE_PATH . DIRECTORY_SEPARATOR . $this->getGeoIpFileName();
		return $file;
	}
	
	public function isGeolocationActive($storeId = 0) {
		return (boolean) $this->scopeConfig->getValue(self::XML_PATH_GEOLOCATION_ACTIVE, ScopeInterface::SCOPE_STORE, $storeId);
	}
	
	public function getHereRestApiKey($storeId = 0): string {
		return $this->scopeConfig->getValue(self::XML_PATH_HERE_REST_API, ScopeInterface::SCOPE_STORE, $storeId);
	}

}