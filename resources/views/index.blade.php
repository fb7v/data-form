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
                <tr class="editable-content" data-id="{{ $book->id }}">
                    <td contenteditable="false"><span>{{ $book->title }}</span></td>
                    <td contenteditable="false"><span>{{ $book->author }}</span></td>
                    <td contenteditable="false"><span>{{ $book->genre }}</span></td>
                    <td contenteditable="false"><span>{{ $book->price }}</span></td>
                    <td contenteditable="false"><span>{{ $book->publish_date }}</span></td>
                    <td contenteditable="false"><span>{{ $book->description }}</span></td>
                    <td>
                        <button class="edit-btn">Edit</button>
                        <button class="save-btn" style="display:none;">Save</button>
                    </td>
                </tr>
            @endforeach
            <tr class="new-row" style="display: none;">
                    <td><span></span></td>
                    <td><span></span></td>
                    <td><span></span></td>
                    <td><span></span></td>
                    <td><span></span></td>
                    <td><span></span></td>
            <td>
                <button class="edit-btn">Edit</button>
                <button class="save-btn" style="display:none;">Save</button>
            </td>
            </tr>
            <tr class="new-btn-row">
                <td colspan="7">
                    <button class="new-btn">New</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <script>
        $('.edit-btn').click(function() {
            var row = $(this).closest('tr');
            switchRow(row);
        });

        $('.save-btn').click(function() {
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
                resetRow(row);
                row.find('td').each(function(index) {
                    $(this).text(editedData[Object.keys(editedData)[index + 1]]);
                });
            },
            error: function(error) {
                console.error(error);
            }
        });
        });
        $('.new-btn').click(function() {
            var newRow = $('.new-row');
            switchRow(newRow);
        });

    </script>
@endsection
