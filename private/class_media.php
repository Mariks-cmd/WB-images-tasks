<?php
class Media
{
    public function show($filename) {
        file_put_contents('data.log', time());
        //new Imagick();

        if (!DEBUG_MODE) {
            header('content-type: image/jpeg');
        }

        echo file_get_contents($filename);
    }

    private function resizeImage($imagePath, $width, $height, $filterType, $blur, $bestFit, $cropZoom) {
        $imagick = new Imagick(realpath($imagePath));
    
        $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);
    
        $cropWidth = $imagick->getImageWidth();
        $cropHeight = $imagick->getImageHeight();
    
        if ($cropZoom) {
            $newWidth = $cropWidth / 2;
            $newHeight = $cropHeight / 2;
    
            $imagick->cropimage(
                $newWidth,
                $newHeight,
                ($cropWidth - $newWidth) / 2,
                ($cropHeight - $newHeight) / 2
            );
    
            $imagick->scaleimage(
                $imagick->getImageWidth() * 4,
                $imagick->getImageHeight() * 4
            );
        }

        return $imagick->getImageBlob();
    }

}