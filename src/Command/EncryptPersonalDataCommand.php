<?php

namespace App\Command;

use App\Service\Encrypt;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:encrypt-personal-data',
    description: 'Encrpyt all students personal data',
)]
class EncryptPersonalDataCommand extends Command
{
    public function __construct(
        private Encrypt $encrypt,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->encrypt->encryptAllStudentsPersonalData();
        } catch (\Exception | \Error $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        $io->success('All students personal data have been encrypted.');

        return Command::SUCCESS;
    }
}
