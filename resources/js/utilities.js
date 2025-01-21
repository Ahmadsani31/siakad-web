axios.defaults.headers.common["X-CSRF-TOKEN"] = $(
    'meta[name="csrf-token"]'
).attr("content");

$(document).on("click", ".modal-cre", function (e) {
    $("#contentBody").html(
        '<div class="p-5 d-flex align-items-start justify-content-center"><div style="color:red; font-weight:bold;padding-right:10px;">Loading ...</div> <div class="spinner-border text-danger" role="status"> <span class="visually-hidden"></span></div></div> '
    );
    // $("#loading-ajax-modal").show();
    var serial = "";
    $.each(this.attributes, function () {
        if (this.specified) {
            serial += "&" + this.name + "=" + this.value;
        }
    });

    var id = $(this).attr("id");
    var judul = $(this).attr("judul");
    console.log(id);
    if (id == "karyawan") {
        $("#size_modal").addClass("modal-xl");
    } else {
        $("#size_modal").removeClass("modal-lg");
        $("#size_modal").removeClass("modal-xl");
    }
    $("#myModals").modal("toggle");

    if (judul != null) {
        $(".modal-title").html(judul);
    } else {
        $(".modal-title").html("Kelola Data");
    }

    var base_url = $('meta[name="base-url"]').attr("content");

    var page = base_url + "/modal/modal-" + id;

    $("#myModals").modal("toggle");

    axios
        .post(page, serial)
        .then(function (response) {
            console.log(response);
            $("#contentBody").html(response.data);
            // handle success
        })
        .catch(function (error) {
            console.log(error);
            Toast.fire({
                icon: "warning",
                title: error.message,
            });
            // handle error
        });
});

$(document).on("click", ".modal-image-cre", function (e) {
    $("#myModalImages").modal("toggle");

    $("#content").html(
        '<div style="text-align:center; color:red; font-weight:bold;padding:10px">Loading ...</div> '
    );
    // $("#loading-ajax-modal").show();
    var serial = "";
    $.each(this.attributes, function () {
        if (this.specified) {
            serial += "&" + this.name + "=" + this.value;
        }
    });

    var id = $(this).attr("id");
    var judul = $(this).attr("judul");
    // console.log(id);
    if (id == "person" || id == "aktivitas") {
        $("#size_modal").addClass("modal-xl");
    } else {
        $("#size_modal").removeClass("modal-lg");
        $("#size_modal").removeClass("modal-xl");
    }

    if (judul != null) {
        $(".modal-title").html(judul);
    } else {
        $(".modal-title").html("Kelola Data");
    }

    var base_url = $('meta[name="base-url"]').attr("content");

    var page = base_url + "/modal/modal-" + id;
    $.post(page, serial, function (data) {
        // $("#loading-ajax-modal").hide();
        $("#content-images").html(data);
    });
});

$(document).on("click", ".modal-del", function (e) {
    var tbData = "";
    var idData = "";
    $.each(this.attributes, function () {
        if (this.specified) {
            if (this.name == "tabel") {
                tbData = this.value;
            }
            if (this.name == "id") {
                idData = this.value;
            }
        }
    });

    Swal.fire({
        title: "Perhatian!",
        text: "Kamu yakin ingin menghapus data ini?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Delete",
    }).then((result) => {
        if (result.isConfirmed) {
            var base_url = $('meta[name="base-url"]').attr("content");
            var page = base_url + "/delete/" + tbData + "/" + idData;
            $("#page-pre-loader").show();
            axios
                .delete(page)
                .then((response) => {
                    DTable.ajax.reload();
                    $("#page-pre-loader").hide();
                    Toast.fire({
                        icon: "success",
                        title: response.data.message,
                    });
                })
                .catch((error) => {
                    DTable.ajax.reload();
                    $("#page-pre-loader").hide();
                    Swal.fire({
                        icon: "error",
                        title: "Kesalahan !",
                        text: error.response.data.message,
                    });
                });
        }
    });
});

$("ul a")
    .click(function (e) {
        var link = $(this);
        var item = link.parent("li");
        // console.log(item);

        if (item.hasClass("active")) {
            item.removeClass("active").children("a").removeClass("active");
        } else {
            item.addClass("active").children("a").addClass("active");
        }

        if (item.children("ul").length > 0) {
            var href = link.attr("href");
            link.attr("href", "#");
            setTimeout(function () {
                link.attr("href", href);
            }, 300);
            e.preventDefault();
        }
    })

    .each(function () {
        var link = $(this);

        if (link.get(0).href === location.href) {
            link.addClass("active").parents("li").addClass("active");
            link.addClass("active").parents(".collapse").addClass("show");
            return false;
        }
    });
