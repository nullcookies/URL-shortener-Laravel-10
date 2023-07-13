$(document).ready(function () {

    var form = '#shortener-form';

    $(form).on('submit', function (event) {
        event.preventDefault();

        var url = $(this).attr('action');

        $.ajax({
            url: url,
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if ($.isEmptyObject(response.error)) {

                    // Extract value from table header.
                    let col = [];
                    let custom_col = ['ID', 'Link', 'Short Link'];
                    for (let i = 0; i < response.length; i++) {
                        for (let key in response[i]) {
                            if (col.indexOf(key) === -1) {
                                col.push(key);
                            }
                        }
                    }

                    // Create table.
                    const table = document.createElement("table");
                    table.setAttribute('class', 'table table-bordered table-sm')

                    // Create table header row using the extracted headers above.
                    let tr = table.insertRow(-1);                   // table row.

                    for (let i = 0; i < col.length; i++) {
                        let th = document.createElement("th");      // table header.
                        th.innerHTML = custom_col[i];
                        tr.appendChild(th);
                    }

                    // add json data to the table as rows.
                    for (let i = 0; i < response.length; i++) {

                        tr = table.insertRow(-1);

                        for (let j = 0; j < col.length; j++) {
                            let tabCell = tr.insertCell(-1);
                            tabCell.innerHTML = response[i][col[j]];
                        }
                    }

                    // Now, add the newly created table with json data, to a container.
                    const divShowData = document.getElementById('show-data');
                    divShowData.innerHTML = "";
                    divShowData.appendChild(table);
                    $('#errorMsg').hide();
                } else {
                    printErrorMsg(response.error);
                }

                $(form).trigger("reset");

            },
            error: function (response) {
            }
        });
    });

    function printErrorMsg(msg) {
        $(".print-error-msg").find("ul").html('');
        $('#errorMsg').show();
        $.each(msg, function (key, value) {
            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        });
    }

});
