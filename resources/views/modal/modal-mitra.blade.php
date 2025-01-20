@php
    $nama_perusahaan = '';
    $email = '';
    $no_telepon = '';
    $alamat = '';
    $status = '';
    $mitra = \App\Models\Mitra::find(request()->parent);
    if ($mitra) {
        $nama_perusahaan = $mitra->nama_perusahaan;
        $email = $mitra->email;
        $no_telepon = $mitra->no_telepon;
        $alamat = $mitra->alamat;
        $status = $mitra->status;
    }

@endphp
<form action="{{ route('mitra.store') }}" onsubmit="return false" method="post" id="form-action">
    @csrf
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    <div class="modal-body">
        <x-form-input label="Nama" type="text" name="nama_perusahaan" placeholder="Tulis nama perusahaan"
            :value="$nama_perusahaan" />
        <x-form-input label="Email" type="email" name="email" placeholder="Tulis email perusahaan"
            :value="$email" />
        <x-form-input label="No Telepon" type="number" name="no_telepon" placeholder="Tulis no telpon perusahaan"
            :value="$no_telepon" />
        <x-form-textarea label="Alamat" name="alamat" placeholder="Tulis alamat" :value="$alamat" rows="5" />
        <x-form-select label="Status" name="status" :options="['Aktif' => 'Aktif', 'Inaktif' => 'Inaktif']" :selected="$status" placeholder="Pilih status"
            :required="true" />
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
