
//  Activity log index table
var activity_table = $(".activity-log-data-table").DataTable({
    processing: true,
    serverSide: true,
    aaSorting: [],
    ajax: {
        url: $("#table_url").attr("data-table-url"),
        data: function (data) {
            data.event = $("#event").val();
            data.causer_type = $("#causer_type").val();
            data.causer_name = $("#causer_name").val();
            data.subject_name = $("#subject_name").val();
            data.activity_log_startDate = $("#activity_log_startDate").val();
            data.activity_log_endDate = $("#activity_log_endDate").val();
        },
        error: function (xhr, error, thrown) {
            if (xhr.status === 419) {
                window.location.reload();
                return;
            }
        },
    },
    columns: [
        { data: "created_at", name: "created_at" },
        { data: "causer_type", name: "causer_type" },
        { data: "causer_name", name: "causer_name", orderable: false },
        { data: "subject_type", name: "subject_type" },
        { data: "description", name: "description" },
    ],
});

// $("#activity_log_dateRange").on("cancel.daterangepicker", function () {
//     $("#activity_log_dateRange").val("");
//     $("#activity_log_startDate").val("");
//     $("#activity_log_endDate").val("");
// });
