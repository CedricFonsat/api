<?php

namespace App\Command;

use Phpml\Classification\NaiveBayes;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NeuralCommand extends Command
{
    protected static $defaultName = 'app:neural';

    protected function configure()
    {
        $this
            ->setDescription('Utiliser l\'algorithme Naive Bayes pour prédire si un commentaire est positif ou négatif.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Exemple de données pour l'apprentissage automatique
        $trainingSamples = [
            ['C\'était un excellent film, je l\'ai adoré', 'positive'],
            ['Je n\'ai pas aimé ce livre, c\'était ennuyeux', 'negative'],
            ['Le service dans ce restaurant était exceptionnel', 'positive'],
            ['Je suis déçu de la qualité de ce produit', 'negative']
        ];

        // Exemple de commentaires à prédire
        $comments = [
            'Je pense que ce film est génial',
            'Je suis très déçu de ce produit'
        ];

        // Extraction des échantillons et des étiquettes
        $samples = [];
        $labels = [];
        foreach ($trainingSamples as $sample) {
            $samples[] = $sample[0];
            $labels[] = $sample[1];
        }

        // Création d'un modèle Naive Bayes
        $classifier = new NaiveBayes();

        // Entraînement du modèle
        $classifier->train($samples, $labels);

        // Prédiction des commentaires
        foreach ($comments as $comment) {
            $prediction = $classifier->predict([$comment]);
            $output->writeln("Le commentaire '$comment' a été prédit comme étant '$prediction'.");
        }

        return Command::SUCCESS;
    }
}
