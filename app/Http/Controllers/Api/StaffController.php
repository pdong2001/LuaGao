<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Resources\StaffResource;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffController extends Controller
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
        $query = Staff::query();
        if (!empty($search)) {
            $query->where('name', $search)
                ->orWhere('email', $search);
        }
        $page = $query->paginate(perPage: $pageSize, page: $pageIndex);
        $result = StaffResource::collection($page);
        return response()->json([
            'items' => $result,
            'perPage' => $pageSize,
            'total' => $page->total(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStaffRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStaffRequest $request)
    {
        $data = $request->validated();
        $staff = Staff::create($data);
        return response()->json($staff);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        if (!$staff) {
            return response(status: 404);
        }
        return response()->json($staff);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStaffRequest  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $staff->fill($request->only($staff->getFillable()))->save();
        return response()->json($staff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return response()->json($staff->id);
    }
}
