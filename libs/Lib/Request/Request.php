<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Lib\Request;

/**
 * Request class
 *
 * @author Florian Kasper <florian.kasper@corscience.de>
 */
class Request
{
	/**
	 * @var string
	 */
    private $webseperator = '/';
    
    /**
     * @var self|boolean
     */
	private static $instance = false;
	
	/**
	 * @var array
	 */
    private $file;

    /**
     * @var array
     */
    private $post;

    /**
     * @var array
     */
    private $get;

    /**
     * @var array
     */
    private $globals;

    /**
     * @var array
     */
    private $request;

    /**
     * @var array
     */
    private $environment;

    /**
     * @var array
     */
	private $server;

	/**
	 * @var array
	 */
	private $session;
	
	/**
	 * Constructor.
	 * 
	 */
	public function __construct(){
		
	}
	/**
	 * Build Request from globals
	 * 
	 * @return Ambigous <\Lib\Request\self, boolean>
	 */
    public static function fromGlobals(){
		if(self::$instance){
			return self::$instance;
		}else{
			self::$instance = new self;
		}
		return self::$instance->buildRequest($_POST,$_GET,$_FILES,$_REQUEST,$_ENV,$_SERVER,$_SESSION);
	}
	
	/**
	 * Build the Request non-statically
	 * 
	 * @param array $post
	 * @param array $get
	 * @param array $file
	 * @param array $request
	 * @param array $env
	 * @param array $server
	 * @param array $session
	 * @return \Lib\Request\Request
	 */
    public function buildRequest($post = null, $get = null, $file = null,$request = null, $env = null,$server = null, $session = null){
    	if(null !== $get){
    		$this->get = $get;
    	}
    	if(null !== $post){
    		$this->post = $post;
    	}
    	if(null !== $file){
    		$this->file = $file;
    	}
    	if(null !== $request){
    		$this->request = $request;
    	}
    	if(null !== $env){
    		$this->environment = $env;
    	}
    	if(null !== $server){
    		$this->server = $server;
    	}
    	if(null !== $session){
    		$this->session = $session;
    	}
    	return $this;
    }
    
    /**
     * Gets a Parameter from the SERVER variable
     * 
     * @param string $param
     * @return string|NULL
     */
    public function getServerParam($param){
    	if(array_key_exists($parm, $this->server)){
    		return $this->server[$param];
    	}
    	return null;   	
    }
    
    /**
     * Get a Get parameter
     * 
     * @param string $param
     * @return string|NULL
     */
    public function get($param){
    	if(in_array($param,$this->get)){
    		return $this->get[$param];
    	}
    	return null;
    }
    
    /**
     * All get parameters
     * 
     * @return array
     */
    public function getParams(){
    	return $this->get;
    }
    
    /**
     * Gets the remote IP address
     * 
     * @return string
     */
    public function getRemoteIp(){
    	return $this->server['REMOTE_ADDR'];
    }
    
    /**
     * Gets the HTTP cache control 
     * 
     * @return string
     */
    public function getCacheControl(){
    	return $this->server['HTTP_CACHE_CONTROL'];
    }
    
    /**
     * Gets all acceptable languages
     * 
     * @return string
     */
    public function getAcceptLanguage(){
    	return $this->server['HTTP_ACCEPT_LANGUAGE'];
    }

    /**
     * Gets the local server port
     *
     * @return string
     */
    public function getServerPort(){
    	return $this->server['SERVER_PORT'];
    }
    
    /**
     * Gets the Server Software
     *
     * @return string
     */
    public function getServerSoftware(){
    	return $this->server['SERVER_SOFTWARE'];
    }

    /**
     * Gets the Username, the Server runs
     *
     * @return string
     */
    public function getUsername(){
    	return $this->environment['USERNAME'];
    }

    /**
     * Gets the request time
     *
     * @return string
     */
    public function getRequestTime(){
    	return $this->server['REQUEST_TIME_FLOAT'];
    }

    /**
     * Gets the remote port
     *
     * @return string
     */
    public function getRemotePort(){
    	return $this->server['REMOTE_PORT'];
    }

    /**
     * Gets the Servers protocol
     *
     * @return string
     */
    public function getServerProtocol(){
    	return $this->server['SERVER_PROTOCOL'];
    }

    /**
     * Get connection state
     *
     * @return string
     */
    public function getConnection(){
    	return $this->server['HTTP_CONNECTION'];
    }

    /**
     * Gets argv array
     *
     * @return array
     */
    public function getArgv(){
    	return $this->server['argv'];
    }

    /**
     * Gets the argument count
     *
     * @return integer
     */
    public function getArgc(){
    	return $this->server['argc'];
    }

    /**
     * Gets the full HTTP host
     *
     * @return string
     */
    public function getHttpHost(){
    	return $this->server['HTTP_HOST'];
    }

    /**
     * Gets acceptable content types
     *
     * @return string
     */
    public function getAcceptTypes(){
    	return $this->server['HTTP_ACCEPT'];
    }
    
    /**
     * Gets acceptable encodings 
     * @return string
     */
    public function getAcceptEncoding(){
    	return $this->server['HTTP_ACCEPT_ENCODING'];
    }

    /**
     * Get document root
     * @return string
     */	
    public function getDocRoot(){
    	return $this->server['DOCUMENT_ROOT'];
    }
    

}
