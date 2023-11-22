<?php

namespace App\Event;

use App\Entity\Movie;

class MovieSavedEvent
{
    private $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function getMovie()
    {
        return $this->movie;
    }
}
