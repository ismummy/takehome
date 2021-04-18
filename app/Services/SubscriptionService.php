<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Topic;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SubscriptionService
{

    /**
     *  Creates a new subscription
     *
     * @param string $url
     * @param string $topic
     *
     * @return array $response
     */
    public function createSubscription(string $url, string $topic)
    {
        try {
            $sub = new Subscription;

            $sub->url = $url;
            $sub->topic = $topic;
            $sub->save();

            return ["data" => $sub, "message" => "subscription created", "success" => true];

        } catch (\Throwable $th) {
            Log::error("unable to create subscription", ["error" => $th->getMessage()]);

            return ["error" => "unable to create subscription", "data" =>  $th->getMessage(), "success" => false];
        }
    }

    /**
     * Find all subscription with the passed topic
     *
     * @param string $topic
     *
     * @return collection
     */
    public function getByTopic($topic)
    {
        $sub = Subscription::select(["url", "topic"])->where(["topic" => $topic])->get();

        return $sub;

    }

    /**
     * Notify the pass subscriber the given payload
     *
     * @param \App\Models\Subscription $sub
     * @param object|array $payload
     *
     *
     */
    public function notify($sub, $payload)
    {
        try {
            $data = [
                "topic" => $sub->topic,
                "data"=> $payload
            ];
            $v = Http::post($sub->url, $data);
            Log::error("notified subscriber", ["error" => $v]);
        } catch (\Throwable $th) {
            Log::error("unable to notify subscriber", ["error" => $th->getMessage()]);
        }
    }
}
