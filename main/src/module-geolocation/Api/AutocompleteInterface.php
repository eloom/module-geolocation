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

namespace Eloom\Geolocation\Api;

/**
 * Interface for managing zipcode.
 * @api
 * @since 100.0.2
 */
interface AutocompleteInterface {

	/**
	 * Get address by zipcode.
	 *
	 * @param string $zipcode
	 * @return string
	 * @throws \Magento\Framework\Exception\LocalizedException
	 */
	public function getAddressByPostalCode($zipcode);
}