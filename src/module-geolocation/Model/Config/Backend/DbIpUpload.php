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

namespace Eloom\Geolocation\Model\Config\Backend;

use Eloom\Geolocation\Helper\Data;
use GuzzleHttp\Client;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Filesystem\Driver\File;
use Psr\Log\LoggerInterface;

class DbIpUpload {

	const FILE_URL = 'https://download.db-ip.com/free/dbip-city-lite-%s-%s.mmdb.gz';

	CONST BASE_PATH = 'eloom/dbip';

	private $baseTmpPath;

	private $basePath;

	protected $configWriter;

	private $varDirectory;

	private $logger;

	private $driverFile;

	public function __construct(DirectoryList $directoryList, WriterInterface $configWriter, File $driverFile, LoggerInterface $logger) {
		$this->varDirectory = $directoryList->getPath(DirectoryList::VAR_DIR);
		$this->configWriter = $configWriter;
		$this->driverFile = $driverFile;
		$this->logger = $logger;

		$this->baseTmpPath = sys_get_temp_dir();
		$this->basePath = $this->varDirectory . DIRECTORY_SEPARATOR . self::BASE_PATH;
	}

	public function start() {
		$url = sprintf(self::FILE_URL, date('Y'), date('m')); // TO-DO: decrementar mês se não tiver o arquivo do mês atual
		$fileName = $this->downloadPackage($url, $this->baseTmpPath);
		//$fileName = '/var/tmp/dbip-city-lite-2019-12.mmdb.gz';

		$extractedFile = $this->extractGzFile($fileName);
		$package = parse_url($extractedFile);
		$filename = basename($package['path']);
		$result = $this->moveFile($extractedFile, $filename);

		$this->configWriter->save(Data::XML_PATH_GEOIP_FILENAME, $filename, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);

		return $filename;
	}

	private function moveFile($srcFile, $toFile) {
		$result = false;
		try {
			if (!$this->driverFile->isExists($this->basePath)) {
				$this->driverFile->createDirectory($this->basePath, 0770);
			}
			$toFile = $this->basePath . DIRECTORY_SEPARATOR . $toFile;
			$result = copy($srcFile, $toFile);
		} catch (\Exception $e) {
			$this->logger->critical(sprintf("%s - Exception: %s", __METHOD__, $e->getMessage()));
			$this->logger->critical(sprintf("%s - Exception: %s", __METHOD__, $e->getTraceAsString()));

			throw new \Magento\Framework\Exception\LocalizedException(__('Something went wrong while saving the file(s).'));
		}

		return $result;
	}

	private function downloadPackage($packageFile, $tmp) {
		$package = parse_url($packageFile);
		$filename = basename($package['path']);
		$output = $this->get($packageFile, [], []);

		if ($output) {
			file_put_contents($tmp . DIRECTORY_SEPARATOR . $filename, $output);
			return $tmp . DIRECTORY_SEPARATOR . $filename;
		}

		return null;
	}

	private function get($url, $data, $headers) {
		$client = new Client();
		$response = $client->get($url, [
			'headers' => array_merge(array('Content-Type' => 'application/json', 'Accept' => 'application/json'), $headers),
			'query' => $data
		]);

		$contents = $response->getBody()->getContents();
		return $contents;
	}

	private function extractGzFile($fileName) {
		$outFileName = str_replace('.gz', '', $fileName);
		$archive = gzopen($fileName, 'rb');
		$outFile = fopen($outFileName, 'wb');

		while (!gzeof($archive)) {
			fwrite($outFile, gzread($archive, 4096));
		}

		fclose($outFile);
		gzclose($archive);

		return $outFileName;
	}

	public function getAllowedExtensions() {
		return $this->allowedExtensions;
	}
}