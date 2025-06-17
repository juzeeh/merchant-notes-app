<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        $merchants = [
            [
                'name' => 'Tech Solutions Inc.',
                'email' => 'contact@techsolutions.com',
                'phone' => '+1-555-0123',
                'address' => '123 Tech Street, Silicon Valley, CA 94000'
            ],
            [
                'name' => 'Green Garden Supplies',
                'email' => 'info@greengarden.com',
                'phone' => '+1-555-0456',
                'address' => '456 Garden Ave, Portland, OR 97200'
            ],
            [
                'name' => 'Urban Fashion Hub',
                'email' => 'hello@urbanfashion.com',
                'phone' => '+1-555-0789',
                'address' => '789 Fashion Blvd, New York, NY 10001'
            ],
            [
                'name' => 'Coastal Seafood Co.',
                'email' => 'orders@coastalseafood.com',
                'phone' => '+1-555-0321',
                'address' => '321 Harbor Road, Seattle, WA 98101'
            ],
            [
                'name' => 'Mountain Peak Adventures',
                'email' => 'adventures@mountainpeak.com',
                'phone' => '+1-555-0654',
                'address' => '654 Summit Trail, Denver, CO 80202'
            ]
        ];

        foreach ($merchants as $merchant) {
            Merchant::create($merchant);
        }
    }
}