<?php

use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;
use Helpers\ValidationHelper;
use Helpers\DatabaseHelper;

return [
    '' => function (): HTMLRenderer {
        return new HTMLRenderer('home');
    },
    'new' => function (): HTMLRenderer {
        return new HTMLRenderer('new');
    },
    'image' => function (): HTMLRenderer {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // /image/以下のパスを取得
        $hash = ValidationHelper::string(ltrim($path, '/image/'));
        $imageInfo = DatabaseHelper::getImage($hash, 'post_path');

        return new HTMLRenderer('image', ['image' => $imageInfo]);
    },
    'delete' => function(): HTMLRenderer {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $hash = ValidationHelper::string(ltrim($path, '/delete/'));
        $imageInfo = DatabaseHelper::getImage($hash, 'delete_path');

        return new HTMLRenderer('delete', ['image' => $imageInfo]);
    },
    'all_images' => function (): HTMLRenderer {
        $images = DatabaseHelper::getImages();
        return new HTMLRenderer('all_images', ['images' => $images]);
    },
    '404' => function (): HTMLRenderer {
        return new HTMLRenderer('404');
    },
];