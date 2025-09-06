$(function () {
    function apply() {
        if ($("#section-mode").val() === "1") {
            $("#section-data-table-ruangan").addClass("d-none");
            $("#section-data-table-kendaraan").addClass("d-none");
            $("#section-data-calendar").removeClass("d-none");
        } else if ($("#section-mode").val() === "0") {
            $("#section-data-calendar").addClass("d-none");
            $("#section-data-table-kendaraan").addClass("d-none");
            $("#section-data-table-ruangan").removeClass("d-none");
        } else if ($("#section-mode").val() === "-1") {
            $("#section-data-calendar").addClass("d-none");
            $("#section-data-table-ruangan").addClass("d-none");
            $("#section-data-table-kendaraan").removeClass("d-none");
        }
    }
    $("#section-mode").on("change", apply);
    apply();
});
