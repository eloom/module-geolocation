<?php

namespace Eloom\Geolocation\Lib\GeoIp2\Record;

abstract class AbstractPlaceRecord extends AbstractRecord {
	private $locales;

	/**
	 * @param mixed $record
	 * @param mixed $locales
	 * @ignore
	 *
	 */
	public function __construct($record, $locales = ['en']) {
		$this->locales = $locales;
		parent::__construct($record);
	}

	/**
	 * @param mixed $attr
	 * @ignore
	 *
	 */
	public function __get($attr) {
		if ($attr === 'name') {
			return $this->name();
		}

		return parent::__get($attr);
	}

	private function name() {
		$locale = $this->firstSetNameLocale();

		return $locale === null ? null : $this->names[$locale];
	}

	private function firstSetNameLocale() {
		foreach ($this->locales as $locale) {
			if (isset($this->names[$locale])) {
				return $locale;
			}
		}

		return null;
	}

	/**
	 * @param mixed $attr
	 * @ignore
	 *
	 */
	public function __isset($attr) {
		if ($attr === 'name') {
			return $this->firstSetNameLocale() === null ? false : true;
		}

		return parent::__isset($attr);
	}
}
