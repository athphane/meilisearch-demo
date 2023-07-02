<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Legislation extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title', 'description',
    ];

    public function consolidations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Consolidation::class);
    }

    public function searchableAs(): string
    {
        return 'legislations_index';
    }

    public function toSearchableArray(): array
    {
        $legislations = $this->toArray();

        $legislations['consolidations'] = $this->consolidations->map(function (Consolidation $consolidation) {
            $sections = $consolidation->sections->map(function (Section $section) {
                return $section->toArray();
            })->toArray();

            $consolidation = $consolidation->toArray();

            $consolidation['sections'] = $sections;

            return $consolidation;
        })->toArray();

        return $legislations;
    }
}
