<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\course;
use App\Models\teacher;

class enroll extends Model
{
    use HasFactory;
    protected $primarykey='id';
    protected $fillable = [
        'uid', // Add cname attribute here
        'cid',
        // 'tid',
        // 'uname',
        // 'uemail',
        // 'cname',
        // 'cteach',
        // 'cleng',
        // 'camount',
       
    ];
    // public function user()
    // {
    //     return $this->hasOne(User::class, 'uid'); // 'uid' is the foreign key in the enroll table
    // }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'uid'); // 'user_id' is the foreign key in the enrolls table
    }
    public function course()
    {
        return $this->belongsTo(course::class, 'cid'); // 'cid' is the foreign key in the enrolls table
    }
    // public function teacher()
    // {
    //     return $this->belongsTo(teacher::class, 'tid'); // 'cid' is the foreign key in the enrolls table
    // }
}
