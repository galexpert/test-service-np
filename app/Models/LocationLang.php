<?php

namespace App\Models;

use GuzzleHttp\Utils;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



/**
 * Modules\Realty\Entities\CategoryLang
 *
 * @property int $id
 * @property string $title
 * @property string $alias
 * @property int $category_id
 * @property string|null $intro
 * @property string|null $desc
 * @property string $lang
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Modules\Realty\Database\factories\CategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryLang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LocationLang extends Model
{
    use HasFactory;
    protected $table = 'locations_lang';

    protected $fillable = [
        'title',
        'areadescription',
        'location_id',
        'lang',
    ];

    protected $casts = [
      //  'metadata' => 'array',
    ];

    protected $hidden = ['id', 'created_at', 'updated_at'];

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


    protected static function newFactory()
    {
        return \Modules\Realty\Database\factories\LocationLangFactory::new();
    }

    public function setMetadataAttribute($value)
    {
        // dump($value);
        if (is_array($value)) {
            $this->attributes['metadata'] = Utils::jsonEncode($value, JSON_FORCE_OBJECT);
        } else {
            $this->attributes['metadata'] = Utils::jsonEncode($value, JSON_FORCE_OBJECT);
        }
    }

}
