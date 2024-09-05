$(function () {
    "use strict";

    // chart
    var chart = AmCharts.makeChart("production-chart", {
        "type": "serial",
        "theme": "light",
        "marginTop": 0,
        "marginRight": 80,
        "dataProvider": [{
            "year": "1950",
            "value": -0.307,
            "value2": -0.5,
        }, {
            "year": "1951",
            "value": -0.168,
            "value2": -0.2,
        }, {
            "year": "1952",
            "value": -0.073,
            "value2": -0.2,
        }],
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
            "categoryBalloonDateFormat": "YYYY",
            "cursorAlpha": 0,
            "valueLineEnabled": true,
            "valueLineBalloonEnabled": true,
            "valueLineAlpha": 0.5,
            "fullWidth": true
        },
        "dataDateFormat": "YYYY",
        "categoryField": "year",
        "categoryAxis": {
            "minPeriod": "YYYY",
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
});
