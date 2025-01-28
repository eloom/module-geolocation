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
use Magento\Framework\Data\Form\Element\AbstractElement;

class Documentation extends Field {
	
	protected function _getElementHtml(AbstractElement $element) {
		return '<a href="https://docs.eloom.tech/checkout/" target="_blank">' . __('Documentation') . '</a>';
	}
}
