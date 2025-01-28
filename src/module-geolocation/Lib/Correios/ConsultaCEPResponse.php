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

namespace Eloom\Geolocation\Lib\Correios;

class ConsultaCEPResponse {
	
	public $return = null;
	
	public function __construct(EnderecoERP $return) {
		$this->return = $return;
	}
}
