Installation
=
You first need to decide which transporter you would like to use. There are several options: https://php-enqueue.github.io/transport
For example, you want to use the file system to store the queue, you would need to install the enqueue package for that transporter

```composer require enqueue/fs```

Configure the transporter by either setting the environment variable or directly change the configuration file 'config/packages/enqueue.yaml'

Set the ENQUEUE_DSN variable to 

```ENQUEUE_DSN=file:```

It will store the queue in the system temporary directory.

Commands
=
```
# To produce messages:
./bin/console mugo:queue:produce <processor>

# To process messages:
./bin/console enqueue:transport:consume <processor>

# To clear queue:
./bin/console mugo:queue:purge <processor>

```

Creating a new Queue
=

Create queue service class
--

Configure queue service class
--
```
  MugoWeb\QueueBundle\Queue\ExampleProcessor:
    tags:
      - { name: 'enqueue.transport.processor', processor: 'example_processor' }
```
