<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use function PHPUnit\Framework\fileExists;

class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(
        UploadedFile $picture, ?string $folder = '', ?int $width = 300, ?int $height = 300)
    {
        $fichier = md5(uniqid(rand(), true)). '.webp';

        $pictureInfos = getimagesize($picture);

        if($pictureInfos === false) {
            throw new Exception('Format d\'image incorrect');
        }

        switch($pictureInfos['mime']){
            case 'image/png':
                $pictureSource = imagecreatefrompng($picture);
                break;
            case 'image/jpg':
                $pictureSource = imagecreatefromjpeg($picture);
                break;
            case 'image/webp':
                $pictureSource = imagecreatefromwebp($picture);
                break;
            default :
                throw new Exception('Format d\'image incorrect');
        }

        $imageWidth = $pictureInfos[0];
        $imageHeight = $pictureInfos[1];

        switch($imageWidth <=> $imageHeight) {
            case -1 :
                $squareSize = $imageWidth;
                $srcX = 0;
                $srcY = ($imageHeight - $squareSize)/2;
                break;
            case -0 :
                $squareSize = $imageWidth;
                $srcX = 0;
                $srcY = 0;
                break;
            case 1 :
                $squareSize = $imageHeight;
                $srcY = 0;
                $srcX = ($imageWidth - $squareSize)/2;
                break;
        }

        $resizedPicture = imagecreatetruecolor($width, $height);

        imagecopyresampled($resizedPicture, $pictureSource, 0, 0, $srcX, $srcY, $width, $height, $squareSize,$squareSize);

        $path = $this->params->get('images_directory').$folder;

        if(!file_exists($path.'/mini/')){
            mkdir($path.'/mini/', 0755, true);
        }

        imagewebp($resizedPicture, $path.'/mini/'.'mini-'.$fichier);
        imagewebp($pictureSource, $path.'/'.$fichier);

        return $fichier;
    }

    public function delete(string $path, string $miniPath)
    {
        $success = false;
        
        if(fileExists($path)) {
            unlink($path);
            $succes = true;
            if(fileExists($miniPath)) {
                unlink($miniPath);
            }
        }

        return $success;
    }
}