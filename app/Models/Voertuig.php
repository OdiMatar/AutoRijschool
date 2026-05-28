<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Voertuig extends Model
{
    protected $table = 'voertuigen';

    protected $primaryKey = 'Id';

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $fillable = [
        'Kenteken',
        'Type',
        'Bouwjaar',
        'Brandstof',
        'TypeVoertuigId',
        'IsActief',
        'Opmerking',
    ];

    protected $casts = [
        'Bouwjaar' => 'date',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function typeVoertuig(): BelongsTo
    {
        return $this->belongsTo(TypeVoertuig::class, 'TypeVoertuigId', 'Id');
    }

    public function instructeurs(): BelongsToMany
    {
        return $this->belongsToMany(Instructeur::class, 'voertuig_instructeur', 'VoertuigId', 'InstructeurId')
            ->withPivot(['Id', 'DatumToekenning', 'IsActief', 'Opmerking'])
            ->using(VoertuigInstructeur::class);
    }

    public function huidigeToewijzing(): HasOne
    {
        return $this->hasOne(VoertuigInstructeur::class, 'VoertuigId', 'Id');
    }
}
