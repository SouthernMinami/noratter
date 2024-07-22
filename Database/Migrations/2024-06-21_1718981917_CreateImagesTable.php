<?php

namespace Database\Migrations;

use Database\SchemaMigration;

class CreateImagesTable implements SchemaMigration
{
    public function up(): array
    {
        // マイグレーション処理を書く
        return [
            'CREATE TABLE images (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(50),
                description VARCHAR(10),
                image_path VARCHAR(255),    
                post_url VARCHAR(255),
                delete_url VARCHAR(255),
                view_count INT,
                ip_address VARCHAR(255),
                file_size double,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                accessed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )'
        ];
    }

    public function down(): array
    {
        return [
            'DROP TABLE images'
        ];
    }
}