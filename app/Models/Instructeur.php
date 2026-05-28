<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Instructeur extends Model
{
    protected $table = 'instructeurs';

    protected $primaryKey = 'Id';

    const CREATED_AT = 'DatumAangemaakt';
    const UPDATED_AT = 'DatumGewijzigd';

    protected $fillable = [
        'Voornaam',
        'Tussenvoegsel',
        'Achternaam',
        'Mobiel',
        'DatumInDienst',
        'AantalSterren',
        'IsActief',
        'Opmerking',
    ];

    protected $casts = [
        'DatumInDienst' => 'date',
        'IsActief' => 'boolean',
        'DatumAangemaakt' => 'datetime',
        'DatumGewijzigd' => 'datetime',
    ];

    public function voertuigen(): BelongsToMany
    {
        return $this->belongsToMany(Voertuig::class, 'voertuig_instructeur', 'InstructeurId', 'VoertuigId')
            ->withPivot(['Id', 'DatumToekenning', 'IsActief', 'Opmerking'])
            ->using(VoertuigInstructeur::class);
    }

    public function getVolledigeNaamAttribute(): string
    {
        return collect([$this->Voornaam, $this->Tussenvoegsel, $this->Achternaam])
            ->filter()
            ->implode(' ');
    }

    public function getAantalSterrenWaardeAttribute(): int
    {
        return strlen($this->AantalSterren);
    }
}
