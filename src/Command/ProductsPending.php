<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductsPending extends Command
{
    private $em;

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:products-pending';

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Products pending list.')

            // the full command description shown when running the command with
            ->setHelp('This command show products where status = pending')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '============================================',
            'Products on "Pending"',
            '============================================',
            '',
        ]);

        $outputProducts = $this->em->getRepository(Product::class)
            ->findByStatusOlderOneWeek('pending');

        foreach ($outputProducts as $product) {

            $date = $product->getUpdatedAt()->format('d-m-Y');

            $output->writeln([
                $product->getIssn().' | '.$product->getName().' | '.
                $product->getStatus().' | '.$date

            ]);
        }
    }
}