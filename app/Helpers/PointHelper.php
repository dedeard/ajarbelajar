<?php

namespace App\Helpers;

class PointHelper extends Helper
{
    public static function onMinitutorPostCreated($user)
    {
        $user->incrementPoint(25);
    }
    public static function onMinitutorPostCommentAccepted($user)
    {
        $user->incrementPoint(4);
    }
    public static function onCommentAccepted($user)
    {
        $user->incrementPoint(2);
    }
    public static function onReviewed($user)
    {
        $user->incrementPoint(4);
    }
    public static function onMinitutorPostReviewed($user, $rating)
    {
        $user->incrementPoint($rating*4);
    }
}
