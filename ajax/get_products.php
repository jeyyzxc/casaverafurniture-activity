<?php
// FIX 1: Go UP one level (../) to find these files
require_once '../config.php';
require_once '../classes/Database.php';

header('Content-Type: application/json');

try {
    $db = new Database();
    
    // Fetch all products
    $products = $db->fetchAll("SELECT * FROM products ORDER BY date_added DESC");
    
    // Process the data for JavaScript
    foreach ($products as &$p) {
        $p['id'] = (int)$p['id'];
        $p['price'] = (float)$p['price'];
        
        // FIX 2: Handle "is_new" boolean
        // Some MySQL versions return 1/0, others return "1"/"0"
        $p['is_new'] = ($p['is_new'] == 1); 

        // FIX 3: Image Handling
        // Map DB column 'images' to JS property 'image'
        if (!empty($p['images'])) {
            $p['image'] = $p['images'];
        } elseif (isset($p['image_url']) && !empty($p['image_url'])) {
             $p['image'] = $p['image_url'];
        }

        // Ensure path has directory
        if (isset($p['image']) && strpos($p['image'], '/') === false) {
            $p['image'] = 'src/images/' . $p['image'];
        }

        // Fallback: Ensure there is always an 'image' property
        if (!isset($p['image'])) {
            $p['image'] = 'src/images/placeholder.jpg';
        }
    }

    echo json_encode($products);

} catch (Exception $e) {
    // Return a clean error JSON so JS doesn't crash
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>