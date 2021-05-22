<?php
/**
* 
* Geolocation para Magento 2
* 
* @category     Ã©lOOm
* @package      Modulo Geolocation
* @copyright    Copyright (c) 2021 Ã©lOOm (https://www.eloom.com.br)
* @version      1.0.0
* @license      https://www.eloom.com.br/license/
*
*/
declare(strict_types=1);

namespace Eloom\Geolocation\Model\ResourceModel\PostalCode;

use Eloom\Geolocation\Lib\Correios\AtendeCliente;
use Eloom\Geolocation\Lib\Correios\ConsultaCEP;
use Magento\Directory\Model\RegionFactory;

class CorreiosHandler implements EngineHandlerInterface {
	
	private $regionFactory;
	
	public function __construct(RegionFactory $regionFactory) {
		$this->regionFactory = $regionFactory;
	}
	
	/**
	 * @inheritDoc
	 */
	public function query(string $postalcode): array {
		$address = [];
		$client = new AtendeCliente();
		$consultaCEP = new ConsultaCEP(preg_replace('/\D/', '', $postalcode));
		
		try {
			$content = $client->consultaCEP($consultaCEP);
			
			if (isset($content->return)) {
				$address = [
					'street' => $content->return->end,
					'city' => $content->return->cidade,
					'state' => $this->regionFactory->create()->loadByCode($content->return->uf, 'BR')->getRegionId(),
					'district' => $content->return->bairro
				];
			}
		} catch (\Exception $e) {
		}
		
		return $address;
	}
	
	public function isAvailable(): bool {
		return true;
	}
}