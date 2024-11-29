<?php

namespace Tests\Feature;

use App\Helpers\UserHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelperTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_create_default_user_and_teacher()
    {
        // Arrange: Configuració inicial
        config(['users.default' => [
            'name' => 'Default User',
            'email' => 'user@example.com',
            'password' => 'password123', // Sense bcrypt aquí
        ]]);
        config(['users.teacher' => [
            'name' => 'Default Teacher',
            'email' => 'teacher@example.com',
            'password' => 'password123', // Sense bcrypt aquí
        ]]);

        // Act: Creació d'usuaris
        $defaultUser = UserHelper::createDefaultUser();
        $teacherUser = UserHelper::createDefaultTeacher();

        // Assert: Comprovacions
        $this->assertDatabaseHas('users', [
            'email' => 'user@example.com',
            'name' => 'Default User',
        ]);
        $this->assertTrue(password_verify('password123', $defaultUser->password));
        $this->assertNotNull($defaultUser->teams()->first());
        $this->assertTrue($defaultUser->teams()->first()->personal_team);

        $this->assertDatabaseHas('users', [
            'email' => 'teacher@example.com',
            'name' => 'Default Teacher',
        ]);
        $this->assertTrue(password_verify('password123', $teacherUser->password));
        $this->assertNotNull($teacherUser->teams()->first());
        $this->assertTrue($teacherUser->teams()->first()->personal_team);
    }
}

