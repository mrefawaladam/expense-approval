<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approver extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function approvalStages()
    {
        return $this->hasOne(ApprovalStage::class);
    }
}
