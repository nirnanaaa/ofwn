<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */
namespace Lib\Config;

use Symfony\Component\Yaml\Parser;
use Lib\File\ReaderInterface;

/**
 * Parses the YAML file provided
 *
 * @author Florian Kasper <florian.kasper@corscience.de>
 */
class YamlParser implements ParserInterface{
	/**
	 * File location / content varies
	 * @var string
	 */
	private $file;
	
	/**
	 * @var \Symfony\Component\Yaml\Parser
	 */
	private $parser;
	
	/**
	 * Constructor.
	 * 
	 * @param \Lib\File\ReaderInterface $file the location of the configuration
	 * @return void
	 */
	public function __construct( ReaderInterface $file){
		//change this to something better;
		$this->file = $file;
		$this->parser = new Parser();
	}
	
	/**
	 * Writes into the configuration file
	 * 
	 * @see \Lib\Config\ParserInterface::write()
	 * @return boolean
	 */
	public function write($content){
		return $this->file->writeFile($content,true);
	}
	
	/**
	 * Reads the configuration file
	 * 
	 * @see \Lib\Config\ParserInterface::read()
	 * @return string
	 */
	public function read(){
		return $this->file->readFile();
	}
	
	/**
	 * Parses the read file
	 * 
	 * @see \Lib\Config\ParserInterface::parse()
	 * @return string
	 */
	public function parse(){
		return $this->arrayToObject($this->parser->parse($this->file->readFile()));
		
	}
	
	/**
	 * 
	 * @param array $array
	 * @return array|\Lib\Config\stdClass|boolean
	 */
	public function arrayToObject($array) {
		if(!is_array($array)) {
			return $array;
		}
	
		$object = new \stdClass();
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $name=>$value) {
				$name = strtolower(trim($name));
				if (!empty($name)) {
					$object->$name = $this->arrayToObject($value);
				}
			}
			return $object;
		}
		else {
			return FALSE;
		}
	}
	public function isValid(){
		
	}
	
}