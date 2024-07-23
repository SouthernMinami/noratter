<?php

namespace Database\Seeds;

require_once __DIR__ . '/../../vendor/autoload.php';

use Database\AbstractSeeder;
use Database\MySQLWrapper;

class ImagesSeeder extends AbstractSeeder
{

    protected ?string $tableName = 'images';
    protected array $tableColumns = [
        [
            'data_type' => 'string',
            'column_name' => 'title'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'description'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'image_path'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'post_path'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'delete_path'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'view_count'
        ],
        [
            'data_type' => 'string',
            'column_name' => 'ip_address'
        ],
        [
            'data_type' => 'int',
            'column_name' => 'file_size'
        ],
    ];

    protected MySQLWrapper $db;

    public function createRowData(string $dataStr): array
    {
        $data_array = explode(',', $dataStr);
        
        return [
            [
                $data_array[0],
                $data_array[1],
                $data_array[2],
                $data_array[3],
                $data_array[4],
                0,
                $data_array[5],
                (int)$data_array[6]
            ]
        ];
    }
}