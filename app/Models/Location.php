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

    /* protected function alias(): Attribute
     {
         return Attribute::make(
             get: fn ($value) => ucfirst($value),
             set: fn ($value) => strtolower($value) . '-555',
         );
     }*/

    /*  public function setAliasAttribute($value): string
      {
          return $this->alias . '-1';
          //$this->attributes['alias'] = $this->alias. '-1';
      }*/

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

/*    public function files(){
        return $this->morphMany(File::class, 'fileable')->where('parent_id', '=', null);
        //return $this->morphedByMany(File::class, 'fileable');
        //return $this->morphToMany(File::class, 'fileable');
    }*/
    protected static function newFactory()
    {
        return \Modules\Realty\Database\factories\LocationFactory::new();
    }

    public function lang(){
        return $this->hasOne(LocationLang::class);
    }


}
