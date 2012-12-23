<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 */ 

namespace Lib\Router;
use Lib\Request\RequestUtils;

class RouterUtils extends RequestUtils{
	
	/**
	 * Explodes request string @ "?" symbol
	 * 
	 * @param string $string
	 */
	public function getRequestPath($string){
		$url = $this->parseRequestUrl($string);
		return $url[path];
	}
	
	/**
	 * Gets the request Query
	 * @param string $string
	 */
	public function getRequestQuery($string){
		$url = $this->parseRequestUrl($string);
		return $url[query];
	}
	
	/**
	 * Parses given url
	 * @param string $url
	 */
	public function parseRequestUrl($url){
		if(is_string($url)){
			return parse_url($url);
		}
		return null;
	}
	
}