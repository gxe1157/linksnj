
/* Site Search ajax / mysql  */

$(document).ready(function() {
    $('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get('../search', { query: query }, function (data) {
               console.log(data);
               data = $.parseJSON(data);
               return process(data);
            });
        }
    });

} );
