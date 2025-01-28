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

use Eloom\Geolocation\Api\AutocompleteInterface;
use Eloom\Geolocation\Model\ResourceModel\PostalCode\EngineHandlerFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;

class Autocomplete implements AutocompleteInterface {
	
	private $engineHandlerFactory;
	
	private $serializer;
	
	public function __construct(EngineHandlerFactory $engineHandlerFactory, Json $serializer = null) {
		$this->engineHandlerFactory = $engineHandlerFactory;
		$this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
	}
	
	/**
	 * @inheritDoc
	 */
	public function getAddressByPostalCode($zipcode) {
		$factory = $this->engineHandlerFactory->create();
		$address = $factory->query($zipcode);
		
		return $this->serializer->serialize($address);
	}
}