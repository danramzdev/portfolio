<?php

namespace App\Controllers;

use App\Models\Knowledge;

class KnowledgeController extends BaseController {
  protected $msg = '';
  protected $error = '';

  public function getKnowledgeForm() {
    $knowledges = Knowledge::all();

    return $this->renderHTML('admin/knowledge.twig', array(
      'knowledges' => $knowledges
    ));
  }

  public function addKnowledge($request) {
    $data = $request->getParsedBody();

    if ($request->getMethod() == 'POST') {
      $knowledgeExist = Knowledge::where('knowledge', $data['knowledge'])->first();

      if (!$knowledgeExist) {
        $knowledge = new Knowledge();
        $knowledge->knowledge = $data['knowledge'];
        $knowledge->percentage = $data['percentage'];
        $knowledge->save();
        $this->msg = 'Nuevo conocimiento guardado';
      } else {
        $this->error = 'El nombre de knowledge ya existe';
      }
    }

    return $this->renderHTML('admin/result.twig', array(
      'error' => $this->error,
      'msg' => $this->msg
    ));
  }

  public function getEditKnowledge($request, $route) {
    $id = $route->attributes['id'];
    $edit_data = $this->knowledgeById($id);
    $new_data = $request->getParsedBody();

    if ($request->getMethod() == 'POST') {
      $this->editKnowledge($edit_data, $new_data);
    }

    return $this->renderHTML('admin/knowledge.twig', array(
      'edit' => true,
      'id' => $id,
      'editData' => $edit_data,
      'msg' => $this->msg
    ));
  }

  public function deleteKnowledge($request, $route) {
    $id = $route->attributes['id'];
    $data = $this->knowledgeById($id);
    $data->delete();

    $this->msg = 'Conocimiento eliminado';

    return $this->renderHTML('admin/result.twig', array(
      'msg' => $this->msg
    ));
  }

  private function editKnowledge($edit_data, $new_data) {
    $edit_data->knowledge = $new_data['knowledge'];
    $edit_data->percentage = $new_data['percentage'];
    $edit_data->update();
    $this->msg = 'Conocimiento editado';
  }

  private function knowledgeById($id) {
    return Knowledge::where('id', $id)->first();
  }
}
