<?php

namespace App\Utils;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\DefaultPathGenerator;

class MediaPathGenerator extends DefaultPathGenerator
{
    /**
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {
        $prefix = config('media-library.prefix', '');
        // path will be : [PREFIX]/[MODEL NAME]/[MODEL ID]/[COLLECTION]
        // e.g. : for photos of delivery with ID 20, path will be [PREFIX]/delivery/20/photos
        $path = [
            $prefix,
            Str::lower(Str::afterLast($media->model_type, '\\')),
            $media->model_id,
            $media->collection_name,
        ];

        return implode('/', array_filter($path));
    }
}
