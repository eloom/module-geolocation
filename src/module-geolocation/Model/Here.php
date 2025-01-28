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

use Eloom\Core\Enumeration\HttpStatus;
use Eloom\Geolocation\Api\HereInterface;
use Eloom\Geolocation\Helper\Data;
use GuzzleHttp\Client;
use Magento\Directory\Model\RegionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Directory\Model\Country;

class Here implements HereInterface {

	private $regionFactory;

	private $storeManager;

	private $helper;

	private $serializer;
	
	private $country;
	
	public function __construct(RegionFactory $regionFactory,
	                            StoreManagerInterface $storeManager,
	                            Data $helper,
	                            Json $serializer = null,
	                            Country $country = null) {
		$this->regionFactory = $regionFactory;
		$this->storeManager = $storeManager;
		$this->helper = $helper;
		$this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
		$this->country = $country ?: ObjectManager::getInstance()->get(Country::class);
	}

	/**
	 * @inheritDoc
	 */
	public function getAddressByGeocoordinates($lat, $lng) {
		$response = ['code' => HttpStatus::OK()->getCode()];
		$apiKey = $this->helper->getHereRestApiKey();
		
		try {
			$client = new Client();
			$hereResponse = $client->get("https://revgeocode.search.hereapi.com/v1/revgeocode?at=${lat},${lng}&apiKey=${apiKey}", [
				'headers' => array_merge(array('Content-Type' => 'application/json')),
				'query' => null
			]);
			
			$content = json_decode($hereResponse->getBody()->getContents());
			if(isset($content->items)) {
				$address = $content->items[0]->address;
				
				$countryId = $this->country->loadByCode($address->countryCode)->getCountryId();
				$region = $this->regionFactory->create()->loadByCode($address->stateCode, $countryId);
				
				$response['data'] = [
					'street' 				=> isset($address->street) ? $address->street : '',
					'city' 					=> isset($address->city) ? $address->city : '',
					'district' 	    => isset($address->district) ? ($address->city != $address->district? $address->district : '') : '',
					'postalCode'    => isset($address->postalCode) ? $address->postalCode : '',
					'state' 			 	=> ['id' => $region->getRegionId(), 'name' => $region->getDefaultName()],
					'country'       => $countryId
				];
			}
		} catch (\Exception $e) {
			$response['code'] = HttpStatus::BAD_GATEWAY()->getCode();
			$response['data'] = __($e->getMessage());
		}
		
		return $this->serializer->serialize($response);
	}
}