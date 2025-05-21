// Get NRC township using nrc state
$(document).on("change", ".nrc_state", function () {
    nrc_state = $(this).val();
    url = $(this).attr("data-attr-url") + "/" + nrc_state;
    $.ajax({
        url: url,
        type: "GET",
        success: function (data) {
            if (data) {
                option = "<option value=''>xxx</option>";
                $.each(data, function (index, value) {
                    option +=
                        '<option value="' +
                        value.id +
                        '">' +
                        value.code +
                        "</option>";
                });
                $(".nrc_township").html(option);
            }
        },
    });
});