# Create a Function with Redis Caching for a Select Query
This example demonstrates caching the results of a query using Redis. If the data is already in the Redis cache, it retrieves from Redis; otherwise, it queries the database, caches the results in Redis, and returns the data.

Define the Controller Method: Here’s a sample function in a controller (e.g., ProductController.php) that uses Redis to cache a select query.

```php
<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Predis\Client as RedisClient; // Load Predis client

class ProductController extends Controller
{
    protected $redis;
    protected $cacheDuration = 300; // Cache duration in seconds (e.g., 5 minutes)

    public function __construct()
    {
        // Initialize Redis connection
        $this->redis = new RedisClient([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);
    }

    // Method to get products with Redis caching
    public function getProducts()
    {
        // Define a unique cache key for the query
        $cacheKey = 'products_list';

        try {
            // Check if data exists in Redis
            if ($this->redis->exists($cacheKey)) {
                // Retrieve data from Redis cache
                $products = json_decode($this->redis->get($cacheKey), true);
                echo "Data retrieved from Redis cache.";
            } else {
                // If not cached, query the database
                $db = \Config\Database::connect();
                $query = $db->query("SELECT * FROM products"); // Example table `products`
                $products = $query->getResultArray();

                // Cache the data in Redis for future use
                $this->redis->setex($cacheKey, $this->cacheDuration, json_encode($products));
                echo "Data retrieved from MySQL and cached in Redis.";
            }
        } catch (\Exception $e) {
            // Handle Redis errors (fallback to MySQL if Redis fails)
            log_message('error', 'Redis error: ' . $e->getMessage());
            $db = \Config\Database::connect();
            $query = $db->query("SELECT * FROM products");
            $products = $query->getResultArray();
        }

        // Return or display data
        return view('products', ['products' => $products]);
    }
}
```
## Explanation of the Code:

Redis Caching: The function first checks if the data exists in Redis using exists($cacheKey). If available, it retrieves the data from Redis.
Database Fallback: If the data isn’t cached or if Redis is unavailable, it queries the MySQL database and then caches the results in Redis for future requests.
Cache Duration: setex($cacheKey, $this->cacheDuration, json_encode($products)) caches the data in Redis with a timeout. Adjust $cacheDuration as needed.
View (products.php): Display the product data in a view file.

```html

<h2>Product List</h2>
<ul>
    <?php foreach ($products as $product): ?>
        <li><?= esc($product['name']); ?> - $<?= esc($product['price']); ?></li>
    <?php endforeach; ?>
</ul>
```
# Clear the Cache on Data Update
If your application updates the data in MySQL, you should invalidate (remove) the corresponding cache in Redis to ensure that users see the latest data.

Clear Redis Cache:
```php
public function updateProduct($id, $data)
{
    $db = \Config\Database::connect();
    $db->table('products')->update($data, ['id' => $id]);

    // Clear the Redis cache to ensure it gets updated
    $this->redis->del('products_list');
}
```
By implementing Redis caching for select queries, you can reduce database load and improve response times for frequently accessed data. This setup ensures a fallback to MySQL in case Redis is unavailable, keeping your application robust and efficient.
