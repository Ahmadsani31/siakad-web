@php
    $nama = '';
    $jenis_bahan = '';
    $jumlah = '';
    $satuan_bahan = '';
    $harga = '';
    $kadaluarsa = '';
    $bahanBaku = \App\Models\BahanBaku::find(request()->parent);
    if ($bahanBaku) {
        $nama = $bahanBaku->nama;
        $jenis_bahan = $bahanBaku->jenis_bahan;
        $jumlah = $bahanBaku->jumlah;
        $satuan_bahan = $bahanBaku->satuan_bahan;
        $harga = $bahanBaku->harga;
        $kadaluarsa = $bahanBaku->kadaluarsa;
    }

@endphp
<form action="{{ route('bahan-baku.store') }}" onsubmit="return false" method="post" id="form-action">
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <x-input-label for="nama" :value="__('Nama')" />
            <x-input id="nama" type="text" name="nama" :value="$nama" autofocus
                placeholder="Tulis nama bahan" />
        </div>
        <div class="mb-3">
            <x-input-label for="jenis_bahan" :value="__('Jenis')" />
            <select class="form-control select-2" name="jenis_bahan" id="jenis_bahan">
                {!! Option('jenis_bahan', 'id', $jenis_bahan, 'nama') !!}
            </select>
        </div>
        <div class="mb-3">
            <x-input-label for="jumlah" :value="__('Jumlah')" />
            <x-input id="jumlah" type="number" name="jumlah" :value="$jumlah" placeholder="Tulis jumlah bahan" />
        </div>
        <div class="mb-3">
            <x-input-label for="satuan_bahan" :value="__('Satuan')" />
            <select class="form-control select-2" name="satuan_bahan" id="satuan_bahan">
                {!! Option('satuan_bahan', 'id', $satuan_bahan, 'nama') !!}
            </select>
        </div>
        <div class="mb-3">
            <x-input-label for="harga" :value="__('Harga Satuan')" />
            <x-input id="harga" type="number" name="harga" :value="$harga" placeholder="Tulis harga bahan" />
        </div>
        <div class="mb-3">
            <x-input-label for="kadaluarsa" :value="__('Tanggal Kadaluarsa')" />
            <x-input id="kadaluarsa" type="date" name="kadaluarsa" :value="$kadaluarsa" />
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
<script>
    $('.select-2').select2({
        dropdownParent: $("#myModals")
    });

    $("form#form-action").on("submit", function(event) {
        event.preventDefault();
        $('#page-pre-loader').show();

        const form = this;
        let settings = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        };
        axios.post($(form).attr('action'), form, settings)
            .then(response => {
                $('#page-pre-loader').hide();
                DTable.ajax.reload(null, false);
                if (response.data.param == true) {
                    $('#myModals').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: response.data.message,
                    });

                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: response.data.message,
                    });
                }
                console.log(response)
            }).catch(error => {
                $('#page-pre-loader').hide();
                DTable.ajax.reload(null, false);

                if (error.response.status == 422) {
                    let msg = error.response.data.errors;
                    $.each(msg, function(key, value) {
                        console.log(key);
                        console.log(value);

                        $('#' + key).addClass('is-invalid');
                    });

                    Swal.fire({
                        title: "Kesalahan",
                        text: error.response.data.message,
                        icon: "warning",

                    });
                } else {
                    Swal.fire({
                        title: "Kesalahan",
                        text: "error sistem",
                        icon: "error",
                        showConfirmButton: false,
                    });
                }

                console.log(error.response.data.message)
            })
    });
</script>
