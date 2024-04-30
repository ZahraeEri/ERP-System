<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
    </x-slot>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Business List</title>
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
            <h2>Business List</h2>

            <!-- Search bar -->
            <div class="input-group mb-3">
                <input id="searchInput" type="text" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                    <button id="searchButton" class="btn btn-outline-primary" type="button"><i
                            class="bi bi-search"></i>
                    </button>
                </div>
            </div>
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif

            <!-- Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($affaires as $affaire)
                    <tr>
                        <td>{{ $affaire->Numero }}</td>
                        <td>
                            <a href="/update-affaire/{{ $affaire->id }}" class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                            <button type="button" class="btn btn-danger delete-affaire-btn" data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal" data-affaire-id="{{ $affaire->id }}">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item" id="prevPage">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item" id="currentPage"><a class="page-link"></a></li>
                        <li class="page-item" id="nextPage">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Add affaire button -->
            <a href="/add_affaire" class="btn btn-success"><i class="bi bi-plus"></i> Add Business</a>
        </div>

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
                        Are you sure you want to delete this affaire?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <a id="deleteAffaireBtn" class="btn btn-danger" href="#">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var currentPage = 1;
                var itemsPerPage = 10; // Number of items to display per page

                // Function to update table data based on current page
                function updateTableData() {
                    var startIndex = (currentPage - 1) * itemsPerPage;
                    var endIndex = startIndex + itemsPerPage;
                    $('table tbody tr').hide().slice(startIndex, endIndex).show();
                    $('#currentPage a').text('Page ' + currentPage);
                }

                // Initial update of table data
                updateTableData();

                // Event listener for next page button
                $('#nextPage').click(function() {
                    var totalItems = $('table tbody tr').length;
                    var totalPages = Math.ceil(totalItems / itemsPerPage);

                    if (currentPage < totalPages) {
                        currentPage++;
                        updateTableData();
                    }
                });

                // Event listener for previous page button
                $('#prevPage').click(function() {
                    if (currentPage > 1) {
                        currentPage--;
                        updateTableData();
                    }
                });

                $('#searchButton').click(function() {
                    var searchText = $('#searchInput').val().toLowerCase();

                    // Loop through each table row
                    $('table tbody tr').each(function() {
                        var rowText = $(this).text().toLowerCase();

                        // If the row contains the search text, show it; otherwise, hide it
                        if (rowText.includes(searchText)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });

                // Handle keyup event on search input to trigger search
                $('#searchInput').keyup(function() {
                    var searchText = $(this).val().toLowerCase();

                    // Loop through each table row
                    $('table tbody tr').each(function() {
                        var rowText = $(this).text().toLowerCase();

                        // If the row contains the search text, show it; otherwise, hide it
                        if (rowText.includes(searchText)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });

                // Function to handle delete affaire button click
                $('.delete-affaire-btn').click(function() {
                    var affaireId = $(this).data('affaire-id'); // Get the affaire ID from the button data attribute

                    // Show the confirmation modal
                    $('#confirmDeleteModal').modal('show');

                    // Handle delete button click inside the modal
                    $('#deleteAffaireBtn').click(function() {
                        // Send an AJAX request to delete the affaire
                        $.ajax({
                            url: '/delete-affaire/' + affaireId, // Replace '/delete-affaire/' with the actual delete route
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Hide the modal
                                $('#confirmDeleteModal').modal('hide');

                                // Reload the page to update the affaire list
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                // Handle error
                                console.error(xhr.responseText);
                            }
                        });
                    });
                });
            });
        </script>

    </body>

    </html>
</x-app-layout>
