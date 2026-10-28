<?php

namespace App\Command;

use App\Service\PattatrasService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:pattatras',
    description: 'Parcourt les nombres de 1 à 6457 et applique les règles Pattatras.',
)]
final class PattatrasCommand extends Command
{
    public function __construct(
        private readonly PattatrasService $pattatrasService,
    ) {
        parent::__construct();
    }

    /**
     * Affiche un résultat par ligne, puis un bilan du parcours.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $results = $this->pattatrasService->generate();

        foreach ($results as $result) {
            $output->writeln($result['value']);
        }

        $io->success(sprintf(
            'Parcours terminé : %d valeurs affichées (de %d à %d).',
            count($results),
            PattatrasService::DEFAULT_START,
            PattatrasService::DEFAULT_END,
        ));

        return Command::SUCCESS;
    }
}
