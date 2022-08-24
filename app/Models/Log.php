<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function scopeId($query, $id)
    {
        if ($id != null) {
            return $query->where('id', $id);
        } else {
            return $query;
        }
    }
    public function scopeAdmin($query, $admin)
    {
        if ($admin != null) {
            return $query->where('admin_id', $admin);
        } else {
            return $query;
        }
    }
    public function scopeInfo($query, $info)
    {
        if ($info != null) {
            return $query->where('info', 'LIKE', '%' . $info . '%');
        } else {
            return $query;
        }
    }
    public function scopeIp($query, $ip)
    {
        if ($ip != null) {
            return $query->where('ip', $ip);
        } else {
            return $query;
        }
    }
    public function scopeDate($query, $date)
    {
        if ($date != null) {
            return $query->where('created_at', 'LIKE', '%' . $date . '%');
        } else {
            return $query;
        }
    }
}
