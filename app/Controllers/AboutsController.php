<?php

namespace App\Controllers;

use App\Models\About;

class AboutsController extends BaseController {
  protected $msg;

  public function getAbout($request) {
    $about = About::find(1);
    if (!$about) {
    	$about = new About();
		}
    $data = $request->getParsedBody();

    if ($request->getMethod() == 'POST') {
      $about->name = $data['name'];
      $about->degree = $data['degree'];
      $about->birth = $data['birth'];
      $about->phone_ext = $data['phone-ext'];
      $about->phone_number = $data['phone-number'];
      $about->email = $data['email'];
      $about->state = $data['state'];
      $about->city = $data['city'];
      $about->description = $data['description'];
      $about->github_link = $data['github-link'];
      $about->twitter_link = $data['twitter-link'];
      $about->linkedin_link = $data['linkedin-link'];
      $about->facebook_link = $data['facebook-link'];

      $about->save();
      $this->msg = 'Datos Guardados';
    }

    return $this->renderHTML('admin/about.twig', [
      'about' => $about,
      'msg' => $this->msg,
    ]);
  }
}