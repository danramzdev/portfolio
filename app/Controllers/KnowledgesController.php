<?php

namespace App\Controllers;

use App\Models\Knowledge;
use Zend\Diactoros\ServerRequest;

class KnowledgesController extends BaseController
{
	protected $msg = '';
	protected $error = '';

	public function getKnowledgeForm()
	{
		$knowledges = Knowledge::all();

		return $this->renderHTML('admin/knowledge.twig', array(
			'knowledges' => $knowledges
		));
	}

	public function addKnowledge(ServerRequest $request)
	{
		if ($request->getMethod() == 'POST') {
			$data = $request->getParsedBody();
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

	public function getEditKnowledge(ServerRequest $request)
	{
		$params = $request->getQueryParams();
		$edit_data = $this->knowledgeById($params['id']);
		$new_data = $request->getParsedBody();

		if ($request->getMethod() == 'POST') {
			$this->editKnowledge($edit_data, $new_data);
		}

		return $this->renderHTML('admin/knowledge.twig', array(
			'edit' => true,
			'id' => $params['id'],
			'editData' => $edit_data,
			'msg' => $this->msg
		));
	}

	public function deleteKnowledge(ServerRequest $request)
	{
		$params = $request->getQueryParams();
		$data = $this->knowledgeById($params['id']);
		$data->delete();

		$this->msg = 'Conocimiento eliminado';

		return $this->renderHTML('admin/result.twig', array(
			'msg' => $this->msg
		));
	}

	private function editKnowledge($edit_data, $new_data)
	{
		$edit_data->knowledge = $new_data['knowledge'];
		$edit_data->percentage = $new_data['percentage'];
		$edit_data->update();
		$this->msg = 'Conocimiento editado';
	}

	private function knowledgeById($id)
	{
		return Knowledge::find($id);
	}
}
