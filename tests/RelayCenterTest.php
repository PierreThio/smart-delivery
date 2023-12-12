<?php

namespace App\Tests;

use App\Entity\Locker;
use App\Entity\RelayCenter;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class RelayCenterTest extends TestCase
{
    public function testGetAvailableLockers(): void
    {
        $relayCenter = new RelayCenter;

        $locker = $this->createMock(Locker::class);
        $locker->method('getStatus')->willReturn('Available');
        $relayCenter->addLocker($locker);

        $locker1 = $this->createMock(Locker::class);
        $locker1->method('getStatus')->willReturn('Unavailable');
        $relayCenter->addLocker($locker1);

        $expectedLockers = new ArrayCollection();
        $expectedLockers->add($locker);

        $this->assertEquals($expectedLockers, $relayCenter->getAvailableLockers());

        $relayCenter = new RelayCenter;

        $locker = $this->createMock(Locker::class);
        $locker->method('getStatus')->willReturn('Available');
        $relayCenter->addLocker($locker);

        $locker1 = $this->createMock(Locker::class);
        $locker1->method('getStatus')->willReturn('Unavailable');
        $relayCenter->addLocker($locker1);

        $locker2 = $this->createMock(Locker::class);
        $locker2->method('getStatus')->willReturn('Available');
        $relayCenter->addLocker($locker2);

        $expectedLockers = new ArrayCollection();
        $expectedLockers->add($locker);
        $expectedLockers->add($locker2);

        $this->assertEquals($expectedLockers, $relayCenter->getAvailableLockers());
    }

    public function testGetRecommendedLocker(): void
    {
        $relayCenter = new RelayCenter;

        $locker = $this->createMock(Locker::class);
        $locker->method('getStatus')->willReturn('Available');
        $locker->method('getAvailableVolume')->willReturn(100);
        $relayCenter->addLocker($locker);

        $locker1 = $this->createMock(Locker::class);
        $locker1->method('getStatus')->willReturn('Unavailable');
        $locker1->method('getAvailableVolume')->willReturn('150');
        $relayCenter->addLocker($locker1);

        $this->assertSame($locker, $relayCenter->getRecommendedLocker());

        $relayCenter = new RelayCenter;

        $locker = $this->createMock(Locker::class);
        $locker->method('getStatus')->willReturn('Available');
        $locker->method('getAvailableVolume')->willReturn(100);
        $relayCenter->addLocker($locker);

        $locker1 = $this->createMock(Locker::class);
        $locker1->method('getStatus')->willReturn('Available');
        $locker1->method('getAvailableVolume')->willReturn(150);
        $relayCenter->addLocker($locker1);

        $this->assertSame($locker1, $relayCenter->getRecommendedLocker());

        $relayCenter = new RelayCenter;

        $locker = $this->createMock(Locker::class);
        $locker->method('getStatus')->willReturn('Unavailable');
        $locker->method('getAvailableVolume')->willReturn(100);
        $relayCenter->addLocker($locker);

        $locker1 = $this->createMock(Locker::class);
        $locker1->method('getStatus')->willReturn('Unavailable');
        $locker1->method('getAvailableVolume')->willReturn(150);
        $relayCenter->addLocker($locker1);
        +
        $this->assertSame(null, $relayCenter->getRecommendedLocker());
    }
}
