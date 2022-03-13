<?php

namespace danilo9;

/**
 * Class Yanatoon
 * @package danilo9
 */
class Yanatoon
{
    private const typeList = ['male', 'female'];

    /**
     * @var string
     */
    private string $type = 'male';

    /**
     * @var int
     */
    private int $size = 32;

    private $img;

    /**
     * @return Yanatoon
     */
    public static function random()
    {
        $type = self::typeList[array_rand(self::typeList)];
        $bg = Yanatoon::randomPngFromPath(__DIR__ . '/imgs/background/');
        $eyes = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/eyes/");
        $face = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/face/");
        $hair = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/hair/");
        $mouth = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/mouth/");
        $clothes = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/clothes/");

        return (new Yanatoon($type))->genetate($bg, $eyes, $face, $hair, $mouth, $clothes);
    }

    public static function randomSize($size)
    {
        $type = self::typeList[array_rand(self::typeList)];
        $bg = Yanatoon::randomPngFromPath(__DIR__ . '/imgs/background/');
        $eyes = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/eyes/");
        $face = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/face/");
        $hair = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/hair/");
        $mouth = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/mouth/");
        $clothes = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$type}/clothes/");

        return (new Yanatoon($type, $size))->genetate($bg, $eyes, $face, $hair, $mouth, $clothes);
    }

    public function __construct(string $type = '', int $size = 32)
    {
        $this->setType($type);
        $this->setSize($size);
    }

    public function setSize(int $size = 32): bool
    {
        if(!is_numeric($size) || $size > 1024){
            return false;
        }

        $this->size = $size;
        return true;
    }

    public function setType(string $type): bool
    {
        if(array_search($type, self::typeList) === false){
            return false;
        }

        $this->type = $type;
        return true;
    }

    public function genetate($bgPath, $eyesPath, $facePath, $hairPath, $mouthPath, $clothesPath)
    {
        $this->img = imagecreatetruecolor( $this->size, $this->size );

        $this->drawElement($bgPath);
        $this->drawElement($facePath);
        $this->drawElement($eyesPath);
        $this->drawElement($hairPath);
        $this->drawElement($mouthPath);
        $this->drawElement($clothesPath);

        return $this;
    }

    public function getImage(){
        return $this->img;
    }

    public function printImage(){
        imagepng($this->img);
    }

    public function save($path){
        imagepng($this->img, $path);
    }

    private function drawElement($path) {
        $imagePart = imagecreatefrompng( $path );
        imagecopyresized( $this->img, $imagePart, 0, 0, 0, 0, $this->size, $this->size, imagesx($imagePart), imagesy( $imagePart ) );
    }

    private static function randomPngFromPath(string $path){
        $parts = glob( $path . '*.png' );
        shuffle( $parts );

        return $parts[0];
    }

    public static function setContentType()
    {
        header("Content-Type: image/png;");
    }
}