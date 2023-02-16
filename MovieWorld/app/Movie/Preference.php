<?php

namespace Movie;

use Movie\DataAccess;

class Preference extends DataAccess
{
    public function isPreference($user_id, $movie_id)
    {
        //Prepare parameters
        $parameters = [
            ':user_id' => $user_id,
            ':movie_id' => $movie_id
           ];
        $preference = $this->fetch('SELECT * FROM rate WHERE user_id = :user_id AND movie_id = :movie_id' , $parameters);
        
        return $preference;
    }

    public function updatePreference($rate_id, $user_like, $user_hate)
    {
        //Prepare parameters
        $parameters = [
            ':rate_id' => $rate_id,
            ':user_like' => $user_like,
            ':user_hate' => $user_hate,
           ];
           $update = $this->fetch('UPDATE rate SET user_like = :user_like, user_hate = :user_hate WHERE rate_id = :rate_id' , $parameters);
        
        return $update;
    }

    public function addPreference($user_id, $movie_id, $user_like, $user_hate)
    {
        //Prepare parameters
        $parameters = [
          ':user_id' => $user_id,
          ':movie_id' => $movie_id,
          ':user_like' => $user_like,
          ':user_hate' => $user_hate,
         ];

        $row = $this->execute('INSERT INTO rate (user_id, movie_id, user_like, user_hate) VALUES (:user_id, :movie_id, :user_like, :user_hate)', $parameters);

        return $row == 1;
    }
}
