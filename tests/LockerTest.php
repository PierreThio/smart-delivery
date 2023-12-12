<?php

namespace App\Tests;

use App\Entity\Locker;
use App\Entity\Package;
use PHPUnit\Framework\TestCase;

class LockerTest extends TestCase
{
    public function testGetAvailableVolume(): void
    {
        $locker = new Locker;
        $locker->setVolume(100);

        $package = $this->createMock(Package::class);
        $package->method('getVolume')->willReturn(50);
        $locker->addPackage($package);

        $package1 = $this->createMock(Package::class);
        $package1->method('getVolume')->willReturn(80);
        $locker->addPackage($package1);
        
        $this->assertSame(0, $locker->getAvailableVolume());

        $locker = new Locker;
        $locker->setVolume(100);

        $package = $this->createMock(Package::class);
        $package->method('getVolume')->willReturn(70);
        $locker->addPackage($package);

        
        $this->assertSame(30, $locker->getAvailableVolume());
    }

    public function testEnoughVolumeChecker(): void
    {
        $locker = new Locker;
        $locker->setVolume(100);

        $package = $this->createMock(Package::class);
        $package->method('getVolume')->willReturn(50);
        $locker->addPackage($package);

        $package1 = $this->createMock(Package::class);
        $package1->method('getVolume')->willReturn(50);

        $this->assertSame(true, $locker->enoughVolumeChecker($package1));

        $locker = new Locker;
        $locker->setVolume(100);

        $package = $this->createMock(Package::class);
        $package->method('getVolume')->willReturn(70);
        $locker->addPackage($package);

        $package1 = $this->createMock(Package::class);
        $package1->method('getVolume')->willReturn(40);

        $this->assertSame(false, $locker->enoughVolumeChecker($package));
    }
}
