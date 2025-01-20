@php
    $harga = '';
    $nama = '';
    $potongan = \App\Models\Potongan::find(request()->parent);
    if ($potongan) {
        $nama = $potongan->nama;
        $harga = $potongan->harga;
    }

@endphp
<form action="{{ route('potongan.store') }}" onsubmit="return false" method="post" id="form-action">
    @csrf
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    <div class="modal-body">
        <x-form-input label="Nama" type="text" name="nama" placeholder="Tulis nama potongan" :value="$nama" />
        <x-form-input-group label="Harga" name="harga" type="number" prepend="Rp."
            placeholder="Tulis harga potongan" :value="$harga" />
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

                $('input').removeClass('is-invalid');
                $('textarea').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
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

                $('input').removeClass('is-invalid');
                $('textarea').removeClass('is-invalid');
                $('select').removeClass('is-invalid');
                if (error.response.status == 422) {
                    let msg = error.response.data.errors;
                    $.each(msg, function(key, value) {
                        console.log(key);
                        console.log(value);

                        $('#error-' + key).html(value[0]);
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
            }).finally(function() {
                DTable.ajax.reload(null, false);

            });
    });
</script>
