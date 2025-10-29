<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pakistani names for 20 users
        $pakistaniNames = [
            'Ahmed Ali Khan',
            'Fatima Sheikh',
            'Usman Malik',
            'Ayesha Hassan',
            'Bilal Ahmad',
            'Sana Rizvi',
            'Hassan Ali',
            'Zainab Qureshi',
            'Ali Raza',
            'Maham Butt',
            'Mohammad Shah',
            'Amina Khan',
            'Salman Abbas',
            'Hina Javed',
            'Waleed Akram',
            'Rabia Sheikh',
            'Talha Iqbal',
            'Mehwish Ali',
            'Hamza Farooq',
            'Areeba Malik'
        ];

        // Color palette for avatars (20 different colors)
        $colors = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#FFA07A', '#98D8C8',
            '#F7DC6F', '#BB8FCE', '#85C1E2', '#F8B739', '#52B788',
            '#E63946', '#A8DADC', '#457B9D', '#F1C40F', '#E67E22',
            '#9B59B6', '#3498DB', '#1ABC9C', '#E74C3C', '#2ECC71'
        ];

        // Pakistan country ID (assuming PK country exists, else use default)
        $pakistanCountryId = DB::table('countries')
            ->where('name', 'LIKE', '%Pakistan%')
            ->value('id') ?? 1; // Fallback to ID 1 if not found

        // Start from user ID 328
        $startId = 328;

        // Disable foreign key checks temporarily for ID insertion
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($pakistaniNames as $index => $name) {
            $userId = $startId + $index;
            $email = "dummy_user_" . ($index + 1) . "@xpertbid.com";
            $password = "password123"; // Plain password
            $firstLetter = strtoupper(substr($name, 0, 1));
            $color = $colors[$index];

            // Generate SVG avatar with initial and color background
            $profilePic = $this->generateAvatarSVG($firstLetter, $color, $userId);

            // Check if user already exists
            $existingUser = User::find($userId);
            
            if ($existingUser) {
                // Update existing user
                $existingUser->update([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'phone' => '+92' . rand(3000000000, 3499999999),
                    'role' => 'user',
                    'country_id' => $pakistanCountryId,
                    'status' => 'active',
                    'profile_pic' => $profilePic,
                ]);
            } else {
                // Create new user with specific ID
                DB::table('users')->insert([
                    'id' => $userId,
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'phone' => '+92' . rand(3000000000, 3499999999),
                    'role' => 'user',
                    'country_id' => $pakistanCountryId,
                    'status' => 'active',
                    'profile_pic' => $profilePic,
                    'approved' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Create wallet for user (if wallet creation is automatic, this might be redundant)
                DB::table('wallets')->insert([
                    'user_id' => $userId,
                    'balance' => 0.00,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Store plain password in a note file or log (for reference)
            \Log::info("Dummy User Created - ID: {$userId}, Email: {$email}, Password: {$password}");
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ 20 Dummy Pakistani users created successfully! (IDs: 328-347)');
        $this->command->info('📧 All passwords: password123');
    }

    /**
     * Generate and save SVG avatar as file, return path
     */
    private function generateAvatarSVG(string $initial, string $bgColor, int $userId): string
    {
        // Ensure directory exists
        $profileDir = public_path('assets/images/profile');
        if (!file_exists($profileDir)) {
            mkdir($profileDir, 0755, true);
        }

        // Generate SVG content
        $svg = '<?xml version="1.0" encoding="UTF-8"?>
<svg width="200" height="200" xmlns="http://www.w3.org/2000/svg">
    <rect width="200" height="200" fill="' . htmlspecialchars($bgColor) . '"/>
    <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="80" font-weight="bold" 
          fill="white" text-anchor="middle" dominant-baseline="central">' . htmlspecialchars($initial) . '</text>
</svg>';

        // Save SVG file
        $filename = 'avatar_' . $userId . '.svg';
        $filepath = $profileDir . '/' . $filename;
        file_put_contents($filepath, $svg);

        // Return path in database format (without leading slash, matchingên real users)
        return 'assets/images/profile/' . $filename;
    }
}

