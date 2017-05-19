<?php

namespace Osahform\src\Osahform\Service;

class PHPWord_IOFactory {
	
	/**
	 * Search locations
	 *
	 * @var array
	 */
	private static $_searchLocations = array(
			array('type' => 'IWriter', 'path' => 'PHPWord/Writer/{0}.php', 'class' => 'PHPWord_Writer_{0}')
	);
	
	/**
	 * Autoresolve classes
	 *
	 * @var array
	*/
	private static $_autoResolveClasses = array(
			'Serialized'
	);
	
	/**
	 * Private constructor for PHPWord_IOFactory
	*/
	private function __construct() { }
	
	/**
	 * Get search locations
	 *
	 * @return array
	 */
	public static function getSearchLocations() {
		return self::$_searchLocations;
	}
	
	/**
	 * Set search locations
	 *
	 * @param array $value
	 * @throws Exception
	 */
	public static function setSearchLocations($value) {
		if (is_array($value)) {
			self::$_searchLocations = $value;
		} else {
			throw new Exception('Invalid parameter passed.');
		}
	}
	
	/**
	 * Add search location
	 *
	 * @param string $type            Example: IWriter
	 * @param string $location        Example: PHPWord/Writer/{0}.php
	 * @param string $classname     Example: PHPWord_Writer_{0}
	 */
	public static function addSearchLocation($type = '', $location = '', $classname = '') {
		self::$_searchLocations[] = array( 'type' => $type, 'path' => $location, 'class' => $classname );
	}
	
	/**
	 * Create PHPWord_Writer_IWriter
	 *
	 * @param PHPWord $PHPWord
	 * @param string  $writerType    Example: Word2007
	 * @return PHPWord_Writer_IWriter
	 */
	public static function createWriter(PHPWord $PHPWord, $writerType = '') {
		$searchType = 'IWriter';
	
		foreach (self::$_searchLocations as $searchLocation) {
			if ($searchLocation['type'] == $searchType) {
				$className = str_replace('{0}', $writerType, $searchLocation['class']);
				$classFile = str_replace('{0}', $writerType, $searchLocation['path']);
	
				$instance = new $className($PHPWord);
				if(!is_null($instance)) {
					return $instance;
				}
			}
		}
	
		throw new Exception("No $searchType found for type $writerType");
	}
}

?>