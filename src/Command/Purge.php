<?php

namespace MugoWeb\QueueBundle\Command;

use Enqueue\Symfony\ContainerProcessorRegistry;
use Interop\Queue\Context;
use MugoWeb\QueueBundle\Queue\BaseProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Purge extends Command
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
			->setName( 'mugo:queue:purge' )
			->setDescription( 'Purges all messages from the queue' )
			->addArgument( 'processor', InputArgument::REQUIRED, 'Service name of Processor class' )
		;
	}

	protected function execute( InputInterface $input, OutputInterface $output ): int
	{
		$processorServiceName = $input->getArgument( 'processor' );

		try
		{
			/** @var BaseProcessor $processorService */
			$processorService = $this->processorRegistry->get( $processorServiceName );
		}
		catch( \Exception $e )
		{
			$output->writeln( '<error>' . $e->getMessage() . '</error>' );
			return Command::FAILURE;
		}

		foreach( $processorService::getSubscribedQueues() as $queueName )
		{
			$queue = $this->context->createQueue( $queueName );
			$this->context->purgeQueue( $queue );
		}

		return Command::SUCCESS;
	}
}
