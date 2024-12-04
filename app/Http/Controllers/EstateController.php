<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstateRequest;
use App\Http\Requests\UpdateEstateRequest;
use App\Http\Resources\EstatesResource;
use App\Models\Estate;
use App\Utils\ApiResponse;
use GeoIp2\Database\Reader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // sleep(3);
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

        return ApiResponse::success([], [], 'Record deleted');
    }

    public function form()
    {
        $reader = new Reader(database_path('/external/GeoLite2-Country.mmdb'));

        $record = $reader->country('128.101.101.101');

        Log::debug(json_encode($record));
        $country = '';
        $buildingDataRequirement = 'required_unless:type,' . Estate::TYPE_LAND . ',' . Estate::TYPE_REGULATED_LAND;
        $typeOptions = [];
        foreach (Estate::AVAILABLE_TYPES as $type) {
            $typeOptions[$type] = __('estate.' . $type);
        }
        $constructionTypeOptions = [null => ''];
        foreach (Estate::AVAILABLE_CONSTRUCTION_TYPES as $type) {
            $constructionTypeOptions[$type] = __('estate.' . $type);
        }
        return ApiResponse::success([
            [
                'name' => 'price',
                'label' => __('estate.price'),
                'type' => 'number',
                'validation' => ['required', 'float'],
            ],
            [
                'name' => 'currency_code',
                'label' => __('estate.currency'),
                'type' => 'select',
                'options' => [
                    'BGN' => 'BGN',
                    'EUR' => 'EUR',
                    'USD' => 'USD',
                ],
                'validation' => ['required', 'in:BGN,EUR,USD'],
            ],
            [
                'name' => 'region',
                'label' => __('estate.region'),
                'type' => 'text',
                'validation' => ['required', 'string'],
            ],
            [
                'name' => 'city',
                'label' => 'City',
                'type' => 'text',
                'validation' => ['required_without:village', 'string'],
            ],
            [
                'name' => 'village',
                'label' => 'Village',
                'type' => 'text',
                'validation' => ['required_without:city', 'string'],
            ],
            [
                'name' => 'district',
                'label' => 'District',
                'type' => 'text',
                'validation' => ['required_with:city', 'string'],
            ],
            [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'select',
                'options' => $typeOptions,
                'validation' => ['required', 'in:' . implode(',', Estate::AVAILABLE_TYPES)],
            ],
            [
                'name' => 'construction_type',
                'label' => 'Construction',
                'type' => 'select',
                'options' => $constructionTypeOptions,
                'validation' => [$buildingDataRequirement, 'in:' . implode(',', Estate::AVAILABLE_CONSTRUCTION_TYPES)],
            ],
            [
                'name' => 'land_size',
                'label' => 'Land',
                'type' => 'number',
                'validation' => ['required_unless:type,' . Estate::TYPE_APARTMENT, 'integer'],
            ],
            [
                'name' => 'building_size',
                'label' => 'Building',
                'type' => 'number',
                'validation' => [$buildingDataRequirement, 'integer'],
            ],
            [
                'name' => 'rooms',
                'label' => 'Rooms',
                'type' => 'number',
                'validation' => ['required_with:building_size', 'integer'],
            ],
            [
                'name' => 'bathrooms',
                'label' => 'Bathrooms',
                'type' => 'number',
                'validation' => ['required_with:building_size', 'integer'],
            ],
            [
                'name' => 'floors',
                'label' => 'Floors',
                'type' => 'number',
                'validation' => ['required_with:building_size', 'integer'],
            ],
            [
                'name' => 'floor_number',
                'label' => 'Floor number',
                'type' => 'number',
                'validation' => ['required_if:type,' . Estate::TYPE_APARTMENT, 'integer'],
            ],
            [
                'name' => 'construction_date',
                'label' => 'Construction date',
                'type' => 'date',
                'validation' => ['required_with:building_size', 'date_format:Y-m-d'],
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'validation' => ['required', 'string'],
            ],
        ], [], 'Form structure');
    }
}
