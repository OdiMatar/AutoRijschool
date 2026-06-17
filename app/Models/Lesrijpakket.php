<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesrijpakket extends Model
{
    protected $table = 'lesrijpakkets';

    protected $primaryKey = 'id';

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $fillable = [
        'Naam',
        'Beschrijving',
        'Prijs',
        'Lessen',
        'Categorie',
        'IsActief',
        'Opmerking',
    ];

    protected $casts = [
        'IsActief' => 'boolean',
        'Prijs' => 'decimal:2',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];
}
