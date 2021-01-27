<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table="student";
    protected $fillable = [
        'name', 'email', 'phone','attachment','date','state_id'
    ];

    public function getState()
    {
        return $this->belongsTo(State::class,'state_id');
    }

    public function getTechnology()
    {
        return $this->belongsToMany(Technology::class);
    }
        
    public function getcreatedAtAttribute($value)
    {
        $date=date_create($value);
        return date_format($date,"d M Y");
    }
}
