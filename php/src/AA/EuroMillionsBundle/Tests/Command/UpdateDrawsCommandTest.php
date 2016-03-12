<?php
namespace AA\EuroMillionsBundle\Tests\Command;

use AA\EuroMillionsBundle\Command\UpdateDrawsCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UpdateDrawsCommandTest extends WebTestCase
{
    public function testExecute()
    {
        $kernel = $this->createKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $application->add(new UpdateDrawsCommand());

        $command = $application->find('aa:update-draws');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertRegExp('/Execution terminated successfully/', $commandTester->getDisplay());
    }
}
