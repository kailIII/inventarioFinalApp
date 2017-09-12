<?php

namespace App;

use App\Transformers\CustodiosTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class Custodios extends Model
{
    use SoftDeletes;
    use Notifiable, HasApiTokens;

    public $transformer = CustodiosTransformer::class;

    const CUSTODIO_NOTIFICADO = '1';
    const CUSTODIO_NO_NOTIFICADO = '0';

    protected $dates = ['deleted_at'];
    protected $fillable = ['nombre_responsable','ciudad','direccion','area-piso','documentoIdentificacion','cargo','compania','telefono','estado'];

    public function estados() {
        return $this->hasMany('ACTIVO', 'INACTIVO');
    }
    public function equiposhm()
    {
        return $this->hasMany('App\Equipos', 'custodio_id', 'id');
    }
    public function reponovedadeshm()
    {
        return $this->hasMany('App\RepoNovedades', 'custodio_id', 'id');
    }

    public function mandarNotificacion()
    {
        return $this->notificado == Custodios::CUSTODIO_NOTIFICADO;
    }

    public static function getENUM($tabla)
    {
        $type = DB::select( DB::raw("SHOW COLUMNS FROM custodios WHERE Field = '".$tabla."'") )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $value )
        {
            $v = trim( $value, "'" );
            $enum = array_add($enum, $v, $v);
        }
        return $enum;
    }

}
