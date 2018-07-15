<?php

namespace Tests\Feature;

use Tests\TestCase;

class CareTest extends TestCase
{
    public function testSuccess()
    {
        $this->json('post', '/care', [
            'id' => 1,
        ])->assertStatus(200);
    }

    public function testValidation()
    {
        $this->json('post', '/care', [
            'id' => 'wrong',
        ])->assertStatus(422);
    }
}
