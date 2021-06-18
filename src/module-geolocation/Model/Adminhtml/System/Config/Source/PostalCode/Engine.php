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

namespace Eloom\Geolocation\Model\Adminhtml\System\Config\Source\PostalCode;

class Engine implements \Magento\Framework\Option\ArrayInterface {
	
	/**
	 * Engines list
	 *
	 * @var array
	 */
	private $engines;
	
	/**
	 * @param array $engines
	 */
	public function __construct(array $engines) {
		$this->engines = $engines;
	}
	
	/**
	 * @inheritdoc
	 */
	public function toOptionArray() {
		$options = [['value' => null, 'label' => __('--Please Select--')]];
		foreach ($this->engines as $key => $label) {
			$options[] = ['value' => $key, 'label' => $label];
		}
		return $options;
	}
}