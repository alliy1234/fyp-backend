<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\course;

class admission extends Model
{
    use HasFactory;
    protected $fillable = [
        'cid',
        'uid', // Add cname attribute here
        // 'uname',
        // 'uemail',
        // 'cname',
        // 'cteach',
        // 'cleng',
        // 'camount',
       
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'uid'); // 'user_id' is the foreign key in the enrolls table
    }
    public function course()
    {
        return $this->belongsTo(course::class, 'cid'); // 'user_id' is the foreign key in the enrolls table
    }
}
