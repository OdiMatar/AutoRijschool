<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeVoertuig extends Model
{
    protected $table = 'type_voertuigen';

    protected $primaryKey = 'Id';

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $fillable = [
        'TypeVoertuig',
        'Rijbewijscategorie',
        'IsActief',
        'Opmerking',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function voertuigen(): HasMany
    {
        return $this->hasMany(Voertuig::class, 'TypeVoertuigId', 'Id');
    }
}
