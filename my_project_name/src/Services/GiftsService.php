<?php
namespace App\Services;

use Psr\Log\LoggerInterface;

class GiftsService
{
    public $gifts = ['flower', 'car', 'piano', 'money'];
    public function __construct(LoggerInterface $logger)
    {
        $logger->info('Gifts were randomizec');
        shuffle($this->gifts);
    }

}