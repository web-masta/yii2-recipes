var messageBox = $('#filter-message')
var selectFilter = $('#recipe-search')

selectFilter.multiSelect({
    selectableHeader: "<div class='custom-header'>List</div>",
    selectionHeader: "<div class='custom-header'>Selected</div>",
})

selectFilter.change(function() {
    refreshFilter(selectFilter)
});

function refreshFilter(el) {
    if ($(el).val().length < 2) {
        messageBox.text('Выберите больше ингредиентов.').show()
    } else if ($(el).val().length >= 2 && $(el).val().length < 5) {
        messageBox.text('').hide()
    }
    if ($(el).val().length >= 5) {
        $(el).find(':not(:selected)').prop('disabled', true)
        messageBox.text('Можно выбрать не более 5 ингридиентов.').show()
    } else {
        $(el).find(':not(:selected)').prop('disabled', false)
    }
    el.multiSelect('refresh')
}