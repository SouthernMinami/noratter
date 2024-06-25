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
        return new HTMLRenderer('image');
    },
    'all_images' => function (): HTMLRenderer {
        return new HTMLRenderer('all_images');
    },
];