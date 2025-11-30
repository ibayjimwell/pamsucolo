<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Basic ID Lanyard',
                'type' => 'Lanyard',
                'image_url' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=400&h=400&fit=crop',
                'size' => 'N/A',
                'price' => 5.00,
                'short_description' => 'Standard issue ID lanyard for student identification. Durable and comfortable.',
            ],
            [
                'name' => 'Premium Woven Lanyard',
                'type' => 'Lanyard',
                'image_url' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400&h=400&fit=crop',
                'size' => 'N/A',
                'price' => 9.00,
                'short_description' => 'High-quality woven lanyard with premium materials. Perfect for daily use.',
            ],
            [
                'name' => 'BSIT Department Shirt',
                'type' => 'Department Shirt',
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                'size' => 'M',
                'price' => 15.00,
                'short_description' => 'Official BS Information Technology department shirt. Comfortable cotton blend.',
            ],
            [
                'name' => 'BSED Department Shirt',
                'type' => 'Department Shirt',
                'image_url' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=400&h=400&fit=crop',
                'size' => 'L',
                'price' => 15.00,
                'short_description' => 'Official BS Education department shirt. Show your department pride!',
            ],
            [
                'name' => 'Student Uniform Set',
                'type' => 'Uniform',
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop',
                'size' => 'M',
                'price' => 25.00,
                'short_description' => 'Complete student uniform set. Professional and comfortable for campus wear.',
            ],
            [
                'name' => 'University Polo Shirt',
                'type' => 'Uniform',
                'image_url' => 'https://images.unsplash.com/photo-1594938291221-94f18e0e0e6a?w=400&h=400&fit=crop',
                'size' => 'L',
                'price' => 20.00,
                'short_description' => 'Official university polo shirt. Perfect for formal campus events.',
            ],
            [
                'name' => 'Campus Tote Bag',
                'type' => 'Accessories',
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop',
                'size' => 'N/A',
                'price' => 12.00,
                'short_description' => 'Stylish tote bag with university logo. Spacious and durable for carrying books and essentials.',
            ],
            [
                'name' => 'Student ID Card Holder',
                'type' => 'Accessories',
                'image_url' => 'https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400&h=400&fit=crop',
                'size' => 'N/A',
                'price' => 3.00,
                'short_description' => 'Protective card holder for your student ID. Waterproof and durable.',
            ],
            [
                'name' => 'BS Accountancy Department Shirt',
                'type' => 'Department Shirt',
                'image_url' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=400&fit=crop',
                'size' => 'S',
                'price' => 15.00,
                'short_description' => 'Official BS Accountancy department shirt. Represent your department with style.',
            ],
            [
                'name' => 'Campus Cap',
                'type' => 'Accessories',
                'image_url' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=400&h=400&fit=crop',
                'size' => 'One Size',
                'price' => 8.00,
                'short_description' => 'Stylish campus cap with university branding. Adjustable fit for all head sizes.',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

