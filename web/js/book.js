$(document).on('hidden.bs.modal', '.modal', function () {
    $(this).removeData('bs.modal');
});

$(function() {
    $('.book-delete').on('click', function(event){
        event.preventDefault();
        var self = $(this);
        $.getJSON(self.attr('href'))
            .done(function(data){
                if (data.result==true) {
                    self.parents('tr').remove();
                }
            });
    });
});