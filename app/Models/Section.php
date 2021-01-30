<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $guarded = [];
    public $translatedAttributes = ['name'];

    protected $table =  'sections';

    public function levels()
    {
        return $this->hasMany(Level::class);
    }
}
