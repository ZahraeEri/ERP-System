<x-app-layout>
    @include('components.add-modal')
    <x-slot name="header">
        <!-- Header content goes here -->
    </x-slot>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Table with Bootstrap</title>

        <!-- fontawesome cdn -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fontawesome-6-pro@6.4.0/css/all.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- jquery and jquery UI libraries  -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    </head>

    <body>
        <div class="container mt-3">
            <h2>Table Data</h2>

            <div class="row">
                <div class="col-md-6">
                    <select id="tableSelect" class="form-select mb-3">
                        <option value="">Select a table</option>
                        @foreach ($filteredTableNames as $tableName)
                            <option value="{{ $tableName }}">{{ $tableName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- search area --}}
            <div class="input-group mb-3 ">
                <input id="searchInput" type="text" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                    <button class="btn btn-outline-warning" type="button"><i class="bi bi-search"></i></button>
                </div>
            </div>

            <div id="tableData">
                <!-- Table data will be displayed here -->
                <table id="parameters-table" class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col" id="valueColumn" style="display: none;">Value</th>
                            <!-- Initially hidden -->
                            <th scope="col">Actions</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination -->
<div id="paginationContainer" class="container mt-3" style="display: none;">
    <div class="row">
        <div class="col-md-11 d-flex justify-content-center">
            <div class="pagination">
                <button id="prevPage" class="btn btn-outline-warning"><i class="bi bi-skip-backward-circle"></i></button>
                <span id="currentPage" class="mx-2"></span>
                <button id="nextPage" class="btn btn-outline-warning"><i class="bi bi-skip-forward-circle"></i></button>
            </div>
        </div>
    </div>
