<?php

namespace App\Command;

use App\Service\Security;
use OTPHP\TOTP;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GenerateOTPSecretCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('otp:generate-secret')
            ->setDescription('Generates an OTP Secret');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Generating OTP Secret');
        $secret = TOTP::create()->getSecret();
        $io->text("Generated secret: {$secret}");
        $io->success('Done!');
    }
}
