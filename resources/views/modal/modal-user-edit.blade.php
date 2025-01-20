@php

    $user = \App\Models\User::find(request()->parent);
    if ($user) {
        $name = $user->name;
        $email = $user->email;
        $roles = $user->roles;
        $status = $user->status;
        $phone = $user->phone;
        $address = $user->address;
    }
    $rolesArr = [
        'admin' => 'Admin',
        'dosen' => 'Dosen',
        'mahasiswa' => 'Mahasiswa',
    ];

    $statusArr = [
        'Y' => 'Aktif',
        'N' => 'Non Aktif',
    ];

@endphp
<form action="{{ route('user.update') }}" onsubmit="return false" method="post" id="form-action">
    <input type="hidden" name="ID" value="{{ request()->parent }}">
    @csrf
    <div class="modal-body">
        <x-form-input label="Nama" type="text" name="name" :value="$name" autofocus placeholder="Tulis nama"
            required />
        <x-form-input label="Email" type="email" name="email" :value="$email" placeholder="Tulis email"
            readonly />
        <x-form-input label="Nomor Telphone" type="text" name="phone" :value="$phone"
            placeholder="Tulis nomor telepon" required />
        <div class="row">
            <div class="col-md-6">
                <x-form-select label="Roles" class="select-2" name="roles" :options="$rolesArr" :selected="$roles"
                    placeholder="Pilih Roles" :required="true" />
            </div>
            <div class="col-md-6">
                <x-form-select label="Status" class="select-2" name="status" :options="$statusArr" :selected="$status"
                    placeholder="Pilih Status" :required="true" />
            </div>
        </div>
        <x-form-textarea label="Alamat" name="address" :value="$address" placeholder="Tulis alamat" required />

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('.select-2').select2({
            dropdownParent: $("#myModals")
        });
    });
    $("form#form-action").on("submit", function(event) {
        event.preventDefault();
        $('#page-pre-loader').show();
        const form = this;

        axios.post($(form).attr('action'), form)
            .then(response => {
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
                $('#page-pre-loader').hide();
                DTable.ajax.reload(null, false);
            });
    });
</script>
