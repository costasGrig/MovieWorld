<?php

namespace Movie;

use PDO;
use Movie\DataAccess;
use Support\Configuration\Configuration;

class User extends DataAccess
{
       const TOKEN_KEY = 'asdfjkl;qweruiop';

    private static $currentUserId;

    public function getByEmail($email)
    {
       $parameters = [
        ':email' => $email
       ];
       return $this->fetch('SELECT * FROM user WHERE email = :email' , $parameters);
    }

    public function getByUserId($user_id)
    {
      $parameters = [
        ':user_id' => $user_id
       ];
       return $this->fetch('SELECT * FROM user WHERE user_id = :user_id' , $parameters);
    }

    public function getList()
    {
       return $this->fetchAll('SELECT * FROM user');
    }

    public function insert($name,$email,$password)
    {     
        //password hash protection
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        //Prepare parameters
        $parameters = [
          ':name' => $name,
          ':email' => $email,
          ':password' => $passwordHash,
         ];
         
        $row = $this->execute('INSERT INTO user (name, email, password) VALUES (:name, :email , :password)', $parameters);
        return $row == 1;
    }

    public function verify($email,$password)
    {
        //find the user 
        $user = $this->getByEmail($email);
       
        //verify the user
        return password_verify($password, $user['password']);
       
    }

    public function generateWebToken($userId, $csrf = '')
    {  
      //Token creation
      $payload = [
          'user_id' => $userId,
          'csrf' => $csrf ? : md5(time()),
      ];
      $payloadEncoded = base64_encode(json_encode($payload));
      $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

      return sprintf('%s.%s', $payloadEncoded, $signature);
    }

    public function getTokenPayload($token)
    {
      //Split payload from signature
      [$payloadEncoded] = explode('.', $token);

      //Decode payload
      return json_decode(base64_decode($payloadEncoded),true);
    }

    public function verifyToken($token)
    {
      //Get payload
      $payload = $this->getTokenPayload($token);
      $userId = $payload['user_id'];
      $csrf = $payload['csrf'];

      //Compare
      return $this->generateWebToken($userId, $csrf) == $token;
    }   

    public static function verifyCsrf($csrf)
    {  
      return self::getCsrf() == $csrf;
    }

    public static function getCsrf()
    {
      //Get payload
      $token = $_COOKIE['user_token'];
      $payload = self::getTokenPayload($token);
  
      return $payload['csrf'];
    }

    public static function getCurrentUserId(){
      return self::$currentUserId;
    }

    public static function setCurrentUserId($userId)
    {
      self::$currentUserId = $userId;
    }
}