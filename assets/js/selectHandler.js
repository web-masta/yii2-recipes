var messageBox = $('#filter-message')
var selectFilter = $('#recipe-search')
var searchButton = $('#recipe-search-button')

selectFilter.multiSelect({
    selectableHeader: "<div class='custom-header'>List</div>",
    selectionHeader: "<div class='custom-header'>Selected</div>",
})

refreshFilter(selectFilter)

selectFilter.change(function() {
    refreshFilter(selectFilter)
});

function refreshFilter(el) {
    if ($(el).val().length < 2) {
        messageBox.text(
            decodeURIComponent('%D0%92%D1%8B%D0%B1%D0%B5%D1%80%D0%B8%D1%82%D0%B5%20%D0%B1%D0%BE%D0%BB%D1%8C%D1%88%D0%B5%20%D0%B8%D0%BD%D0%B3%D1%80%D0%B5%D0%B4%D0%B8%D0%B5%D0%BD%D1%82%D0%BE%D0%B2.')).show()
        searchButton.prop('disabled', true)

    } else if ($(el).val().length >= 2 && $(el).val().length < 5) {
        messageBox.text('').hide()
        searchButton.prop('disabled', false)
    }
    if ($(el).val().length >= 5) {
        $(el).find(':not(:selected)').prop('disabled', true)
        messageBox.text(
            decodeURIComponent('%D0%9C%D0%BE%D0%B6%D0%BD%D0%BE%20%D0%B2%D1%8B%D0%B1%D1%80%D0%B0%D1%82%D1%8C%20%D0%BD%D0%B5%20%D0%B1%D0%BE%D0%BB%D0%B5%D0%B5%205%20%D0%B8%D0%BD%D0%B3%D1%80%D0%B8%D0%B4%D0%B8%D0%B5%D0%BD%D1%82%D0%BE%D0%B2.')).show()
        if ($(el).val().length > 5) {
            searchButton.prop('disabled', true)
        }
    }
    else {
        $(el).find(':not(:selected)').prop('disabled', false)
        //searchButton.prop('disabled', false)
    }
    el.multiSelect('refresh')
}