(function () {
    const selectAll = document.getElementById('select-all-items');
    const itemCheckboxes = document.querySelectorAll('.mpl-item-checkbox');

    if (!selectAll || itemCheckboxes.length === 0) {
        return;
    }

    selectAll.addEventListener('change', function () {
        itemCheckboxes.forEach(function (checkbox) {
            checkbox.checked = selectAll.checked;
        });
    });

    itemCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const checkedCount = document.querySelectorAll('.mpl-item-checkbox:checked').length;
            selectAll.checked = checkedCount === itemCheckboxes.length;
        });
    });
})();
