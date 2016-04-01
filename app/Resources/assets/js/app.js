//Cache the loading wheel image
var loading =$('<img/>');
loading.attr('src', "/img/loader.gif");
loading.attr('width', 20);

/**
 * Disables elements with class 'onclick-disable' when they are clicked
 */
(function onclickDisable(){
    var $noSubmitElements = $('.onclick-disable[type!=submit]')
    var $submitElements = $('.onclick-disable[type=submit]')

    $noSubmitElements.on('click', function(e){
        var $target = $(e.target).closest('.onclick-disable')
        disableElement($target)
    })

    $submitElements.closest('form').submit(function(){
        var $ele =  $(this).find('.onclick-disable')
        disableElement($ele)
    })

    function disableElement($ele){
        $ele.empty()
        $ele.attr('disabled', true)
        $ele.append(loading.clone())
    }
})();

(function enterClickButton(){
    var $forms = $('.enter-click-button')
    $forms.keydown(function(e){
        if(e.keyCode === 13){
            $(e.target).closest('.enter-click-button').find('button').click()
            e.preventDefault()
        }
    })
})();

/**
 * Sort Table By Attribute
 * @param $table A Table jQuery element
 * @param {string} attr Attribute to be sorted by
 * @param {boolean} ascending True will sort ascending order
 */
function sortTableByAttribute($table, attr, ascending){
    var rows = $table.find('tbody  tr').get();

    rows.sort(function(a, b) {

        var A = $(a).attr(attr);
        var B = $(b).attr(attr);

        if(A < B) {
            return ascending ? -1 : 1;
        }

        if(A > B) {
            return ascending ? 1 : -1;
        }

        return 0;

    });

    $.each(rows, function(index, row) {
        $table.children('tbody').append(row);
    });
};

Date.prototype.getWeekNumber = function(){
    var d = new Date(+this);
    d.setHours(0,0,0);
    d.setDate(d.getDate()+4-(d.getDay()||7));
    return Math.ceil((((d-new Date(d.getFullYear(),0,1))/8.64e7)+1)/7);
};