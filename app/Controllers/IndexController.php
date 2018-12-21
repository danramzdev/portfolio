<?php

namespace App\Controllers;

use App\Models\{Knowledge, About, Portfolio};

class IndexController extends BaseController {
  public function getIndex() {
    $knowledges = Knowledge::all();
    $about = About::where('id', 1)->first();
    $portfolios = Portfolio::all();
    $about->birth = $this->birthSpanish($about->birth);

    return $this->renderHTML('index.twig', [
      'knowledges' => $knowledges,
      'about' => $about,
      'portfolios' => $portfolios,
    ]);
  }

  private function birthSpanish($birth) {
		$time  = strtotime($birth);
  	$year = date('Y', $time);
  	$month = date('m', $time) - 1;
  	$day = date('d', $time);

  	$monthSpanish = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

  	return "$day de $monthSpanish[$month] de $year";
  }
}
