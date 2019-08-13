<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskAdded extends Notification
{
    use Queueable;

    protected $project;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project=$project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
             'message'=>'new task added in '.$this->project->title,
            'notifier' => auth()->user(),
            'link'=>$this->project->path()
        ];
    }
}
