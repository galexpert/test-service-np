<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';

    protected $fillable = [
        'cityId',
        'ref',
        'parent_id',
        'published',


    ];
   // protected $with = ['lang'];


    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }

    public function parent()
    {

        return $this->belongsTo(self::class, 'parent_id');
    }

    public function parentParent()
    {
        return $this->belongsTo(self::class, 'parent_id')->with('parent');
    }

    protected static function newFactory()
    {
        return \Modules\Realty\Database\factories\LocationFactory::new();
    }

    public function lang(){
        return $this->hasOne(LocationLang::class);
    }


}
