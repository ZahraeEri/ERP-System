<x-app-layout>
    <select id="tableSelect">
        <option value="">Select a table</option>
        @foreach($tableNames as $tableName)
            <option value="{{ $tableName }}">{{ $tableName }}</option>
        @endforeach
    </select>

    <div id="tableData">
        <!-- Table data will be displayed here -->
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tableSelect = document.getElementById('tableSelect');
        tableSelect.addEventListener('change', function() {
            var tableName = this.value;
            if (tableName !== '') {
                fetchTableData(tableName);
            }
        });
    });

    function fetchTableData(tableName) {
        var tableDataDiv = document.getElementById('tableData');
        tableDataDiv.innerHTML = 'Loading...';

        fetch('/settings/fetch-table-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ table: tableName })
        })
        .then(response => response.json())
        .then(data => renderTable(data))
        .catch(error => console.error('Error fetching table data:', error));
    }

    function renderTable(data) {
        var tableDataDiv = document.getElementById('tableData');
        tableDataDiv.innerHTML = '';

        var table = document.createElement('table');
        var thead = table.createTHead();
        var tbody = document.createElement('tbody');

        // Create table header row
        var headerRow = thead.insertRow();
        for (var key in data[0]) {
            var th = document.createElement('th');
            th.textContent = key;
            headerRow.appendChild(th);
        }

        // Create table rows with data
        data.forEach(function(rowData) {
            var row = tbody.insertRow();
            for (var key in rowData) {
                var cell = row.insertCell();
                cell.textContent = rowData[key];
            }
        });

        table.appendChild(thead);
        table.appendChild(tbody);
        tableDataDiv.appendChild(table);
    }
</script>
