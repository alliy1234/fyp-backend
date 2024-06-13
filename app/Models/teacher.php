<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\enroll;
use App\Models\course;
class teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', // Add cname attribute here
        'email',
        'contact',
        'address',
        'specialist',
        // 'image'
       
    ];
    public function course()
    {
        return $this->hasOne(course::class, 'tid'); // 'user_id' is the foreign key in the enrolls table
    }
    // public function enroll()
    // {
    //     return $this->hasOne(enroll::class, 'tid'); // 'user_id' is the foreign key in the enrolls table
    // }
}
