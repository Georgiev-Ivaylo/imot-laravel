<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstateRequest;
use App\Http\Requests\UpdateEstateRequest;
use App\Http\Resources\EstatesResource;
use App\Models\Estate;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        sleep(3);
        $user = $request->user();

        $estates = Estate::query();
        if ($user) {
            $estates->where('user_id', $user->id);
        }

        if ($request->input('order_by')) {
            $orderRules = explode(',', $request->input('order_by'));
            foreach ($orderRules as $orderRule) {
                if (Str::contains($orderRule, '-')) {
                    $estates->orderBy(Str::replace('-', '', $orderRule), 'DESC');
                    continue;
                }
                $estates->orderBy($orderRule, 'ASC');
            }
        }
        if ($request->input('query')) {
            $estates->where(
                'description',
                'ILIKE',
                "%{$request->input('query')}%"
            );
        }

        if ($request->input('get_pages')) {
            return EstatesResource::collection($estates->paginate(9));
        }
        return EstatesResource::collection($estates->simplePaginate(9));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $estateId)
    {
        // dd(Estate::with(['author'])->findOrFail($estateId));
        return new EstatesResource(Estate::with(['author'])
            ->findOrFail($estateId));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstateRequest $request, Estate $estate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estate $estate)
    {
        Gate::authorize('forceDelete', $estate);

        $estate->delete();

        return ApiResponse::success([]);
    }
}
