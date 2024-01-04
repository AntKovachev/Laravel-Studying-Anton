<?php

namespace App\Services;

use Exception;
use MailchimpMarketing\ApiClient;

class MailchimpNewsletter implements Newsletter
{
    public function __construct(protected ApiClient $client) 
    {

    }

    public function subscribe(string $email, string $list = null)
    {
        $list ??= config('services.mailchimp.lists.subscribers');
        
            return $this->client->lists->addListMember($list, [
                'email_address' => $email,
                'status' => 'subscribed'
            ]);        
    }

    public function isSubscribed(string $email, string $list = null): bool
    {
        $list ??= config('services.mailchimp.lists.subscribers');

        try {
            $member = $this->client->lists->getListMember($list, md5(strtolower($email)));
            return isset($member->status) && $member->status === 'subscribed';
        } catch (\Exception $e) {
            // Handle exceptions (e.g., if the member is not found or there's an API error)
            return false;
        }
    }

    public function unsubscribe(string $email, string $list = null)
    {
        $list ??= config('services.mailchimp.lists.subscribers');
           
        return $this->client->lists->updateListMember($list, md5(strtolower($email)), ['status' => 'unsubscribed']);
        
    }
}
