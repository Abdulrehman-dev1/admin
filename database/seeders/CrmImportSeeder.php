<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrmImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = base_path('Xpertbid Customer Outreach File - Sheet1.csv');
        if (!file_exists($csvPath)) {
            $this->command->error("CSV File not found at: {$csvPath}");
            return;
        }

        // 1. Load all users to minimize queries
        $users = \App\Models\User::all();
        $usersByEmail = $users->pluck('id', 'email'); // email => id
        
        $file = fopen($csvPath, 'r');
        $header = fgetcsv($file); // Skip header

        $importedEmails = [];

        // 2. Process CSV
        while (($row = fgetcsv($file)) !== false) {
            // Mapping based on CSV structure seen in view_file
            // 0: Contact Date, 1: Name, 2: User(Email), 3: Contact, 4: Status(Verification), 5: Call Status, 6: Feedback, 7: Whatsapp, 8: Comments
            
            $contactDate = $row[0] ?? null;
            $name = $row[1] ?? null;
            $email = trim($row[2] ?? '');
            $contact = $row[3] ?? null;
            $verificationStatus = $row[4] ?? null;
            $callStatus = $row[5] ?? 'Pending';
            $feedback = $row[6] ?? null;
            $whatsapp = $row[7] ?? null;
            $comments = $row[8] ?? null;

            // Normalize Date (DD-MM-YYYY to YYYY-MM-DD) if needed, or store as is? DB field is date.
            // CSV Date is 12-01-2026. PHP strtotime handles typical formats, but d-m-Y is safe.
            try {
                $dateObj = \Carbon\Carbon::createFromFormat('d-m-Y', $contactDate);
                $formattedDate = $dateObj ? $dateObj->format('Y-m-d') : null;
            } catch (\Exception $e) {
                $formattedDate = null;
            }

            if ($email && isset($usersByEmail[$email])) {
                $userId = $usersByEmail[$email];
                
                \App\Models\CustomerOutreach::updateOrCreate(
                    ['user_id' => $userId],
                    [
                        'contact_date' => $formattedDate,
                        'name' => $name, // Update name just in case
                        'email' => $email, // Store email for record
                        'phone' => $contact,
                        'verification_status' => $verificationStatus,
                        'call_status' => $callStatus,
                        'customer_feedback_summary' => $feedback,
                        'whatsapp_outreach' => $whatsapp,
                        'additional_comments' => $comments,
                    ]
                );
                $importedEmails[] = $email;
            }
        }
        fclose($file);

        // 3. Create records for Users NOT in CSV
        foreach ($users as $user) {
            if (!$user->customerOutreach) { // Check relationship
                 // Double check if we already created it (in case logic above didn't catch relation update immediately)
                 if (!\App\Models\CustomerOutreach::where('user_id', $user->id)->exists()) {
                     \App\Models\CustomerOutreach::create([
                         'user_id' => $user->id,
                         'name' => $user->name,
                         'email' => $user->email,
                         'phone' => $user->phone,
                         'call_status' => 'Pending',
                     ]);
                 }
            }
        }
    }
}
