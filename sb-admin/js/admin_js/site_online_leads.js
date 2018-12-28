
$(document).ready(function() {

    $('#select_lead_status').val( $('#selected_status').val() );

    $('#select_lead_status').on('change', function(){
      let sel_opt = this.value;
      window.location.replace("https://linksnj.com/site_online_leads/manage_admin/"+sel_opt);      
    });
});

