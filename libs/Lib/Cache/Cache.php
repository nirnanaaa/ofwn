<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Lib\Cache;

use Lib\File\Resource;

class Cache{
	
	/**
	 * @var string
	 */
	private $facility;
	
	/**
	 * @var \StdClass
	 */
	private $config;
	
	/**
	 * Constructor.
	 * 
	 * @param string $facility
	 */
	public function __construct($facility,$config){
		$this->facility = $facility;
		$this->config = $config;
		$directory = $this->getCachePath().$facility;
		if(!is_dir($directory)){
			mkdir($directory,0755,true);
		}

	}
	
	/**
	 * gets the cache path
	 * 
	 * @return string
	 */
	public function getCachePath(){
		return $this->config->cache->directory;
	}
	
	/**
	 * Writes the cache
	 * 
	 * @param string $id
	 * @param mixed $content
	 * @return boolean
	 */
	public function writeCache($id,$content){
		$location = $this->getCacheLocation($id);
		$file = new Resource($location);
		if(is_string($content)){
			$file->writeFile($content);
		}else{
			$file->writeFile(serialize($content));
		}
		
	}
	
	/**
	 * Gets files content and performs $this->writeCache
	 * 
	 * @param string $id
	 * @param \Lib\File\Resource $content
	 */
	public function writeFileCache($id, Resource $file){
		$this->writeCache($id,$file->readFile());
	}
	
	/**
	 * gets a file from the cache
	 * 
	 * @param string $id
	 * @return mixed
	 */
	public function readCache($id){
		$location = $this->getCacheLocation($id);
		if(filemtime($location)+$this->config->cache->expire < time()){
			return false;
		}
		$file = new Resource($location);
		$filecontent = $file->readFile();
		if(is_string($filecontent)){
			return $filecontent;
		}else{
			return unserialize($file->readFile());
		}
	}
	
	
	/**
	 * generates an unique identifier for the ID
	 * 
	 * @param string $id
	 */
	public function generateId($id){
		return sha1($id);
	}
	/**
	 * gets the caches location
	 * 
	 * @param string $id
	 * @return string
	 * 
	 */
	public function getCacheLocation($id){
		return $this->getCachePath().$this->facility.'/'.$this->generateId($id).'.'.$this->config->general->phpext;
	}
	/**
	 * gets the relative cache path
	 * @param string $id
	 * @return string
	 */
	public function getCacheLocationRelative($id){
		return $this->facility.'/'.$this->generateId($id).'.'.$this->config->general->phpext;
	}
	
}