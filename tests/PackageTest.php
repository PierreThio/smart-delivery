<?php

namespace App\Tests;

use App\Entity\Localisation;
use App\Entity\Package;
use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;

class PackageTest extends TestCase
{
    public function testGetLastLocalisation(): void
    {
        $package = new Package;
        
        $localisation = $this->createMock(Localisation::class);
        $timestamp = new DateTime();
        $localisation->setTimestamp($timestamp);
        $package->addLocalisation($localisation);

        $this->assertSame($localisation, $package->getLastLocalisation());

        $package = new Package;
        
        $localisation = $this->createMock(Localisation::class);
        $timestamp = new DateTime();
        $localisation->setTimestamp($timestamp);
        $package->addLocalisation($localisation);

        $localisation1 = $this->createMock(Localisation::class);
        $timestamp1 = $timestamp->add(new DateInterval('P1D'));
        $localisation1->setTimestamp($timestamp1);
        $package->addLocalisation($localisation1);

        $this->assertSame($localisation1, $package->getLastLocalisation());

        $package = new Package;
        
        $timestamp = new DateTime();
        $localisation = $this->createMock(Localisation::class);
        $timestamp = $timestamp->add(new DateInterval('P1D'));
        $localisation->setTimestamp($timestamp);
        $package->addLocalisation($localisation);

       

        $localisation1 = $this->createMock(Localisation::class);
        $timestamp1 = new DateTime();
        $localisation1->setTimestamp($timestamp1);
        $package->addLocalisation($localisation1);

        $this->assertEquals($localisation, $package->getLastLocalisation());
    }
}
