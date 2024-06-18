<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    public $table = 'task_list';

    protected $fillable = [
        'title',
        'description',
    ];

    public function isCompleted()
    {
        return $this->completed_at !== null;
    }
}
