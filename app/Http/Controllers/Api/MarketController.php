<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Market;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $query = Market::where('is_active', true)->withCount('farmers');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%')
                  ->orWhere('address', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('day')) {
            $query->where('open_days', 'like', '%' . $request->day . '%');
        }

        return response()->json([
            'status' => true,
            'data'   => $query->orderBy('name')->paginate(20),
        ]);
    }

    public function show(Market $market)
    {
        return response()->json([
            'status' => true,
            'data'   => $market->load([
                'farmers' => function ($query) {
                    $query->where('approval_status', 'approved')->with(['user', 'products' => function ($pq) {
                        $pq->where('status', 'available');
                    }]);
                }
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'address'    => 'required|string',
            'city'       => 'nullable|string|max:100',
            'latitude'   => 'nullable|numeric|between:-90,90',
            'longitude'  => 'nullable|numeric|between:-180,180',
            'open_days'  => 'nullable|string|max:50',
            'open_time'  => 'nullable',
            'close_time' => 'nullable',
        ]);

        foreach (['city', 'latitude', 'longitude', 'open_days', 'open_time', 'close_time'] as $field) {
            if (array_key_exists($field, $validated) && $validated[$field] === '') {
                $validated[$field] = null;
            }
        }

        $market = Market::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Market created',
            'data'    => $market,
        ], 201);
    }

    public function update(Request $request, Market $market)
    {
        $validated = $request->validate([
            'name'      => 'sometimes|string|max:100',
            'address'   => 'sometimes|string',
            'city'      => 'nullable|string|max:100',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'open_days' => 'nullable|string|max:50',
            'open_time' => 'nullable',
            'close_time'=> 'nullable',
            'is_active' => 'sometimes|boolean',
        ]);

        foreach (['city', 'latitude', 'longitude', 'open_days', 'open_time', 'close_time'] as $field) {
            if (array_key_exists($field, $validated) && $validated[$field] === '') {
                $validated[$field] = null;
            }
        }

        $market->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Market updated',
            'data'    => $market,
        ]);
    }

    public function destroy(Market $market)
    {
        $market->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Market deleted',
        ]);
    }
}