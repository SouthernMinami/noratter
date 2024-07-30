<?php

namespace Helpers;

use \Database\MySQLWrapper;

class DatabaseHelper
{
    public static function getImage(string $path, string $pathColumn): array
    {
        $db = new MySQLWrapper();

        $query = "SELECT * FROM images WHERE $pathColumn = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $path);
        $stmt->execute();
        $result = $stmt->get_result();
        $imageInfo = $result->fetch_assoc();

        if (!$imageInfo) {
            // 404ページを表示
            header('Location: /404');
            throw new \InvalidArgumentException(sprintf('No image post found with the path: %s', $path));
        }

        return $imageInfo;
    }
    
    public static function getImages(): array
    {
        $db = new MySQLWrapper();

        $query = 'SELECT * FROM images';
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $i = 0;
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[$i] = [
                'title' => $row['title'],
                'description' => $row['description'],
                'image_path' => $row['image_path'],
                'post_path' => $row['post_path'],
                'delete_path' => $row['delete_path'],
                'view_count' => $row['view_count'],
                'ip_address' => $row['ip_address'],
                'created_at' => $row['created_at'],
                'accessed_at' => $row['accessed_at']
            ];
            $i++;
        }

        return $images;

    }

    public static function updateImage(string $path): void
    {
        $db = new MySQLWrapper();

        $now = date('Y-m-d H:i:s');
        // 特定のpost_pathの投稿のview_countを1増やし、accessed_atを現在時刻に更新
        $query = "UPDATE images SET view_count = view_count + 1, accessed_at = ? WHERE post_path = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $now, $path);
        $stmt->execute();
    }
}