<?php

namespace Talandis\Larams\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Talandis\Larams\StructureItem;

class MediaController extends Controller
{

    public function getView(StructureItem $structureItem, $mediaId, $width = null, $height = null, $cropType = 0, $type = 'png')
    {

        $image = $structureItem->find($mediaId);

        if ( in_array( $width, ['jpg', 'png']) ) {
            $type = $width;
            $width = null;
        }

        $imagePath = storage_path('uploads/' . $image->data->name);

        $img = Image::cache(function ($image) use ($imagePath, $width, $height, $cropType) {

            if (!empty($width) || !empty($height)) {

                if (empty($cropType)) {
                    $image->make($imagePath)->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                } elseif ($cropType == 1) {
                    $image->make($imagePath)->fit($width, $height, function( $constraint ) {
                        $constraint->upsize();
                    });
                }

            } else {

                $image->make($imagePath);

            }
        }, null, true);

        $outputFileName = intval( $mediaId );

        if (!empty( $width ) || !empty( $height )) {
            $outputFileName .= '_'.intval( $width );
            $outputFileName .= '_'.intval( $height );
        }

        if (!empty( $cropType)) {
            $outputFileName .= '_'.intval( $cropType );
        }

        if (!empty( $type ) && in_array( $type, ['jpg', 'png'])) {
            $outputFileName .= '.'.$type;
        }

        $img->save( public_path('media/' . $outputFileName ) );

        return $img->response($type);
    }


}
