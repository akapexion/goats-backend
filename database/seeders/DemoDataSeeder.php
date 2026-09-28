<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Market;
use App\Models\Category;
use App\Models\FarmerProfile;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Categories
        $categoriesList = [
            'Vegetables',
            'Fresh Fruits',
            'Dairy & Eggs',
            'Fresh Herbs',
            'Grains & Bakery',
            'Honey & Preserves',
        ];

        $categories = [];
        foreach ($categoriesList as $catName) {
            $categories[$catName] = Category::firstOrCreate(
                ['name' => $catName],
                ['is_active' => true]
            );
        }

        // 2. Seed Markets
        $marketsData = [
            [
                'name' => 'Green Valley Farmers Market',
                'address' => 'Plot #42, University Road, Gulshan-e-Iqbal',
                'city' => 'Karachi',
                'latitude' => 24.9180,
                'longitude' => 67.0971,
                'open_days' => 'Saturday, Sunday',
                'open_time' => '08:00:00',
                'close_time' => '14:00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Clifton Beachside Organic Bazaar',
                'address' => 'Near Sea View Park, Marine Promenade, Clifton Block 4',
                'city' => 'Karachi',
                'latitude' => 24.8138,
                'longitude' => 67.0303,
                'open_days' => 'Sunday',
                'open_time' => '07:30:00',
                'close_time' => '13:00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Lahore Model Town Agro Mart',
                'address' => 'Central Park Circular Road, Model Town',
                'city' => 'Lahore',
                'latitude' => 31.4815,
                'longitude' => 74.3225,
                'open_days' => 'Friday, Saturday',
                'open_time' => '08:30:00',
                'close_time' => '15:00:00',
                'is_active' => true,
            ],
            [
                'name' => 'Islamabad F-7 Sunday Farmers Fair',
                'address' => 'F-7 Markaz Community Ground',
                'city' => 'Islamabad',
                'latitude' => 33.7215,
                'longitude' => 73.0560,
                'open_days' => 'Sunday',
                'open_time' => '08:30:00',
                'close_time' => '14:30:00',
                'is_active' => true,
            ],
        ];

        $markets = [];
        foreach ($marketsData as $m) {
            $markets[$m['name']] = Market::firstOrCreate(
                ['name' => $m['name']],
                $m
            );
        }

        // 3. Seed Admin & Customer Users
        User::firstOrCreate(
            ['email' => 'admin@marketlink.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '0300 0000000',
                'status' => 'active',
            ]
        );

        User::firstOrCreate(
            ['email' => 'customer@marketlink.com'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '0311 1112233',
                'status' => 'active',
            ]
        );

        // 4. Seed Farmers & Products matching Reference Images 1, 2 & 4
        $farmersData = [
            [
                'user' => [
                    'name' => 'Bilal Ahmed',
                    'email' => 'bilal@organicgreens.pk',
                    'phone' => '0300 7144321',
                ],
                'profile' => [
                    'stall_name' => 'Bilal Organic Greens',
                    'market_name' => 'Green Valley Farmers Market',
                    'address' => 'Stall #14, Green Valley Market, University Road, Karachi',
                    'description' => 'Family-owned pesticide-free vegetable farm providing leafy greens and crunchy roots freshly harvested each dawn.',
                    'operating_days' => 'Saturday, Sunday',
                    'pickup_start_time' => '08:00:00',
                    'pickup_end_time' => '13:30:00',
                    'cutoff_hours' => 12,
                    'approval_status' => 'approved',
                ],
                'products' => [
                    [
                        'name' => 'Fresh Organic Spinach (Palak)',
                        'category_name' => 'Vegetables',
                        'price' => 120.00,
                        'unit' => 'bunch',
                        'stock_quantity' => 40,
                        'description' => 'Nutrient-rich pesticide-free spinach harvested fresh in the morning.',
                    ],
                    [
                        'name' => 'Crisp Red Radish & Carrots',
                        'category_name' => 'Vegetables',
                        'price' => 180.00,
                        'unit' => '2kg',
                        'stock_quantity' => 30,
                        'description' => 'Sweet red carrots and crunchy radishes sourced directly from farm soil.',
                    ],
                    [
                        'name' => 'Vine Ripe Tomatoes & Red Onions',
                        'category_name' => 'Vegetables',
                        'price' => 220.00,
                        'unit' => 'kg',
                        'stock_quantity' => 35,
                        'description' => 'Juicy organic red tomatoes paired with sharp red onions.',
                    ],
                    [
                        'name' => 'Farm Fresh Cucumbers & Okra',
                        'category_name' => 'Vegetables',
                        'price' => 160.00,
                        'unit' => 'kg',
                        'stock_quantity' => 25,
                        'description' => 'Tender green cucumbers and fresh ladyfingers.',
                    ],
                    [
                        'name' => 'Mint & Fresh Coriander Bundle',
                        'category_name' => 'Fresh Herbs',
                        'price' => 70.00,
                        'unit' => 'bunch',
                        'stock_quantity' => 60,
                        'description' => 'Aromatic mint leaves and fresh coriander for everyday cooking.',
                    ],
                ]
            ],

            [
                'user' => [
                    'name' => 'Tariq Mahmood',
                    'email' => 'tariq@sunvalley.pk',
                    'phone' => '0312 2334445',
                ],
                'profile' => [
                    'stall_name' => 'Sun Valley Orchard & Herbs',
                    'market_name' => 'Clifton Beachside Organic Bazaar',
                    'address' => 'Stall #03, Beachside Plaza, Clifton Block 4, Karachi',
                    'description' => 'Fresh seasonal fruit orchards and aromatic hydroponic herbs, grown using sustainable soil practices.',
                    'operating_days' => 'Sunday',
                    'pickup_start_time' => '08:00:00',
                    'pickup_end_time' => '12:30:00',
                    'cutoff_hours' => 8,
                    'approval_status' => 'approved',
                ],
                'products' => [
                    [
                        'name' => 'Sweet Farm Strawberries Box',
                        'category_name' => 'Fresh Fruits',
                        'price' => 450.00,
                        'unit' => '500g box',
                        'stock_quantity' => 20,
                        'description' => 'Handpicked ripe strawberries straight from orchard beds.',
                    ],
                    [
                        'name' => 'Citrus Farm Oranges (Kinnow)',
                        'category_name' => 'Fresh Fruits',
                        'price' => 320.00,
                        'unit' => 'dozen',
                        'stock_quantity' => 45,
                        'description' => 'Juicy sweet Sargodha kinnows packed with vitamin C.',
                    ],
                    [
                        'name' => 'Hydroponic Sweet Basil & Rosemary',
                        'category_name' => 'Fresh Herbs',
                        'price' => 150.00,
                        'unit' => 'pack',
                        'stock_quantity' => 15,
                        'description' => 'Fragrant hydroponically grown sweet basil and rosemary twigs.',
                    ],
                ]
            ],

            [
                'user' => [
                    'name' => 'Zainab Bibi',
                    'email' => 'zainab@puredairy.pk',
                    'phone' => '0345 6789012',
                ],
                'profile' => [
                    'stall_name' => 'Pure Dairy & Blossom Honey',
                    'market_name' => 'Lahore Model Town Agro Mart',
                    'address' => 'Stall #208, Model Town Agro Mart, Lahore',
                    'description' => 'Farm fresh unprocessed raw cow and buffalo milk, country butter, organic eggs, and raw wildflower honey.',
                    'operating_days' => 'Friday, Saturday',
                    'pickup_start_time' => '08:30:00',
                    'pickup_end_time' => '15:00:00',
                    'cutoff_hours' => 6,
                    'approval_status' => 'approved',
                ],
                'products' => [
                    [
                        'name' => 'Farm Pure Buffalo Milk (Unprocessed)',
                        'category_name' => 'Dairy & Eggs',
                        'price' => 240.00,
                        'unit' => 'liter',
                        'stock_quantity' => 50,
                        'description' => 'Pure rich unprocessed buffalo milk direct from morning milking.',
                    ],
                    [
                        'name' => 'Desi Free-Range Brown Eggs',
                        'category_name' => 'Dairy & Eggs',
                        'price' => 380.00,
                        'unit' => 'dozen',
                        'stock_quantity' => 30,
                        'description' => 'Nutritious brown eggs from free-roaming farm hens.',
                    ],
                    [
                        'name' => 'Wild Sidr Raw Blossom Honey',
                        'category_name' => 'Honey & Preserves',
                        'price' => 1200.00,
                        'unit' => '500g jar',
                        'stock_quantity' => 15,
                        'description' => '100% pure raw unheated Sidr honey with natural healing properties.',
                    ],
                ]
            ],

            [
                'user' => [
                    'name' => 'Rashid Khan',
                    'email' => 'rashid@greenfield.pk',
                    'phone' => '0322 3364566',
                ],
                'profile' => [
                    'stall_name' => 'Rashid Greenfield Harvest',
                    'market_name' => 'Islamabad F-7 Sunday Farmers Fair',
                    'address' => 'Stall #FV-7, F-7 Markaz Ground, Islamabad',
                    'description' => 'Fresh organic highland potatoes, sweet carrots, heirloom tomatoes, and freshly stone-milled whole grains.',
                    'operating_days' => 'Sunday',
                    'pickup_start_time' => '09:00:00',
                    'pickup_end_time' => '14:00:00',
                    'cutoff_hours' => 10,
                    'approval_status' => 'approved',
                ],
                'products' => [
                    [
                        'name' => 'Highland Baby Red Potatoes',
                        'category_name' => 'Vegetables',
                        'price' => 130.00,
                        'unit' => 'kg',
                        'stock_quantity' => 70,
                        'description' => 'Naturally grown baby red potatoes ideal for roasting and curries.',
                    ],
                    [
                        'name' => 'Stone-Ground Whole Wheat Flour (Chakki Atta)',
                        'category_name' => 'Grains & Bakery',
                        'price' => 450.00,
                        'unit' => '5kg bag',
                        'stock_quantity' => 25,
                        'description' => 'Pure traditional stone-ground whole wheat flour loaded with natural bran.',
                    ],
                ]
            ],
        ];

        foreach ($farmersData as $fData) {
            $user = User::firstOrCreate(
                ['email' => $fData['user']['email']],
                [
                    'name' => $fData['user']['name'],
                    'password' => Hash::make('password'),
                    'role' => 'farmer',
                    'phone' => $fData['user']['phone'],
                    'status' => 'active',
                ]
            );

            $market = $markets[$fData['profile']['market_name']] ?? null;

            $profile = FarmerProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'market_id' => $market ? $market->id : null,
                    'stall_name' => $fData['profile']['stall_name'],
                    'address' => $fData['profile']['address'],
                    'description' => $fData['profile']['description'],
                    'operating_days' => $fData['profile']['operating_days'],
                    'pickup_start_time' => $fData['profile']['pickup_start_time'],
                    'pickup_end_time' => $fData['profile']['pickup_end_time'],
                    'cutoff_hours' => $fData['profile']['cutoff_hours'],
                    'approval_status' => $fData['profile']['approval_status'],
                ]
            );

            foreach ($fData['products'] as $pData) {
                $category = $categories[$pData['category_name']] ?? null;
                Product::firstOrCreate(
                    [
                        'farmer_profile_id' => $profile->id,
                        'name' => $pData['name'],
                    ],
                    [
                        'category_id' => $category ? $category->id : null,
                        'market_id' => $market ? $market->id : null,
                        'description' => $pData['description'],
                        'price' => $pData['price'],
                        'unit' => $pData['unit'],
                        'stock_quantity' => $pData['stock_quantity'],
                        'status' => 'available',
                    ]
                );
            }
        }
    }
}
