<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\CourseStatus;
class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'status',
        'image_path',
        'video_path',
        'welcome_message',
        'goodbye_message',
        'observation',
        'user_id',
        'level_id',
        'category_id',
        'price_id',
    ];

    //castear verificar para almacenar en la base de datos
//    protected $casts = [
//        'status' => CourseStatus::class,
//    ];
    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

	public function getStatusNameAttribute(): string
	{
		return match ($this->status) {
			1 => 'BORRADOR',
			2 => 'PENDIENTE',
			3 => 'PUBLICADO',
			default => 'DESCONOCIDO',
		};
	}
	protected function image():Attribute{
		return new Attribute(
			get: function(){
				return $this->image_path ? asset('storage/'.$this->image_path) : "https://img.freepik.com/vector-premium/vector-icono-imagen-predeterminado-pagina-imagen-faltante-diseno-sitio-web-o-aplicacion-movil-no-hay-foto-disponible_87543-11093.jpg";
			}
		);
	}
}
