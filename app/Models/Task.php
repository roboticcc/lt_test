<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = false;
    protected $table = 'tasks';

    /**
     * Define many-to-one relation between task and its category
     *
     * @return belongsTo
     */
    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function userCompleted(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'completed_by');
    }
}
