$(document).ready(function () {
    $(".preloader").fadeOut();
}); 

// grafik
async function goshowGrafik() {
    try
    {
        await showGrafikRekapBulan(); 
        await showGrafikHarian();  
    } catch (err) {
        toast(err, "error")
    }
}
function showGrafikRekapBulan() { 
    var Info_Date_Start = document.getElementById("Info_Date_Start").value; 
    const base_url = window.location.origin;
    $.ajax({
        "url": base_url + '/SIKBREC/public/GrafikKunjunganPasien/RekapBulan/',
        type: "POST",
        data:  "&Info_Date_Start=" + Info_Date_Start,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            am4core.ready(function () {
 
               // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end
 
                // Create chart instance
                var chart = am4core.create("chartdivjeniskelamin", am4charts.PieChart3D);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                chart.legend = new am4charts.Legend();
 
                // Add data
                chart.data = data;


                var series = chart.series.push(new am4charts.PieSeries3D());
                series.dataFields.value = "value";
                series.dataFields.category = "Gander";
  
                 
                // Enable export
                chart.exporting.menu = new am4core.ExportMenu();
            }); // end am4core.ready()
        },
        error: function (data) {
            // Welcome notification
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3500",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            } 
        }
    });
}
function showGrafikHarian() { 
    var Info_Date_Start = document.getElementById("Info_Date_Start").value; 
    const base_url = window.location.origin;
    $.ajax({
        "url": base_url + '/SIKBREC/public/GrafikKunjunganPasien/Harian/',
        type: "POST",
        data:  "&Info_Date_Start=" + Info_Date_Start,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            am4core.ready(function () {
 
                // Apply chart themes
                am4core.useTheme(am4themes_animated);
                am4core.useTheme(am4themes_kelly);

                // Create chart instance
                var chart = am4core.create("chartdivUsia", am4charts.XYChart);
               
                // Add data
                chart.data = data;

                                
                // Create axes
                var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "Usia";
                categoryAxis.title.text = "Jenis Pasien ( Baru/Lama )";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.minGridDistance = 20;

                var  valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis.title.text = "Total Pasien";

                // Create series
                var series = chart.series.push(new am4charts.ColumnSeries());
                series.dataFields.valueY = "pasienbaru";
                series.dataFields.categoryX = "Usia";
                series.name = "Pasien Baru";
                series.tooltipText = "{name}: [bold]{valueY}[/]";
                // This has no effect
                // series.stacked = true;

                var series2 = chart.series.push(new am4charts.ColumnSeries());
                series2.dataFields.valueY = "pasienlama";
                series2.dataFields.categoryX = "Usia";
                series2.name = "Pasien Lama";
                series2.tooltipText = "{name}: [bold]{valueY}[/]";
                // Do not try to stack on top of previous series
                // series2.stacked = true;
 

                // Add cursor
                chart.cursor = new am4charts.XYCursor();

                // Add legend
                chart.legend = new am4charts.Legend();

                 
                // Enable export
                chart.exporting.menu = new am4core.ExportMenu();
            }); // end am4core.ready()
        },
        error: function (data) {
            // Welcome notification
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3500",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            } 
        }
    });
} 

