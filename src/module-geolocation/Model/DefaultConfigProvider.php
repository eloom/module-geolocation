<?php
/**
* 
* Geolocation para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Geolocation
* @copyright    Copyright (c) 2021 Ã©lOOm (https://eloom.tech)
* @version      1.0.0
* @license      https://eloom.tech/license/
*
*/
declare(strict_types=1);

namespace Eloom\Geolocation\Model;

use Eloom\Geolocation\Helper\Data;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Store\Model\StoreManagerInterface;

class DefaultConfigProvider implements ConfigProviderInterface {
	
	private $storeManager;
	
	private $helper;
	
	public function __construct(StoreManagerInterface $storeManager,
	                            Data $helper) {
		$this->storeManager = $storeManager;
		$this->helper = $helper;
	}
	
	public function getConfig() {
		$storeId = $this->getStoreId();
		
		return [
			'active' => $this->helper->isGeolocationActive($storeId)
		];
	}
	
	private function getStoreId() {
		return $this->storeManager->getStore()->getId();
	}
}