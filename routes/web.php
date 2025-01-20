<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/register-retry', function () {
    // Chrome F12 Headers - my_first_application_session=eyJpdiI6ImNnRH...
    Cookie::queue(Cookie::forget(strtolower(str_replace(' ', '_', config('app.name'))) . '_session'));
    return redirect('/register');
});

Route::get('/', function () {
    return view('pages.auth.login');
})->middleware('guest');

// Route::get('/', function () {
//     // return view('welcome');

//     // print_r(str_split(2024));
//     // $n = 2024;
//     // $text = str_split($n);
//     // $a = $text[0] . $text[1];
//     // $b = $text[2] . $text[3];
//     // $hasil =  $a + $b;
//     // print_r($hasil);
//     // $text = explode("", strval(2024));
//     // print_r($text);
//     // $hasil = $text[0] . $text[1] +  $text[2] . $text[3];
//     // return $hasil;
//     // $k = [];
//     // $n = 2;
//     // for ($i = 1; $i <= $n; $i++) {
//     //     $k[$i] = 0;
//     // }
//     // return
//     // implode("", $k);
//     // print_r(implode("", $k));
//     $nilai = [];
//     $n = 1;
//     for ($i = 1; $i <= 3; $i++) {
//         for ($k = 1; $k <= 5; $k++) {
//             $nilai[$i][$k] = $n++;
//         }
//     }

//     $yujiItadori = [70, 80, 90];
//     $rohKutukan = [90, 70, 90];
//     $a = 0;
//     $b = 0;
//     for ($i = 0; $i < count($yujiItadori); $i++) {
//         if ($yujiItadori[$i] > $rohKutukan[$i]) {
//             $a += 1; // Tambah 1 jika nilai yuji lebih besar
//         } elseif ($yujiItadori[$i] < $rohKutukan[$i]) {
//             $b += 1; // Tambah 1 jika nilai rohKutukan lebih besar
//         } else {
//             // Jika nilainya sama, tambah 1 di kedua array
//             $a += 1;
//             $b += 1;
//         }
//     }
//     if ($a == $b) {
//         return 'Keduanya Imbang';
//     } elseif ($a >= $b) {
//         return 'Yuji Itadori';
//     } else {
//         return 'Roh Kutukan';
//     }
//     echo '<pre>';
//     print_r($a);
//     print_r($b);
//     echo '</pre>';
// });
