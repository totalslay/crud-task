<?php
namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/*class CreateProductCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output):input
    {
        protected static $defaultName = 'app:create-product';
        private $entityManager;
        public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Создает новый продукт')
            ->addArgument('name', InputArgument::REQUIRED, 'Название продукта')
            ->addArgument('price', InputArgument::REQUIRED, 'Цена продукта');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $price = $input->getArgument('price');

        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $output->writeln('Продукт ' . $name . ' был успешно создан с ценой ' . $price);
        return Command::SUCCESS;
    }
}
}*/
