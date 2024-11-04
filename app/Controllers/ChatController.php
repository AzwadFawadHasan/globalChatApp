<?php

namespace App\Controllers;

class ChatController extends BaseController
{
    public function index()
    {
        $session = session(); // Start or retrieve the session
        
        // Check if the user is logged in
        if (!$session->get('logged_in')) {
            // Redirect to login page if not logged in
            return redirect()->to(site_url('login'))->with('error', 'Please log in to access the chat.');
        }
        
        // If logged in, show the chat page
        return view('chat');
    }

    public function logout()
    {
        $session = session(); // Start or retrieve the session
        // print_r(($session));
        $session->destroy(); // Destroy the session, logging the user out
        
        // Redirect to the login page
        return redirect()->to(site_url('login'))->with('message', 'You have been logged out.');
    }
    public function testRedis()
    {
        // Connect to Redis using Predis (works if phpredis is not installed)
        $redis = new \Predis\Client([
            'scheme' => 'tcp',
            'host'   => '3',
            'port'   => 333,
            'password' => '',
        ]);

        // Set a key-value pair in Redis
        $redis->set('test_key', 'Hello, Redis!');

        // Retrieve and display the value
        echo $redis->get('test_key'); // This should output "Hello, Redis!"
    }
    public function addMessage($message)
    {
        $redis = new \Predis\Client([
            'scheme' => 'tcp',
            'host'   => 'r3om',
            'port'   => 333,
            'password' => '333',
        ]);
        // echo $message;
        // Add the message to the end of the list
        $redis->rpush('chat_messages', $message);
        // die();
        // print_r()
    }

    public function getMessages()
    {
        $redis = new \Predis\Client([
            'scheme' => 'tcp',
            'host'   => '3-333m',
            'port'   => 333,
            'password' => '333',
        ]);
        
        // Retrieve all messages from the list
        return $redis->lrange('chat_messages', 0, -1);
    }
    public function sendMessage()
    {
        $session = session(); // Retrieve the current session

        // Get the user ID and username from the session
        $userId = $session->get('id');
        $username = $session->get('username');


        $data = json_decode(file_get_contents('php://input'), true); // Capture the message from AJAX
        // echo ($data);
        // Assuming you have the user's ID stored in the session
        $session = session();
        $userId = $session->get('user_id');
        $db = \Config\Database::connect();
        $query = $db->query("SELECT username FROM users WHERE id = ?", [$userId]);
        $result = $query->getRow();

        // print_r($result);

        $message = $data['message'];
        // Format the message to include the username
        $formattedMessage = "[$username] $message";

        // Add the formatted message to Redis
        $this->addMessage($formattedMessage);
        // $this->addMessage($message); // Add the message to Redis

        return $this->response->setJSON(['status' => 'success']);
    }

    public function retrieveMessages()
    {
        $messages = $this->getMessages(); // Get messages from Redis
        // $messages = $messages+get_current_user();
        return $this->response->setJSON($messages);
    }






}
