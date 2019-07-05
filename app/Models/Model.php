<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Models;

class Model extends Models
{
	public function scopeRecent($query)
	{
	    return $query->orderBy('id', 'desc');
	}
}
