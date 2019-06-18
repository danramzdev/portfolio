<?php

namespace App\Controllers;

class ErrorController extends BaseController
{
	public function get404()
	{
		return $this->renderHTML('404.twig');
	}
}
