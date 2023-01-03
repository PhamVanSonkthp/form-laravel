<?php

namespace App\Traits;

use App\Models\Formatter;
use App\Models\Helper;
use App\Models\Image;
use App\Models\SingpleImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

trait BaseControllerTrait{

    public $size_default_thumbnail;

    public function __construct()
    {
        $this->size_default_thumbnail = config('_my_config.default_size_avatar');
    }
    
}
