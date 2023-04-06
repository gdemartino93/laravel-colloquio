<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'city'
    ];

    protected $visible = [
    	'name',
		'email',
		'city',
		'tags'
	];

    public function tags(){
        return $this->hasMany(Tag :: class);
    }
}
