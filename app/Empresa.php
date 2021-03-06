<?php

namespace App;

use App\Transformers\EmpresaTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    public $transformer = EmpresaTransformer::class;
    protected $dates = ['deleted_at'];

    protected $fillable = ['empresa'];
}
