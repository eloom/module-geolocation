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

namespace Eloom\Geolocation\Model\ResourceModel\PostalCode;

interface EngineResolverInterface {
	
	public function getCurrentSearchEngine();
}