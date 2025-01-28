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

namespace Eloom\Geolocation\Model\ResourceModel\PostalCode;

interface EngineHandlerInterface {
	
	/**
	 * @param string $postalcode
	 * @return array
	 */
	public function query(string $postalcode): array;
	
	/**
	 * @return boolean
	 */
	public function isAvailable(): bool;
}