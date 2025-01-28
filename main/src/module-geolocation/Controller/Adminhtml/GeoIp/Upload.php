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

namespace Eloom\Geolocation\Controller\Adminhtml\GeoIp;

use Eloom\Core\Enumeration\HttpStatus;
use Eloom\Geolocation\Model\Config\Backend\DbIpUpload;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Upload extends Action {

	private $dbIpUpload;
	private $resultJsonFactory;

	public function __construct(Context $context, JsonFactory $resultJsonFactory, DbIpUpload $fileUpload) {
		$this->resultJsonFactory = $resultJsonFactory;
		$this->dbIpUpload = $fileUpload;

		parent::__construct($context);
	}

	public function execute() {
		$result = $this->resultJsonFactory->create();
		$response = ['code' => HttpStatus::OK()->getCode()];

		try {
			$r = $this->dbIpUpload->start();
			$response['file'] = $r;
		} catch (\Exception $e) {
			$response['code'] = HttpStatus::BAD_GATEWAY()->getCode();
			$response['data'] = __($e->getMessage());
		}

		return $result->setData($response);
	}

	public function _isAllowed() {
		return $this->_authorization->isAllowed('Eloom_Geolocation::config');
	}
}