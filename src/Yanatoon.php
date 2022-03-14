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

    private array $data = [];

    private $img;
    
    private $error = false;

    /**
     * @return Yanatoon
     */
    public static function make($size = 32, $type = 'random', $data = []): Yanatoon
    {
        if(array_search($type, self::typeList) === false){
            $type = self::typeList[array_rand(self::typeList)];
        }

        return (new Yanatoon())->setType($type)->setSize($size)->setData($data)->generate();
    }

    public function __construct(string $type = '', int $size = 32, array $data = [])
    {
        $this->setType($type)
            ->setData($data)
            ->setSize($size);
    }

    public function setSize(int $size = 32): Yanatoon
    {
        if(is_numeric($size) || $size <= 1024){
            $this->size = $size;
        }


        return $this;
    }

    public function setData(array $data = []): Yanatoon
    {
        $this->data = $data;
        return $this;
    }

    public function setType(string $type): Yanatoon
    {
        if(array_search($type, self::typeList)){
            $this->type = $type;
        }
        return $this;
    }

    public function generate(): Yanatoon
    {
        $this->img = imagecreatetruecolor( $this->size, $this->size );

        $this->dataFormatter();

        ['bg' => $bg, 'eyes' => $eyes, 'face' => $face, 'hair' => $hair, 'mouth' => $mouth, 'clothes' => $clothes] = $this->data;

        $this->drawElement(__DIR__ . "/imgs/background/{$bg}.png");
        $this->drawElement(__DIR__ . "/imgs/{$this->type}/face/{$face}.png");
        $this->drawElement(__DIR__ . "/imgs/{$this->type}/clothes/{$clothes}.png");
        $this->drawElement(__DIR__ . "/imgs/{$this->type}/eyes/{$eyes}.png");
        $this->drawElement(__DIR__ . "/imgs/{$this->type}/hair/{$hair}.png");
        $this->drawElement(__DIR__ . "/imgs/{$this->type}/mouth/{$mouth}.png");
        
        if($this->error){
            throw new \Exception('Ошибка наложения');
        }

        return $this;
    }

    public function getImage(){
        return $this->img;
    }

    public function printImage(){
        imagepng($this->img);
    }
    
    public function getData(){
        return $this->data;
    }

    public function save($path){
        imagepng($this->img, $path);
    }

    private function drawElement($path) {
        if(!file_exists($path)) {
            $this->error = true;
            return;
        }
        $imagePart = imagecreatefrompng( $path );
        imagecopyresized( $this->img, $imagePart, 0, 0, 0, 0, $this->size, $this->size, imagesx($imagePart), imagesy( $imagePart ) );
    }

    private function dataFormatter(){
        $list = ['bg', 'eyes', 'face', 'hair', 'mouth', 'clothes'];

        $newData = [];
        $data = $this->data;

        foreach ($list as $el) {
            if(array_key_exists($el, $data) === false) {
                if($el === 'bg'){
                    $newData['bg'] = Yanatoon::randomPngFromPath(__DIR__ . '/imgs/background/');
                    continue;
                }

                $newData[$el] = Yanatoon::randomPngFromPath(__DIR__ . "/imgs/{$this->type}/{$el}/");
            } else {
                $newData[$el] = $data[$el];
            }
        }

        $this->data = $newData;
    }

    private static function randomPngFromPath(string $path){
        $parts = glob( $path . '*.png' );
        shuffle( $parts );
        //return $parts[0];
        $filename = explode('/', $parts[0]);
        return str_replace('.png', '', $filename[count($filename) - 1]);
    }

    public static function setContentType()
    {
        header("Content-Type: image/png;");
    }
}
