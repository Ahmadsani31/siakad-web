@php
    $prodiArr = \App\Models\ProgramStudi::all()->pluck('name', 'id');

    $code = '';
    $name = '';
    $sks = '';
    $program_studi_id = '';
    $sql = \App\Models\MataKuliah::find(request()->parent);
    if ($sql) {
        $code = $sql->code;
        $name = $sql->name;
        $sks = $sql->sks;
        $program_studi_id = $sql->program_studi_id;
    }

@endphp
<form action="{{ route('mata-kuliah.store') }}" onsubmit="return false" method="post" id="form-action">
    @csrf
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    <div class="modal-body">
        <x-form-select label="Program Studi" class="select-2" name="program_studi_id" :options="$prodiArr" :selected="$program_studi_id"
            placeholder="Pilih Program Studi" :required="true" />
        <x-form-input label="Kode" type="text" name="code" placeholder="Tulis Kode MK" :value="$code" />
        <x-form-input label="Nama" type="text" name="name" placeholder="Tulis Nama MK" :value="$name" />
        <x-form-input label="SKS" type="number" name="sks" placeholder="Tulis SKS" :value="$sks" />
    </div>
    <hr class="m-0" />
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
