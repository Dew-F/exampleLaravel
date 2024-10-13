//Фильтр
$(() => {
    if ($('.filter').length === 0) return;

    $('.filter-name').each(function() {
        $(this).on('click', openBlock);
    });

    $('.filter-checkbox').each(function() {
        $(this).on('change', function() {
            applyCategory($(this).is(':checked'), $(this).val());
        });
    });

    $('#filter-apply').on('click', applyFilter)
    $('#filter-clear').on('click', resetFilter)
});

//Применить стиль выбранного элемента
function applyText(obj) {
    if ($(obj).hasClass('active')){
        $(obj).removeClass('active');
    } else {
        $(obj).addClass('active');
    }
}

//Раскрыть категорию
function openBlock() {
    if ($(this).next().is(':visible')){
        $(this).next().slideUp()
        $(this).removeClass('opened');
    } else {
        $(this).addClass('opened');
        $(this).next().slideDown({
            start: function() {
                $(this).css('display','grid');
            }
        });
    }
}

//Применить категорию(добавит характеристики при наличии)
function applyCategory(isActive, uid) {
    fetch(`/filter/category`, {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({'uid' : uid })
    })
    .then(response => response.json())
    .then(data => {
        if (isActive) {
            if (data.attributes.length > 0){
                data.attributes.forEach(attribute => {
                    let htmlattr = $('<a class="filter-name" data-attribute="'+attribute['uid']+'">'+attribute['name']+'</a>')
                    htmlattr.on('click', openBlock);
                    $('.filter-attributes').append(htmlattr);
                    let htmlfilterblock = $('<div class="filter-block"></div>')
                    data.attrvalues.forEach(value => {
                        if (value['attribute_uid'] == attribute['uid']) {
                            let htmlattrval = $('<input type="checkbox" id="'+value['uid']+'" class="filter-checkbox" value="'+value['uid']+'" name="attrvalues[]"><label for="'+value['uid']+'" class="filter-button">'+value['name']+'</label>');
                            htmlfilterblock.append(htmlattrval);
                        }
                    });
                    $('.filter-attributes').append(htmlfilterblock);
                });
            }
        } else {
            data.attributes.forEach(attribute => {
                $('.filter-name').each(function() {
                    if ($(this).data('attribute') == attribute['uid']){
                        $(this).next().remove();
                        $(this).remove();
                    }
                });
            });
        }
    })
    .catch(error => {
        //console.error('Ошибка при применении фильтра:', error);
    });
}

//Применить фильтр
function applyFilter(){
    if ($('.filter-checkbox:checked').length > 0) $('#filter-attributes').submit();
}

//Сбросить фильтр
function resetFilter(){
    $('.filter-checkbox').each(function() {
        if ($(this).prop('checked') == true) {
            $(this).prop('checked', false);
            $(this).trigger('change ');
        }
    });
}
