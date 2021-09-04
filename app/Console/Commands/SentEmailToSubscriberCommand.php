<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Jobs\SendEmailSubscriberJob;

class SentEmailToSubscriberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SentEmailToSubscriberCommand {post_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to sent emails to all subscriber of webiste when new post created';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $post_id = $this->argument('post_id');
   
        if ($post_id) {
            $post_data = Post::where('id',$post_id)
                                ->with('website.subscribers')
                                ->get();
        }else{
            $post_data = Post::with('website.subscribers')
                                ->get();
        }

        if ($post_data->count() > 0) {
            foreach ($post_data as $key => $single_post) {
                $subscribers = $single_post['website']['subscribers'];

                foreach ($subscribers as $key => $single_subscriber) {
                    dispatch(new SendEmailSubscriberJob(['title'=>$single_post->title,'description'=>$single_post->description,'subscriber'=>$single_subscriber,'post_id'=>$single_post->id]));
                }
            }
        }
    }
}
