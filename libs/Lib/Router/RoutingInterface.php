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
use Symfony\Component\HttpFoundation\Response;

interface RoutingInterface
{
    public function __construct($dispatcher,$request,$response,$config,$dependencyInjector);
    public function route();
    public function reverseRoute();
    public function returnResponse(Response $response);
}
