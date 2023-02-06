<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleTypeRequest;
use App\Http\Resources\VehicleTypeResource;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
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
        $query = VehicleType::query();
        if (!empty($search)) {
            $query->where('name', $search)
                ->orWhere('email', $search);
        }
        $page = $query->paginate(perPage: $pageSize, page: $pageIndex);
        $result = VehicleTypeResource::collection($page);
        return response()->json([
            'items' => $result,
            'perPage' => $pageSize,
            'total' => $page->total(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleTypeRequest $request)
    {
        $data = $request->validated();
        $vehicleType = VehicleType::create($data);
        return response()->json($vehicleType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleType $vehicleType)
    {
        if (!$vehicleType) {
            return response(status: 404);
        }
        return response()->json($vehicleType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreVehicleTypeRequest  $request
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function update(StoreVehicleTypeRequest $request, VehicleType $vehicleType)
    {
        $vehicleType->fill($request->only($vehicleType->getFillable()))->save();
        return response()->json($vehicleType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VehicleType  $vehicleType
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();
        return response()->json($vehicleType->id);
    }
}
