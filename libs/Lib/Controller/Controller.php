<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Lib\Controller;

use Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpFoundation\Request,
    Lib\File\Resource,
    Lib\Cache\Cache,
    MtHaml\Autoloader,
	MtHaml\Environment,
	MtHaml\Support\Twig\Extension,
	MtHaml\Support\Twig\Loader,
	\Twig_Loader_Filesystem,
	\Twig_Environment;

class Controller
{
    /**
     * The Response.
     *
     * @var \Symfony\Component\HttpFoundation\Response
     */
    private $response;

    /**
     * The Request.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    private $request;

    /**
     * Config
     */
    private $config;
    
    /**
     * Constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Symfony\Component\HttpFoundation\Request  $request
     * @param \StdClass $config
     * 
     */
    public function __construct(Response $response, Request $request,\StdClass $config)
    {
        $this->response = $response;
        $this->request = $request;
        $this->config = $config;
    }

    /**
     * gets the request
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * gets the current response
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * renders raw text as text/plain mime
     *
     * @param  string $text
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderText($text)
    {
        if (is_string($text)) {
            $this->response->setContent($text)
            ->setStatusCode(200);
        }

        return $this->response;
    }

    public function render($file,$vars = array())
    {
    	//echo $this->config->templating->tpl_dir.$file;
    	
    	$haml = new Environment('twig', array('enable_escaper' => false));
    	$fs = new Twig_Loader_Filesystem(array($this->config->templating->tpl_dir));
    	$twig = new Twig_Environment($fs, array(
    			'cache' => $this->config->cache->directory.'/twig/',
    	));
    	$twig->addExtension(new Extension());
    	//$fileLoader = new Resource($this->config->templating->tpl_dir.$file);
    	
    	$haml = $haml->compileString(file_get_contents($this->config->templating->tpl_dir.$file), $file);
    	
		$this->response->setContent($twig->render($haml,$vars));
		return $this->response;
    }

    public function renderView()
    {
    }
}
