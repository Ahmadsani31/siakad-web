@php
    $code = '';
    $name = '';
    $tahun_mulai = '';
    $tahun_selesai = '';
    $sql = \App\Models\TahunAkademik::find(request()->parent);
    if ($sql) {
        $code = $sql->code;
        $name = $sql->name;
        $tahun_mulai = $sql->tahun_mulai;
        $tahun_selesai = $sql->tahun_selesai;
    }

@endphp
<form action="{{ route('tahun-akademik.store') }}" onsubmit="return false" method="post" id="form-action">
    @csrf
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    <div class="modal-body">
        <x-form-input label="Kode" type="number" name="code" placeholder="Tulis kode" :value="$code" />
        <x-form-input label="Nama" type="text" name="name" placeholder="Tulis nama" :value="$name" />
        <div class="row">
            <div class="col-md-6">
                <x-form-input label="Mulai" type="date" name="tahun_mulai" :value="$tahun_mulai" />
            </div>
            <div class="col-md-6">
                <x-form-input label="Selesai" type="date" name="tahun_selesai" :value="$tahun_selesai" />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
<script>
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
