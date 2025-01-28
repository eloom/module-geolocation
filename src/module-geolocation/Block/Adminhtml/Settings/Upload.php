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

namespace Eloom\Geolocation\Block\Adminhtml\Settings;

use Eloom\Geolocation\Helper\Data;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Exception\LocalizedException;

class Upload extends Field {

	private $helper;

	public function __construct(Context $context, Data $helper, array $data = []) {
		$this->helper = $helper;

		parent::__construct($context, $data);
	}

	public function _getElementHtml(AbstractElement $element) {
		$url = ['url' => $this->getUrl('eloomgeolocation/geoip/upload')];
		$block = $this->getLayout()->createBlock(\Magento\Backend\Block\Template::class)->setTemplate('Eloom_Geolocation::upload.phtml')->setConfig(json_encode($url));

		$this->setImportData($block);

		return $block->toHtml();
	}

	public function setImportData($block) {
		$file = $this->helper->getGeoIpFilePath();

		if (!file_exists($file)) {
			$file = __('GeoIP Database not found.');
		} else {
			$file = $this->helper->getGeoIpFileName();
		}
		$block->setGeoIpFilePath($file);
	}
}