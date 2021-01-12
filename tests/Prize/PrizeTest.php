<?php

use PHPUnit\Framework\TestCase;
use app\classes\Prize;

class PrizeTest extends TestCase
{
    private $prize;

    protected function setUp(): void
    {
        $this->prize = new Prize;
    }

    /**
     * @dataProvider prizeProvider
     */
    public function testGet($prize): void
    {
        $this->prize::set($prize);
        $this->assertEquals($prize, $this->prize::get());
    }

    /**
     * @dataProvider prizeProvider
     */
    public function testRemove($prize): void
    {
        $this->prize::set($prize);
        $this->prize::remove($prize);
        $this->assertEmpty($this->prize::get());
    }

    public function prizeProvider(): array
    {
        return [
            ['type' => 'score', 'name' => '1500 баллов', 'value' => 1500],
            ['type' => 'mon', 'name' => '3500 $', 'value' => 3500],
            ['type' => 'phys', 'name' => 'Фонарь', 'value' => 0],
        ];
    }

}