</div>





        <!-- Add button -->
        {{-- <button type="button" class="btn btn-success" id="addParameterBtn" data-toggle="modal"
            data-target="#addParameterModal"><i class="bi bi-plus-circle"></i></button> --}}

        <!-- Add Parameter Modal -->
        <div class="modal fade" id="addParameterModal" tabindex="-1" role="dialog"
            aria-labelledby="addParameterModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addParameterModalLabel">Add Parameter</h5>
                    </div>
                    <form id="addParameterForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="addLibelle">Libelle:</label>
                                <input type="text" class="form-control" id="addLibelle" name="libelle">
                            </div>
                            <div id="valeurInput" style="display: none;">
                                <label for="addValeur">Value:</label>
                                <input type="number" class="form-control" id="addValeur" name="valeur">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
            // document.addEventListener('DOMContentLoaded', function() {
            //     var tableSelect = document.getElementById('tableSelect');
            //     tableSelect.addEventListener('change', function() {
            //         var tableName = this.value;
            //         if (tableName !== '') {
            //             fetchTableData(tableName);
            //         }
            //     });
            // });

            function fetchTableData(tableName) {
                var tableDataDiv = document.getElementById('tableData');
                tableDataDiv.innerHTML = 'Loading...';

                fetch('/settings/fetch-table-data', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            table: tableName
                        })
                    })
                    .then(response => response.json())
                    .then(data => appendTableRows(data))
                    .catch(error => console.error('Error fetching table data:', error));
            }

            function appendTableRows(data) {
                var tableDataDiv = document.getElementById('tableData');
                var table = document.createElement('table');
                table.classList.add('table', 'table-striped');
                var tbody = document.createElement('tbody');

                // Create header row
                var headerRow = document.createElement('tr');
                for (var key in data[0]) {
                    if (key !== 'created_at' && key !== 'updated_at') {
                        var th = document.createElement('th');
                        // Map column names to custom labels
                        switch (key) {
                            case 'id':
                                th.textContent = 'Id';
                                break;
                            case 'libelle':
                                th.textContent = 'Label';
                                break;
                            case 'valeur':
                                th.textContent = 'Value';
                                break;
                            default:
                                th.textContent = key;
                        }
                        headerRow.appendChild(th);
                    }
                }

                // Add the header for the actions column
                var actionsHeader = document.createElement('th');
                actionsHeader.textContent = 'Actions';
                headerRow.appendChild(actionsHeader);
                tbody.appendChild(headerRow);

                // Append table rows with data
                data.forEach(function(rowData) {
                    var row = document.createElement('tr');
                    for (var key in rowData) {
                        if (key !== 'created_at' && key !== 'updated_at') {
                            var cell = document.createElement('td');
                            cell.textContent = rowData[key];
                            row.appendChild(cell);
                        }
                    }

                    // Add buttons for deleting and updating data
                    var actionsCell = document.createElement('td');

                    var deleteButton = document.createElement('button');
                    deleteButton.innerHTML = '<i class="bi bi-trash3"></i>';
                    deleteButton.classList.add('btn', 'btn-danger', 'me-2');
                    deleteButton.setAttribute('data-bs-toggle', 'modal');
                    deleteButton.setAttribute('data-bs-target', '#confirmDeleteModal');
                    deleteButton.setAttribute('data-item-id', rowData['id']);
                    actionsCell.appendChild(deleteButton);
                    //update button
                    var updateButton = document.createElement('button');
                    updateButton.innerHTML = '<i class="bi bi-pencil-square"></i>';
                    updateButton.classList.add('btn', 'btn-primary', 'me-2');
                    updateButton.addEventListener('click', function() {
                        fetchParameterData(rowData['id']);
                    });
                    actionsCell.appendChild(updateButton);

                    row.appendChild(actionsCell);
                    tbody.appendChild(row);
                });

                table.appendChild(tbody);
                tableDataDiv.innerHTML = '';
                tableDataDiv.appendChild(table);


                //add new button
                function openAddModal() {
                    // Get a reference to the component's element
                    const addModalElement = document.querySelector('x-add-modal');
                    if (addModalElement) {
                        // Show or make the modal visible
                        addModalElement.classList.add('show'); // Assuming a "show" class toggles visibility
                        // Optionally, create the component instance if it's not already there:
                        if (!addModalElement.componentInstance) {
                            createComponent('x-add-modal', addModalElement); // Assuming a createComponent function
                        }
                    } else {
                        console.error('x-add-modal component not found');
                    }
                }
                // Add button for adding new data
                var addButton = document.createElement('button');
                addButton.innerHTML = '<i class="bi bi-person-plus"></i> Add New Data';
                addButton.classList.add('btn', 'btn-success', 'mt-3');
                addButton.addEventListener('click', openAddModal); // Assign the function directly to the click event listener

                tableDataDiv.appendChild(addButton);
            }

            function fetchParameterData(id) {
                fetch('/settings/fetch-parameter-data/' + id)
                    .then(response => response.json())
                    .then(data => {
                        $("#libelle").val(data.libelle);
                        $("#editParameterModal").modal("show");
                    })
                    .catch(error => console.error('Error fetching parameter data:', error));
            }

            // Handle form submission for updating parameter
            // $("#editParameterForm").submit(function (event) {
            //     event.preventDefault();
            //     var formData = $(this).serialize();
            //     // Add AJAX request to update parameter with formData
            //     $.post("/settings/update-parameter", formData)
            //         .done(function (response) {
            //             if (response.success) {
            //                 // Refresh table data after successful update
            //                 var tableName = $("#tableSelect").val();
            //                 fetchTableData(tableName);
            //                 // Close modal
            //                 $("#editParameterModal").modal("hide");
            //             } else {
            //                 console.error("Failed to update parameter");
            //             }
            //         })
            //         .fail(function () {
            //             console.error("Failed to update parameter");
            //         });
            // });

            function deleteItem() {
                var itemId = $('#deleteItemBtn').data('item-id');

                $.ajax({
                    url: '/delete-table-row/' + itemId,
                    type: 'POST', // Change to POST for deletion
                    dataType: 'json', // Expect JSON response
                    success: function(response) {
                        if (response.message === 'Row deleted successfully') {
                            // Remove the table row for the deleted item
                            $("#item-row-" + itemId).remove();
                            $('#confirmDeleteModal').modal('hide');
                        } else {
                            alert('Error deleting item: ' + response.message); // Handle errors
                        }
                    },
                    error: function(error) {
                        console.error('Error deleting item:', error);
                        if (error.status === 404) {
                            alert('The delete route could not be found. Please contact support.');
                        } else if (error.responseJSON) {
                            // Access specific error details from the response (if available)
                            var errorMessage = error.responseJSON.message;
                            alert('Error: ' + errorMessage);
                        } else {
                            alert('An unexpected error occurred. Please try again later.');
                        }
                    }
                });
            }
        </script>
        {{-- <script>
            $(document).ready(function() {
                $('.delete-user-btn').click(function(e) {
                    e.preventDefault(); // Prevent default action

                    var itemId = $(this).data('item-id');
                    $('#deleteItemBtn').attr('href', '/delete-table-row/' + itemId);
                });
            });
        </script> --}}
        <!-- Modal -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Delete</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <form id="deleteParameterForm">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <div class="col-sm-12 mb-3 mb-2">

                                <input type="hidden" name="idDelParameter" id="idDelParameter">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <p>Are you sure you want to delete this Parameter ?</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <center>
                                <button type="submit" id="deleteParameterBtn" class="btn btn-danger"
                                    data-parameter-id="">
                                    <i class="bi bi-trash3"></i> Delete
                                </button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                            </center>
                        </form>


                    </div>
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button id="deleteItemBtn" class="btn btn-danger" data-item-id="" onclick="deleteItem()">
                            <i class="bi bi-trash3"></i> Delete
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- Edit Parameter Modal -->
        <div class="modal fade" id="editParameterModal" tabindex="-1" aria-labelledby="editParameterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editParameterModalLabel">Edit Parameter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editParameterForm">
                            <input type="hidden" name="idEditParameter" id="idEditParameter">
                            @csrf
                            <div class="mb-3">
                                <label for="editLibelle" class="form-label">Label</label>
                                <input type="text" class="form-control" id="editLibelle" name="editLibelle"
                                    value="">
                            </div>
                            <!-- Add the input field for "valeur" -->
                            <div class="mb-3">
                                <label for="editValeur" class="form-label">Value</label>
                                <input type="number" class="form-control" id="editValeur" name="editValeur"
                                    value="">
                            </div>
                            <button type="submit" id="editParameterBtn" class="btn btn-primary"
                                data-parameter-id="">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </body>

    <script src="{{ asset('CustomStyle/js/managetabs.js') }}?n=7"></script>

    </html>
</x-app-layout>
