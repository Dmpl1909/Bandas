<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Album;

class Band extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'photo_path',
        'description',
        'albums_count'
    ];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function updateAlbumsCount()
    {
        $this->update(['albums_count' => $this->albums()->count()]);
    }

}
