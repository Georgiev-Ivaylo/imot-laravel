<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Estate extends Model
{
    use HasFactory;

    const UNSIGNED_SMALLINT = 32000;

    const TYPE_LAND = "land";
    const TYPE_REGULATED_LAND = "regulated_land";
    const TYPE_APARTMENT = "apartment";
    const TYPE_HOUSE = "house";
    const TYPE_COMMERCIAL_BUILDING = "commercial_building";

    const AVAILABLE_TYPES = [
        self::TYPE_LAND,
        self::TYPE_REGULATED_LAND,
        self::TYPE_APARTMENT,
        self::TYPE_HOUSE,
        self::TYPE_COMMERCIAL_BUILDING,
    ];

    const CONSTRUCTION_TYPE_EPK = "EPK";
    const CONSTRUCTION_TYPE_CONCRETE = "concrete";
    const CONSTRUCTION_TYPE_WOOD = "wood";
    const CONSTRUCTION_TYPE_METAL = "metal";
    const CONSTRUCTION_TYPE_BRICK = "brick";
    const CONSTRUCTION_TYPE_ELSE = "else";

    const AVAILABLE_CONSTRUCTION_TYPES = [
        self::CONSTRUCTION_TYPE_EPK,
        self::CONSTRUCTION_TYPE_CONCRETE,
        self::CONSTRUCTION_TYPE_WOOD,
        self::CONSTRUCTION_TYPE_METAL,
        self::CONSTRUCTION_TYPE_BRICK,
        self::CONSTRUCTION_TYPE_ELSE,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
