<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Consolidation extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'consolidations';

    protected $fillable = [
        'title', 'description',
    ];

    public function sections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function searchableAs(): string
    {
        return 'consolidations_index';
    }
}
