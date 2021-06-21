<?php

declare(strict_types=1);

use ...Direction;
use ...ObsTackle;
use ...Point;
use ...Rover;
use ...Surface;
use PHPUnit\Framework\TestCase;

class RoverTest extends TestCase
{
    /**
     * @var Surface
     */
    private static Surface $surface;
    /**
     * @var int
     */
    private static int $xMaxLocation;
    /**
     * @var int
     */
    private static int $yMaxLocation;
    /**
     * @var Rover
     */
    private static Rover $rover;
    /**
     * @var Direction
     */
    private static Direction $starterDirection;
    /**
     * @var Point
     */
    private static Point $starterPoint;


    public static function setUpBeforeClass(): void
    {
        self::$xMaxLocation = 10;
        self::$yMaxLocation = 10;
        self::$surface = new Surface(self::$xMaxLocation, self::$yMaxLocation, []);
        self::$surface->addObstacle(new ObsTackle(new Point(9, 2)));
        self::$surface->addObstacle(new ObsTackle(new Point(8, 9)));
        self::$starterPoint = new Point(1, 2);
        self::$starterDirection = new Direction('N');
        self::$rover = new Rover(self::$starterPoint, self::$starterDirection, self::$surface);
    }


    public function testBeforeRoverStart()
    {
        self::assertEquals(self::$surface->getXMaxLocation(), self::$xMaxLocation);
        self::assertEquals(self::$surface->getYMaxLocation(), self::$yMaxLocation);

    }

    public function testRoverShouldHaveSurfaceInfo()
    {
        self::assertEquals(self::$rover->getSurface(), self::$surface);
    }

    public function testRoverCanMoveForWard()
    {
        $yExpected = self::$rover->getPosition()->getLocationY() + 1;
        self::$rover->receiveCommands('f');
        self::assertEquals(self::$rover->getPosition()->getLocationY(), $yExpected);
    }

    public function testRoverCanMoveBackWard()
    {
        $yExpected = self::$rover->getPosition()->getLocationY() - 1;
        self::$rover->receiveCommands('b');
        self::assertEquals(self::$rover->getPosition()->getLocationY(), $yExpected);
    }

    public function testRoverCanTurnLeft()
    {
        $directionExpected = 'N';
        self::$rover->receiveCommands('llllllll');
        self::assertEquals(self::$rover->getDirection()->getShortName(), $directionExpected);
    }

    public function testRoverCanTurnRight()
    {
        $directionExpected = 'N';
        self::$rover->receiveCommands('rrrrrrrr');
        self::assertEquals(self::$rover->getDirection()->getShortName(), $directionExpected);
    }

    public function testRoverPassEdge()
    {
        $locationYExpected = 2;
        self::$rover->receiveCommands('ffffffffff');
        self::assertEquals(self::$rover->getPosition()->getLocationY(), $locationYExpected);
    }

    public function testRoverDetectObstacle()
    {
        $locationXExpected = 8;
        self::$rover->receiveCommands('rffffffffff');
        self::assertEquals(self::$rover->getPosition()->getLocationX(), $locationXExpected);
    }
}