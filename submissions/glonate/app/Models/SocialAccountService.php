<?php

namespace App\Models;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetFBUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email'         => $providerUser->getEmail(),
                    'name'          => $providerUser->getName(),
                    'user_type'     => 'user',
                    'active_status' => 1,
                ]);
            }
            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }


    public function createOrGetGoogleUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider('google')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'google'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email'         => $providerUser->getEmail(),
                    'name'          => $providerUser->getName(),
                    'user_type'     => 'user',
                    'active_status' => 1,
                ]);
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }


}