<?php

namespace Derp\Bundle\ERBundle\Command;

use Derp\Command\RegisterWalkin;
use Matthias\SymfonyConsoleForm\Console\Helper\FormHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterWalkinConsoleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('register:walk-in')
            ->addArgument('firstName')
            ->addArgument('lastName')
            ->addArgument('sex')
            ->addArgument('birthDate')
            ->addArgument('indication')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new RegisterWalkin();
        $command->firstName = $input->getArgument('firstName');
        $command->lastName = $input->getArgument('lastName');
        $command->sex = $input->getArgument('sex');
        $command->birthDate = \DateTime::createFromFormat(
            'Y-m-d',
            $input->getArgument('birthDate')
        );
        $command->indication = $input->getArgument('indication');

        $violationList = $this->getContainer()->get('validator')->validate($command);
        if (count($violationList)) {
            echo $violationList;
            return 1;
        }

        $this->getContainer()->get('command_bus')->handle($command);

        // Symfony console form package.
        $formHelper = $this->getHelper('form');
        /* @var $formHelper FormHelper  */

    }
}