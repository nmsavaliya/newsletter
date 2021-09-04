<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PostEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewsLetter;

class SendEmailSubscriberJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $email_data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_data)
    {
        $this->email_data = $email_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email_data = $this->email_data;
        $subscriber = $email_data['subscriber'];

        $check_already_sent_email = PostEmail::where('post_id',$email_data['post_id'])
                                                ->where('subscriber_id',$subscriber->id)
                                                ->count();
        
        if ($check_already_sent_email == 0) {
            try {    
                Mail::to($subscriber->email)->send(new SendNewsLetter($email_data));
                PostEmail::create(['post_id'=>$email_data['post_id'],'subscriber_id'=>$subscriber->id]);
            } catch (\Exception $e) {
            }
        }
    }
}
