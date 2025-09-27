<?php

namespace App\Services;

use FFMpeg\FFMpeg;

class VideoService
{
    public static function getVideoDuration($path)
    {
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($path);
        $format = $video->getFormat();

        return (int) $format->get('duration'); // en secondes
    }
}
