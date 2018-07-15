<?php

namespace Tests\Feature;

use Tests\TestCase;

class JoyTest extends TestCase
{
    public function testSuccess()
    {
        $this->json('post', '/joy', [
            'id' => 1,
        ])->assertStatus(200);
    }

    public function testValidation()
    {
        $this->json('post', '/joy', [
            'id' => 'wrong',
        ])->assertStatus(422);
    }
}
