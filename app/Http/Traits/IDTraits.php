<?php

namespace App\Http\Traits;

trait HashId {
    public function scopeByHashId(Builder $query, string $hash){
        $query->where('id', '=', Hashids::decode($hash)[0]);
    }
}

