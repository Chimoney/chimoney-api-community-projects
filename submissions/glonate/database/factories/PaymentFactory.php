<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'user_id' => rand(1,10),
            'reward_id' => rand(1,8),
            'payment_method' => 'stripe', //'bank_transfer'
            'status' =>  'success', //'initial','pending','success','failed','declined','dispute'
            'currency' => 'USD',
            'token_id' => null,
            'card_last4' => '4242',
            'card_id' => 'card_1Cz9VmIdV7MTb07GmgbzcHZL',
            'card_brand' => 'Visa',
            'card_country' => null,
            'card_exp_month' =>  '12',
            'card_exp_year' => '2019',
            'client_ip' => null,
            'charge_id_or_token' => 'ch_1Cz9VrIdV7MTb07GwfjKGaUL',
            'payer_email' => null,
            'description' => 'Last night in USA – Maybe not the true story [Contributing]',
            'local_transaction_id' => null,
            'payment_created' => null,
            'contributor_name_display' => null,
            'bank_swift_code' => null,
            'account_number' => null,
            'branch_name' => null,
            'branch_address' => null,
            'account_name' => null,
            'iban' => null
        ];

    }
}
