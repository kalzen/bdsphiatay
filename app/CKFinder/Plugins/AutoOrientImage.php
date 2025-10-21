<?php

namespace App\CKFinder\Plugins;

use CKSource\CKFinder\CKFinder;
use CKSource\CKFinder\Event\CKFinderEvent;
use CKSource\CKFinder\Event\AfterCommandEvent;
use CKSource\CKFinder\Plugin\PluginInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Plugin để tự động xoay ảnh theo EXIF orientation
 */
class AutoOrientImage implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var CKFinder
     */
    protected $app;

    public function setContainer(CKFinder $app)
    {
        $this->app = $app;
    }

    public function getDefaultConfig()
    {
        return [];
    }

    public static function getSubscribedEvents()
    {
        return [
            'AfterCommand.FileUpload' => 'autoOrientImage',
        ];
    }

    public function autoOrientImage(AfterCommandEvent $event)
    {
        $uploadedFile = $event->getFile();
        
        if (!$uploadedFile) {
            return;
        }

        $filePath = $uploadedFile->getPath();
        
        // Chỉ xử lý ảnh JPEG và JPG
        $imageInfo = @getimagesize($filePath);
        if (!$imageInfo || !in_array($imageInfo['mime'], ['image/jpeg', 'image/jpg'])) {
            return;
        }

        // Đọc EXIF orientation
        $exif = @exif_read_data($filePath);
        if (!$exif || !isset($exif['Orientation'])) {
            return;
        }

        $orientation = $exif['Orientation'];
        
        // Nếu orientation là 1 (normal), không cần xoay
        if ($orientation == 1) {
            return;
        }

        // Load ảnh
        $image = imagecreatefromjpeg($filePath);
        if (!$image) {
            return;
        }

        // Xoay ảnh theo orientation
        switch ($orientation) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 6:
                $image = imagerotate($image, -90, 0);
                break;
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }

        // Lưu ảnh đã xoay
        imagejpeg($image, $filePath, 90);
        imagedestroy($image);

        // Reset EXIF orientation về 1 (normal)
        if (function_exists('exif_read_data')) {
            // Chỉ có thể reset EXIF nếu có extension exif
            // Nếu không, ảnh đã được xoay đúng rồi nên không cần EXIF nữa
        }
    }
}

