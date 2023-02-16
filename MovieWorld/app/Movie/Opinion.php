<?php

namespace Movie;

use Movie\DataAccess;

class Opinion extends DataAccess
{
    public function addOpinion($movie_id, $user_like, $user_hate)
    {
        //Prepare parameters
        $parameters = [
            ':movie_id' => $movie_id,
            ':user_like' => $user_like,
            ':user_hate' => $user_hate,
           ];
        return $this->fetch('UPDATE movie SET movie_likes = movie_likes + :user_like, movie_hates = movie_hates + :user_hate WHERE movie_id = :movie_id' , $parameters);
    }

    public function changeOpinionLike($movie_id)
    {
        //Prepare parameters
        $parameters = [
            ':movie_id' => $movie_id
           ];

        return $this->fetch('UPDATE movie SET movie_likes = movie_likes + 1, movie_hates = movie_hates - 1 WHERE movie_id = :movie_id' , $parameters);
    }

    public function changeOpinionHate($movie_id)
    {
        //Prepare parameters
        $parameters = [
            ':movie_id' => $movie_id
           ];

        return $this->fetch('UPDATE movie SET movie_likes = movie_likes - 1, movie_hates = movie_hates + 1 WHERE movie_id = :movie_id' , $parameters);
    }

}
