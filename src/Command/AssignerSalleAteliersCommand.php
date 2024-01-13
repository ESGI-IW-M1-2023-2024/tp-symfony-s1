<?php

namespace App\Command;

use App\Entity\Atelier;
use App\Entity\Salle;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:assigner-salle-ateliers',
    description: 'Assignation des salles aux ateliers suivant le nombre d’inscription et la capacité de la salle',
)]

class AssignerSalleAteliersCommand extends Command
{

    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->writeln('Assignation des salles en cours...');

        $this->assignRoomToWorkshop();

        $io->success('Tout les ateliers ont une salle assignée!');

        return Command::SUCCESS;
    }

    private function assignRoomToWorkshop(): void
    {
        $atelierNonAssigne = array();
        $ateliers = $this->entityManager->getRepository(Atelier::class)->findAll() ;
        usort($ateliers, function ($a, $b){
            return $b->countLyceen() <=> $a->countLyceen();
        });
        $salles = $this->entityManager->getRepository(Salle::class)->findAll();
        usort($salles, function ($a, $b){
            return $b->getCapacite() <=> $a->getCapacite();
        });

        foreach($salles as $salle){
            foreach ($ateliers as $key => $atelier) {
                if ($salle->getCapacite() > $atelier->countLyceens()) {
                    $atelier->setSalle($salle);
                    unset($atelier[$key]);
                    break;
                }
                $atelierNonAssigne[] = $atelier;
            }
        }
    }
}
