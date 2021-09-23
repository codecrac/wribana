<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WaribanaChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id_tontine;
    public $id_menbre;
    public $nom_complet_menbre;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id_tontine,$id_menbre,$nom_complet_menbre,$message)
    {
        $this->id_tontine = $id_tontine;
        $this->id_menbre = $id_menbre;
        $this->nom_complet_menbre = $nom_complet_menbre;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('waribana');
    }

    public function broadcastAs()
    {
        return "message-tontine";
    }
}
