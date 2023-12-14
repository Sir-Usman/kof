<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RealTimeNotification implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;


	public $message;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($message)
	{
// 		dd($message);
		$this->message  = $message;
		
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn()
	{
		return ['customer-message'];
	}
	
	public function broadcastAs() {
         return 'customer-message';
    }
}