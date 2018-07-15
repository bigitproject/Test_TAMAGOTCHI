<?php

namespace Tests\Feature;

use Tests\TestCase;

class SleepTest extends TestCase
{
    public function testSuccess()
    {
        $this->json('post', '/sleep', [
            'id' => 1,
        ])->assertStatus(200);
    }

    public function testValidation()
    {
        $this->json('post', '/sleep', [
            'id' => 'wrong',
        ])->assertStatus(422);
    }
}
