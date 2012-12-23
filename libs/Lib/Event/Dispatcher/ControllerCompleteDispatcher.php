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

use Symfony\Component\EventDispatcher\Event,
    Symfony\Component\HttpFoundation\Response;

class ControllerCompleteDispatcher extends Event
{
    /**
     * Symfony Response instance
     *
     * @var \Symfony\Component\HttpFoundation\Response
     */
    private $response;

    /**
     * Constructor.
     *
     * @param \Symfony\Component\HttpFoundation\Response $response The response object
     *
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }

}
