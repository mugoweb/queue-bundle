<?php

namespace MugoWeb\QueueBundle\Queue;

use Enqueue\Sqs\SqsMessage;
use Interop\Queue\Context;
use Interop\Queue\Message;
use Interop\Queue\Processor;
use Enqueue\Consumption\QueueSubscriberInterface;

class BaseProcessor implements Processor, QueueSubscriberInterface
{
	public function process( Message $message, Context $context ) : string
	{
		return self::ACK;
	}

	public static function getSubscribedQueues() : array
	{
		return [ 'default' ];
	}

	public function getMessageByString( string $string, array $properties = [], $headers = [] ) : SqsMessage
	{
		return new SqsMessage( $string, $properties, $headers );
	}

	public function produce( Context $context, $limit ) : void
	{}
}
