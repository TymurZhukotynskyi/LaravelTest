<?php

namespace App\Services;

use App\Models\User;
use App\Models\Link;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserService
{
    public function getUser(string $name, string $phone): User
    {
        return User::firstOrCreate(
            ['name' => $name, 'phone' => $phone]
        );
    }

//    public function getActiveLink(User $user): Link
//    {
//        $activeLink = Link::where('user_id', $user->id)
//            ->where('is_active', true)
//            ->where('expires_at', '>', Carbon::now())
//            ->first();
//
//        if (!$activeLink) {
//            $activeLink = Link::create([
//                'user_id' => $user->id,
//                'unique_link' => Str::uuid(),
//                'game_type' => 'LuckyNumber',
//                'expires_at' => Carbon::now()->addDays(7),
//                'is_active' => true,
//            ]);
//        }
//
//        return $activeLink;
//    }
}
