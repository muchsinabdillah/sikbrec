$(document).ready(function(){
    $("#caridata").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableitempemeriksaan tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });