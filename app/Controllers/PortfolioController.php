<?php

namespace App\Controllers;

use App\Models\Portfolio;
use Respect\Validation\Validator as v;

class PortfolioController extends BaseController {
  protected $msg = [];

	public function getPortfolio() {
    $portfolios = Portfolio::all();

		return $this->renderHTML('admin/portfolio.twig', [
      'portfolios' => $portfolios
    ]);
	}

	public function addPortfolio($request) {
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

				$this->msg = [
					'type' => 'success',
					'msg' => 'Portafolio guardado'
				];
			} catch (\Exception $e) {
				$this->msg = [
					'type' => 'error',
					'msg' => 'Error al guardar portafolio' . $e->getMessage()
				];
			}
		}

		return $this->renderHTML('admin/portfolio.twig', [
			'msg' => $this->msg
		]);
  }
  
  public function getEditPortfolio($request, $route) {
    $id = $route->attributes['id'];
    $edit_data = $this->portfolioById($id);
    $new_data = $request->getParsedBody();

    if ($request->getMethod() == 'POST') {
      $this->editPortfolio($edit_data, $new_data);
    }

    return $this->renderHTML('admin/portfolio.twig', array(
      'edit' => true,
      'id' => $id,
      'editData' => $edit_data,
      'msg' => $this->msg
    ));
  }

  private function editPortfolio($edit_data, $new_data) {
    $edit_data->name = $new_data['name'];
    $edit_data->technologies = $new_data['technologies'];
    $edit_data->link = $new_data['link'];
    $edit_data->image = $new_data['image'];
    $edit_data->description = $new_data['description'];
    $edit_data->update();
    $this->msg = [
      'type' => 'success',
      'msg' => 'Portafolio editado'
    ];
  }

  private function portfolioById($id) {
    return Portfolio::where('id', $id)->first();
  }
}