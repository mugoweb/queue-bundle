<?php

namespace MugoWeb\QueueBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MugoWebQueueBundle extends Bundle
{
	public function getPath(): string
	{
		return \dirname(__DIR__);
	}
}
