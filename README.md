# globalChatApp
Simple implementation to practice redis in CodeIgniter


This repository contains practice work on Redis, featuring a basic global chat application built with CodeIgniter 4 and Redis. This project showcases Redis as a fast, in-memory data store to handle real-time messaging, caching, and other data operations.

## Table of Contents
Make sure to add your credentials (redis, mysql)
1. [Introduction](#introduction)
2. [About Redis](#about-redis)
   - [What is Redis?](#what-is-redis)
   - [Redis Data Structures](#redis-data-structures)
3. [Application Features](#application-features)
4. [Getting Started](#getting-started)
   - [Installation and Setup](#installation-and-setup)
   - [Running the Application](#running-the-application)
5. [Redis Commands Used](#redis-commands-used)
6. [CodeIgniter and Redis Integration](#codeigniter-and-redis-integration)
7. [Project Structure](#project-structure)
8. [Future Enhancements](#future-enhancements)
9. [Contributing](#contributing)
10. [License](#license)

---

## Introduction

This project serves as a practice implementation for Redis in a real-time environment. The application provides a basic chat interface where users can communicate in real time, with Redis used to store and manage chat messages.

## About Redis

### What is Redis?

**Redis (Remote Dictionary Server)** is an in-memory data store that stores data in RAM instead of on a hard disk. This characteristic makes Redis extremely fast, as data can be accessed and manipulated much faster in memory. Redis is widely used as:
- A **caching layer**: Storing frequently accessed data to reduce load on databases.
- A **session store**: Persisting user sessions in applications.
- A **real-time data store**: Powering applications like chat apps, leaderboards, and notifications.

#### Key Characteristics of Redis
- **Key-Value Storage**: Redis stores data in key-value pairs, similar to a dictionary or hash map.
- **Data Persistence**: Though Redis primarily stores data in memory, it offers options to persist data on disk, which helps mitigate the risk of data loss.
- **High Performance**: Redis operations are fast due to in-memory storage, making it suitable for real-time applications.

**[Redis Commands Documentation](https://redis.io/docs/latest/commands/)**

### Redis Data Structures

Redis supports several data structures, each suited to different use cases:

1. **Strings**: Basic key-value pairs (e.g., storing a username).
2. **Lists**: Linked lists, ideal for ordered data like message queues.
3. **Sets**: Unordered collections of unique values, often used to represent tags or user groups.
4. **Hashes**: Key-value pairs within a key, useful for storing objects (e.g., user profiles).
5. **Sorted Sets**: Similar to sets but with scores, enabling use cases like leaderboards.

## Application Features

- **Global Chat Functionality**: Users can send and view messages in real time.
- **Redis-Powered Message Storage**: Messages are stored as Redis list entries for fast retrieval and management.
- **User Authentication**: Users must log in to participate in the chat.
- **Session Management**: Redis can store user sessions for fast access.

## Getting Started

### Installation and Setup

1. **Clone the repository**:
   ```bash
   git clone https://github.com/azwadfawadhasan/redis_practice_chat_app.git
   cd redis_practice_chat_app

### Installation and Setup (continued)

2. **Install Dependencies:**

#### CodeIgniter Dependencies:
```bash
composer install`
```
Redis Client (Predis):
----------------------

```bash
`composer require predis/predis`
```
3.  **Configure Environment Variables:**
    
    *   Copy `.env.example` to `.env` and set up your database and Redis credentials
    *   Redis configuration in `.env`:
    
    
    `redis.default.host = your_redis_host
    redis.default.port = your_redis_port
    redis.default.password = your_redis_password`
    
4.  **Set Up the Database:**
    *   Import the SQL file provided (`database/chat_app.sql`) into your MySQL database
    *   Update database credentials in `.env`

### Running the Application

1.  **Start the CodeIgniter Server:**

```bash

`php spark serve`
```
The application will run at `http://localhost:8080` by default.

2.  **Start Redis Server** (if running Redis locally):


```bash
redis-server
```
3.  **Access the Chat Application:**
    *   Go to `http://localhost:8080/register` to create a new user
    *   Log in at `http://localhost:8080/login` to access the chat room

### Redis Commands Used

Common Redis Commands in the Application
----------------------------------------

1.  **LPUSH/RPUSH**: Adds messages to the beginning or end of a list

```bash

`RPUSH chat_messages "Hello, world!"`
```
2.  **LRANGE**: Retrieves a range of messages from the list

```bash
`LRANGE chat_messages 0 99`
```
3.  **SET/GET**: Stores and retrieves key-value pairs

```bash

`SET user:1001:name "Alice"
```
```bash
GET user:1001:name`
```
### CodeIgniter and Redis Integration

In this application, Redis is integrated as both a caching layer and a message store. CodeIgniter communicates with Redis through the Predis client, allowing efficient real-time message retrieval and session management.

Example: Storing and Retrieving Messages with Redis
---------------------------------------------------

**Storing Messages:**

```bash
`$redis = \Config\Services::redis();
```
```bash
$redis->rpush('chat_messages', "[$username] $message");`
```
**Retrieving Messages:**

```bash

`$redis = \Config\Services::redis();
```
```bash
$messages = $redis->lrange('chat_messages', 0, -1);`
```
Setting Up Redis as a CodeIgniter Cache Driver
----------------------------------------------
```bash
Configure `app/Config/Cache.php`:



`public $handler = 'redis';
public $backupHandler = 'file';`
```
### Project Structure
```bash

`redis_practice_chat_app/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php       # Manages user registration, login, and logout
│   │   └── ChatController.php       # Manages chat logic and message handling
│   ├── Models/
│   │   └── UserModel.php            # Defines the user model and database interactions
│   ├── Views/
│   │   ├── chat.php                 # Chat interface
│   │   ├── login.php                # Login page
│   │   └── register.php             # Registration page
├── writable/                        # Stores session data and cache
├── .env                             # Environment configuration file
├── composer.json                    # Composer dependencies
└── README.md                        # Project documentation`
```
### Future Enhancements

Consider adding the following features:

*   **Direct Messaging**: Allow users to send private messages to each other
*   **Message Timestamps**: Display timestamps for each message
*   **Notifications**: Use Redis Pub/Sub to notify users of new messages
*   **Redis-Powered Leaderboard**: Track the most active users in the chat

### Contributing

Contributions are welcome! Please open a pull request if you want to add features or improve this project.

### License

This project is licensed under the MIT License. See LICENSE for more details.
