<?php

namespace RedisClient\Command\Traits;

use RedisClient\Command\Command;
use RedisClient\Command\Parameter\EnumParameter;
use RedisClient\Command\Parameter\IntegerParameter;
use RedisClient\Command\Parameter\StringParameter;
use RedisClient\Command\Parameter\StringsParameter;

/**
 * PubSub
 * @link http://redis.io/commands#pubsub
 */
trait PubSubCommandsTrait {

    /**
     * PSUBSCRIBE pattern [pattern ...]
     * Available since 2.0.0.
     * Time complexity: O(N) where N is the number of patterns the client is already subscribed to.
     */
    public function psubscribe($pattern) {
        return $this->returnCommand(
            new Command('PSUBSCRIBE', new StringsParameter($pattern))
        );
    }

    /**
     * PUBLISH channel message
     * Available since 2.0.0.
     * Time complexity: O(N+M) where N is the number of clients subscribed to the receiving channel
     * and M is the total number of subscribed patterns (by any client).
     *
     * @param string $channel
     * @param string $message
     * @return int The number of clients that received the message.e
     */
    public function publish($channel, $message) {
        return $this->returnCommand(
            new Command('PUBLISH', [
                new StringParameter($channel),
                new StringParameter($message)
            ])
        );
    }

    /**
     * PUBSUB subcommand [argument [argument ...]]
     * Available since 2.8.0.
     * Time complexity: O(N) for the CHANNELS subcommand, where N is the number of active channels,
     * and assuming constant time pattern matching (relatively short channels and patterns).
     * O(N) for the NUMSUB subcommand, where N is the number of requested channels.
     * O(1) for the NUMPAT subcommand.
     *
     * @param string $subcommand
     * @param string|string[] argument
     * @return array|int
     */
    public function pubsub($subcommand, $argument = null) {
        $params = [
            new EnumParameter($subcommand, ['CHANNELS', 'NUMSUB', 'NUMPAT'])
        ];
        if (isset($argument)) {
            $params[] = new StringsParameter($argument);
        }
        return $this->returnCommand(
            new Command('PUBSUB', $params)
        );
    }

    /**
     * PUNSUBSCRIBE [pattern [pattern ...]]
     * Available since 2.0.0.
     * Time complexity: O(N+M) where N is the number of patterns the client is already subscribed
     * and M is the number of total patterns subscribed in the system (by any client).
     *
     * @param string|string[]|null $pattern
     * @return
     */
    public function punsubscribe($pattern = null) {
        return $this->returnCommand(
            new Command('PUNSUBSCRIBE', isset($pattern) ? new StringsParameter($pattern) : null)
        );
    }

    /**
     * SUBSCRIBE channel [channel ...]
     * Available since 2.0.0.
     * Time complexity: O(N) where N is the number of channels to subscribe to.
     *
     * @param string|string[] $channel
     * @return 
     */
    public function subscribe($channel) {
        return $this->returnCommand(
            new Command('SUBSCRIBE', new StringsParameter($channel))
        );
    }

    /**
     * UNSUBSCRIBE [channel [channel ...]]
     * Available since 2.0.0.
     * Time complexity: O(N) where N is the number of clients already subscribed to a channel.
     *
     * @param string|string[]|null $channel
     * @return
     */
    public function unsubscribe($channel) {
        return $this->returnCommand(
            new Command('SUBSCRIBE', isset($channel) ? new StringsParameter($channel) : null)
        );
    }

}