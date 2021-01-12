<?php

use PHPUnit\Framework\TestCase;
use app\classes\User;

class UserTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        $this->user = new User;
        $this->user::setAuthUser([
            'id' => 1,
            'name' => 'Alex',
            'score' => 2000
        ]);
    }

    public function testId(): void
    {
        $this->assertEquals(1, $this->user::getAuthUserId());
    }

    public function testName(): void
    {
        $this->assertEquals('Alex', $this->user::getAuthUserName());
    }

    public function testScore(): void
    {
        $this->assertEquals(2000, $this->user::getAuthUserScore());
    }

    public function testSetScore(): void
    {
        $this->user::setAuthUserScore(3000);
        $this->assertEquals(3000, $this->user::getAuthUserScore());
    }

    public function testLogout(): void
    {
        $this->user::logoutUser();
        $this->assertEmpty($this->user::getAuthUserId());
    }

    public function testGenPassword(): void
    {
        $hash = $this->user::genHashPassword('12345');
        $this->assertEquals(true, $this->user::verifyPassword('12345', $hash));
    }

}