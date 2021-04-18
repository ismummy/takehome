<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Events\NewTopicPublished;
use App\Services\SubscriptionService;
use App\Http\Resources\CreateSubscriptionResource;

class SubscriptionController extends Controller
{
    protected $ss;

    public function __construct(SubscriptionService $ss)
    {
        $this->ss = $ss;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribeToTopic(Request $request, $topic)
    {
        $request->validate([
            "url" => ["required", "url"]
        ]);

        $sub = $this->ss->createSubscription($request->url, $topic);



        if($sub["success"])
            return response()->json(new CreateSubscriptionResource($sub["data"]));


        return response()->json($sub, 400);
    }

    public function publishSubscription(Request $request, $topic)
    {
        $subs = $this->ss->getByTopic($topic);

        if($subs->count() > 0) {
            event(new NewTopicPublished($subs, $request->all()));

            return response()->json(["message" =>"Message published"]);
        }
        // if no $subs then notify the user or perform other action(s)

    }
}
