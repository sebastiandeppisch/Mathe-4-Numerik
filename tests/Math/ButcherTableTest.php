<?php 
use PHPUnit\FrameWork\TestCase;

use \Math\ButcherTable;
use \Math\RationalNumber;
class ButcherTableTest extends Testcase{
    //https://de.wikipedia.org/wiki/Runge-Kutta-Verfahren#Beispiele
    const expliciteEuler=[
        [0, null],
        [null, 1]
    ];

    const impliciteEuler=[
        [1, 1],
        [null, 1]
    ];

    const heun=[
        [0, null, null],
        [1, 1, null],
        [0, "1/2", "1/2"]
    ];

    const rungeKutta2=[
        [0, null, null],
        ["1/2", "1/2", null],
        [null, 0, 1]
    ];

    const impliciteTrapez2=[
        [0, null, null],
        [1, "1/2", "1/2"],
        [null, "1/2", "1/2"]
    ];

    const rungeKutta3=[
        [0, null, null, null],
        ["1/2", "1/2", null, null],
        [1, -1, 2, null],
        [null, "1/6", "4/6", "1/6"]
    ];

    const heun3=[
        [0, null, null, null],
        ["1/3", "1/3", null, null],
        ["2/3", 0, "2/3", null],
        [null, "1/4", 0, "3/4"]
    ];

    const rungeKutta4=[
        [0, null, null, null, null],
        ["1/2", "1/2", null, null, null],
        ["1/2", null, "1/2", null, null],
        [1, 0, 0, 1, null],
        [null, "1/6", "1/3", "1/3", "1/6"]
    ];

    public function testFromArrayAndGetter(){
        $b = ButcherTable::fromArray(ButcherTableTest::expliciteEuler);
        $this->assertEquals(new RationalNumber(0), $b->getGamma(1));
        $this->assertEquals(new RationalNumber(0), $b->getAlpha(1, 1));
        $this->assertEquals(new RationalNumber(1), $b->getBeta(1));

        $b = ButcherTable::fromArray(ButcherTableTest::impliciteTrapez2);
        $this->assertEquals(new RationalNumber(0), $b->getGamma(1));
        $this->assertEquals(new RationalNumber(1), $b->getGamma(2));
        $this->assertEquals(new RationalNumber(0), $b->getAlpha(1, 1));
        $this->assertEquals(new RationalNumber(0), $b->getAlpha(1, 2));
        $this->assertEquals(new RationalNumber(1, 2), $b->getAlpha(2, 1));
        $this->assertEquals(new RationalNumber(1, 2), $b->getAlpha(2, 2));
        $this->assertEquals(new RationalNumber(1, 2), $b->getBeta(1));
        $this->assertEquals(new RationalNumber(1, 2), $b->getBeta(2));
    }

    /*public function testToArray(){

    }*/

    public function testConsistency(){
      /*  $b = ButcherTable::fromArray(ButcherTableTest::expliciteEuler);
        $this->assertEquals(1, $b->getConistency());

        $b = ButcherTable::fromArray(ButcherTableTest::impliciteEuler);
        $this->assertEquals(1, $b->getConistency());

        $b = ButcherTable::fromArray(ButcherTableTest::heun);
        $this->assertEquals(2, $b->getConistency());

        $b = ButcherTable::fromArray(ButcherTableTest::rungeKutta2);
        $this->assertEquals(2, $b->getConistency());

        $b = ButcherTable::fromArray(ButcherTableTest::impliciteTrapez2);
        $this->assertEquals(2, $b->getConistency());

        $b = ButcherTable::fromArray(ButcherTableTest::rungeKutta3);
        $consistency = $b->getConistency();
        $this->assertEquals(ButcherTable::fromArray(ButcherTableTest::rungeKutta3), $b);
        $this->assertEquals(3, $consistency);

        $b = ButcherTable::fromArray(ButcherTableTest::heun3);
        $this->assertEquals(3, $b->getConistency());*/

        $b = ButcherTable::fromArray(ButcherTableTest::rungeKutta4);
        $this->assertEquals(4, $b->getConistency());
    }

    public function testImplicite(){

    }
}