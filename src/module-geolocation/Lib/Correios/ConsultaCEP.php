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

namespace Eloom\Geolocation\Lib\Correios;

class ConsultaCEP {
	
	public $cep;
	
	public function __construct($cep = null) {
		$this->cep = $cep;
	}
}
