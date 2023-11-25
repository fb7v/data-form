// Funkcija resetRow(row)
// atgriež rindu row sākotnējā stāvoklī
function resetRow(row) {
    row.removeClass('editing new-row');
    row.find('span').attr('contenteditable', 'false');
    row.find('.save-btn').hide();
    row.find('.edit-btn').show();

    var initialValues = row.data('initial-values');
    setRowValues(row, initialValues);
}

// Funkcija getRowValues(row)
// iegūst rindas row vērtības
function getRowValues(row) {
    var values = [];
    row.find('div').each(function(index) {
        values['td' + index] = $(this).text();
    });
    return values;
}

// Funkcija setRowValues(row, values)
// uzstāda rindas row vērtības values
function setRowValues(row, values) {
    row.find('td:not(:last-child) div').each(function(index) {
        $(this).text(values[index]); // Use an empty string if the value is undefined
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
        row.find('div').attr('contenteditable', 'true');
        row.find('.new-btn').hide();
        row.find('.edit-btn').hide();
        row.find('.save-btn').show();
        row.data('initial-values', getRowValues(row));
    } else {
        row.addClass('editing');
        row.data('initial-values', getRowValues(row));
        row.find('div').attr('contenteditable', 'true');
        row.find('.edit-btn').hide();
        row.find('.save-btn').show();
    }
}
function confirmSwitch() {
    return confirm('Another row is already being edited. Are you sure you want to switch? Unsaved changes will be lost!');
}