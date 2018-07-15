<?php

namespace Tests\Feature;

use Tests\TestCase;

class NewGameTest extends TestCase
{
    public function testSuccess()
    {
        $this->json('post', '/newgame', [
            'dog' => 1,
        ])->assertStatus(200);
    }

    public function testValidation()
    {
        $this->json('post', '/newgame', [
            'dog' => 'wrong',
        ])->assertStatus(422);
    }
}
