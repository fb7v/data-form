// Funkcija resetRow(row)
// atgriež rindu row uz sākotnējām vērtībām
function resetRow(row) {
    row.removeClass('editing new-row');
    row.find('td').attr('contenteditable', 'false');
    row.find('.save-btn').hide();
    row.find('.edit-btn').show();

    var initialValues = row.data('initial-values');
    setRowValues(row, initialValues);
}

// Funkcija getRowValues(row)
// iegūst rindas row vērtības
function getRowValues(row) {
    var values = [];
    row.find('td:not(:last-child):not(:last-child)').each(function() {
    values.push($(this).text());
});
    return values;
}

// Funkcija setRowValues(row, values)
// uzstāda rindas row vērtības value
function setRowValues(row, values) {
    row.find('td').each(function(index) {
        $(this).text(values[index]);
    });
}
// Funkcija refreshTable
// atjauno tabulu
function refreshTable() {
    $.ajax({
        url: '/get-updated-table',
        type: 'GET',
        success: function(response) {
            $('#books-table').html(response);
        },
        error: function(error) {
            console.error(error);
        }
    });
}
// Funkcija switchRow(row)
// nodrošina rindu pārslēgšanu
function switchRow(row) {
    var editingRow = $('.editing');
    if (editingRow.length > 0) {
        if (confirmSwitch()) {
            resetRow(editingRow);
        } else {
            return;
        }
    }

    if (row.hasClass('new-row')) {
        row.show();
        row.find('td').attr('contenteditable', 'true');
        row.find('.new-btn').hide();
        row.find('.edit-btn').hide();
        row.find('.save-btn').show();
        row.data('initial-values', getRowValues(row));
    } else {
        row.addClass('editing');
        row.data('initial-values', getRowValues(row));
        row.find('td').attr('contenteditable', 'true');
        row.find('.edit-btn').hide();
        row.find('.save-btn').show();
    }
}
function confirmSwitch() {
    return confirm('Another row is already being edited. Are you sure you want to switch? Unsaved changes will be lost!');
}