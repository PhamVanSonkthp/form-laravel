$('select[name="limit"]').on('change', function () {
    addUrlParameter('limit', this.value)
});

function tryParseInt(val) {
    try {
        val = val.toString()
        return parseInt(val.replace(/,/g, "").replace(/$/g, "").replace(/đ/g, "")) || 0
    } catch (e) {
        return 0
    }
}

function tryParseFloat(val) {
    try {
        val = val.toString()
        return parseFloat(val.replace(/,/g, "").replace(/$/g, "").replace(/đ/g, "")) || 0
    } catch (e) {
        return 0
    }
}

function formatMoney(nStr) {
    nStr += ""
    x = nStr.split(",")
    x1 = x[0]
    x2 = x.length > 1 ? "," + x[1] : ""
    var rgx = /(\d+)(\d{3})/
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, "$1" + "," + "$2")
    }
    return (x1 + x2).split(".")[0] + "đ"
}

const getOnlyTime = (dataD) => {
    let data = new Date(dataD)
    let hrs = data.getHours()
    let mins = data.getMinutes()
    if (hrs <= 9)
        hrs = '0' + hrs
    if (mins < 10)
        mins = '0' + mins
    const postTime = hrs + ':' + mins
    return postTime
}

const getOnlyDate = (dataD, format = "dd/mm/yyyy") => {
    let dateObj = new Date(dataD)
    let myDate = addZero(dateObj.getUTCDate()) + "/" + addZero(dateObj.getMonth() + 1) + "/" + addZero(dateObj.getUTCFullYear());

    if (format == "yyyy/mm/dd") {
        myDate = addZero(dateObj.getUTCFullYear()) + "/" + addZero(dateObj.getMonth() + 1) + "/" + addZero(dateObj.getUTCDate());
    } else if (format == "mm/dd/yyyy") {
        myDate = addZero(dateObj.getMonth() + 1) + "/" + addZero(dateObj.getUTCDate()) + "/" + addZero(dateObj.getUTCFullYear());
    }

    return myDate;
}

function addZero(input) {
    if ((input + "").length <= 1) {
        return '0' + input
    }
    return input
}

function getFormattedDate(input, format = "dd/mm/yyyy") {
    // var date = new Date(input)
    // var year = date.getFullYear();
    //
    // var month = (1 + date.getMonth()).toString();
    // month = month.length > 1 ? month : '0' + month;
    //
    // var day = date.getDate().toString();
    // day = day.length > 1 ? day : '0' + day;
    //
    // return month + '/' + day + '/' + year;

    return getOnlyDate(input, format) + " " + getOnlyTime(input)
}

function actionDelete(event, url = null, table = null, target_remove = null) {
    event.preventDefault()
    let urlRequest = $(this).data('url')
    let that = $(this)

    if (!urlRequest) {
        urlRequest = url
    }

    Swal.fire({
        title: 'Bạn có chắc?',
        text: "Tác vụ sẽ không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Vâng, xóa nó!',
        cancelButtonText: 'Không'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: urlRequest,
                beforeSend: function () {
                    showLoading()
                },
                success: function (response) {
                    hideLoading()
                    if (response.code === 200) {
                        table
                            .row(target_remove)
                            .remove()
                            .draw();

                        Swal.fire(
                            'Đã xóa!',
                            'Đã xóa bản ghi.',
                            'success'
                        )
                    }
                },
                error: function (err) {
                    console.log(err)
                    hideLoading()
                    Swal.fire(
                        {
                            icon: 'error',
                            title: err.responseText,
                        }
                    );
                },
            })
        }
    })
}

$(document).ready(function () {
    $(document).on('click', '.action_delete', actionDelete);
    $("input").attr("autocomplete", "off");
});

