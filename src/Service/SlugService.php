<?php

namespace App\Service;

use Symfony\Component\String\Slugger\AsciiSlugger;

class SlugService
{
    public function generateSlug(string $text): string
    {
        $slugger = new AsciiSlugger();
        return $slugger->slug($text);
    }
}
