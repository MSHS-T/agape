<?php

namespace App\Models\Contracts;

interface WithCreator
{
    public function makePublic(): static;
    public function makePrivate(): static;
}
