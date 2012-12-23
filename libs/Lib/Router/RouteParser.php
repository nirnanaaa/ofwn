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

use Lib\File\ReaderInterface,
    Lib\Config\YamlParser;

class RouteParser
{
    /**
     * @var \Lib\File\ReaderInterface
     */
    private $router;

    /**
     * Constructor.
     *
     * @param \Lib\File\ReaderInterface $file
     */
    public function __construct(ReaderInterface $file)
    {
        $this->router = $file;
    }
    public function parse()
    {
        $parser = new YamlParser($this->router);

        return $parser->parse();
    }

}
