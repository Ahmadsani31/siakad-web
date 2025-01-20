@php
    $jabatanArr = \App\Models\Jabatan::all()->pluck('nama', 'id');
    $posisiArr = \App\Models\Posisi::all()->pluck('nama', 'id');

    $jabatan_id = '';
    $posisi_id = '';
    $tanggal_masuk = '';
    $tanggal_selesai = '';
    $status = '';
    $penempatan = \App\Models\HistoriPenempatan::find(request()->parent);
    if ($penempatan) {
        $jabatan_id = $penempatan->jabatan_id;
        $posisi_id = $penempatan->posisi_id;
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
        <x-form-select label="Jabatan" name="jabatan_id" :options="$jabatanArr" :selected="$jabatan_id"
            placeholder="Pilih Jenis jabatan" :required="true" />
        <div class="mb-3">
            <label class="form-label">Posisi <span class="text-danger">*</span></label>
            <select class="form-control" name="posisi_id" id="posisi_id">
                <option value="">Pilih Salah Satu</option>
                {{-- {!! Option('posisi', 'posisi_id', '', 'nama') !!} --}}
            </select>
        </div>
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

    function onChangeSelect(url, id, name) {
        $('#page-pre-loader').show();
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id
            },
            success: function(data) {
                $('#page-pre-loader').hide();
                $('#' + name).empty();
                $.each(data, function(key, value) {
                    $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }

    $(function() {

        $('#jabatan_id').on('change', function() {
            onChangeSelect('{{ route('select.posisi') }}', $(this).val(), 'posisi_id');
            $('#viewTab').html('');
        })

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
