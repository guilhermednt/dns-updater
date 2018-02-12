<?php

namespace App\Command;

use App\Service\Security;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetOTPQrCodeCommand extends Command
{
    /** @var Security */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('otp:get-qr-code')
            ->setDescription('Get the QRCode URI.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Generating OTP QRCode URI...');
        $io->text($this->security->getQrCodeUri());
        $io->success('Done!');
    }
}
