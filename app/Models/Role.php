<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;


    protected $hidden = [
        'pivot',
        'created_at',
        'descripcion',
        'updated_at'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'roles_asignados');
    }
}
