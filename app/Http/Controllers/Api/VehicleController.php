<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Resources\VehicleResource;
use Illuminate\Http\Request;
use App\Models\Vehicle;


class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageIndex = $request['page_index'] ?? 1;
        $pageSize = $request['page_size'] ?? 10;
        if ($pageSize  < 0) {
            $pageSize = 0;
        }
        $search = $request['search'] ?? null;
        $query = Vehicle::query();
        if (!empty($search)) {
            $query->where('name', $search)
                ->orWhere('email', $search);
        }
        $page = $query->paginate(perPage: $pageSize, page: $pageIndex);
        $result = VehicleResource::collection($page);
        return response()->json([
            'items' => $result,
            'perPage' => $pageSize,
            'total' => $page->total(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleRequest $request)
    {
        $data = $request->validated();
        $vehicle = Vehicle::create($data);
        return response()->json($vehicle);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        if (!$vehicle) {
            return response(status: 404);
        }
        return response()->json($vehicle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleRequest  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->fill($request->only($vehicle->getFillable()))->save();
        return response()->json($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return response()->json($vehicle->id);
    }
}
