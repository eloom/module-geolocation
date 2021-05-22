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

use SoapClient;

class AtendeCliente extends SoapClient {
	
	const TIMEOUT = '30';
	
	private static $classmap = [
		'consultaCEP' => '\Eloom\Geolocation\Lib\Correios\ConsultaCEP',
		'consultaCEPResponse' => '\Eloom\Geolocation\Lib\Correios\ConsultaCEPResponse'];
	
	public function __construct(array $options = array(), $wsdl = 'https://apps.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl') {
		foreach (self::$classmap as $key => $value) {
			if (!isset($options['classmap'][$key])) {
				$options['classmap'][$key] = $value;
			}
		}
		ini_set('default_socket_timeout', self::TIMEOUT);
		parent::__construct($wsdl, $options);
	}
	
	public function consultaCEP(ConsultaCEP $parameters) {
		return $this->__soapCall('consultaCEP', array($parameters));
	}
}
