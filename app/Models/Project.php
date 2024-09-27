<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = ['id'];

    public function badgeData(){
        $html = '';
        if($this->status == Status::ACTIVE){
            $html = '<span class="badge rounded-pill bg-success">Active</span>';
        }
        elseif($this->status == Status::INACTIVE){
            $html = '<span class="badge rounded-pill bg-danger">Inactive</span>';
        }
        elseif($this->status == Status::HOLD){
            $html = '<span class="badge rounded-pill bg-warning">Hold</span>';
        }

        return $html;
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'assign_staff_id', 'id');
    }
}