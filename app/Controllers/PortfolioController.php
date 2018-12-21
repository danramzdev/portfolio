<?php

namespace App\Controllers;

use App\Models\Portfolio;
use Respect\Validation\Validator as v;

class PortfolioController extends BaseController {
	public function getPortfolio() {
		return $this->renderHTML('admin/portfolio.twig');
	}

	public function addPortfolio($request) {
		$msg = [];
		if ($request->getMethod() == 'POST') {
			$data = $request->getParsedBody();
			$portfolioValidator = v::key('name', v::stringType()->length(1,32))
				->key('technologies', v::stringType()->notEmpty())
				->key('description', v::stringType()->notEmpty())
        ->key('link', v::url())
        ->key('image', v::url());
			try {
				$portfolioValidator->assert($data);

				$portfolio = new Portfolio();
				$portfolio->name = $data['name'];
				$portfolio->technologies = $data['technologies'];
				$portfolio->description = $data['description'];
        $portfolio->link = $data['link'];
        $portfolio->image = $data['image'];
				$portfolio->save();

				$msg = [
					'type' => 'success',
					'msg' => 'Portafolio guardado'
				];
			} catch (\Exception $e) {
				$msg = [
					'type' => 'error',
					'msg' => 'Error al guardar portafolio' . $e->getMessage()
				];
			}
		}

		return $this->renderHTML('admin/portfolio.twig', [
			'msg' => $msg
		]);
	}
}