<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaintJob extends Model
{

	protected $table = 'cars';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plate_number', 
        'curr_color', 
        'target_color', 
        'queued',
    ];
}
