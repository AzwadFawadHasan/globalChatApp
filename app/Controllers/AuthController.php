<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function register()
    {
        return view('register');
    }

    public function store()
    {
        $db = \Config\Database::connect();
    
        // Capture form data manually
        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
    
        // Manual insert query
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $query = $db->query($sql, [$username, $email, $password]);
    
        if ($query) {
            echo "User inserted successfully!";
            // Redirect using `site_url` to prevent redundant path issues
            return redirect()->to(site_url('login'));
        } else {
            echo "Failed to insert user directly.";
        }
    }
    


    public function login()
    {
        return view('login');
    }

    public function authenticate()
    {
        $session = session(); // Start or retrieve the current session
        $userModel = new UserModel(); // Load the user model to access the users table
        $email = $this->request->getVar('email'); // Get email from form input
        $password = $this->request->getVar('password'); // Get password from form input

        // Look up the user by email in the database
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            // If a user was found, verify the entered password against the stored hashed password
            if (password_verify($password, $user['password'])) {
                // Store user data in the session
                $session->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'logged_in' => true // Boolean flag for logged-in status
                ]);

                // Redirect to the chat page
                return redirect()->to(site_url('chat'));
            } else {
                // Incorrect password handling
                return redirect()->to(site_url('login'))->with('error', 'Incorrect Password');
            }
        } else {
            // Email not found handling
            return redirect()->to(site_url('login'))->with('error', 'Email not found');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    public function testDB()
    {
        $db = \Config\Database::connect();
        if ($db->connect()) {
            echo "Database connection successful!";
        } else {
            echo "Database connection failed.";
        }
    }

}
