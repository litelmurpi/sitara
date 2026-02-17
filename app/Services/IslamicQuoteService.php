<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IslamicQuoteService
{
    /**
     * Curated collection of hadith & ayat Al-Qur'an with Indonesian translations.
     * Rotates daily based on day of year.
     */
    private static array $quotes = [
        // === HADITH ===
        ['text' => 'Sebaik-baik kalian adalah yang mempelajari Al-Qur\'an dan mengajarkannya.', 'source' => 'HR. Bukhari', 'type' => 'hadith'],
        ['text' => 'Sesungguhnya setiap amalan tergantung pada niatnya.', 'source' => 'HR. Bukhari & Muslim', 'type' => 'hadith'],
        ['text' => 'Barangsiapa menempuh jalan untuk mencari ilmu, maka Allah mudahkan baginya jalan menuju surga.', 'source' => 'HR. Muslim', 'type' => 'hadith'],
        ['text' => 'Didiklah anak-anakmu karena mereka diciptakan untuk zaman yang berbeda dengan zamanmu.', 'source' => 'Ali bin Abi Thalib', 'type' => 'hadith'],
        ['text' => 'Mukmin yang paling sempurna imannya adalah yang paling baik akhlaknya.', 'source' => 'HR. Ahmad & Tirmidzi', 'type' => 'hadith'],
        ['text' => 'Tersenyum di hadapan saudaramu adalah sedekah.', 'source' => 'HR. Tirmidzi', 'type' => 'hadith'],
        ['text' => 'Barangsiapa yang tidak menyayangi, maka tidak akan disayangi.', 'source' => 'HR. Bukhari & Muslim', 'type' => 'hadith'],
        ['text' => 'Jagalah Allah, niscaya Allah akan menjagamu.', 'source' => 'HR. Tirmidzi', 'type' => 'hadith'],
        ['text' => 'Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia lainnya.', 'source' => 'HR. Ahmad & Thabrani', 'type' => 'hadith'],
        ['text' => 'Tuntutlah ilmu dari buaian sampai ke liang lahat.', 'source' => 'HR. Ibnu Abdil Barr', 'type' => 'hadith'],
        ['text' => 'Orang yang beriman tidak akan disengat dari lubang yang sama dua kali.', 'source' => 'HR. Bukhari & Muslim', 'type' => 'hadith'],
        ['text' => 'Barangsiapa beriman kepada Allah dan hari akhir, hendaklah ia berkata baik atau diam.', 'source' => 'HR. Bukhari & Muslim', 'type' => 'hadith'],
        ['text' => 'Malu itu sebagian dari iman.', 'source' => 'HR. Bukhari & Muslim', 'type' => 'hadith'],
        ['text' => 'Kebersihan adalah sebagian dari iman.', 'source' => 'HR. Muslim', 'type' => 'hadith'],
        ['text' => 'Tidaklah beriman seseorang di antara kalian hingga ia mencintai saudaranya sebagaimana ia mencintai dirinya sendiri.', 'source' => 'HR. Bukhari & Muslim', 'type' => 'hadith'],
        ['text' => 'Bertakwalah kepada Allah di mana pun kamu berada, iringilah keburukan dengan kebaikan, niscaya kebaikan itu akan menghapusnya.', 'source' => 'HR. Tirmidzi', 'type' => 'hadith'],
        ['text' => 'Orang kuat itu bukan yang pandai bergulat, tetapi orang kuat itu adalah yang mampu mengendalikan dirinya ketika marah.', 'source' => 'HR. Bukhari & Muslim', 'type' => 'hadith'],
        ['text' => 'Berbuat baiklah kepada tetanggamu, niscaya kamu menjadi mukmin.', 'source' => 'HR. Tirmidzi & Ibnu Majah', 'type' => 'hadith'],

        // === AYAT AL-QUR'AN ===
        ['text' => 'Sesungguhnya sesudah kesulitan itu ada kemudahan.', 'source' => 'QS. Al-Insyirah: 6', 'type' => 'quran'],
        ['text' => 'Dan Tuhanmu berfirman: "Berdoalah kepada-Ku, niscaya Aku perkenankan bagimu."', 'source' => 'QS. Al-Mu\'min: 60', 'type' => 'quran'],
        ['text' => 'Allah tidak membebani seseorang melainkan sesuai dengan kesanggupannya.', 'source' => 'QS. Al-Baqarah: 286', 'type' => 'quran'],
        ['text' => 'Maka nikmat Tuhanmu yang manakah yang kamu dustakan?', 'source' => 'QS. Ar-Rahman: 13', 'type' => 'quran'],
        ['text' => 'Sesungguhnya Allah bersama orang-orang yang sabar.', 'source' => 'QS. Al-Baqarah: 153', 'type' => 'quran'],
        ['text' => 'Dan tolong-menolonglah kamu dalam kebajikan dan takwa.', 'source' => 'QS. Al-Maidah: 2', 'type' => 'quran'],
        ['text' => 'Bacalah dengan menyebut nama Tuhanmu yang menciptakan.', 'source' => 'QS. Al-Alaq: 1', 'type' => 'quran'],
        ['text' => 'Sesungguhnya bersama kesulitan pasti ada kemudahan.', 'source' => 'QS. Al-Insyirah: 5', 'type' => 'quran'],
        ['text' => 'Dan janganlah kamu berputus asa dari rahmat Allah.', 'source' => 'QS. Yusuf: 87', 'type' => 'quran'],
        ['text' => 'Sesungguhnya Allah tidak akan mengubah keadaan suatu kaum sebelum mereka mengubah keadaan diri mereka sendiri.', 'source' => 'QS. Ar-Ra\'d: 11', 'type' => 'quran'],
        ['text' => 'Hai orang-orang yang beriman, jadikanlah sabar dan sholat sebagai penolongmu.', 'source' => 'QS. Al-Baqarah: 153', 'type' => 'quran'],
        ['text' => 'Cukuplah Allah sebagai penolong kami dan Dia sebaik-baik pelindung.', 'source' => 'QS. Ali Imran: 173', 'type' => 'quran'],
    ];

    /**
     * Get today's quote (rotates daily).
     */
    public static function getTodayQuote(): array
    {
        return Cache::remember('islamic_quote_' . now()->format('Y-m-d'), now()->endOfDay(), function () {
            $dayOfYear = now()->dayOfYear;
            $index = $dayOfYear % count(self::$quotes);
            return self::$quotes[$index];
        });
    }

    /**
     * Fetch a random hadith from external API (optional, cached for 24h).
     * Falls back to local collection if API fails.
     */
    public static function fetchFromApi(): array
    {
        return Cache::remember('islamic_quote_api_' . now()->format('Y-m-d'), now()->endOfDay(), function () {
            try {
                $books = ['bukhari', 'muslim', 'tirmidzi'];
                $book = $books[array_rand($books)];
                $maxNumbers = ['bukhari' => 6638, 'muslim' => 4930, 'tirmidzi' => 3625];
                $number = rand(1, $maxNumbers[$book]);

                $response = Http::timeout(5)->get("https://api.hadith.gading.dev/books/{$book}?range={$number}-{$number}");

                if ($response->successful()) {
                    $data = $response->json();
                    $hadith = $data['data']['hadiths'][0] ?? null;

                    if ($hadith) {
                        // Extract the actual matn (content) from the full text
                        $text = $hadith['id'];

                        // Trim to reasonable length for display
                        if (mb_strlen($text) > 200) {
                            $text = mb_substr($text, 0, 197) . '...';
                        }

                        return [
                            'text' => $text,
                            'source' => $data['data']['name'] . ' No. ' . $hadith['number'],
                            'type' => 'hadith',
                        ];
                    }
                }
            } catch (\Exception $e) {
                // Silently fall back to local
            }

            return self::getTodayQuote();
        });
    }
}
