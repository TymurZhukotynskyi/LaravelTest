<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Games\LinkEnum;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_type',
        'unique_link',
        'expires_at',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function getFullLinkToGamePage()
    {
        return route(LinkEnum::LuckyNumber->value . '.game_page', $this->unique_link);
    }
}
