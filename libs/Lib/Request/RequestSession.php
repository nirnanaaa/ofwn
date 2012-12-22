<?php

namespace Lib\Request;

use Lib\Request\Exception\SessionPathNotFoundException;

class RequestSession
{
	public function __construct($path){
		if(!is_dir($path)){
			throw new SessionPathNotFoundException("Session storage path not found!");
		}
		session_save_path($path);
	}
    public function initSession(){
	
	}
	public function hashSession(){
	
	}
	public function closeSession(){
	
	}
	public function setSessionDir(){
	
	}
	public function destroySession(){
	
	}
	public function setSessionName(){
	
	}
	public function getSessionName(){
	
	}
	public function generateId(){
	
	}
	public function setId(){}
	public function getId(){}
	public function setCacheLimiter(){}
	public function getCacheLimiter(){}
	
}