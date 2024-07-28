<?php

namespace Helpers;

use \Database\MySQLWrapper;

class DatabaseHelper
{
    public static function getImage(string $path): array
    {
        $db = new MySQLWrapper();

        $query = "SELECT * FROM images WHERE post_path = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $path);
        $stmt->execute();
        $result = $stmt->get_result();
        $imageInfo = $result->fetch_assoc();

        if (!$imageInfo) {
            throw new \InvalidArgumentException(sprintf('No image post found with the path: %s', $path));
        }

        return $imageInfo;
    }
    
    public static function getImages(): array
    {

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