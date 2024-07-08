<?php
/*
 * To produce messages:
 * ./bin/console mugo:queue:produce example_processo
 *
 * To process messages:
 * ./bin/console enqueue:transport:consume example_processor
 *
 * To purge all messages:
 * ./bin/console mugo:queue:purge example_processor
 */
namespace MugoWeb\QueueBundle\Queue;

use Interop\Queue\Context;
use Interop\Queue\Message;

class ExampleProcessor extends BaseProcessor
{
	public function produce( Context $context, $limit ) : void
	{
		$queue = $context->createQueue( self::getSubscribedQueues()[ 0 ] );

		if( method_exists( $context, 'declareQueue' ) )
		{
			// Making sure the queue exists in AWS
			$context->declareQueue( $queue );
		}

		// message is being sent right now, we use it as RPC
		$context->createProducer()->send(
			$queue,
			$context->createMessage( 'Hello World!' )
		);
	}

	public function process( Message $message, Context $context ) : string
	{
		echo $message->getBody();
		return self::ACK;
	}
}
