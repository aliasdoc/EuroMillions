<?php

namespace ArturAlves\EuroMillionsBundle\Tests\Entity;

// use Symfony\Component\Validator\Validation;
// use Symfony\Bundle\FrameworkBundle\Validator\ConstraintValidatorFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use ArturAlves\EuroMillionsBundle\Entity\Draw;

class DrawTest extends WebTestCase
{
    private $validator;

    /**
     * {@inheritDoc}
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

        $errors = $this->validator->validate($draw);
        $this->assertInstanceOf('Symfony\Component\Validator\ConstraintViolationList', $errors);
        $this->assertFalse(0 === count($errors));
    }
}
