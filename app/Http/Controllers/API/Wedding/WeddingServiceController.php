<?php

namespace App\Http\Controllers\API\Wedding;

use App\Http\Controllers\Controller;
use App\Models\Wedding\WeddingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WeddingServiceController extends Controller
{
    // Get all services (public)
    public function getServices()
    {
        $services = WeddingService::all();
        
        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    // Create new service (admin)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $service = WeddingService::create([
            'service_name' => $request->service_name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service created successfully',
            'data' => $service
        ], 201);
    }

    // Update service (admin)
    public function update(Request $request, $id)
    {
        $service = WeddingService::find($id);
        
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $service->update([
            'service_name' => $request->service_name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service updated successfully',
            'data' => $service
        ]);
    }

    // Delete service (admin)
    public function destroy($id)
    {
        $service = WeddingService::find($id);
        
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found'
            ], 404);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted successfully'
        ]);
    }
}