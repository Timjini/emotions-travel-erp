<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait CreatedByTrait
{
    public static function bootCreatedByTrait()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}