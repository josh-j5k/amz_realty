<?php

class CompressImage
{
    public static function compress($original_image, int $max_width, int $quality, string $folder, string | null $subfolder = null)
    {

        $dir = $folder;
        if (!is_dir($dir)) {
            mkdir($dir, recursive: true);
        }
        $imageType = getimagesize($original_image)['mime'];
        if ($imageType === 'image/png') {
            $img = imagecreatefrompng($original_image);
        } elseif ($imageType === 'image/jpeg') {
            $img = imagecreatefromjpeg($original_image);
        } elseif ($imageType === 'image/webp') {
            $img = imagecreatefromwebp($original_image);
        }

        $img_name = $original_image->hashName();

        $MAX_WIDTH = $max_width;

        imagepalettetotruecolor($img);
        $scale_size = $MAX_WIDTH / getimagesize($original_image)[0];

        $MAX_HEIGHT = getimagesize($original_image)[1] * $scale_size;
        $resized_img = imagescale($img, $MAX_WIDTH, $MAX_HEIGHT);
        imagewebp($resized_img, $dir . '/' . $img_name, $quality);
        imagedestroy($img);
        imagedestroy($resized_img);
        if ($subfolder) {

            $url = '/' . $folder . '/' . $subfolder . '/' . $img_name;
        }
        return $url;
    }
}
