Install Redis on Windows:

Download Redis for Windows from Memurai (Redis Labs does not officially support Windows, so Memurai or alternatives like redis-windows are commonly used).
Install and start the Redis server following the setup instructions provided by the installer.


Install Predis in CodeIgniter 4:
composer require predis/predis

# install redis server
```bash
sudo apt update
sudo apt install redis-server
```
# Start Redis Server:
```bash
redis-server
```

# Install Predis in CodeIgniter Project
```bash
composer require predis/predis
```

# Configure Redis in CodeIgniter:

Open app/Config/Redis.php or app/Config/Cache.php if you want to configure Redis for caching.
Example configuration in app/Config/Redis.php:

```php

public $default = [
    'host'     => '127.0.0.1', // or your Redis server IP if remote
    'password' => null,        // add if you have a password
    'port'     => 6379,        // default Redis port
    'timeout'  => 0,
];
```
Set up Redis as a Fallback Cache Driver:

In app/Config/Cache.php, set Redis as the primary cache handler and file as a backup:
```php
public $handler = 'redis';
public $backupHandler = 'file';
```

# Using Redis to Save and Retrieve Data
Let’s set up a CodeIgniter controller to:

Save data to Redis.
Retrieve data from Redis if available.
Fallback to MySQL if Redis is unavailable.
Example Controller (ChatController.php)
Create a Controller:

In app/Controllers, create ChatController.php:
```php
<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Predis\Client as RedisClient; // Use Predis client

class ChatController extends Controller
{
    protected $redis;

    public function __construct()
    {
        // Set up Redis connection
        $this->redis = new RedisClient([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);
    }

    // Store a message in Redis
    public function storeMessage($message)
    {
        try {
            // Add message to Redis
            $this->redis->rpush('chat_messages', $message);
        } catch (\Exception $e) {
            // Handle Redis error if Redis is unavailable
            log_message('error', 'Redis error: ' . $e->getMessage());
            return false;
        }
        return true;
    }

    // Retrieve messages from Redis, fallback to MySQL if unavailable
    public function getMessages()
    {
        try {
            // Attempt to retrieve messages from Redis
            $messages = $this->redis->lrange('chat_messages', 0, -1);
            if ($messages) {
                return $messages;
            }
        } catch (\Exception $e) {
            log_message('error', 'Redis error: ' . $e->getMessage());
        }

        // Fallback to MySQL if Redis is unavailable
        $db = \Config\Database::connect();
        $query = $db->query("SELECT message FROM messages ORDER BY created_at DESC LIMIT 100");
        return $query->getResultArray();
    }

    // Display chat messages
    public function chat()
    {
        $messages = $this->getMessages();
        return view('chat', ['messages' => $messages]);
    }

    // For testing, save a message
    public function sendMessage()
    {
        $message = "Hello, Redis!"; // Example message
        if ($this->storeMessage($message)) {
            echo "Message stored in Redis!";
        } else {
            echo "Failed to store message.";
        }
    }
}
```
# Set Up MySQL Fallback Table:


Create a MySQL table to store messages as a fallback option if Redis is unavailable:
```sql
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
# Save Messages in MySQL (if Redis is unavailable):

Modify the storeMessage function to add messages to MySQL as a fallback if Redis fails:
```php

public function storeMessage($message)
{
    try {
        // Attempt to store in Redis
        $this->redis->rpush('chat_messages', $message);
    } catch (\Exception $e) {
        log_message('error', 'Redis error: ' . $e->getMessage());

        // Fallback to MySQL
        $db = \Config\Database::connect();
        $db->query("INSERT INTO messages (message) VALUES (?)", [$message]);
        return false;
    }
    return true;
}
```
