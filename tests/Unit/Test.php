<?php

namespace Tests\Unit;

use Tests\TestCase;

class Test extends TestCase
{
    /**
     * Check if csrf cookie is set
     *
     * @return void
     */
    public function testIfCsrfCookieExists()
    {
        $response = $this->get('/sanctum/csrf-cookie');
        $response->assertStatus(204);
        $response->assertCookie('XSRF-TOKEN');
    }
}
