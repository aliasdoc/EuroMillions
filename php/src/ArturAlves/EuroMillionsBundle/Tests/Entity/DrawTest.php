<?php

namespace ArturAlves\EuroMillionsBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ArturAlves\EuroMillionsBundle\Entity\Draw;

class DrawTest extends WebTestCase
{
    private $validator;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->validator = static::$kernel->getContainer()->get('validator');
    }

    public function testValidators()
    {
        $draw = new Draw();
        $this->isInvalid($draw);

        // Checks the date's getter and setter
        $date = '2016-01-01';
        $draw->setDate(new \DateTime($date));
        $this->assertEquals($draw->getDate()->format('Y-m-d'), $date);

        // Is invalid with 4 numbers
        $invalidResult = array(
            'numbers' => array(1, 2, 3, 4),
            'stars' => array(1, 2),
        );
        $this->isInvalid($draw, $invalidResult);

        // Is invalid with number 0
        $invalidResult = array(
            'numbers' => array(0, 1, 2, 3, 4),
            'stars' => array(1, 2),
        );
        $this->isInvalid($draw, $invalidResult);

        // Is invalid with 6 numbers
        $invalidResult = array(
            'numbers' => array(45, 46, 47, 48, 49, 50),
            'stars' => array(1, 2),
        );
        $this->isInvalid($draw, $invalidResult);

        // Is invalid with number 51
        $invalidResult = array(
            'numbers' => array(47, 48, 49, 50, 51),
            'stars' => array(1, 2),
        );
        $this->isInvalid($draw, $invalidResult);

        // Is invalid with 1 star
        $invalidResult = array(
            'numbers' => array(46, 47, 48, 49, 50),
            'stars' => array(1),
        );
        $this->isInvalid($draw, $invalidResult);

        // Is invalid with star 0
        $invalidResult = array(
            'numbers' => array(46, 47, 48, 49, 50),
            'stars' => array(0, 1),
        );
        $this->isInvalid($draw, $invalidResult);

        // Is invalid with star 12
        $invalidResult = array(
            'numbers' => array(46, 47, 48, 49, 50),
            'stars' => array(11, 12),
        );
        $this->isInvalid($draw, $invalidResult);

        // Is valid
        $validResult = array(
            'numbers' => array(46, 47, 48, 49, 50),
            'stars' => array(10, 11),
        );
        $draw->setResult(json_encode($validResult));
        $errors = $this->validator->validate($draw);
        $this->assertTrue(0 === count($errors));
    }

    /**
     * Checks if a draw is invalid.
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param Draw $draw A Draw to validate
     */
    private function isInvalid($draw, $invalidResult = null)
    {
        if (!is_null($invalidResult)) {
            $draw->setResult(json_encode($invalidResult));
        }

        $errors = $this->validator->validate($draw);
        $this->assertInstanceOf('Symfony\Component\Validator\ConstraintViolationList', $errors);
        $this->assertFalse(0 === count($errors));
    }
}
