<?php

namespace Tests\Unit;

use App\Infrastructure\Authorization\AuthorizationService;
use App\Models\User\User;
use Tests\TestCase;

class AuthorizationServiceTest extends TestCase
{
    public function test_can_check_user_has_access()
    {
        $user = User::factory()->author()->makeOne();
        $service = new AuthorizationService([
            'author' => [
                'can-write',
                'can-read',
            ],
            'admin' => [
                'can-delete'
            ]
        ]);

        $this->assertTrue($service->can($user, 'can-write'));
        $this->assertTrue($service->can($user, 'can-read'));
        $this->assertFalse($service->can($user, 'can-delete'));
    }
}
