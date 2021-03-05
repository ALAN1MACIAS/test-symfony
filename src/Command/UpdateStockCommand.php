<?php

namespace  App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

class UpdateStockCommand extends Command
{

  protected static $defaultName = 'app:csv';

  public function __construct($projectDir)
  {
    $this->projectDir = $projectDir;
    parent::__construct();
  }

  protected function configure() 
  {
    $this->setDescription('Update stock records')
      ->addArgument('markup', InputArgument::OPTIONAL, 'Porcentage markup', 20)
      ->addArgument('process_date', InputArgument::OPTIONAL, 'Date of the process', date_create()->format('Y-m-d'));
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    // Convert csv file content into iterable php

    $inputFile = $this->projectDir . '/public/docs/ventas.csv';

    $decoder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
    
    $rows = $decoder->decode(file_get_contents($inputFile), 'csv');

    dd($rows);

    // Loop over records

    // foreach ($suplierProducts as $suplierProduct){

      // Update if matching found in DB

      // Create new records if matching records not found in the DB

    // }
  }
}