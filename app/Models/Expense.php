<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'status_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function latestApproval()
    {
        return $this->hasOne(Approval::class)->latest();
    }
}
