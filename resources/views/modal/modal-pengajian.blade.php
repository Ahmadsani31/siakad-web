@php
    $jabatanArr = \App\Models\Karyawan::all()->pluck('nama', 'id');
    $posisiArr = \App\Models\Posisi::all()->pluck('nama', 'id');

    $jabatan = '';
    $posisi = '';
    $tanggal_masuk = '';
    $tanggal_selesai = '';
    $status = '';
    $penempatan = \App\Models\HistoriPenempatan::find(request()->parent);
    if ($penempatan) {
        $jabatan = $penempatan->jabatan;
        $posisi = $penempatan->posisi;
        $tanggal_masuk = $penempatan->tanggal_masuk;
        $tanggal_selesai = $penempatan->tanggal_selesai;
        $status = $karyawan->status;
    }

@endphp
<form action="{{ route('karyawan-penempatan.store') }}" onsubmit="return false" method="post" id="form-action">
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    <input type="hidden" name="karyawan_id" value="{{ request()->karyawanid }}">
    @csrf
    <div class="modal-body">
        <x-form-select label="Jabatan" name="jabatan_id" :options="$jabatanArr" :selected="$jabatan"
            placeholder="Pilih Jenis jabatan" :required="true" />
        <x-form-select label="Posisi" name="posisi_id" :options="$posisiArr" :selected="$posisi"
            placeholder="Pilih Jenis posisi" :required="true" />
        <div class="row">
            <div class="col-md-6">
                <x-form-input label="Tanggal Mulai" type="date" name="tanggal_masuk" :value="$tanggal_masuk" />
            </div>
            <div class="col-md-6">
                <x-form-input label="Tanggal Selesai" type="date" name="tanggal_selesai" :value="$tanggal_selesai" />
            </div>
        </div>
        <x-form-select label="Status" name="status" :options="['Aktif' => 'Aktif', 'Inactive' => 'Inactive']" :selected="$status"
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
