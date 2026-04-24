<?php

namespace App\Http\Controllers\API\HomeAPI;

use App\Http\Controllers\Controller;
use App\Models\HomeModel\HomePageSectionTwoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomePageSectionTwoController extends Controller
{
    // GET ALL
    public function index()
    {
        $data = HomePageSectionTwoModel::all();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // CREATE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $slide = HomePageSectionTwoModel::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Slide created successfully',
            'data' => $slide
        ], 201);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $slide = HomePageSectionTwoModel::find($id);

        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'sub_title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image_url' => 'sometimes|required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $slide->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Slide updated successfully',
            'data' => $slide
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        $slide = HomePageSectionTwoModel::find($id);

        if (!$slide) {
            return response()->json([
                'success' => false,
                'message' => 'Slide not found'
            ], 404);
        }

        $slide->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slide deleted successfully'
        ]);
    }
}