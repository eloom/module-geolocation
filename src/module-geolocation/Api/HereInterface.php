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

namespace Eloom\Geolocation\Api;

/**
 * Interface for managing HERE API.
 * @api
 * @since 100.0.2
 */
interface HereInterface {
	
	/**
	 * Find address by geocoordinates.
	 *
	 * @param string $lat
	 * @param string $lng
	 * @return string
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getAddressByGeocoordinates($lat, $lng);
}