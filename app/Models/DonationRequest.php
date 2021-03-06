<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    use HasFactory;

    public function contacts(){
        return $this->hasMany(ContactList::class);
    }

    public function response(){
        return $this->hasOne(RequestResponse::class);
    }
}
