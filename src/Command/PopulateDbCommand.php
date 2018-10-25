<?php

declare(strict_types=1);

namespace App\Command;

use App\JoindIn\Client;
use App\Repository\TalkRepository;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateDbCommand extends Command
{
    /**
     * @var TalkRepository
     */
    private $repository;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param TalkRepository $repository
     * @param Client $client
     */
    public function __construct(TalkRepository $repository, Client $client)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->client = $client;
    }

    protected function configure()
    {
        $this
            ->setName('app:populate')
            ->setDescription('Store talk list in database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->client->getTalks() as $talk) {
            $this->repository->add($talk);
        }
    }

}
