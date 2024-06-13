<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\enroll;
use App\Models\teacher;
class course extends Model
{
    use HasFactory;
    protected $fillable = [
        'cname', // Add cname attribute here
        'cdesc',
        'cleng',
        'tid',
        'ctime',
        'camount',
        'cstart',
        'cend',
        'cseat',
        'image',

        // Add other fillable attributes here
    ];

    public function  courseenroll()
    {
        return $this->hasOne(enroll::class, 'cid'); // 'user_id' is the foreign key in the enrolls table
    }
    public function teachers()
    {
        return $this->belongsTo(teacher::class, 'tid'); // 'cid' is the foreign key in the enrolls table
    }
    public function admission()
    {
        return $this->hasOne(admission::class, 'cid'); // 'user_id' is the foreign key in the enrolls table
    }
}
