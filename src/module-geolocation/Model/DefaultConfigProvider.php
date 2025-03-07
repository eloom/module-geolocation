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
			'geolocation' => [
				'active' => $this->helper->isGeolocationActive($storeId)
			]
		];
	}
	
	private function getStoreId() {
		return $this->storeManager->getStore()->getId();
	}
}