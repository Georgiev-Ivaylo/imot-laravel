<?php

use App\Models\Estate;

return [
    Estate::TYPE_LAND => 'Land',
    Estate::TYPE_REGULATED_LAND => 'Land in regulation',
    Estate::TYPE_APARTMENT => 'Apartment',
    Estate::TYPE_HOUSE => 'House',
    Estate::TYPE_COMMERCIAL_BUILDING => 'Commercial building',
    Estate::CONSTRUCTION_TYPE_EPK => 'EPK',
    Estate::CONSTRUCTION_TYPE_CONCRETE => 'Concrete',
    Estate::CONSTRUCTION_TYPE_WOOD => 'Wood',
    Estate::CONSTRUCTION_TYPE_METAL => 'Metal',
    Estate::CONSTRUCTION_TYPE_BRICK => 'Brick',
    Estate::CONSTRUCTION_TYPE_ELSE => 'Else',
    'price' => 'Price',
    'currency' => 'Currency',
    'region' => 'Region',
];
