<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'app:create-product',
    description: 'Создает новый продукт',
)]
class CreateProductCommand extends Command
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }
    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Имя продукта')
            ->addArgument('price', InputArgument::REQUIRED, 'Цена продукта');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $price = (float)$input->getArgument('price');
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price); 

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $output->writeln("Создан продукт '$name' с ценой '$price'.");

        return Command::SUCCESS;
    }
}
