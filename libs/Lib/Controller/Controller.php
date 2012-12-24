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
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Lib\File\Resource,
    Lib\Cache\Cache,
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
     * Container Builder
     */
    private $injector;
    
    /**
     * Constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Symfony\Component\HttpFoundation\Request  $request
     * @param \StdClass $config
     * 
     */
    public function __construct(Response $response, Request $request,ContainerBuilder $dep)
    {
    	$this->injector = $dep;
        $this->response = $response;
        $this->request = $request;
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
		$twig = $this->injector->get('twignormal');
		//$this->response->setContent($twig->render($cache->getCacheLocationRelative($file),$vars));
		$this->response->setContent($twig->render($file,$vars));
		return $this->response;
    }

    public function renderView()
    {
    }
}
