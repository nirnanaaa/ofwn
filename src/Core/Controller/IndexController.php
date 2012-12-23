<?php

/*
 * This file is part of the Ofwn package.
 * (c) Florian Kasper <florian.kasper@khnetworks.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 */

namespace Core\Controller;

use Lib\Controller\Controller;


class IndexController extends Controller{
	
	public function indexAction(){
		return $this->render("Main/Lib.haml",array(
				"title" => "main"
				));
		//return $this->renderText("123");
	}
	public function someAction($as,$to,$my,$some){
		return $this->renderText("123");
	}
	
}