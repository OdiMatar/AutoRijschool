<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VoertuigInstructeur extends Pivot
{
    protected $table = 'voertuig_instructeur';

    protected $primaryKey = 'Id';

    public $incrementing = true;

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $fillable = [
        'VoertuigId',
        'InstructeurId',
        'DatumToekenning',
        'IsActief',
        'Opmerking',
    ];

    protected $casts = [
        'DatumToekenning' => 'date',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function voertuig(): BelongsTo
    {
        return $this->belongsTo(Voertuig::class, 'VoertuigId', 'Id');
    }

    public function instructeur(): BelongsTo
    {
        return $this->belongsTo(Instructeur::class, 'InstructeurId', 'Id');
    }
}
