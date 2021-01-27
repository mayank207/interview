<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table="notes";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'favourite','user_id'
    ];
public function getcreatedAtAttribute($value)
    {
        $date=date_create($value);
        return date_format($date,"d M Y");
    }

}
