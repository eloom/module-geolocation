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

use Eloom\Geolocation\Api\GeoIpInterface;
use Eloom\Geolocation\Helper\Data;
use Magento\Directory\Model\RegionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Eloom\Core\Enumeration\HttpStatus;
use Eloom\Geolocation\Lib\GeoIp2\Database\Reader;
use Magento\Framework\App\RequestInterface;

class GeoIp implements GeoIpInterface {

	private $regionFactory;

	private $storeManager;

	private $helper;

	private $serializer;
	
	private $remoteAddress;
	
	private $request;
	
	public function __construct(RegionFactory $regionFactory,
	                            StoreManagerInterface $storeManager,
	                            Data $helper,
	                            Json $serializer = null,
	                            RemoteAddress $remoteAddress,
	                            RequestInterface $request = null) {
		$this->regionFactory = $regionFactory;
		$this->storeManager = $storeManager;
		$this->helper = $helper;
		$this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
		$this->remoteAddress = $remoteAddress;
		$this->request = $request ?: ObjectManager::getInstance()->get(RequestInterface::class);
	}

	/**
	 * @inheritDoc
	 */
	public function getLocationByIp() {
		$response = ['code' => HttpStatus::OK()->getCode()];
		
		try {
				$ip = null;
				$remoteAddress = $this->remoteAddress->getRemoteAddress();
				if ($remoteAddress !== false) {
					$ip = $this->request->getServer('HTTP_X_FORWARDED_FOR');
				}
				if (null == $ip || $ip == '::1' || $ip == '127.0.0.1') {
					$ip = '45.165.51.227';
				}
				
				$file = $this->helper->getGeoIpFilePath();
				
				$geoIpReader = ObjectManager::getInstance()->create(Reader::class, ['filename' => $file]);
				$getIpRecord = $geoIpReader->city($ip);
				
				$line = array('ip' => $ip, 'country' => $getIpRecord->country->isoCode, 'city' => $getIpRecord->city->name, 'lat' => $getIpRecord->location->latitude, 'long' => $getIpRecord->location->longitude);
				$geoIpReader->close();
				
				$response['data'] = $line;
		} catch (\Exception $e) {
			$response['code'] = HttpStatus::BAD_GATEWAY()->getCode();
			$response['data'] = __($e->getMessage());
		}
		
		return $this->serializer->serialize($response);
	}
}