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
        $imageInfo = DatabaseHelper::getImage($hash);

        return new HTMLRenderer('image', ['image' => $imageInfo]);
    },
    'all_images' => function (): HTMLRenderer {
        return new HTMLRenderer('all_images');
    },
];