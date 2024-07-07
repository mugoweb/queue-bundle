<?php

namespace MugoWeb\QueueBundle\Command;


use Enqueue\Symfony\ContainerProcessorRegistry;
use Interop\Queue\Context;
use Enqueue\Client\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Produce extends Command
{
	private Context $context;

	private ContainerProcessorRegistry $processorRegistry;

	public function __construct(
		ContainerProcessorRegistry $processorRegistry,
		Context $context,
		string $name = null
	)
	{
		$this->processorRegistry = $processorRegistry;
		$this->context = $context;

		parent::__construct( $name );
	}

	protected function configure()
	{
		$this
			->setName( 'mugo:queue:produce' )
			->setDescription( 'Queue command' )
			->addArgument( 'processor', InputArgument::REQUIRED, 'Service name of Processor class' )
			->addOption( 'limit', 'l', InputOption::VALUE_OPTIONAL, 'Limit number of queue items to process.' )
		;
	}

	protected function execute( InputInterface $input, OutputInterface $output ): int
	{
		$processorServiceName = $input->getArgument( 'processor' );

		try
		{
			$processorService = $this->processorRegistry->get( $processorServiceName );
		}
		catch( \Exception $e )
		{
			$output->writeln( '<error>' . $e->getMessage() . '</error>' );
			return Command::FAILURE;
		}

		$processorService->produce( $this->context, $input->getOption( 'limit' ) );

		return Command::SUCCESS;
	}
}
