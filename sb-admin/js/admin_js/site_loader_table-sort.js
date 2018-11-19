
  /* Drag and Drop rows */
  $('table tbody').sortable({
         update: function (event, ui) {
             $(this).children().each(function (index) {
                  if ($(this).attr('data-position') != (index+1)) {
                      $(this).attr('data-position', (index+1)).addClass('updated');
                  }
             });

             saveNewPositions();
         }
   });

  function saveNewPositions() {
      var positions = [];
      $('.updated').each(function () {
         positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
         $(this).removeClass('updated');
      });

      $.ajax({
         url:  dir_path+'site_table_sort/update_positions/site_weekly_ads_placed',
         method: 'POST',
         dataType: 'text',
         data: {
             update: 1,
             positions: positions
         }, success: function (response) {
              console.log(response);
         }
      });
  }
