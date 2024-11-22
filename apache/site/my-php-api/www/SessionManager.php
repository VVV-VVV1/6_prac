<?php

class SessionManager {
    public function __construct($redisHost, $redisPort) {
        ini_set('session.save_handler', 'redis');
        ini_set('session.save_path', "tcp://$redisHost:$redisPort");
        session_start();
    }
}
