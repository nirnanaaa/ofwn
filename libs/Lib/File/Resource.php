<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 */

namespace Lib\File;

use Lib\File\Exception\FileNotFoundException,
	Lib\File\Exception\ErrorException;

/**
 * File Reader Class for reading file
 *
 * @author Florian Kasper <florian.kasper@corscience.de>
 */
class Resource implements ReaderInterface{
	/**
	 * @var string
	 */
	protected $file = null;
	
	/**
	 * 
	 * @param string $file
	 * @throws FileNotFoundException
	 */
	public function __construct($file){
		if(!file_exists($file) || null === $file){
			throw new FileNotFoundException("File does not exists");
		}
		$this->file = $file;
	}
	
	/**
	 * gets the files content
	 * 
	 * @throws ErrorException
	 * @return string
	 */
	public function readFile(){
		if(is_readable($this->file)){
			return file_get_contents($this->file);
		}else{
			throw new ErrorException("File is not readable");
		}
	}
	
	/**
	 * adds/sets files content
	 * 
	 * @param string $content
	 * @param boolean $add
	 * @throws ErrorException
	 */
	public function writeFile($content,$add = false){
		if(is_null($content)||empty($content)){
			throw new ErrorException("Content Empty");
		}
		if(!is_writable($this->file)){
			throw new ErrorException("File is not writable");
		}
		if($add){
			file_put_contents($this->file,$content,FILE_APPEND);
		}else{
			file_put_contents($this->file,$content);
		}
	}
	
}