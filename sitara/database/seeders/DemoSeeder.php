<?php

namespace Database\Seeders;

use App\Models\Santri;
use App\Models\Attendance;
use App\Models\Achievement;
use App\Models\Finance;
use App\Models\Material;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌟 Seeding Demo Data untuk SITARA...');

        // Create Admin User
        $this->seedAdmin();

        // Seed Santri
        $santris = $this->seedSantri();

        // Seed Attendances
        $this->seedAttendances($santris);

        // Seed Achievements
        $this->seedAchievements($santris);

        // Seed Finance
        $this->seedFinance();

        // Seed Materials
        $this->seedMaterials();

        // Seed Gallery
        $this->seedGallery();

        // Seed Quizzes
        $this->seedQuizzes();

        $this->command->info('✅ Demo seeding selesai!');
    }

    private function seedAdmin(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@sitara.test'],
            [
                'name' => 'Admin TPA',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $this->command->info('👤 Admin user created: admin@sitara.test / password');
    }

    private function seedSantri(): array
    {
        $santriData = [
            ['name' => 'Ahmad Faiz', 'parent_name' => 'Bapak Faiz', 'parent_phone' => '081234567890'],
            ['name' => 'Aisyah Putri', 'parent_name' => 'Ibu Siti', 'parent_phone' => '081234567891'],
            ['name' => 'Muhammad Rizki', 'parent_name' => 'Bapak Rizki', 'parent_phone' => '081234567892'],
            ['name' => 'Fatimah Zahra', 'parent_name' => 'Ibu Zahra', 'parent_phone' => '081234567893'],
            ['name' => 'Umar Hadi', 'parent_name' => 'Bapak Hadi', 'parent_phone' => '081234567894'],
            ['name' => 'Khadijah Amira', 'parent_name' => 'Ibu Amira', 'parent_phone' => '081234567895'],
            ['name' => 'Ali Rahman', 'parent_name' => 'Bapak Rahman', 'parent_phone' => '081234567896'],
            ['name' => 'Zainab Salsabila', 'parent_name' => 'Ibu Salsa', 'parent_phone' => '081234567897'],
            ['name' => 'Hamzah Pratama', 'parent_name' => 'Bapak Pratama', 'parent_phone' => '081234567898'],
            ['name' => 'Maryam Nur', 'parent_name' => 'Ibu Nur', 'parent_phone' => '081234567899'],
            ['name' => 'Ibrahim Malik', 'parent_name' => 'Bapak Malik', 'parent_phone' => '081234567800'],
            ['name' => 'Hafidz Kurnia', 'parent_name' => 'Bapak Kurnia', 'parent_phone' => '081234567801'],
            ['name' => 'Naila Safitri', 'parent_name' => 'Ibu Safitri', 'parent_phone' => '081234567802'],
            ['name' => 'Yusuf Hakim', 'parent_name' => 'Bapak Hakim', 'parent_phone' => '081234567803'],
            ['name' => 'Bilqis Azzahra', 'parent_name' => 'Ibu Azzahra', 'parent_phone' => '081234567804'],
        ];

        $santris = [];
        foreach ($santriData as $data) {
            $santris[] = Santri::firstOrCreate(
                ['name' => $data['name']],
                [
                    'parent_name' => $data['parent_name'],
                    'parent_phone' => $data['parent_phone'],
                    'address' => 'Jl. Contoh No. ' . rand(1, 100),
                    'birth_date' => Carbon::now()->subYears(rand(7, 12))->subDays(rand(1, 365)),
                    'total_points' => 0,
                ]
            );
        }

        $this->command->info('👦 ' . count($santris) . ' santri created');
        return $santris;
    }

    private function seedAttendances(array $santris): void
    {
        $count = 0;
        $startDate = Carbon::now()->subDays(14);

        foreach ($santris as $santri) {
            for ($i = 0; $i < 14; $i++) {
                $date = $startDate->copy()->addDays($i);

                // Random attendance (80% hadir, 10% izin, 5% sakit, 5% alpha)
                $rand = rand(1, 100);
                if ($rand <= 80) {
                    $status = 'hadir';
                    $checkInTime = $date->copy()->setTime(16, rand(0, 30), rand(0, 59))->format('H:i:s');
                    $points = 10;
                } elseif ($rand <= 90) {
                    $status = 'izin';
                    $checkInTime = null;
                    $points = 0;
                } elseif ($rand <= 95) {
                    $status = 'sakit';
                    $checkInTime = null;
                    $points = 0;
                } else {
                    $status = 'alpha';
                    $checkInTime = null;
                    $points = 0;
                }

                $exists = Attendance::where('santri_id', $santri->id)
                    ->whereDate('date', $date)
                    ->exists();

                if (!$exists) {
                    Attendance::create([
                        'santri_id' => $santri->id,
                        'date' => $date->format('Y-m-d'),
                        'status' => $status,
                        'check_in_time' => $checkInTime,
                        'points_gained' => $points,
                    ]);
                    $count++;
                }
            }
        }

        $this->command->info('📅 ' . $count . ' attendance records created');
    }

    private function seedAchievements(array $santris): void
    {
        $achievementTypes = [
            ['type' => 'hafalan', 'description' => 'Hafal Surat Al-Fatihah', 'points' => 20],
            ['type' => 'hafalan', 'description' => 'Hafal Surat An-Nas', 'points' => 15],
            ['type' => 'hafalan', 'description' => 'Hafal Surat Al-Falaq', 'points' => 15],
            ['type' => 'hafalan', 'description' => 'Hafal Surat Al-Ikhlas', 'points' => 15],
            ['type' => 'adab', 'description' => 'Adab baik selama di TPA', 'points' => 10],
            ['type' => 'adab', 'description' => 'Membantu teman', 'points' => 10],
            ['type' => 'partisipasi', 'description' => 'Aktif dalam diskusi', 'points' => 5],
            ['type' => 'partisipasi', 'description' => 'Memimpin doa', 'points' => 10],
        ];

        $count = 0;
        foreach ($santris as $santri) {
            // Each santri gets 1-4 random achievements
            $numAchievements = rand(1, 4);
            $selectedAchievements = array_rand($achievementTypes, $numAchievements);

            if (!is_array($selectedAchievements)) {
                $selectedAchievements = [$selectedAchievements];
            }

            foreach ($selectedAchievements as $index) {
                $achievement = $achievementTypes[$index];
                Achievement::create([
                    'santri_id' => $santri->id,
                    'type' => $achievement['type'],
                    'description' => $achievement['description'],
                    'points' => $achievement['points'],
                    'created_by' => 1,
                ]);
                $count++;
            }
        }

        $this->command->info('🏆 ' . $count . ' achievements created');
    }

    private function seedFinance(): void
    {
        $financeData = [
            // Income
            ['type' => 'income', 'category' => 'donasi', 'amount' => 500000, 'description' => 'Donasi dari Bpk. xxx', 'days_ago' => 1],
            ['type' => 'income', 'category' => 'donasi', 'amount' => 250000, 'description' => 'Donasi dari Ibu yyy', 'days_ago' => 3],
            ['type' => 'income', 'category' => 'donasi', 'amount' => 1000000, 'description' => 'Donasi dari Masjid', 'days_ago' => 5],
            ['type' => 'income', 'category' => 'lainnya', 'amount' => 150000, 'description' => 'Sumbangan snack', 'days_ago' => 7],

            // Expense
            ['type' => 'expense', 'category' => 'takjil', 'amount' => 200000, 'description' => 'Beli takjil hari ke-1', 'days_ago' => 1],
            ['type' => 'expense', 'category' => 'takjil', 'amount' => 180000, 'description' => 'Beli takjil hari ke-2', 'days_ago' => 2],
            ['type' => 'expense', 'category' => 'hadiah', 'amount' => 70000, 'description' => 'Hadiah Top 1', 'days_ago' => 2],
            ['type' => 'expense', 'category' => 'operasional', 'amount' => 50000, 'description' => 'Beli ATK', 'days_ago' => 4],
            ['type' => 'expense', 'category' => 'operasional', 'amount' => 30000, 'description' => 'Listrik & Air', 'days_ago' => 6],
        ];

        $count = 0;
        foreach ($financeData as $data) {
            Finance::create([
                'type' => $data['type'],
                'category' => $data['category'],
                'amount' => $data['amount'],
                'description' => $data['description'],
                'date' => Carbon::now()->subDays($data['days_ago']),
                'created_by' => 1,
            ]);
            $count++;
        }

        $this->command->info('💰 ' . $count . ' finance records created');
    }

    private function seedMaterials(): void
    {
        $materials = [
            [
                'title' => 'Pengenalan Huruf Hijaiyah',
                'content' => 'Hari ini kita belajar mengenal huruf hijaiyah dari Alif sampai Ya. Setiap huruf memiliki bentuk dan bunyi yang berbeda.',
                'video_url' => 'https://www.youtube.com/watch?v=example1',
                'days_ago' => 0,
            ],
            [
                'title' => 'Adab Membaca Al-Quran',
                'content' => "Sebelum membaca Al-Quran, kita harus:\n1. Berwudhu\n2. Menghadap kiblat\n3. Membaca ta'awudz dan basmalah\n4. Membaca dengan tartil",
                'video_url' => null,
                'days_ago' => 1,
            ],
            [
                'title' => 'Hafalan Surat Al-Fatihah',
                'content' => 'Mari menghafal surat Al-Fatihah bersama-sama. Surat Al-Fatihah terdiri dari 7 ayat dan merupakan surat pembuka Al-Quran.',
                'video_url' => 'https://www.youtube.com/watch?v=example2',
                'days_ago' => 2,
            ],
            [
                'title' => 'Kisah Nabi Muhammad SAW',
                'content' => 'Nabi Muhammad SAW lahir di kota Mekah pada tanggal 12 Rabiul Awal tahun Gajah. Beliau adalah nabi dan rasul terakhir yang diutus Allah SWT.',
                'video_url' => null,
                'days_ago' => 3,
            ],
        ];

        $count = 0;
        foreach ($materials as $data) {
            Material::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'video_url' => $data['video_url'],
                'date' => Carbon::now()->subDays($data['days_ago']),
                'created_by' => 1,
            ]);
            $count++;
        }

        $this->command->info('📚 ' . $count . ' materials created');
    }

    private function seedGallery(): void
    {
        // Note: This creates placeholder entries. Real images should be uploaded manually.
        $galleryData = [
            ['caption' => 'Pembukaan TPA Ramadan 1447H', 'category' => 'kegiatan', 'days_ago' => 14],
            ['caption' => 'Belajar Iqro bersama', 'category' => 'kegiatan', 'days_ago' => 12],
            ['caption' => 'Lomba hafalan surat pendek', 'category' => 'lomba', 'days_ago' => 10],
            ['caption' => 'Berbagi takjil ke warga', 'category' => 'takjil', 'days_ago' => 8],
            ['caption' => 'Foto bersama ustadz', 'category' => 'kegiatan', 'days_ago' => 5],
            ['caption' => 'Penyerahan hadiah', 'category' => 'lomba', 'days_ago' => 3],
        ];

        $this->command->info('📷 Gallery entries skipped (upload images manually via admin panel)');
    }

    private function seedQuizzes(): void
    {
        $quiz1 = Quiz::firstOrCreate(
            ['title' => 'Kuis Surat-Surat Pendek'],
            [
                'description' => 'Uji pengetahuan tentang surat-surat pendek dalam Al-Quran',
                'date' => Carbon::today(),
                'time_per_question' => 30,
                'created_by' => 1,
            ]
        );

        if ($quiz1->questions()->count() === 0) {
            $questions1 = [
                [
                    'question' => 'Surat Al-Fatihah terdiri dari berapa ayat?',
                    'option_a' => '5 ayat',
                    'option_b' => '6 ayat',
                    'option_c' => '7 ayat',
                    'option_d' => '8 ayat',
                    'correct_answer' => 'c',
                ],
                [
                    'question' => 'Surat apakah yang disebut "Ummul Quran"?',
                    'option_a' => 'Al-Baqarah',
                    'option_b' => 'Al-Fatihah',
                    'option_c' => 'Al-Ikhlas',
                    'option_d' => 'Yasin',
                    'correct_answer' => 'b',
                ],
                [
                    'question' => 'Surat Al-Ikhlas membahas tentang?',
                    'option_a' => 'Kisah Nabi',
                    'option_b' => 'Hukum puasa',
                    'option_c' => 'Keesaan Allah',
                    'option_d' => 'Hari kiamat',
                    'correct_answer' => 'c',
                ],
                [
                    'question' => 'Surat terakhir dalam Al-Quran adalah?',
                    'option_a' => 'Al-Falaq',
                    'option_b' => 'Al-Ikhlas',
                    'option_c' => 'Al-Lahab',
                    'option_d' => 'An-Nas',
                    'correct_answer' => 'd',
                ],
                [
                    'question' => '"Qul a\'udzu birabbil falaq" adalah ayat pertama surat?',
                    'option_a' => 'An-Nas',
                    'option_b' => 'Al-Falaq',
                    'option_c' => 'Al-Ikhlas',
                    'option_d' => 'Al-Kafirun',
                    'correct_answer' => 'b',
                ],
            ];

            foreach ($questions1 as $i => $q) {
                $q['quiz_id'] = $quiz1->id;
                $q['order'] = $i;
                QuizQuestion::create($q);
            }
        }

        $quiz2 = Quiz::firstOrCreate(
            ['title' => 'Kuis Adab & Akhlak'],
            [
                'description' => 'Pengetahuan tentang adab sehari-hari dalam Islam',
                'date' => Carbon::today()->subDay(),
                'time_per_question' => 20,
                'created_by' => 1,
            ]
        );

        if ($quiz2->questions()->count() === 0) {
            $questions2 = [
                [
                    'question' => 'Doa apa yang dibaca sebelum makan?',
                    'option_a' => 'Bismillah',
                    'option_b' => 'Alhamdulillah',
                    'option_c' => 'Subhanallah',
                    'option_d' => 'Astaghfirullah',
                    'correct_answer' => 'a',
                ],
                [
                    'question' => 'Doa apa yang dibaca setelah makan?',
                    'option_a' => 'Bismillah',
                    'option_b' => 'Alhamdulillah',
                    'option_c' => 'La ilaha illallah',
                    'option_d' => 'Allahu Akbar',
                    'correct_answer' => 'b',
                ],
                [
                    'question' => 'Ketika bersin, kita mengucapkan?',
                    'option_a' => 'Subhanallah',
                    'option_b' => 'Astaghfirullah',
                    'option_c' => 'Alhamdulillah',
                    'option_d' => 'Bismillah',
                    'correct_answer' => 'c',
                ],
            ];

            foreach ($questions2 as $i => $q) {
                $q['quiz_id'] = $quiz2->id;
                $q['order'] = $i;
                QuizQuestion::create($q);
            }
        }

        $this->command->info('❓ 2 quizzes with ' . ($quiz1->questions()->count() + $quiz2->questions()->count()) . ' questions created');
    }
}
