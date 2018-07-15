<?php

namespace Tests\Feature;

use Tests\TestCase;

class HungrTest extends TestCase
{
    public function testSuccess()
    {
        $this->json('post', '/hungr', [
            'id' => 1,
        ])->assertStatus(200);
    }

    public function testValidation()
    {
        $this->json('post', '/hungr', [
            'id' => 'wrong',
        ])->assertStatus(422);
    }
}
