<?php

namespace App\Controllers;

use App\Models\{Knowledge, About, Portfolio};
use App\Traits\BirthSpanish;

class IndexController extends BaseController {
	use BirthSpanish;

  public function getIndex() {
    $knowledges = Knowledge::all();
    $about = About::find(1) ?? null;
    $portfolios = Portfolio::all();

    if ($about) {
			$about->birth = $this->birthSpanish($about->birth);
		}

    $auth = $_SESSION['userId'] ?? null;

    return $this->renderHTML('index.twig', [
      'knowledges' => $knowledges,
      'about' => $about,
      'portfolios' => $portfolios,
      'auth' => $auth
    ]);
  }
}
