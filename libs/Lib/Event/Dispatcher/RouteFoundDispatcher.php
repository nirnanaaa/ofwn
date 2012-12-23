<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Lib\Event\Dispatcher;

use Symfony\Component\EventDispatcher\Event;

class RouteFoundDispatcher extends Event
{
    /**
     * classes name
     *
     * @var string
     */
    private $name;

    /**
     * route
     * @var stdClass
     */
    private $route;

    /**
     * Constructor.
     *
     * @param string $name The routes name
     *
     */
    public function __construct($name,$route)
    {
        $this->name = $name;
        $this->route = $route;
    }

    public function getFullObject()
    {
        return $this->route->to;
    }
    public function getTo($id)
    {
        $explo = explode(":",$this->route->to);

        return $explo[$id];
    }

    public function getController()
    {
        return $this->getTo(0);
    }

    public function getMethod()
    {
        return $this->getTo(2);
    }

    public function getMatch()
    {
        return $this->route->match;
    }

    public function getParams()
    {
        return $this->route->params;
    }

    public function getAllowedMethods()
    {
        return $this->route->via;
    }

    public function isAllowedMethod($method)
    {
        return in_array($method,(array) $this->route->via);
    }

    public function isExistingClass()
    {
        return class_exists($this->getController());
    }

    public function isExistingMethod()
    {
        return method_exists($this->getController(), $this->getMethod());
    }

}
