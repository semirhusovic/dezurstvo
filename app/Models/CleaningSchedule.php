<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleaningSchedule extends Model
{
    use HasFactory;
    protected $fillable = ['monitoringDate','user1_id','user2_id','isTrash','isDishes'];
    protected $hidden = ['created_at', 'updated_at'];

    public function user1(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user1_id');
    }
    public function user2(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user2_id');
    }
}
