<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserSubscribeRequest;
use App\Models\Subscriber;
use App\Models\WebsiteSubscriber;
use DB;

class SubscribeController extends Controller
{
    /**
     * subsccribe user to website.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userSubscribe(UserSubscribeRequest $request)
    {
        $email = $request->get('email');
        $website_id = $request->get('website_id');

        try {
            DB::beginTransaction();
            $subscriber = Subscriber::firstOrNew(['email'=>$email]);
            $subscriber->email = $email;
            $subscriber->save();

            $check_subscriber = $subscriber->websites()->where('websites.id', $website_id)->exists();

            
            if ($check_subscriber) {
                $message = "You already subscribed to website";
            }else{
                $subscriber->websites()->attach([$website_id]);
                $message = "You successfully subscribed to website";
            }
            DB::commit();
            return response()->json(['success'=>true,'message'=>$message]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success'=>true,'message'=>$e->getMessage()],500);
        }
    }
}
