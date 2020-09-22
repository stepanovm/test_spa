let spaTable;

window.addEventListener('load', function () {
    spaTable = new Table();
    spaTable.load();
    initControls();
});

function initControls() {
    initSortButtons();
    initFilterButton();
}

function initSortButtons() {
    $('[data-sort]').each(function(e, elem){
       $(elem).on('click', function(){
           let $sortArrow = $(elem).find('span');
           let sorttype = $sortArrow.hasClass('ascending') ? 'descending' : 'ascending';
           $(elem).parent().find('span').removeClass('ascending');
           $(elem).parent().find('span').removeClass('descending');
           $sortArrow.addClass(sorttype);
           spaTable.setSort($(elem).data('sort'), sorttype);
           spaTable.load();
       })
    });
}

function initFilterButton() {
    $('.filter-container [type="button"]').on('click', function(){
        let field = $('#f_field').val();
        let operator = $('#f_operator').val();
        let value = $('#f_value').val();
        if(!value){
            alert('Не заполнено поле "Значение"');
            return;
        }
        spaTable.setFilter(field, operator, value);
        spaTable.load();
    });
}
