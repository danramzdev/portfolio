<?php

namespace App\Controllers;

use App\Models\User;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

class UsersController extends BaseController {
  protected $msg = [];

  public function getLogin(ServerRequest $request) {
    if ($request->getMethod() == 'POST') {
      $data = $request->getParsedBody();
      $user = User::where('email', $data['email'])->first();

      if ($user) {
        if (password_verify($data['password'], $user->password)) {
          $_SESSION['userId'] = $user->id;
          return new RedirectResponse('/');
        } else {
          $this->msg = 'El email o contraseña no coinciden';
        }
      } else {
        $this->msg = 'El email o contraseña no coinciden';
      }
    }

    return $this->renderHTML('users/login.twig');
  }

  public function getRegister(ServerRequest $request) {
    if ($request->getMethod() == 'POST') {
      $data = $request->getParsedBody();
      $usernameExist = User::where('username', $data['username'])->first();
      $emailExist = User::where('email', $data['email'])->first();

      $password = $data['password'];
      $confirmPassword = $data['confirm-password'];

      if ($password == $confirmPassword) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if (!$usernameExist && !$emailExist) {
          $user = new User();
          $user->username = $data['username'];
          $user->email = $data['email'];
          $user->password = $hash;
          $user->save();
          $this->msg = [
            'type' => 'success',
            'message' => 'Usuario creado'
          ];
        } elseif ($usernameExist) {
          $this->msg = [
            'type' => 'error',
            'message' => 'El nombre de usuario ya existe'
          ];
        } elseif ($emailExist) {
          $this->msg = [
            'type' => 'error',
            'message' => 'El email ya se encuentra registrado'
          ];
        }
      } else {
        $this->msg = [
            'type' => 'error',
            'message' => 'Las contraseñas no coinciden'
          ];
      }
    }

    return $this->renderHTML('users/register.twig', [
      'msg' => $this->msg
    ]);
  }

  public function getLogout() {
    unset($_SESSION['userId']);
    return new RedirectResponse('/');
  }
}