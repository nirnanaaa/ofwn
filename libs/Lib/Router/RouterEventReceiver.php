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

use Symfony\Component\EventDispatcher\Event,
    Symfony\Component\EventDispatcher\EventDispatcher,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use Lib\Router\Exception\InstanceException;

/**
 * Router Event Receiver class
 *
 * @author Florian Kasper <florian.kasper@corscience.de>
 */
class RouterEventReceiver
{
    /**
     * The event object
     * @var \Symfony\Component\EventDispatcher\Event
     */
    private $event;

    /**
     * processes the event, checks for right instances and calls the router procession
     *
     * @param \Symfony\Component\EventDispatcher\Event $event
     */
    public function processKernelEvent(Event $event)
    {
        $this->event = $event;
        $this->checkInstanceAssociations();
        if (!$this->checkDirectoryExistance()) {
            throw new InstanceException("Routing table does not exist/not readable");
        }
        $event->getDispatcher()->dispatch('router.checks.passed');
    }

    /**
     * checks the Instance Associations for the different functions
     *
     * @throws\Lib\Router\Exception\InstanceException
     */
    public function checkInstanceAssociations()
    {
        if (!$this->event->getDispatcher() instanceof EventDispatcher) {
            throw new InstanceException("Dispatcher is not an instance of \Symfony\Component\EventDispatcher\EventDispatcher");
        }
        if (!$this->event->getResponse() instanceof Response) {
            throw new InstanceException("Response is not an instance of \Symfony\Component\HttpFoundation\Response");
        }
        if (!$this->event->getRequest() instanceof Request) {
            throw new InstanceException("Request is not an instance of \Symfony\Component\HttpFoundation\Request");
        }
    }

    /**
     * checks if the filesystem structure is correct
     * @return boolean
     */
    public function checkDirectoryExistance()
    {
        if (!file_exists($this->event->getConfig()->router->global_router)) {
            return false;
        }
        if (!is_readable($this->event->getConfig()->router->global_router)) {
            return false;
        }

        return true;
    }

}
