<?php
namespace DisciteDB\Security;

class SecurityCsrf
{

    public function __construct()
    {
        
    }


    public static function generateCsrf(int $length = 64) : string
    {
        self::initializeSession();
        self::generateSessionSession();

        $token = self::generateToken($length);
        self::addToSession($token);

        return $token;
    }
    public static function checkCsrf($token) : bool
    {
        self::initializeSession();
        self::generateSessionSession();

        if(hash_equals($_SESSION['DisciteDB']['csrfSecurity'], $token))
        {
            self::removeFromSession($token);
            return true;
        }
        else
        {
            return false;
        }
    }


    private static function initializeSession() : void
    {
        if(session_status() === PHP_SESSION_NONE) session_start();
    }
    private static function generateSessionSession() : void
    {
        $_SESSION['DisciteDB'] = $_SESSION['DisciteDB'] ?? [];
        $_SESSION['DisciteDB']['csrfSecurity'] = $_SESSION['DisciteDB']['csrfSecurity'] ?? '';
    }

    private static function addToSession(string $token) : void
    {
        $_SESSION['DisciteDB']['csrfSecurity'] = $token;
    }
    private static function removeFromSession(string $token) : void
    {
        unset($_SESSION['DisciteDB']['csrfSecurity']);
    }
    private static function generateToken(int $length = 64) : string
    {
        return bin2hex(random_bytes($length));
    }
}

?>