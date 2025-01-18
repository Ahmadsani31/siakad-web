@php
    $array = [1, 4, 5, 10, 4, 2, 1, 3, 1, 6];

    $angka = 4;

    $posisi = [];
    $n = 0;
    foreach ($array as $key => $value) {
        if ($value == $angka) {
            $posisi[] = $key;
            $n++;
        }
    }
    echo '<pre>';
    print_r($posisi);
    echo '</pre>';
    print_r($n);
@endphp
