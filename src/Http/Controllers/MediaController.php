<?php

namespace Larams\Cms\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Larams\Cms\StructureItem;

class MediaController extends Controller
{

    public function getFile( StructureItem $structureItem, $id, $filename, $type )
    {
        $file = $structureItem->find($id);
        $path = storage_path('uploads/'. $file->data->name );
        return response()->download( $path, $filename.'.'.$type );
    }

    public function getViewByFile($filename, $width = null, $height = null, $cropType = 0, $type = 'png', $filePrefix = '')
    {

        $imagePath = storage_path('uploads/' . $filename );

        $isRetinaSize = false;
        if (strpos($cropType, '@2x') !== false) {
            $cropType = str_replace('@2x', '', $cropType);
            $isRetinaSize = true;
        }

        if (strpos($height, '@2x') !== false) {
            $height = str_replace('@2x', '', $height);
            $isRetinaSize = true;
        }

//        if (strpos($mediaId, '@2x') !== false) {
//            $mediaId = str_replace('@2x', '', $mediaId);
//            $isRetinaSize = true;
//        }

        if (!empty($isRetinaSize)) {
            $width *= 2;
            $height *= 2;
        }

        if (in_array($width, ['jpg', 'png', 'gif'])) {
            $type = $width;
            $width = null;
        }

        $img = Image::cache(function ($image) use ($imagePath, $width, $height, $cropType) {

            if (!empty($width) || !empty($height)) {

                if (empty($cropType)) {
                    $image->make($imagePath)->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                } elseif ($cropType == 1) {
                    $image->make($imagePath)->fit($width, $height, function ($constraint) {
                        $constraint->upsize();
                    });
                } elseif ($cropType == 2) {
                    $image->make($imagePath)->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

            } else {

                $image->make($imagePath);

            }
        }, null, true);

        $outputFileName = $filePrefix;

        if (!empty($width) || !empty($height)) {
            $outputFileName .= '_' . intval($width);
            $outputFileName .= '_' . intval($height);
        }

        if (!empty($cropType)) {
            $outputFileName .= '_' . intval($cropType);
        }

        if (!empty($type) && in_array($type, ['jpg', 'png', 'gif'])) {
            $outputFileName .= '.' . $type;
        }

        if ( empty( $width ) && empty( $height ) && $img->mime() == 'image/gif') {
            copy( $imagePath, public_path('media/' . $outputFileName) );
            return response( file_get_contents( $imagePath ), 200, [ 'Content-Type' => 'image/gif'] );
        } else {
            $img->save(public_path('media/' . $outputFileName));
            return $img->response($type);
        }

    }

    public function getView(StructureItem $structureItem, $mediaId, $width = null, $height = null, $cropType = 0, $type = 'png')
    {

        $image = $structureItem->find($mediaId);

        return $this->getViewByFile($image->data->name, $width, $height, $cropType, $type, intval($mediaId) );
    }


}
