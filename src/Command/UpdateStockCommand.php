<?php

namespace  App\Command;

use Symfony\Component\Console\Command\Command;
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
  
  public function getCsvRowsAsArray($processDate){
    $inputFile = $this->projectDir . '/public/docs/'. $processDate .'.csv';
    $decoder = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
    return $decoder->decode(file_get_contents($inputFile), 'csv');
  }
}