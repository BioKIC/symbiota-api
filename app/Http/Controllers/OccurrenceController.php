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

    /**
     * @OA\Get(
     *     path="/api/v2/occurrences",
     *     operationId="/api/v2/occurrences",
     *     tags={""},
     *     @OA\Response(
     *         response="200",
     *         description="Returns list of occurrences",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. ",
     *     ),
     * )
     */
    public function showAllOccurrences(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer',
            'offset' => 'integer'
        ]);

        $limit = $request->input('limit',100);
        $offset = $request->input('offset',0);
        $fullCnt = Occurrence::count();
        $eor = false;
        $retObj = [
            "offset" => $offset,
            "limit" => $limit,
            "endOfRecords" => $eor,
            "count" => $fullCnt,
            "results" => Occurrence::skip($offset)->take($limit)->get()
        ];
        return response()->json($retObj);
    }

    /**
     * @OA\Get(
     *     path="/api/v2/occurrences/{identifier}",
     *     operationId="/api/v2/occurrences/identifier",
     *     tags={""},
     *     @OA\Parameter(
     *         name="identifier",
     *         in="path",
     *         description="occid or specimen GUID (occurrenceID) associated with target occurrence",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="includeMedia",
     *         in="query",
     *         description="Whether to include media within output",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Returns occurrence data",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Error: Bad request. Occurrence identifier is required.",
     *     ),
     * )
     */
     public function showOneOccurrence($id, Request $request)
    {
        $this->validate($request, [
            'includeMedia' => 'integer',
            'includeIdentHistory' => 'integer'
        ]);
        $occurrence = Occurrence::find($id);
        if($request->input('includeMedia')) $occurrence->media = Occurrence::find($id)->media;
        if($request->input('includeIdentHistory ')) $occurrence->identification = Occurrence::find($id)->identification;
        return response()->json($occurrence);
    }

    public function create(Request $request)
    {
        //$occurrence = Occurrence::create($request->all());
        //return response()->json($occurrence, 201);
    }

    public function update($id, Request $request)
    {
        //$occurrence = Occurrence::findOrFail($id);
        //$occurrence->update($request->all());
        //return response()->json($occurrence, 200);
    }

    public function delete($id)
    {
        //Occurrence::findOrFail($id)->delete();
        //return response('Occurrence Deleted Successfully', 200);
    }
}