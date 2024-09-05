$(document).ready(function () {
    $(".preloader").fadeOut();
    testgrafik();
});
 
function testgrafik() {
    var x = "";
    var base_url = window.location.origin;
    $.ajax({
        "url": base_url + '/pms_gut/public/Home/chartReporting/',
        type: "POST",
        data: "q=" + x,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            // chart
            var chart = AmCharts.makeChart("production-chart", {
                "type": "serial",
                "theme": "light",
                "marginTop": 0,
                "marginRight": 80,
                "dataProvider": data,
                "valueAxes": [{
                    "axisAlpha": 0,
                    "position": "left"
                }],
                "graphs": [{
                    "id": "g1",
                    "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span> Actual</b>",
                    "bullet": "round",
                    "bulletSize": 8,
                    "lineColor": "#ff0000",
                    "lineThickness": 2,
                    "negativeLineColor": "#ff0000",
                    "type": "smoothedLine",
                    "valueField": "value"
                }, {
                    "id": "g2",
                    "balloonText": "[[category]]<br><b><span style='font-size:14px;'>[[value]]</span> Plan</b>",
                    "bullet": "round",
                    "bulletSize": 8,
                    "lineColor": "#6699ff",
                    "lineThickness": 2,
                    "negativeLineColor": "#6699ff",
                    "type": "smoothedLine",
                    "valueField": "value2"
                }],
                "chartScrollbar": {
                    "graph": "g1",
                    "gridAlpha": 0,
                    "color": "#888888",
                    "scrollbarHeight": 55,
                    "backgroundAlpha": 0,
                    "selectedBackgroundAlpha": 0.1,
                    "selectedBackgroundColor": "#888888",
                    "graphFillAlpha": 0,
                    "autoGridCount": true,
                    "selectedGraphFillAlpha": 0,
                    "graphLineAlpha": 0.2,
                    "graphLineColor": "#c2c2c2",
                    "selectedGraphLineColor": "#888888",
                    "selectedGraphLineAlpha": 1

                },
                "chartCursor": {
                    "categoryBalloonDateFormat": "MMM DD, YYYY",
                    "cursorAlpha": 0,
                    "valueLineEnabled": true,
                    "valueLineBalloonEnabled": true,
                    "valueLineAlpha": 0.5,
                    "fullWidth": true
                },
                "dataDateFormat": "YYYY-MM-DD",
                "categoryField": "year",
                "categoryAxis": {
                    "minPeriod": "DD",
                    "parseDates": true,
                    "minorGridAlpha": 0.1,
                    "minorGridEnabled": true
                },
                "export": {
                    "enabled": true
                }
            });
            chart.addListener("rendered", zoomChart);
            if (chart.zoomChart) {
                chart.zoomChart();
            }

            function zoomChart() {
                chart.zoomToIndexes(Math.round(chart.dataProvider.length * 0.4), Math.round(chart.dataProvider.length * 0.55));
            }
             
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
           // toastr["error"](data.responseText);
          //  $(".preloader").fadeOut();
        }
    });
}