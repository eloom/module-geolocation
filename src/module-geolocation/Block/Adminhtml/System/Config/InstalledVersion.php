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

namespace Eloom\Geolocation\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\ModuleResource;

class InstalledVersion extends Field {
	
	protected function _getElementHtml(AbstractElement $element) {
		$objectManager = ObjectManager::getInstance();
		$moduleResource = $objectManager->create(ModuleResource::class);
		
		$dbVersion = (string)$moduleResource->getDbVersion('Eloom_Geolocation');
		
		$element->setValue($dbVersion);
		
		return '<strong>' . $element->getEscapedValue() . '</strong> - [<a href="https://github.com/eloom/module-geolocation/releases" target="_blank">' . __('Releases') . '</a>]';
	}
}
