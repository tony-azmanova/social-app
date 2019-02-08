<?php

namespace App\Services\Contracts;

interface ImageServiceInterface
{
    public function getInfoForImage($file, $size = 200);
}