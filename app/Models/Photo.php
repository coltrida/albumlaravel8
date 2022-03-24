<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Photo
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $album_id
 * @property string $img_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereImgPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Database\Factories\PhotoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereDeletedAt($value)
 * @property-read \App\Models\Album $album
 * @property-read mixed $path
 */
class Photo extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function getPathAttribute()
    {
        $url = $this->img_path;
        if (stristr($this->img_path, 'http') === false){
            $url = 'storage/'.$this->img_path;
        }
        return $url;
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
