<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FarmerProfile;
use Illuminate\Http\Request;

class FarmerProfileController extends Controller
{
    public function index(Request $request)
    {
        $query = FarmerProfile::with(['user', 'market', 'products' => function ($q) {
            $q->where('status', 'available')->with('category');
        }]);

        if (!$request->boolean('all')) {
            $query->where('approval_status', 'approved');
        }

        if ($request->filled('market_id')) {
            $query->where('market_id', $request->market_id);
        }

        if ($request->filled('search')) {
            $query->where('stall_name', 'like', '%' . $request->search . '%');
        }

        return response()->json([
            'status' => true,
            'data'   => $query->latest()->paginate(20),
        ]);
    }

    public function show(FarmerProfile $farmer)
    {
        return response()->json([
            'status' => true,
            'data'   => $farmer->load(['user', 'market', 'products' => function ($q) {
                $q->where('status', 'available')->with('category');
            }]),
        ]);
    }

    public function myProfile(Request $request)
    {
        $profile = $request->user()->farmerProfile;

        if (!$profile) {
            return response()->json([
                'status'  => false,
                'message' => 'Profile not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $profile->load(['user', 'market']),
        ]);
    }

    public function updateMyProfile(Request $request)
    {
        $user    = $request->user();
        $profile = $user->farmerProfile;

        if (!$profile) {
            $validated = $request->validate([
                'stall_name'         => 'required|string|max:100',
                'market_id'          => 'nullable|exists:markets,id',
                'description'        => 'nullable|string',
                'address'            => 'nullable|string',
                'operating_days'     => 'nullable|string|max:50',
                'pickup_start_time'  => 'nullable|date_format:H:i',
                'pickup_end_time'    => 'nullable|date_format:H:i',
                'cutoff_hours'       => 'nullable|integer|min:1|max:72',
                'latitude'           => 'nullable|numeric',
                'longitude'          => 'nullable|numeric',
            ]);

            $validated['user_id']         = $user->id;
            $validated['approval_status'] = 'pending';

            $profile = FarmerProfile::create($validated);
        } else {
            $validated = $request->validate([
                'stall_name'         => 'sometimes|string|max:100',
                'market_id'          => 'nullable|exists:markets,id',
                'description'        => 'nullable|string',
                'address'            => 'nullable|string',
                'operating_days'     => 'nullable|string|max:50',
                'pickup_start_time'  => 'nullable|date_format:H:i',
                'pickup_end_time'    => 'nullable|date_format:H:i',
                'cutoff_hours'       => 'nullable|integer|min:1|max:72',
                'latitude'           => 'nullable|numeric',
                'longitude'          => 'nullable|numeric',
            ]);

            $profile->update($validated);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Profile updated',
            'data'    => $profile->load(['user', 'market']),
        ]);
    }

    public function pending()
    {
        $farmers = FarmerProfile::with('user')
            ->where('approval_status', 'pending')
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'data'   => $farmers,
        ]);
    }

    public function approve(FarmerProfile $farmer)
    {
        $farmer->update(['approval_status' => 'approved']);

        return response()->json([
            'status'  => true,
            'message' => 'Farmer approved',
            'data'    => $farmer,
        ]);
    }

    public function suspend(FarmerProfile $farmer)
    {
        $farmer->update(['approval_status' => 'suspended']);

        return response()->json([
            'status'  => true,
            'message' => 'Farmer suspended',
            'data'    => $farmer,
        ]);
    }
}
