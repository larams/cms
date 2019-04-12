<?php

namespace Larams\Cms\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Larams\Cms\StructureItem;

class MediaController extends Controller
{

    public function getFile(StructureItem $structureItem, $id, $filename, $type)
    {
        $file = $structureItem->find($id);
        $path = storage_path('uploads/' . $file->data->name);
        return response()->download($path, $filename . '.' . $type);
    }

    public function showFile($filename)
    {
        $path = storage_path('uploads/' . $filename);
        return response()->file($path);
    }

    public function getViewByFile($filename, $width = null, $height = null, $cropType = 0, $type = 'png', $filePrefix = '', $routeFolder = 'image')
    {

        if (empty($filePrefix)) {
            $filePrefix = $filename;
        }

        if (!is_numeric($width) && empty($height)) {
            $filename .= '/' . $width;
        }

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
            $filename = str_replace('/' . $width, '', $filename);
            $width = null;
        }


        $imagePath = storage_path('uploads/' . $filename);
        $fileType = mime_content_type($imagePath);
        $originalImage = true;

        if (strpos($fileType, 'svg') === false && strpos($fileType, 'xml') === false) {

            if (!empty($width) || !empty($height)) {
                $originalImage = false;
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

                list( $orientation, $flip ) = $this->getOrientation( $imagePath );

                if ( !empty( $flip ) ) {
                    $image->flip();
                }

                if ( $orientation > 0 ) {
                    $image->rotate( $orientation );
                }

            }, null, true);
        } else {
            $content = file_get_contents($imagePath);
            if (strpos($content, '<?xml') === false) {
                $content = '<?xml version="1.0" encoding="utf-8"?>' . $content;
                file_put_contents($imagePath, $content);
                $fileType = mime_content_type($imagePath);
            }
        }

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

        $isSvg = strpos($fileType, 'svg') !== false || strpos($fileType, 'xml') !== false;
        $isAnimatedGif = (empty($width) && empty($height) && !empty($img) && $img->mime() == 'image/gif');

        $path = public_path($routeFolder . '/' . $outputFileName);

        if ( !empty($originalImage) || $isSvg || $isAnimatedGif ) {
            copy($imagePath, $path);
        } else {
            $quality = 100;
            if (strpos($fileType, 'png') !== false) {
                $quality = 9;
            }

            $img->save($path, $quality);

            $apiKey = config('larams.tinify_api_key');
            if (!empty($apiKey)) {
                try {
                    \Tinify\setKey($apiKey);
                    $source = \Tinify\fromFile($path);
                    $source->toFile($path);
                } catch (\Exception $e) {
                }
            }
        }

        if ($isSvg) {
            return response(file_get_contents($imagePath), 200, ['Content-Type' => 'image/svg+xml']);
        } elseif ($isAnimatedGif || $originalImage) {
            return response(file_get_contents($imagePath), 200, ['Content-Type' => $img->mime()]);
        } else {
            return $img->response($type);
        }
    }

    protected function getOrientation( $path )
    {
        if (function_exists('exif_read_data')) {
            $exif = @exif_read_data($path);

            if (!empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 2:
                        return [0, true];
                    case 3:
                        return [180, false];
                    case 4:
                        return [180, true];
                    case 5:
                        return [270, true];
                    case 6:
                        return [270, false];
                    case 7:
                        return [90, true];
                    case 8:
                        return [90, false];
                }
            }
        }

        return [ 0, false ];
    }

    public function getView(StructureItem $structureItem, $mediaId, $width = null, $height = null, $cropType = 0, $type = 'png')
    {

        $image = $structureItem->find($mediaId);

        return $this->getViewByFile($image->data->name, $width, $height, $cropType, $type, intval($mediaId), 'media');
    }


    public function getViewWithoutResize(StructureItem $structureItem, $mediaId, $type = 'png')
    {

        $image = $structureItem->find($mediaId);

        return $this->getViewByFile($image->data->name, 0, 0, 1, $type, intval($mediaId), 'media');
    }
}
