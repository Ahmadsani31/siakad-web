@php
    $nik = '';
    $nama = '';
    $email = '';
    $phone = '';
    $tanggal_lahir = '';
    $jenis_kelamin = '';
    $alamat = '';
    $status = '';
    $karyawan = \App\Models\Karyawan::find(request()->parent);
    if ($karyawan) {
        $nik = $karyawan->nik;
        $nama = $karyawan->nama;
        $email = $karyawan->email;
        $phone = $karyawan->phone;
        $tanggal_lahir = $karyawan->tanggal_lahir;
        $jenis_kelamin = $karyawan->jenis_kelamin;
        $alamat = $karyawan->alamat;
        $status = $karyawan->status;
    }

@endphp
<form action="{{ route('karyawan.store') }}" onsubmit="return false" method="post" id="form-action">
    @csrf
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <x-form-input label="NIK" type="number" name="nik" placeholder="Tulis NIK" :value="$nik" />
            </div>
            <div class="col-md-6">
                <x-form-input label="Nama" type="test" name="nama" placeholder="Tulis Nama" :value="$nama" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-input label="Email" type="email" name="email" placeholder="Tulis email"
                    :value="$email" />
            </div>
            <div class="col-md-6">
                <x-form-input-group label="Number Telphone" name="phone" type="number" prepend="+62"
                    placeholder="Tulis number telphone" :required="true" :value="$phone" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <x-form-input label="Tanggal Lahir" type="date" name="tanggal_lahir" :value="$tanggal_lahir" />
            </div>
            <div class="col-md-6">
                <x-form-select label="Jenis Kelamin" name="jenis_kelamin" :options="['LK' => 'Laki-laki', 'PR' => 'Perempuan']" :selected="$jenis_kelamin"
                    placeholder="Pilih Jenis Kelamin" :required="true" />
            </div>
        </div>
        <x-form-textarea label="Alamat" name="alamat" placeholder="Tulis alamat" :value="$alamat" rows="5" />
        <x-form-select label="Status Karyawan" name="status" :options="['Aktif' => 'Aktif', 'Inactive' => 'Inactive']" :selected="$status"
            placeholder="Pilih Jenis Kelamin" :required="true" />
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
