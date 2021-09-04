Postman link
	=> https://www.getpostman.com/collections/9114d4dda99ed03135ed

I used horizon for background queue so please change QUEUE_CONNECTION=>redis, you can copy paste .env.example for that

To call command to send emails
	=> php artisan command:SentEmailToSubscriberCommand 10
	=> In this command we can pass post_id for which post we have to send emails
	=> If we don't pass anything that it will check for all posts

Also I created event at time of post creations which will call same command with post id to send emails	

Run bellow seeder to create records in website table
    => php artisan db:seed

change email configuration in .env