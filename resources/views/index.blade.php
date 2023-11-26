@extends('layouts.main')

@section('content')
<div id="books-table">
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Price</th>
                <th>Publish Date</th>
                <th>Description</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr data-id="{{ $book->id }}">
                    <td><div contenteditable="false">{{ $book->title }}</div></td>
                    <td><div contenteditable="false">{{ $book->author }}</div></td>
                    <td><div contenteditable="false">{{ $book->genre }}</div></td>
                    <td><div contenteditable="false">{{ $book->price }}</div></td>
                    <td><div contenteditable="false">{{ $book->publish_date }}</div></td>
                    <td><div contenteditable="false">{{ $book->description }}</div></td>
                    <td contenteditable="false">
                        <button class="edit-btn">Edit</button>
                        <button class="save-btn" style="display:none;">Save</button>
                    </td>
                </tr>
            @endforeach
            <tr class="new-row" style="display: none;">
                    <td><div contenteditable="true"></div></td>
                    <td><div contenteditable="true"></div></td>
                    <td><div contenteditable="true"></div></td>
                    <td><div contenteditable="true"></div></td>
                    <td><div contenteditable="true"></div></td>
                    <td><div contenteditable="true"></div></td>
            <td contenteditable="false">
                <button class="edit-btn">Edit</button>
                <button class="save-btn" style="display:none;">Save</button>
            </td>
            </tr>
            <tr class="new-btn-row">
                <td colspan="7" contenteditable="false">
                    <button class="new-btn">New</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script>
    $(document).ready(function () {
        $('#books-table').on('click', '.edit-btn', function() {
            var row = $(this).closest('tr');
            switchRow(row);
        });

        $('#books-table').on('click', '.save-btn', function() {
        var row = $(this).closest('tr');

        // Jāpārbauda vai tiek saglabāta jauna vai eksistējoša rinda
        var isNewRow = row.hasClass('new-row');
        var url = isNewRow ? '/index' : '/index/' + row.data('id');

        
        var editedData = {
            _token: '{{ csrf_token() }}',
            title: row.find('td:eq(0)').text(),
            author: row.find('td:eq(1)').text(),
            genre: row.find('td:eq(2)').text(),
            price: row.find('td:eq(3)').text(),
            publish_date: row.find('td:eq(4)').text(),
            description: row.find('td:eq(5)').text(),
        };

        $.ajax({
            url: url,
            type: isNewRow ? 'POST' : 'PUT',
            data: editedData,
            success: function(response) {
                console.log(response);
                // Atjauno datus pēc veiksmīgas ielādes
                if (isNewRow) {
                    var newBookId = response.id;
                    row.attr('data-id', newBookId);
                }
                setRowValues(row, response.editedData);
                row.data('initial-values', getRowValues(row));
                resetRow(row);
            },
            error: function(error) {
                console.error(error);
            }
        });
        });
        $('#books-table').on('click', '.new-btn', function() {
            var newRow = $('.new-row');
            if (newRow.length === 0) {
                var newRow = $('<tr class="new-row">' +
                '<td><div contenteditable="true"></div></td>' +
                '<td><div contenteditable="true"></div></td>' +
                '<td><div contenteditable="true"></div></td>' +
                '<td><div contenteditable="true"></div></td>' +
                '<td><div contenteditable="true"></div></td>' +
                '<td><div contenteditable="true"></div></td>' +
                '<td contenteditable="false">' +
                '<button class="edit-btn">Edit</button>' +
                '<button class="save-btn" style="display:none;">Save</button>' +
                '</td>' +
                '</tr>');
                newRow.insertBefore('.new-btn-row');
            }
            switchRow(newRow);
        });
    });

    </script>
@endsection
