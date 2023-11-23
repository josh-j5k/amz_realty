<?php

namespace App\Helpers;

class ImageCompressHelper
{
    private $original_image;
    private $max_width;
    private $quality;
    private $folder;
    private $subfolder;
    private $file_folder;
    public function __construct($original_image, int $max_width, int $quality, string $folder, string $subfolder, string | null $file_folder = null)
    {
        $this->original_image = $original_image;
        $this->max_width = $max_width;
        $this->quality = $quality;
        $this->folder = $folder;
        $this->subfolder = $subfolder;
        $this->file_folder = $file_folder;
    }
    public function compress(): string
    {

        if ($this->file_folder) {

            $dir = 'Images/' . $this->folder . '/' . $this->subfolder . '/' . $this->file_folder;
        } else {
            $dir = 'Images/' . $this->folder . '/' . $this->subfolder;
        }
        if (!is_dir($dir)) {
            mkdir($dir, recursive: true);
        }
        $imageType = getimagesize($this->original_image)['mime'];

        if ($imageType === 'image/png') {
            $img = imagecreatefrompng($this->original_image);
        } elseif ($imageType === 'image/jpeg') {
            $img = imagecreatefromjpeg($this->original_image);
        } elseif ($imageType === 'image/webp') {
            $img = imagecreatefromwebp($this->original_image);
        }

        $img_name = $this->original_image->hashName();

        $MAX_WIDTH = $this->max_width;

        imagepalettetotruecolor($img);
        $scale_size = $MAX_WIDTH / getimagesize($this->original_image)[0];

        $MAX_HEIGHT = getimagesize($this->original_image)[1] * $scale_size;
        $resized_img = imagescale($img, $MAX_WIDTH, $MAX_HEIGHT);
        imagewebp($resized_img,  $dir . '/' . $img_name, $this->quality);
        imagedestroy($img);
        imagedestroy($resized_img);

        $url = '/' . $dir . '/' . $img_name;
        return $url;
    }
}
