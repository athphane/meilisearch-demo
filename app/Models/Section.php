<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Section extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'sections';

    protected $fillable = ['title', 'text'];

    public function searchableAs()
    {
        return 'sections_index';
    }
}
