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

namespace Eloom\Geolocation\Block;

use Eloom\Geolocation\Model\DefaultConfigProvider;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class Template extends \Magento\Framework\View\Element\Template {

	/**
	 * @var \Eloom\Core\Model\DefaultConfigProvider
	 */
	protected $configProvider;

	/**
	 * @var \Magento\Framework\Serialize\SerializerInterface
	 */
	private $serializer;

	public function __construct(\Magento\Framework\View\Element\Template\Context $context,
															DefaultConfigProvider $configProvider,
															\Magento\Framework\Serialize\SerializerInterface $serializerInterface = null,
															array $data = []) {
		$this->configProvider = $configProvider;
		$this->serializer = $serializerInterface ?: \Magento\Framework\App\ObjectManager::getInstance()->get(\Magento\Framework\Serialize\Serializer\JsonHexTag::class);

		parent::__construct($context, $data);
	}

	/**
	 * Retrieve configuration
	 *
	 * @return array
	 * @codeCoverageIgnore
	 */
	public function getConfig() {
		return $this->configProvider->getConfig();
	}

	/**
	 * Retrieve serialized config.
	 *
	 * @return bool|string
	 * @since 100.2.0
	 */
	public function getSerializedConfig() {
		return $this->serializer->serialize($this->getConfig());
	}
}