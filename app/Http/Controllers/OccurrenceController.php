<?php

namespace App\Http\Controllers;

use App\Occurrence;
use Illuminate\Http\Request;

class OccurrenceController extends Controller
{
	/**
	 * Occurrence controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	public function showAllOccurrences(Request $request)
	{
		$limit = 100;
		$page = 0;
		if(is_numeric($request->input('limit'))) $limit = $request->input('limit');
		if(is_numeric($request->input('page'))) $page = $request->input('page');
		return response()->json(Occurrence::skip($page)->take($limit)->get());
	}

	public function showOneOccurrence($id, Request $request)
	{
		$occurrence = Occurrence::find($id);
		if($request->input('includeMedia') == 1) $occurrence->media = Occurrence::find($id)->media;
		if($request->input('includeIdentHistory ') == 1) $occurrence->identification = Occurrence::find($id)->identification;
		return response()->json($occurrence);
	}

	public function create(Request $request)
	{
		/*
		$this->validate($request, [
				'name' => 'required',
				'email' => 'required|email|unique:authors',
				'location' => 'required|alpha'
		]);
		*/
		$occurrence = Occurrence::create($request->all());

		return response()->json($occurrence, 201);
	}

	public function update($id, Request $request)
	{
		$occurrence = Occurrence::findOrFail($id);
		$occurrence->update($request->all());

		return response()->json($occurrence, 200);
	}

	public function delete($id)
	{
		Occurrence::findOrFail($id)->delete();
		return response('Occurrence Deleted Successfully', 200);
	}
}