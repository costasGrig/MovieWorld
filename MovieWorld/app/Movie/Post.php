<?php

namespace Movie;

class Post extends DataAccess
{
    public function insertNewPost($title, $description, $user_id, $movie_likes = 0, $movie_hates = 0)
    {
        //Set the parameters
        $parameters = [
            ':title' => $title,
            ':description' => $description,
            ':user_id' => $user_id,
            ':movie_likes' => $movie_likes,
            ':movie_hates' => $movie_hates,
           ];

        $this->execute('INSERT INTO  movie (title, description, user_id, movie_likes, movie_hates) 
                        VALUES(:title, :description, :user_id, :movie_likes, :movie_hates)',$parameters);
    }

    public function allPosts()
    {
        return $this->fetchAll('SELECT * FROM  movie INNER JOIN user ON movie.user_id = user.user_id ORDER BY movie_id DESC');
    }

    public function sortPostByLike()
    {
        return $this->fetchAll('SELECT * FROM  movie INNER JOIN user ON movie.user_id = user.user_id ORDER BY movie_likes DESC');
    }

    public function sortPostByHate()
    {
        return $this->fetchAll('SELECT * FROM  movie INNER JOIN user ON movie.user_id = user.user_id ORDER BY movie_hates DESC');
    }

    public function sortPostByDate()
    {
        return $this->fetchAll('SELECT * FROM  movie INNER JOIN user ON movie.user_id = user.user_id ORDER BY publication_date DESC');
    }

    public function authorPost($email)
    {
        $parameters = [
            ':email' => $email,
        ];
        return $this->fetchAll('SELECT * FROM movie INNER JOIN user ON movie.user_id = user.user_id WHERE email = :email', $parameters);
    }
}