<?php

namespace App;

use App\DTO\Foo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class IssueCommand extends Command
{
    private const CMD_NAME = 'issue';

    private Serializer $sfSerializer;
    private \JMS\Serializer\Serializer $jmsSerializer;

    public function __construct(SerializerInterface $sfSerializer, \JMS\Serializer\SerializerInterface $jmsSerializer)
    {
        parent::__construct(self::CMD_NAME);
        $this->sfSerializer = $sfSerializer;
        $this->jmsSerializer = $jmsSerializer;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $data = [
            '<foo dummy="dummy">foo</foo>',
            '<foo dummy="dummy"><![CDATA[foo]]></foo>',
            '<foo dummy="dummy"><![CDATA[foo]]>bar</foo>',
            '<foo>foo</foo>',
        ];

        foreach ($data as $s) {
            $io->title($s);

            $io->section('Symfony Serializer >');

            $decoded = $this->sfSerializer->decode($s, 'xml');
            $io->writeln(sprintf('decoded : %s', print_r($decoded, true)));

            $deserialized = $this->sfSerializer->deserialize($s, Foo::class, 'xml');
            $io->writeln(sprintf('deserialized : %s', print_r($deserialized, true)));

            $io->section('JMS Serializer >');

            $deserialized = $this->jmsSerializer->deserialize($s, Foo::class, 'xml');
            $output->writeln(sprintf('deserialized : %s', print_r($deserialized, true)));
        }

        return self::SUCCESS;
    }

}