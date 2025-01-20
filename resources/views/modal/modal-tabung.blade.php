@php

    $nama = '';
    $satuan = '';
    $kapasitas = '';
    $owner = '';
    $stock = '';
    $keterangan = '';
    $potongan = \App\Models\Tabung::find(request()->parent);
    if ($potongan) {
        $nama = $potongan->nama;
        $satuan = $potongan->satuan;
        $kapasitas = $potongan->kapasitas;
        $stock = $potongan->stock;
        $owner = $potongan->owner;
        $keterangan = $potongan->keterangan;
    }

@endphp
<form action="{{ route('tabung.store') }}" onsubmit="return false" method="post" id="form-action">
    @csrf
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    <div class="modal-body">
        <x-form-input label="Nama" type="text" name="nama" placeholder="Tulis nama tabung" :value="$nama" />
        <div class="row">
            <div class="col-md-6">
                <x-form-input-group label="Kapasitas" name="kapasitas" type="number" append="KG"
                    placeholder="kapasitas tabung" :value="$kapasitas" />
            </div>
            <div class="col-md-6">
                <x-form-select label="Jenis Tabung" name="satuan" :options="['Kilo' => 'Kilo Gram (KG)', 'Kubik' => 'Meter Kubi (M3)', 'Liter' => 'Liter']" :selected="$satuan"
                    placeholder="Pilih Jenis tabung" :required="true" />
            </div>

        </div>
        <x-form-input label="Jumlah" type="text" name="stock" placeholder="Jumlah tabung" :value="$stock" />
        <x-form-textarea label="Keterangan" name="keterangan" placeholder="-opsional" :value="$keterangan"
            rows="5" />
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="owner" id="flexCheckChecked">
            <label class="form-check-label" for="flexCheckChecked">
                Checked untuk milik perusahaan
            </label>
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
