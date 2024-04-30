$(document).ready(function () {
    var currentPage = 1;
    var itemsPerPage = 5; // Number of items to display per page

    // Hide the pagination controls initially
    $('#paginationContainer').hide();

    // Function to fetch data
    function get_data(tableName) {
        $.get("/settings/fetch-table-data", { tableName: tableName }, function (data, response) {
            // Clear existing table rows
            $('#parameters-table').find('tbody').empty();

            // Check if the selected table is "tva"
            var isTvaTable = tableName === 'tva';

            // Iterate over each item in the data and append rows to the table
            for (var i = 0; i < data.length; i++) {
                var line = '<tr class="' + data[i].id + '">' +
                    '<td class="parameter-label">' + data[i].libelle + '</td>';

                // If it's the "tva" table, append the value column
                if (isTvaTable) {
                    line += '<td class="parameter-value">' + data[i].valeur + '</td>';
                    $("#valueColumn").show(); // Show the "Value" column
                }

                // Add the actions column
                line += '<td>' +
                    '<a class="btn btn-primary btn-sm editbtn" href="#" data-parameter-id="' + data[i].id + '" data-table-name="' + tableName + '" style="margin-right:3px"><i class="fas fa-pen-to-square"></i></a>' +
                    '<a class="btn btn-danger btn-sm delbtn" data-parameter-id="' + data[i].id + '"><i class="fas fa-trash"></i></a>' +
                    '</td>' +
                    '</tr>';

                $('#parameters-table').find('tbody').append(line);
            }

            // If it's not the "tva" table, hide the value input field
            if (!isTvaTable) {
                $("#valueColumn").hide();
            }

            // Show or hide the pagination controls based on whether a table is selected
            if (tableName !== '') {
                $('#paginationContainer').show();
            } else {
                $('#paginationContainer').hide();
            }

            // Show or hide the "Add Parameter" button based on whether a table is selected
            if (tableName !== '') {
                $('.addParameterBtn').show();
            } else {
                $('.addParameterBtn').hide();
            }

            // Append the "Add Parameter" button after the table
            var addButton = '<button class="btn btn-success btn-sm addParameterBtn">Add Parameter</button>';
            $('#parameters-table').next('.addParameterBtn').remove(); // Remove any existing button
            $('#parameters-table').after(addButton);

            // Reset current page to 1 after updating table data
            currentPage = 1;
            updateTableData();
        });
    }

    // Call get_data when table select changes
    $("#tableSelect").change(function () {
        var selectedTable = $(this).val();
        get_data(selectedTable);

        // Show or hide the "valeur" input field based on the selected table
        if (selectedTable === 'tva') {
            $("#valeurInput").show();
        } else {
            $("#valeurInput").hide();
        }
    });

    // Event listener for delete button
    $(document).on('click', '.delbtn', function () {
        var parameterId = $(this).data("parameter-id");
        $("#deleteParameterBtn").attr("data-parameter-id", parameterId);
        $("#idDelParameter").val(parameterId);
        $("#confirmDeleteModal").modal("show");
    });

    // Event listener for edit button
    $(document).on('click', '.editbtn', function () {
        var parameterId = $(this).data("parameter-id");
        $("#editParameterBtn").attr("data-parameter-id", parameterId);
        $("#idEditParameter").val(parameterId);
        var tableName = $(this).data("table-name");
        var parameterLabel = $(this).closest('tr').find('td.parameter-label').text();
        var parameterValue = $(this).closest('tr').find('td.parameter-value').text();

        // Set the modal title to the parameter label
        $("#editParameterModalLabel").text("Edit Parameter: " + parameterLabel);

        // Set the value of the input fields to the parameter label and value
        $("#editLibelle").val(parameterLabel);
        $("#editValeur").val(parameterValue);

        // Show or hide the "valeur" input field based on the selected table
        if (tableName === 'tva') {
            $("#editValeur").closest('.mb-3').show(); // Show the "Value" input field
        } else {
            $("#editValeur").closest('.mb-3').hide(); // Hide the "Value" input field
        }

        // Show the edit modal
        $("#editParameterModal").modal("show");
    });

    // Event listener for add button
    $(document).on('click', '.addParameterBtn', function () {
        // Clear the input field
        $('#addLibelle').val('');
        $('#addValeur').val('');

        // Show the add parameter modal
        $('#addParameterModal').modal('show');
    });

    // Form submission for adding parameter
    $('#addParameterForm').submit(function (event) {
        event.preventDefault();

        // Get the form data
        var formData = $(this).serialize();
        var parameterType = $("#tableSelect").val();
        formData += "&type=" + parameterType;

        // Perform AJAX request to save data to the database
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/add-parameter', // Change the URL to your add parameter endpoint
            type: 'POST',
            data: formData,
            success: function (response) {
                // Handle success
                alert(response);

                // Optionally, you can update the UI here to reflect the added parameter
                // For example, you can append a new row to the table with the added parameter
                // Refresh the table data after adding the parameter
                get_data(parameterType);

                // Close the modal
                $('#addParameterModal').modal('hide');
            },
            error: function (error) {
                // Handle error
                console.error('Error adding parameter:', error);
                alert('An unexpected error occurred. Please try again later.');
            }
        });
    });

    // Form submission for editing parameter
    $('#editParameterForm').submit(function (event) {
        event.preventDefault();

        // Get the form data
        var formData = $(this).serialize();
        var parameterType = $("#tableSelect").val();
        formData += "&type=" + parameterType;

        // Store the edited row ID and label
        var editedRowId = $("#idEditParameter").val();
        var editedLibelle = $("#editLibelle").val();
        var editedValeur = $("#editValeur").val();

        // Perform AJAX request to save data to the database
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/edit-parameter',
            type: 'POST',
            data: formData,
            success: function (response) {
                // Update the corresponding row in the table with the edited data
                var editedRow = $('#parameters-table').find('tr.' + editedRowId);
                editedRow.find('td.parameter-label').text(editedLibelle);
                editedRow.find('td.parameter-value').text(editedValeur);

                // Optionally, you can reset the form fields
                $('#editParameterForm')[0].reset();

                // Close the edit modal
                $('#editParameterModal').modal('hide');
            },
            error: function (error) {
                // Handle error
            }
        });
    });

    // Form submission for delete parameter
    $('#deleteParameterForm').submit(function (event) {
        event.preventDefault();

        var formData = $(this).serialize();
        var parameterType = $("#tableSelect").val();
        formData += "&type=" + parameterType;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/delete-parameter',
            type: 'DELETE',
            data: formData,
            success: function (response) {
                if (response === 'Row deleted successfully') {
                    var deletedParameterId = $('#idDelParameter').val();
                    $('tr.' + deletedParameterId).remove();
                    $('#confirmDeleteModal').modal('hide');
                } else {
                    alert('Error deleting item: ' + response.message);
                }
            },
            error: function (error) {
                console.error('Error deleting item:', error);
                if (error.status === 404) {
                    alert('The delete route could not be found. Please contact support.');
                } else if (error.responseJSON) {
                    var errorMessage = error.responseJSON.message;
                    alert('Error: ' + errorMessage);
                } else {
                    alert('An unexpected error occurred. Please try again later.');
                }
            }
        });
    });

    // Search functionality
    $('#searchInput').on('input', function () {
        var searchText = $(this).val().toLowerCase();
        $('#parameters-table tbody tr').each(function () {
            var textToSearch = $(this).text().toLowerCase();
            if (textToSearch.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Function to update table data based on current page
    function updateTableData() {
        var startIndex = (currentPage - 1) * itemsPerPage;
        var endIndex = startIndex + itemsPerPage;
        $('#parameters-table tbody tr').hide().slice(startIndex, endIndex).show();
        $('#currentPage').text('Page ' + currentPage);
    }

    // Event listener for next page button
    $('#nextPage').click(function () {
        var totalItems = $('#parameters-table tbody tr').length;
        var totalPages = Math.ceil(totalItems / itemsPerPage);

        if (currentPage < totalPages) {
            currentPage++;
            updateTableData();
        }
    });

    // Event listener for previous page button
    $('#prevPage').click(function () {
        if (currentPage > 1) {
            currentPage--;
            updateTableData();
        }
    });
});
