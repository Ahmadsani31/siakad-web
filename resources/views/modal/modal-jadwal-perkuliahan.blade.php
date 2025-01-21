@php
    $dosenArr = \App\Models\User::where('roles', 'dosen')->pluck('name', 'id');
    $taArr = \App\Models\TahunAkademik::all()->pluck('code', 'id')->sortDesc();
    $prodiArr = \App\Models\ProgramStudi::selectRaw('CONCAT(code," - ",name) as name,id')->pluck('name', 'id');
    $mkArr = \App\Models\MataKuliah::selectRaw('CONCAT(code," - ",name) as name,id')->pluck('name', 'id');
    $dosen_id = '';
    $program_studi_id = '';
    $tahun_akademik = '';
    $mata_kuliah = '';
    $tanggal = '';
    $jam_mulai = '';
    $jam_selesai = '';
    $type = '';
    $query = \App\Models\Jadwal::find(request()->parent);
    if ($query) {
        $dosen_id = $query->dosen_id;
        $program_studi_id = $query->program_studi_id;
        $tahun_akademik = $query->tahun_akademik_id;
        $mata_kuliah = $query->mata_kuliah_id;
        $tanggal = $query->tanggal;
        $jam_mulai = $query->jam_mulai;
        $jam_selesai = $query->jam_selesai;
        $type = $query->type;
    }

    $typeJadwal = [
        'online' => 'Online',
        'offline' => 'Offline',
    ];
    $day = [
        'Senin' => 'Senin',
        'Selasa' => 'Selasa',
        'Rabu' => 'Rabu',
        'Kamis' => 'Kamis',
        'Jumat' => 'Jumat',
        'Sabtu' => 'Sabtu',
        'Minggu' => 'Minggu',
    ];
@endphp
<form action="{{ route('jadwal.store') }}" onsubmit="return false" method="post" id="form-action">
    @csrf
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    <div class="modal-body">
        <x-form-select label="Program Studi" class="select-2" name="program_studi_id" :options="$prodiArr" :selected="$program_studi_id"
            placeholder="Pilih Program Studi" :required="true" />
        <x-form-select label="Tahun Akademik" class="select-2" name="tahun_akademik_id" onchange="getTanggalAjar()"
            :options="$taArr" :selected="$tahun_akademik" placeholder="Pilih Tahun Akademik" :required="true" />
        <div class="row">
            <div class="col-md-6">
                <x-form-input label="Tanggal Mulai" type="date" name="tanggal_mulai" readonly />
            </div>
            <div class="col-md-6">
                <x-form-input label="Tanggal Selesai" type="date" name="tanggal_selesai" readonly />
            </div>
        </div>
        <x-form-select label="Mata Kuliah" class="select-2" name="mata_kuliah_id" :options="$mkArr" :selected="$mata_kuliah"
            placeholder="Pilih Mata Kuliah" :required="true" />
        <x-form-select label="Dosen pegampun" class="select-2" name="dosen_id" :options="$dosenArr" :selected="$dosen_id"
            placeholder="Pilih Dosen" :required="true" />
        <x-form-select label="Hari" class="select-2" name="hari" :options="daysOptions()" placeholder="Pilih Hari"
            :required="true" />
        <div class="row">
            <div class="col-md-6">
                <x-form-input label="Jam Mulai" type="time" name="jam_mulai" :value="$jam_mulai" required />
            </div>
            <div class="col-md-6">
                <x-form-input label="Jam Selesai" type="time" name="jam_selesai" :value="$jam_selesai" required />
            </div>
        </div>
        <x-form-select label="Type Jadwal" class="select-2" name="type" :options="$typeJadwal" :selected="$type"
            placeholder="Pilih type" :required="true" />
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

    // $('#program_studi_id').on('change', function() {
    //     let id = $(this).val();
    //     console.log(id);

    //     $('#mata_kuliah_id').select2({
    //         minimumInputLength: 2,
    //         placeholder: 'Select Mata Kuliah',
    //         ajax: {
    //             url: `{{ route('mata-kuliah.index') }}`,
    //             dataType: 'json',
    //             data: function(params) {
    //                 return {
    //                     q: $.trim(params.term),
    //                     prodi: id
    //                 }
    //             },
    //             processResults: data => {

    //                 return {
    //                     results: data.map(res => {
    //                         return {
    //                             text: res.name,
    //                             id: res.id
    //                         }
    //                     })
    //                 }
    //             }
    //         }
    //     })
    // });
    getTanggalAjar()

    function getTanggalAjar() {
        axios
            .get("{{ route('jadwal.get-tanggal-ajar') }}?tahun_akademik_id=" + $('#tahun_akademik_id').val())
            .then(function(response) {
                console.log(response);
                $('#tanggal_mulai').val(response.data.tahun_mulai);
                $('#tanggal_selesai').val(response.data.tahun_selesai);
                // $("#contentBody").html(response.data);
                // handle success
            })
            .catch(function(error) {
                console.log(error);
                Toast.fire({
                    icon: "warning",
                    title: error.message,
                });
                // handle error
            });
    }


    $('#program_studi_id').on('change', function() {
        var id = $(this).val();
        $('#mata_kuliah_id').val(null).trigger('change');
        $('#mata_kuliah_id').select2({
            dropdownParent: $("#myModals"),
            // minimumInputLength: 2,
            placeholder: 'Select Mata Kuliah',
            ajax: {
                url: '{{ route('jadwal.get-mata-kuliah') }}?prodi=' + id,
                dataType: 'json',
                processResults: data => {

                    return {
                        results: data.map(res => {
                            return {
                                text: res.name,
                                id: res.id
                            }
                        })
                    }
                }
            }
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
