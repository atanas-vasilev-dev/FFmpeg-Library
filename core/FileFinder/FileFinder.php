<?php 

namespace FFMpegLib\FileFinder;

use Symfony\Component\Finder\Finder;

class FileFinder {
	protected Finder $finder;

	protected function __construct() {
		$this->finder = new Finder();
	}

	public static function create() {
		return new static();
	}

	public static function findFile($fileName = null, $directoryToSearch = __DIR__) {
		if (!$fileName || !$directoryToSearch) {
			return false;
		}

		if (static::isAbsolute($fileName)) {
			return $fileName;
		}
		$localFinder = new static();
		$localFinder->finder->name($fileName)->files()->in($directoryToSearch);

		$fileAbsolutePath = '';

		foreach ($localFinder->finder as $file) {
			$fileAbsolutePath = $file->getRealPath();
		}

		return $fileAbsolutePath;
	}

	public static function isAbsolute($fileName = null) {
		if (!$fileName) {
			return false;
		}

		return preg_match('~(\/|\\\)~', $fileName);
	}
}
