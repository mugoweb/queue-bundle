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
