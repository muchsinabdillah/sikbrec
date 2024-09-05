
$(document).ready(function () {
    console.log("ok")
    $(".preloader").fadeOut();

    /*
    am4core.ready(function () {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv", am4charts.XYChart);

        // Add data
        chart.data = [{
            "category": "Research & Development",
            "value": 3.5
        }, {
            "category": "Marketing",
            "value": 6
        }, {
            "category": "Distribution",
            "value": 6.5
        }];
        
        // Create axes
        let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "category";
        
        let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        
        // Create series
        var series = chart.series.push(new am4charts.ColumnSeries());
        series.dataFields.valueY = "value";
        series.dataFields.categoryX = "category";
        series.name = "Sales";

        //return false;

        // Add data
        //chart.data = data;
        

        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        //dateAxis.renderer.grid.template.location = 0;
        //dateAxis.renderer.minGridDistance = 30;

        // line pinggir
        var valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis1.title.text = "Aktual"; 

        var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis2.title.text = "Plan";
        valueAxis2.renderer.opposite = true;
        valueAxis2.renderer.grid.template.disabled = true;

        // Create series
        var series1 = chart.series.push(new am4charts.ColumnSeries());
        series1.dataFields.valueY = "market1";
        series1.dataFields.dateX = "date";
        series1.yAxis = valueAxis1;
        series1.name = "Aktual";
        series1.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
        series1.fill = chart.colors.getIndex(0);
        series1.strokeWidth = 0;
        series1.clustered = false;
        series1.columns.template.width = am4core.percent(40);
        series1.columns.template.stroke = am4core.color("#f59842"); // red outline
        series1.columns.template.fill = am4core.color("#f59842"); // green fill

        var series2 = chart.series.push(new am4charts.ColumnSeries());
        series2.dataFields.valueY = "market2";
        series2.dataFields.dateX = "date";
        series2.yAxis = valueAxis1;
        series2.name = "Plan";
        series2.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
        series2.fill = chart.colors.getIndex(0).lighten(0.5);
        series2.strokeWidth = 0;
        series2.clustered = false;
        series2.toBack();
        series2.columns.template.stroke = am4core.color("#eff542"); // red outline
        series2.columns.template.fill = am4core.color("#eff542"); // green fill

        var series3 = chart.series.push(new am4charts.LineSeries());
        series3.dataFields.valueY = "sales1";
        series3.dataFields.dateX = "date";
        series3.name = "Cum Aktual";
        series3.strokeWidth = 2;
        series3.tensionX = 0.7;
        series3.yAxis = valueAxis2;
        series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
        series3.stroke = am4core.color("#f5429c"); // red outline
        series3.fill = am4core.color("#f5429c"); // red outline
       // series3.stroke = am4core.color("#ff0000"); // red

        var bullet3 = series3.bullets.push(new am4charts.CircleBullet());
        bullet3.circle.radius = 3;
        bullet3.circle.strokeWidth = 2;
        bullet3.circle.fill = am4core.color("#fff");

        var series4 = chart.series.push(new am4charts.LineSeries());
        series4.dataFields.valueY = "sales2";
        series4.dataFields.dateX = "date";
        series4.name = "Cum Plan";
        series4.strokeWidth = 2;
        series4.tensionX = 0.7;
        series4.yAxis = valueAxis2;
        series4.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
        series4.stroke = chart.colors.getIndex(0).lighten(0.5);
        series4.strokeDasharray = "3,3";
        series4.stroke = am4core.color("#42a4f5"); // red outline 
        series4.fill = am4core.color("#42a4f5"); // red outline

        var bullet4 = series4.bullets.push(new am4charts.CircleBullet());
        bullet4.circle.radius = 3;
        bullet4.circle.strokeWidth = 2;
        bullet4.circle.fill = am4core.color("#fff");

        // Add cursor
        chart.cursor = new am4charts.XYCursor();

        // Add legend
        chart.legend = new am4charts.Legend();
        chart.legend.position = "top";
        series1.legendSettings.itemValueText = "[bold]{valueY}[/bold]";
        // Add scrollbar
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series1);
        chart.scrollbarX.series.push(series3);
        chart.scrollbarX.parent = chart.bottomAxesContainer;


        // Enable export
        chart.exporting.menu = new am4core.ExportMenu();
    }); // end am4core.ready()
    */

    //getLokasi();
    //testgrafik();
    document.getElementById("CD_currentMonth").innerHTML = "Current Daily";
    document.getElementById("CI_currentMonth").innerHTML = "Current Daily";
    document.getElementById("PD_currentMonth").innerHTML = "Current Daily";
    document.getElementById("PI_currentMonth").innerHTML = "Current Daily";
    document.getElementById("MI_currentMonth").innerHTML = "Current Daily";
    document.getElementById("MD_currentMonth").innerHTML = "Current Daily";

    document.getElementById("CD_PrevMonth").innerHTML = "Previous Daily";
    document.getElementById("CI_PrevMonth").innerHTML = "Previous Daily";
    document.getElementById("PD_PrevMonth").innerHTML = "Previous Daily";
    document.getElementById("PI_PrevMonth").innerHTML = "Previous Daily";
    document.getElementById("MI_PrevMonth").innerHTML = "Previous Daily";
    document.getElementById("MD_PrevMonth").innerHTML = "Previous Daily";

    document.getElementById("CD_NextMonth").innerHTML = "Upcoming Daily";
    document.getElementById("CI_NextMonth").innerHTML = "Upcoming Daily";
    document.getElementById("PD_NextMonth").innerHTML = "Upcoming Daily";
    document.getElementById("PI_NextMonth").innerHTML = "Upcoming Daily";
    document.getElementById("MI_NextMonth").innerHTML = "Upcoming Daily";
    document.getElementById("MD_NextMonth").innerHTML = "Upcoming Daily";
});
async function goshowGrafik() {
    try {
        await ShowGrafikPoliBPJS(); 
        // await showGrafikCostInDirect();
        // await showGrafikProgressDirect();
        // await showGrafikProgressInDirect();
        // await showGrafikMHDirect();
        // await showGrafikMHInDirect();
        // await showTabelCostDirect();
        // await showTabelCostInDirect();
        // await showTabelProgDirect();
        // await showTabelProgInDirect();
        // await  showTabelMHDirect();
        // await showTabelMHInDirect();
         
    } catch (err) {
        toast(err, "error")
    }
}
function toast(data, status) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
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
    toastr[status](data);
}
function pad2(n) {
    return (n < 10 ? '0' : '') + n;
}
function HeaderTable() {
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    if (Dashboard_tipeRekap == "DR") { // daily
        const date = new Date();
        var month = pad2(date.getMonth() + 1);//months (0-11)
        var day = pad2(date.getDate());//day (1-31)
        var day2 = pad2(date.getDate() - 1);//day (1-31)
        var day3 = pad2(date.getDate() + 1);//day (1-31)
        var year = date.getFullYear();

        var formattedDate = day + "/" + month + "/" + year;
        var formattedDate2 = day2 + "/" + month + "/" + year;
        var formattedDate3 = day3 + "/" + month + "/" + year;

        document.getElementById("CD_currentMonth").innerHTML = "Current Day";
        document.getElementById("CI_currentMonth").innerHTML = "Current Day";
        document.getElementById("PD_currentMonth").innerHTML = "Current Day";
        document.getElementById("PI_currentMonth").innerHTML = "Current Day";
        document.getElementById("MI_currentMonth").innerHTML = "Current Day";
        document.getElementById("MD_currentMonth").innerHTML = "Current Day";

        document.getElementById("CD_PrevMonth").innerHTML = "Previous Day";
        document.getElementById("CI_PrevMonth").innerHTML = "Previous Day";
        document.getElementById("PD_PrevMonth").innerHTML = "Previous Day";
        document.getElementById("PI_PrevMonth").innerHTML = "Previous Day";
        document.getElementById("MI_PrevMonth").innerHTML = "Previous Day";
        document.getElementById("MD_PrevMonth").innerHTML = "Previous Day";

        document.getElementById("CD_PrevPeriode1").innerHTML = formattedDate2;
        document.getElementById("CD_PrevPeriode2").innerHTML = formattedDate;
        document.getElementById("CD_PrevPeriode3").innerHTML = formattedDate3;
        document.getElementById("CI_CurrentPeriode1").innerHTML = formattedDate2;
        document.getElementById("CI_CurrentPeriode2").innerHTML = formattedDate;
        document.getElementById("CI_CurrentPeriode3").innerHTML = formattedDate3;
        document.getElementById("PD_CurrentPeriode1").innerHTML = formattedDate2;
        document.getElementById("PD_CurrentPeriode2").innerHTML = formattedDate;
        document.getElementById("PD_CurrentPeriode3").innerHTML = formattedDate3;
        document.getElementById("PI_CurrentPeriode1").innerHTML = formattedDate2;
        document.getElementById("PI_CurrentPeriode2").innerHTML = formattedDate;
        document.getElementById("PI_CurrentPeriode3").innerHTML = formattedDate3;
        document.getElementById("MI_CurrentPeriode1").innerHTML = formattedDate2;
        document.getElementById("MI_CurrentPeriode2").innerHTML = formattedDate;
        document.getElementById("MI_CurrentPeriode3").innerHTML = formattedDate3;
        document.getElementById("MD_CurrentPeriode1").innerHTML = formattedDate2;
        document.getElementById("MD_CurrentPeriode2").innerHTML = formattedDate;
        document.getElementById("MD_CurrentPeriode3").innerHTML = formattedDate3;

        document.getElementById("CD_NextMonth").innerHTML = "Upcoming Day";
        document.getElementById("CI_NextMonth").innerHTML = "Upcoming Day";
        document.getElementById("PD_NextMonth").innerHTML = "Upcoming Day";
        document.getElementById("PI_NextMonth").innerHTML = "Upcoming Day";
        document.getElementById("MI_NextMonth").innerHTML = "Upcoming Day";
        document.getElementById("MD_NextMonth").innerHTML = "Upcoming Day";

    } else if (Dashboard_tipeRekap == "WR") { // week
        // Javascript Cari Week

        var base_url = window.location.origin;
        var start_week = "0";
        var Info_Date_Start_Project = $("#Info_Date_Start_Project").val();
        var Info_Date_End_Project = $("#Info_Date_End_Project").val();
        var START_WEEK = $("#START_WEEK").val();
        $.ajax({
            data: "start_week=" + start_week + "&Info_Date_Start_Project=" 
                    + Info_Date_Start_Project + "&Info_Date_End_Project=" + Info_Date_End_Project
                + "&START_WEEK=" + START_WEEK,
            "url": base_url + '/pms_gut/public/JobOrder/GetWeeklys/',
            type: "POST",
            cache: false,
            dataType: "JSON",
            success: function (data) {
                //$("#vrfWbs_idWBS").val(data.ID_WBS);
                var WeekPrevNumber = data.WEEK_PROJECT-1;
                var WeekCurrentNumber = data.WEEK_PROJECT;
                var WeekUpcomingNumber = parseInt(data.WEEK_PROJECT)+1;
                var weekdaysStartCurrent = data.tgl_start;
                var weekdaysEndCurrent = data.tgl_end;
                var daysPlus1 = 1;
                var daysPlus8 = 7;
                var daysMin1 = 1;
                var daysMin8 = 7;

                document.getElementById("CD_currentMonth").innerHTML = "Current Week " + WeekCurrentNumber;
                document.getElementById("CI_currentMonth").innerHTML = "Current Week " + WeekCurrentNumber;
                document.getElementById("PD_currentMonth").innerHTML = "Current Week " + WeekCurrentNumber;
                document.getElementById("PI_currentMonth").innerHTML = "Current Week " + WeekCurrentNumber;
                document.getElementById("MI_currentMonth").innerHTML = "Current Week " + WeekCurrentNumber;
                document.getElementById("MD_currentMonth").innerHTML = "Current Week " + WeekCurrentNumber;
                document.getElementById("CD_PrevMonth").innerHTML = "Previous Week " + WeekPrevNumber;
                document.getElementById("CI_PrevMonth").innerHTML = "Previous Week " + WeekPrevNumber;
                document.getElementById("PD_PrevMonth").innerHTML = "Previous Week " + WeekPrevNumber;
                document.getElementById("PI_PrevMonth").innerHTML = "Previous Week " + WeekPrevNumber;
                document.getElementById("MI_PrevMonth").innerHTML = "Previous Week " + WeekPrevNumber;
                document.getElementById("MD_PrevMonth").innerHTML = "Previous Week " + WeekPrevNumber;
                document.getElementById("CD_NextMonth").innerHTML = "Upcoming Week " + WeekUpcomingNumber;
                document.getElementById("CI_NextMonth").innerHTML = "Upcoming Week " + WeekUpcomingNumber;
                document.getElementById("PD_NextMonth").innerHTML = "Upcoming Week " + WeekUpcomingNumber;
                document.getElementById("PI_NextMonth").innerHTML = "Upcoming Week " + WeekUpcomingNumber;
                document.getElementById("MI_NextMonth").innerHTML = "Upcoming Week " + WeekUpcomingNumber;
                document.getElementById("MD_NextMonth").innerHTML = "Upcoming Week " + WeekUpcomingNumber;

                //prev
                
                var resultDayMinSeverEnd = new Date(new Date(weekdaysStartCurrent).setDate(new Date(weekdaysStartCurrent).getDate() - daysMin1));
                var resultDayMinSeverStart = new Date(new Date(resultDayMinSeverEnd).setDate(new Date(resultDayMinSeverEnd).getDate() - daysMin8));
                var resultDayMinSeverStart_1 = pad2(resultDayMinSeverStart.getDate()) + "/" + pad2(resultDayMinSeverStart.getMonth()+1) + "/" + pad2(resultDayMinSeverStart.getFullYear());
                var resultDayMinSeverStart_2 = pad2(resultDayMinSeverEnd.getDate()) + "/" + pad2(resultDayMinSeverEnd.getMonth()+1) + "/" + pad2(resultDayMinSeverEnd.getFullYear());

                var fullPeriodePrevious = resultDayMinSeverStart_1 + " - " + resultDayMinSeverStart_2;

                // current
                var resultDayCurentSeverStart = new Date(new Date(weekdaysStartCurrent).setDate(new Date(weekdaysStartCurrent).getDate()));
                var resultDayCurentSeverEnd = new Date(new Date(weekdaysEndCurrent).setDate(new Date(weekdaysEndCurrent).getDate()));
                var resultDaySeverStart_1 = pad2(resultDayCurentSeverStart.getDate()) + "/" + pad2(resultDayCurentSeverStart.getMonth()+1) + "/" + pad2(resultDayCurentSeverStart.getFullYear());
                var resultDaySeverStart_2 = pad2(resultDayCurentSeverEnd.getDate()) + "/" + pad2(resultDayCurentSeverEnd.getMonth()+1) + "/" + pad2(resultDayCurentSeverEnd.getFullYear());
                var fullPeriodeCurrent = resultDaySeverStart_1 + " - " + resultDaySeverStart_2;



                // Upcoming
                var resultDayPlusSeverStart = new Date(new Date(weekdaysEndCurrent).setDate(new Date(weekdaysEndCurrent).getDate() + daysPlus1));
                var resultDayPlusSeverEnd = new Date(new Date(weekdaysEndCurrent).setDate(new Date(weekdaysEndCurrent).getDate() + daysPlus8));
                var resultDayPlusSeverStart_1 = pad2(resultDayPlusSeverStart.getDate()) + "/" + pad2(resultDayPlusSeverStart.getMonth()+1) + "/" + pad2(resultDayPlusSeverStart.getFullYear());
                var resultDayPlusSeverStart_2 = pad2(resultDayPlusSeverEnd.getDate()) + "/" + pad2(resultDayPlusSeverEnd.getMonth()+1) + "/" + pad2(resultDayPlusSeverEnd.getFullYear());
                var fullPeriodeUpcoming = resultDayPlusSeverStart_1 + " - " + resultDayPlusSeverStart_2;




                document.getElementById("CD_PrevPeriode1").innerHTML = fullPeriodePrevious;
                document.getElementById("CD_PrevPeriode2").innerHTML = fullPeriodeCurrent;
                document.getElementById("CD_PrevPeriode3").innerHTML = fullPeriodeUpcoming;
                document.getElementById("CI_CurrentPeriode1").innerHTML = fullPeriodePrevious;
                document.getElementById("CI_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
                document.getElementById("CI_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
                document.getElementById("PD_CurrentPeriode1").innerHTML = fullPeriodePrevious;
                document.getElementById("PD_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
                document.getElementById("PD_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
                document.getElementById("PI_CurrentPeriode1").innerHTML = fullPeriodePrevious;
                document.getElementById("PI_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
                document.getElementById("PI_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
                document.getElementById("MI_CurrentPeriode1").innerHTML = fullPeriodePrevious;
                document.getElementById("MI_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
                document.getElementById("MI_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
                document.getElementById("MD_CurrentPeriode1").innerHTML = fullPeriodePrevious;
                document.getElementById("MD_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
                document.getElementById("MD_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
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
                toastr["error"](data.responseText);
                $(".preloader").fadeOut();
            }
        });
    } else if (Dashboard_tipeRekap == "MR") { //bulan
        const d = new Date();
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        document.getElementById("CD_currentMonth").innerHTML = "Current " + months[d.getMonth()];
        document.getElementById("CI_currentMonth").innerHTML = "Current " + months[d.getMonth()];
        document.getElementById("PD_currentMonth").innerHTML = "Current " + months[d.getMonth()];
        document.getElementById("PI_currentMonth").innerHTML = "Current " + months[d.getMonth()];
        document.getElementById("MI_currentMonth").innerHTML = "Current " + months[d.getMonth()];
        document.getElementById("MD_currentMonth").innerHTML = "Current " + months[d.getMonth()];
        var getMonthNow = d.getMonth();
        var getYear = d.getFullYear();
        var getMonthNewPlus = parseInt(d.getMonth()) + 1;
        var getMonthNewMinus = parseInt(d.getMonth()) - 1; 
        var days = function (month, year) {
            return new Date(year, month, 0).getDate();
        };

        // cari jumlah hari
        var getMonthNowS = days(getMonthNow + 1, getYear);
        var getDaysInMonthPlus = days(getMonthNewPlus + 1, getYear);
        var getDaysInMonthMinus = days(getMonthNewMinus+1, getYear);

        var fullPeriodePrevious = "01" + "/" + pad2(getMonthNewMinus+1) + "/" + getYear + " - " + getDaysInMonthPlus  + "/" + pad2(getMonthNewMinus+1) + "/" + getYear;
        var fullPeriodeCurrent = "01" + "/" + pad2(getMonthNow + 1) + "/" + getYear + " - " + getMonthNowS + "/" + pad2(getMonthNow + 1) + "/" + getYear;
        var fullPeriodeUpcoming = "01" + "/" + pad2(getMonthNewPlus + 1) + "/" + getYear + " - " + getDaysInMonthMinus + "/" + pad2(getMonthNewPlus + 1) + "/" + getYear;
        document.getElementById("CD_PrevMonth").innerHTML = "Previous " + months[getMonthNewMinus];
        document.getElementById("CI_PrevMonth").innerHTML = "Previous " + months[getMonthNewMinus];
        document.getElementById("PD_PrevMonth").innerHTML = "Previous " + months[getMonthNewMinus];
        document.getElementById("PI_PrevMonth").innerHTML = "Previous " + months[getMonthNewMinus];
        document.getElementById("MI_PrevMonth").innerHTML = "Previous " + months[getMonthNewMinus];
        document.getElementById("MD_PrevMonth").innerHTML = "Previous " + months[getMonthNewMinus];

        document.getElementById("CD_NextMonth").innerHTML = "Upcoming " + months[getMonthNewPlus];
        document.getElementById("CI_NextMonth").innerHTML = "Upcoming " + months[getMonthNewPlus];
        document.getElementById("PD_NextMonth").innerHTML = "Upcoming " + months[getMonthNewPlus];
        document.getElementById("PI_NextMonth").innerHTML = "Upcoming " + months[getMonthNewPlus];
        document.getElementById("MI_NextMonth").innerHTML = "Upcoming " + months[getMonthNewPlus];
        document.getElementById("MD_NextMonth").innerHTML = "Upcoming " + months[getMonthNewPlus];


        document.getElementById("CD_PrevPeriode1").innerHTML = fullPeriodePrevious;
        document.getElementById("CD_PrevPeriode2").innerHTML = fullPeriodeCurrent;
        document.getElementById("CD_PrevPeriode3").innerHTML = fullPeriodeUpcoming;
        document.getElementById("CI_CurrentPeriode1").innerHTML = fullPeriodePrevious;
        document.getElementById("CI_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
        document.getElementById("CI_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
        document.getElementById("PD_CurrentPeriode1").innerHTML = fullPeriodePrevious;
        document.getElementById("PD_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
        document.getElementById("PD_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
        document.getElementById("PI_CurrentPeriode1").innerHTML = fullPeriodePrevious;
        document.getElementById("PI_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
        document.getElementById("PI_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
        document.getElementById("MI_CurrentPeriode1").innerHTML = fullPeriodePrevious;
        document.getElementById("MI_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
        document.getElementById("MI_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
        document.getElementById("MD_CurrentPeriode1").innerHTML = fullPeriodePrevious;
        document.getElementById("MD_CurrentPeriode2").innerHTML = fullPeriodeCurrent;
        document.getElementById("MD_CurrentPeriode3").innerHTML = fullPeriodeUpcoming;
    }
}
function ShowGrafikPoliBPJS() {
     $(".preloader").fadeIn();
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var base_url = window.location.origin;
    $.ajax({
        "url": base_url + '/SIKBREC/public/bInformationGrafik/ShowGrafikPoliBPJS',
        type: "POST",
        data: "Info_Date_Start=" + Info_Date_Start + "&Info_Date_End=" + Info_Date_End ,
        cache: false,
        dataType: "JSON",
        success: function (data) {

            datatemp = []
            for (i = 0; i < data.length; i++) {
            datatemp.push(data[i])
            }
            //return false

            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end
        
                // Create chart instance
                var chart = am4core.create("chartdiv", am4charts.XYChart);

                
        
                // Add data
                chart.data = datatemp

                // chart.data = [{
                //     "category": "Research & Development",
                //     "value": 3.5
                // }, {
                //     "category": "Marketing",
                //     "value": 6
                // }, {
                //     "category": "Distribution",
                //     "value": 6.5
                // }];
                
                // Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "NamaUnit";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.tooltip.disabled = true;
categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "Jumlah";
series.dataFields.categoryX = "NamaUnit";
series.columns.template.strokeWidth = 0;
series.columns.template.column.fillOpacity = 0.8;
series.columns.template.column.propertyFields.fill = "color";

// Set up tooltip
series.columns.template.tooltipText = "[{categoryX}: bold]{valueY}[/]";
series.tooltip.getFillFromObject = false;
series.tooltip.label.propertyFields.fill = "color";
series.tooltip.background.propertyFields.stroke = "color";
            });
            
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
    
    $(".preloader").fadeOut();
} 
function showGrafikCostInDirect() {
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $.ajax({
        "url": base_url + '/pms_gut/public/Home/chartshowGrafikCostIndirect/',
        type: "POST",
        data: "Dashboard_tipeRekap=" + Dashboard_tipeRekap + "&Dashboard_tipeGrafik=" + Dashboard_tipeGrafik
            + "&Info_Date_Start=" + Info_Date_Start
            + "&Info_Date_End=" + Info_Date_End
            + "&Info_KodeJo1=" + Info_KodeJo1,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("chartdiv2", am4charts.XYChart);

                // Add data
                chart.data = data;

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                //dateAxis.renderer.grid.template.location = 0;
                //dateAxis.renderer.minGridDistance = 30;

                var valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis1.title.text = "Aktual";

                var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis2.title.text = "Plan";
                valueAxis2.renderer.opposite = true;
                valueAxis2.renderer.grid.template.disabled = true;

                // Create series
                var series1 = chart.series.push(new am4charts.ColumnSeries());
                series1.dataFields.valueY = "market1";
                series1.dataFields.dateX = "date";
                series1.yAxis = valueAxis1;
                series1.name = "Aktual";
                series1.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series1.fill = chart.colors.getIndex(0);
                series1.strokeWidth = 0;
                series1.clustered = false;
                series1.columns.template.width = am4core.percent(40);
                series1.columns.template.stroke = am4core.color("#f59842"); // red outline
                series1.columns.template.fill = am4core.color("#f59842"); // green fill

                var series2 = chart.series.push(new am4charts.ColumnSeries());
                series2.dataFields.valueY = "market2";
                series2.dataFields.dateX = "date";
                series2.yAxis = valueAxis1;
                series2.name = "Plan";
                series2.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series2.fill = chart.colors.getIndex(0).lighten(0.5);
                series2.strokeWidth = 0;
                series2.clustered = false;
                series2.toBack();
                series2.columns.template.stroke = am4core.color("#eff542"); // red outline
                series2.columns.template.fill = am4core.color("#eff542"); // green fill
                

                var series3 = chart.series.push(new am4charts.LineSeries());
                series3.dataFields.valueY = "sales1";
                series3.dataFields.dateX = "date";
                series3.name = "Cum Aktual";
                series3.strokeWidth = 2;
                series3.tensionX = 0.7;
                series3.yAxis = valueAxis2;
                series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series3.stroke = am4core.color("#f5429c"); // red outline
                series3.fill = am4core.color("#f5429c"); // red outline
              

                var bullet3 = series3.bullets.push(new am4charts.CircleBullet());
                bullet3.circle.radius = 3;
                bullet3.circle.strokeWidth = 2;
                bullet3.circle.fill = am4core.color("#fff");

                var series4 = chart.series.push(new am4charts.LineSeries());
                series4.dataFields.valueY = "sales2";
                series4.dataFields.dateX = "date";
                series4.name = "Cum Plan";
                series4.strokeWidth = 2;
                series4.tensionX = 0.7;
                series4.yAxis = valueAxis2;
                series4.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series4.stroke = chart.colors.getIndex(0).lighten(0.5);
                series4.strokeDasharray = "3,3";
                series4.stroke = am4core.color("#42a4f5"); // red outline 
                series4.fill = am4core.color("#42a4f5"); // red outline

                var bullet4 = series4.bullets.push(new am4charts.CircleBullet());
                bullet4.circle.radius = 3;
                bullet4.circle.strokeWidth = 2;
                bullet4.circle.fill = am4core.color("#fff");

                // Add cursor
                chart.cursor = new am4charts.XYCursor();

                // Add legend
                chart.legend = new am4charts.Legend();
                chart.legend.position = "top";

                // Add scrollbar
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series1);
                chart.scrollbarX.series.push(series3);
                chart.scrollbarX.parent = chart.bottomAxesContainer;


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
            // toastr["error"](data.responseText);
            //  $(".preloader").fadeOut();
        }
    });
}
function getLokasi() {
    var xdi = "1";
    var base_url = window.location.origin;
    $.ajax({
        type: "GET",
        data: "kode_prop=" + xdi,
        url: base_url + '/pms_gut/public/UploadPlan/getLokasiJoByHakUser',
        dataType: "json",
        success: function (data) {
            console.log(data.dataJoAll.length);
            var newRow = '<option value=""></option';
            $("#Info_KodeJo1").append(newRow);
            $("#Info_KodeJo2").append(newRow);
            $("#Info_KodeJo3").append(newRow);
            $("#Info_KodeJo4").append(newRow);
            for (i = 0; i < data.dataJoAll.length; i++) {
                var newRow = '<option value="' + data.dataJoAll[i].ID_Data + '">' + data.dataJoAll[i].ID_Data + ' - ' + data.dataJoAll[i].NM_PROJECT + '</option';
                $("#Info_KodeJo1").append(newRow);
                $("#Info_KodeJo2").append(newRow);
                $("#Info_KodeJo3").append(newRow);
                $("#Info_KodeJo4").append(newRow);
            }
            $('.js-example-basic-single').select2();
        }, error: function (data) {
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
            toastr["error"](data.responseText);
        }
    });
}
function showTabelCostDirect() {
    $(".preloader").fadeIn();
    var base_url = window.location.origin;
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $('#tbl_grafik_cost_direct').DataTable().clear().destroy();
    $('#tbl_grafik_cost_direct').DataTable({
        "searching": false,
        "bInfo": false,
        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Home/showTabelCostDirect/',
            "type": "POST",
            data: function (d) {
                d.Dashboard_tipeRekap = Dashboard_tipeRekap;
                d.Dashboard_tipeGrafik = Dashboard_tipeGrafik;
                d.Info_KodeJo1 = Info_KodeJo1;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [
 
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KET + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.PREV) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.CURRENT) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.UPCOMING) + '</font> ';
                    return html
                }
            },
             
        ] 
    });
}
function showTabelCostInDirect() {
    var base_url = window.location.origin;
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $('#tbl_grafik_cost_indirect').DataTable().clear().destroy();
    $('#tbl_grafik_cost_indirect').DataTable({
        "searching": false,
        "bInfo": false,
        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Home/showTabelCostInDirect/',
            "type": "POST",
            data: function (d) {
                d.Dashboard_tipeRekap = Dashboard_tipeRekap;
                d.Dashboard_tipeGrafik = Dashboard_tipeGrafik;
                d.Info_KodeJo1 = Info_KodeJo1;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
            },
            "dataSrc": "", 
            "deferRender": true,
        }, 
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KET + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.PREV) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.CURRENT) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.UPCOMING) + '</font> ';
                    return html
                }
            },

        ] 
         
    });
}



function showGrafikProgressDirect() {
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $.ajax({
        "url": base_url + '/pms_gut/public/Home/chartshowGrafikProgress/',
        type: "POST",
        data: "Dashboard_tipeRekap=" + Dashboard_tipeRekap + "&Dashboard_tipeGrafik=" + Dashboard_tipeGrafik
            + "&Info_Date_Start=" + Info_Date_Start
            + "&Info_Date_End=" + Info_Date_End
            + "&Info_KodeJo1=" + Info_KodeJo1,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("chartdivProgDI", am4charts.XYChart);

                // Add data
                chart.data = data;

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                //dateAxis.renderer.grid.template.location = 0;
                //dateAxis.renderer.minGridDistance = 30;

                var valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis1.title.text = "Aktual";

                var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis2.title.text = "Plan";
                valueAxis2.renderer.opposite = true;
                valueAxis2.renderer.grid.template.disabled = true;

                // Create series
                var series1 = chart.series.push(new am4charts.ColumnSeries());
                series1.dataFields.valueY = "market1";
                series1.dataFields.dateX = "date";
                series1.yAxis = valueAxis1;
                series1.name = "Aktual";
                series1.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series1.fill = chart.colors.getIndex(0);
                series1.strokeWidth = 0;
                series1.clustered = false;
                series1.columns.template.width = am4core.percent(40);
                series1.columns.template.stroke = am4core.color("#f59842"); // red outline
                series1.columns.template.fill = am4core.color("#f59842"); // green fill

                var series2 = chart.series.push(new am4charts.ColumnSeries());
                series2.dataFields.valueY = "market2";
                series2.dataFields.dateX = "date";
                series2.yAxis = valueAxis1;
                series2.name = "Plan";
                series2.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series2.fill = chart.colors.getIndex(0).lighten(0.5);
                series2.strokeWidth = 0;
                series2.clustered = false;
                series2.toBack();
                series2.columns.template.stroke = am4core.color("#eff542"); // red outline
                series2.columns.template.fill = am4core.color("#eff542"); // green fill

                var series3 = chart.series.push(new am4charts.LineSeries());
                series3.dataFields.valueY = "sales1";
                series3.dataFields.dateX = "date";
                series3.name = "Cum Aktual";
                series3.strokeWidth = 2;
                series3.tensionX = 0.7;
                series3.yAxis = valueAxis2;
                series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";

                var bullet3 = series3.bullets.push(new am4charts.CircleBullet());
                bullet3.circle.radius = 3;
                bullet3.circle.strokeWidth = 2;
                bullet3.circle.fill = am4core.color("#fff");
                series3.stroke = am4core.color("#f5429c"); // red outline
                series3.fill = am4core.color("#f5429c"); // red outline

                var series4 = chart.series.push(new am4charts.LineSeries());
                series4.dataFields.valueY = "sales2";
                series4.dataFields.dateX = "date";
                series4.name = "Cum Plan";
                series4.strokeWidth = 2;
                series4.tensionX = 0.7;
                series4.yAxis = valueAxis2;
                series4.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series4.stroke = chart.colors.getIndex(0).lighten(0.5);
                series4.strokeDasharray = "3,3";
                series4.stroke = am4core.color("#42a4f5"); // red outline 
                series4.fill = am4core.color("#42a4f5"); // red outline

                var bullet4 = series4.bullets.push(new am4charts.CircleBullet());
                bullet4.circle.radius = 3;
                bullet4.circle.strokeWidth = 2;
                bullet4.circle.fill = am4core.color("#fff");

                // Add cursor
                chart.cursor = new am4charts.XYCursor();

                // Add legend
                chart.legend = new am4charts.Legend();
                chart.legend.position = "top";

                // Add scrollbar
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series1);
                chart.scrollbarX.series.push(series3);
                chart.scrollbarX.parent = chart.bottomAxesContainer;


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
            // toastr["error"](data.responseText);
            //  $(".preloader").fadeOut();
        }
    });
}
function showGrafikProgressInDirect() {
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $.ajax({
        "url": base_url + '/pms_gut/public/Home/chartshowGrafikProgressIndirect/',
        type: "POST",
        data: "Dashboard_tipeRekap=" + Dashboard_tipeRekap + "&Dashboard_tipeGrafik=" + Dashboard_tipeGrafik
            + "&Info_Date_Start=" + Info_Date_Start
            + "&Info_Date_End=" + Info_Date_End
            + "&Info_KodeJo1=" + Info_KodeJo1,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("chartdivProgIN", am4charts.XYChart);

                // Add data
                chart.data = data;

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                //dateAxis.renderer.grid.template.location = 0;
                //dateAxis.renderer.minGridDistance = 30;

                var valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis1.title.text = "Aktual";

                var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis2.title.text = "Plan";
                valueAxis2.renderer.opposite = true;
                valueAxis2.renderer.grid.template.disabled = true;

                // Create series
                var series1 = chart.series.push(new am4charts.ColumnSeries());
                series1.dataFields.valueY = "market1";
                series1.dataFields.dateX = "date";
                series1.yAxis = valueAxis1;
                series1.name = "Aktual";
                series1.tooltipText = "{name}\n[bold font-size: 20]{valueY}M[/]";
                series1.fill = chart.colors.getIndex(0);
                series1.strokeWidth = 0;
                series1.clustered = false;
                series1.columns.template.width = am4core.percent(40);
                series1.columns.template.stroke = am4core.color("#f59842"); // red outline
                series1.columns.template.fill = am4core.color("#f59842"); // green fill

                var series2 = chart.series.push(new am4charts.ColumnSeries());
                series2.dataFields.valueY = "market2";
                series2.dataFields.dateX = "date";
                series2.yAxis = valueAxis1;
                series2.name = "Plan";
                series2.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series2.fill = chart.colors.getIndex(0).lighten(0.5);
                series2.strokeWidth = 0;
                series2.clustered = false;
                series2.toBack();
                series2.columns.template.stroke = am4core.color("#eff542"); // red outline
                series2.columns.template.fill = am4core.color("#eff542"); // green fill

                var series3 = chart.series.push(new am4charts.LineSeries());
                series3.dataFields.valueY = "sales1";
                series3.dataFields.dateX = "date";
                series3.name = "Cum Aktual";
                series3.strokeWidth = 2;
                series3.tensionX = 0.7;
                series3.yAxis = valueAxis2;
                series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series3.stroke = am4core.color("#f5429c"); // red outline
                series3.fill = am4core.color("#f5429c"); // red outline

                var bullet3 = series3.bullets.push(new am4charts.CircleBullet());
                bullet3.circle.radius = 3;
                bullet3.circle.strokeWidth = 2;
                bullet3.circle.fill = am4core.color("#fff");

                var series4 = chart.series.push(new am4charts.LineSeries());
                series4.dataFields.valueY = "sales2";
                series4.dataFields.dateX = "date";
                series4.name = "Cum Plan";
                series4.strokeWidth = 2;
                series4.tensionX = 0.7;
                series4.yAxis = valueAxis2;
                series4.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series4.stroke = chart.colors.getIndex(0).lighten(0.5);
                series4.strokeDasharray = "3,3";
                series4.stroke = am4core.color("#42a4f5"); // red outline 
                series4.fill = am4core.color("#42a4f5"); // red outline

                var bullet4 = series4.bullets.push(new am4charts.CircleBullet());
                bullet4.circle.radius = 3;
                bullet4.circle.strokeWidth = 2;
                bullet4.circle.fill = am4core.color("#fff");

                // Add cursor
                chart.cursor = new am4charts.XYCursor();

                // Add legend
                chart.legend = new am4charts.Legend();
                chart.legend.position = "top";

                // Add scrollbar
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series1);
                chart.scrollbarX.series.push(series3);
                chart.scrollbarX.parent = chart.bottomAxesContainer;


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
            // toastr["error"](data.responseText);
            //  $(".preloader").fadeOut();
        }
    });
}

function showTabelProgDirect() {
    var base_url = window.location.origin;
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $('#tbl_grafik_prog_direct').DataTable().clear().destroy();
    $('#tbl_grafik_prog_direct').DataTable({
        "searching": false,
        "bInfo": false,
        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Home/showTabelProgDirect/',
            "type": "POST",
            data: function (d) {
                d.Dashboard_tipeRekap = Dashboard_tipeRekap;
                d.Dashboard_tipeGrafik = Dashboard_tipeGrafik;
                d.Info_KodeJo1 = Info_KodeJo1;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KET + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.PREV) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.CURRENT) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.UPCOMING) + '</font> ';
                    return html
                }
            },

        ] 
    });
}
function showTabelProgInDirect() {
    var base_url = window.location.origin;
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $('#tbl_grafik_prog_indirect').DataTable().clear().destroy();
    $('#tbl_grafik_prog_indirect').DataTable({
        "searching": false,
        "bInfo": false,
        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Home/showTabelProgInDirect/',
            "type": "POST",
            data: function (d) {
                d.Dashboard_tipeRekap = Dashboard_tipeRekap;
                d.Dashboard_tipeGrafik = Dashboard_tipeGrafik;
                d.Info_KodeJo1 = Info_KodeJo1;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KET + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.PREV) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.CURRENT) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.UPCOMING) + '</font> ';
                    return html
                }
            },

        ] 
    });
}


function showGrafikMHDirect() {
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $.ajax({
        "url": base_url + '/pms_gut/public/Home/chartshowGrafikMH/',
        type: "POST",
        data: "Dashboard_tipeRekap=" + Dashboard_tipeRekap + "&Dashboard_tipeGrafik=" + Dashboard_tipeGrafik
            + "&Info_Date_Start=" + Info_Date_Start
            + "&Info_Date_End=" + Info_Date_End
            + "&Info_KodeJo1=" + Info_KodeJo1,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("chartdivmhDI", am4charts.XYChart);

                // Add data
                chart.data = data;

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                //dateAxis.renderer.grid.template.location = 0;
                //dateAxis.renderer.minGridDistance = 30;

                var valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis1.title.text = "Aktual";

                var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis2.title.text = "Plan";
                valueAxis2.renderer.opposite = true;
                valueAxis2.renderer.grid.template.disabled = true;

                // Create series
                var series1 = chart.series.push(new am4charts.ColumnSeries());
                series1.dataFields.valueY = "market1";
                series1.dataFields.dateX = "date";
                series1.yAxis = valueAxis1;
                series1.name = "Aktual";
                series1.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series1.fill = chart.colors.getIndex(0);
                series1.strokeWidth = 0;
                series1.clustered = false;
                series1.columns.template.width = am4core.percent(40);
                series1.columns.template.stroke = am4core.color("#f59842"); // red outline
                series1.columns.template.fill = am4core.color("#f59842"); // green fill

                var series2 = chart.series.push(new am4charts.ColumnSeries());
                series2.dataFields.valueY = "market2";
                series2.dataFields.dateX = "date";
                series2.yAxis = valueAxis1;
                series2.name = "Plan";
                series2.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series2.fill = chart.colors.getIndex(0).lighten(0.5);
                series2.strokeWidth = 0;
                series2.clustered = false;
                series2.toBack();
                series2.columns.template.stroke = am4core.color("#eff542"); // red outline
                series2.columns.template.fill = am4core.color("#eff542"); // green fill

                var series3 = chart.series.push(new am4charts.LineSeries());
                series3.dataFields.valueY = "sales1";
                series3.dataFields.dateX = "date";
                series3.name = "Cum Aktual";
                series3.strokeWidth = 2;
                series3.tensionX = 0.7;
                series3.yAxis = valueAxis2;
                series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series3.stroke = am4core.color("#f5429c"); // red outline
                series3.fill = am4core.color("#f5429c"); // red outline

                var bullet3 = series3.bullets.push(new am4charts.CircleBullet());
                bullet3.circle.radius = 3;
                bullet3.circle.strokeWidth = 2;
                bullet3.circle.fill = am4core.color("#fff");

                var series4 = chart.series.push(new am4charts.LineSeries());
                series4.dataFields.valueY = "sales2";
                series4.dataFields.dateX = "date";
                series4.name = "Cum Plan";
                series4.strokeWidth = 2;
                series4.tensionX = 0.7;
                series4.yAxis = valueAxis2;
                series4.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series4.stroke = chart.colors.getIndex(0).lighten(0.5);
                series4.strokeDasharray = "3,3";
                series4.stroke = am4core.color("#42a4f5"); // red outline 
                series4.fill = am4core.color("#42a4f5"); // red outline

                var bullet4 = series4.bullets.push(new am4charts.CircleBullet());
                bullet4.circle.radius = 3;
                bullet4.circle.strokeWidth = 2;
                bullet4.circle.fill = am4core.color("#fff");

                // Add cursor
                chart.cursor = new am4charts.XYCursor();

                // Add legend
                chart.legend = new am4charts.Legend();
                chart.legend.position = "top";

                // Add scrollbar
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series1);
                chart.scrollbarX.series.push(series3);
                chart.scrollbarX.parent = chart.bottomAxesContainer;


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
            // toastr["error"](data.responseText);
            //  $(".preloader").fadeOut();
        }
    });
}
function showGrafikMHInDirect() {
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $.ajax({
        "url": base_url + '/pms_gut/public/Home/chartshowGrafikMHIndirect/',
        type: "POST",
        data: "Dashboard_tipeRekap=" + Dashboard_tipeRekap + "&Dashboard_tipeGrafik=" + Dashboard_tipeGrafik
            + "&Info_Date_Start=" + Info_Date_Start
            + "&Info_Date_End=" + Info_Date_End
            + "&Info_KodeJo1=" + Info_KodeJo1,
        cache: false,
        dataType: "JSON",
        success: function (data) {
            am4core.ready(function () {

                // Themes begin
                am4core.useTheme(am4themes_animated);
                // Themes end

                // Create chart instance
                var chart = am4core.create("chartdivmhIN", am4charts.XYChart);

                // Add data
                chart.data = data;

                // Create axes
                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                //dateAxis.renderer.grid.template.location = 0;
                //dateAxis.renderer.minGridDistance = 30;

                var valueAxis1 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis1.title.text = "Aktual";

                var valueAxis2 = chart.yAxes.push(new am4charts.ValueAxis());
                valueAxis2.title.text = "Plan";
                valueAxis2.renderer.opposite = true;
                valueAxis2.renderer.grid.template.disabled = true;

                // Create series
                var series1 = chart.series.push(new am4charts.ColumnSeries());
                series1.dataFields.valueY = "market1";
                series1.dataFields.dateX = "date";
                series1.yAxis = valueAxis1;
                series1.name = "Aktual";
                series1.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series1.fill = chart.colors.getIndex(0);
                series1.strokeWidth = 0;
                series1.clustered = false;
                series1.columns.template.width = am4core.percent(40);
                series1.columns.template.stroke = am4core.color("#f59842"); // red outline
                series1.columns.template.fill = am4core.color("#f59842"); // green fill

                var series2 = chart.series.push(new am4charts.ColumnSeries());
                series2.dataFields.valueY = "market2";
                series2.dataFields.dateX = "date";
                series2.yAxis = valueAxis1;
                series2.name = "Plan";
                series2.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series2.fill = chart.colors.getIndex(0).lighten(0.5);
                series2.strokeWidth = 0;
                series2.clustered = false;
                series2.toBack();
                series2.columns.template.stroke = am4core.color("#eff542"); // red outline
                series2.columns.template.fill = am4core.color("#eff542"); // green fill

                var series3 = chart.series.push(new am4charts.LineSeries());
                series3.dataFields.valueY = "sales1";
                series3.dataFields.dateX = "date";
                series3.name = "Cum Aktual";
                series3.strokeWidth = 2;
                series3.tensionX = 0.7;
                series3.yAxis = valueAxis2;
                series3.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series3.stroke = am4core.color("#f5429c"); // red outline
                series3.fill = am4core.color("#f5429c"); // red outline

                var bullet3 = series3.bullets.push(new am4charts.CircleBullet());
                bullet3.circle.radius = 3;
                bullet3.circle.strokeWidth = 2;
                bullet3.circle.fill = am4core.color("#fff");

                var series4 = chart.series.push(new am4charts.LineSeries());
                series4.dataFields.valueY = "sales2";
                series4.dataFields.dateX = "date";
                series4.name = "Cum Plan";
                series4.strokeWidth = 2;
                series4.tensionX = 0.7;
                series4.yAxis = valueAxis2;
                series4.tooltipText = "{name}\n[bold font-size: 20]{valueY}[/]";
                series4.stroke = chart.colors.getIndex(0).lighten(0.5);
                series4.strokeDasharray = "3,3";
                series4.stroke = am4core.color("#42a4f5"); // red outline 
                series4.fill = am4core.color("#42a4f5"); // red outline

                var bullet4 = series4.bullets.push(new am4charts.CircleBullet());
                bullet4.circle.radius = 3;
                bullet4.circle.strokeWidth = 2;
                bullet4.circle.fill = am4core.color("#fff");

                // Add cursor
                chart.cursor = new am4charts.XYCursor();

                // Add legend
                chart.legend = new am4charts.Legend();
                chart.legend.position = "top";
                

                // Add scrollbar
                chart.scrollbarX = new am4charts.XYChartScrollbar();
                chart.scrollbarX.series.push(series1);
                chart.scrollbarX.series.push(series3);
                chart.scrollbarX.parent = chart.bottomAxesContainer;


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
            // toastr["error"](data.responseText);
             $(".preloader").fadeOut();
        }
    });
    $(".preloader").fadeOut();
}

function showTabelMHDirect() {
    var base_url = window.location.origin;
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $('#tbl_grafik_mh_direct').DataTable().clear().destroy();
    $('#tbl_grafik_mh_direct').DataTable({
        "searching": false,
        "bInfo": false,
        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Home/showTabelMHDirect/',
            "type": "POST",
            data: function (d) {
                d.Dashboard_tipeRekap = Dashboard_tipeRekap;
                d.Dashboard_tipeGrafik = Dashboard_tipeGrafik;
                d.Info_KodeJo1 = Info_KodeJo1;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KET + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.PREV) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.CURRENT) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.UPCOMING) + '</font> ';
                    return html
                }
            },

        ] 
    });
}
function showTabelMHInDirect() {
    var base_url = window.location.origin;
    var Dashboard_tipeRekap = document.getElementById("Dashboard_tipeRekap").value;
    var Dashboard_tipeGrafik = document.getElementById("Dashboard_tipeGrafik").value;
    var Info_Date_Start = document.getElementById("Info_Date_Start").value;
    var Info_Date_End = document.getElementById("Info_Date_End").value;
    var Info_KodeJo1 = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $('#tbl_grafik_mh_indirect').DataTable().clear().destroy();
    $('#tbl_grafik_mh_indirect').DataTable({
        "searching": false,
        "bInfo": false,
        "paging": false,
        "order": [[1, 'asc']], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": base_url + '/pms_gut/public/Home/showTabelMHInDirect/',
            "type": "POST",
            data: function (d) {
                d.Dashboard_tipeRekap = Dashboard_tipeRekap;
                d.Dashboard_tipeGrafik = Dashboard_tipeGrafik;
                d.Info_KodeJo1 = Info_KodeJo1;
                d.Info_Date_Start = Info_Date_Start;
                d.Info_Date_End = Info_Date_End;
            },
            "dataSrc": "",
            "deferRender": true,
        },
        "columns": [

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + row.KET + '</font> ';
                    return html
                }
            },

            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.PREV) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.CURRENT) + '</font> ';
                    return html
                }
            },
            {
                "render": function (data, type, row) { // Tampilkan kolom aksi
                    var html = ""
                    var html = '<font size="2"> ' + number_to_price(row.UPCOMING) + '</font> ';
                    return html
                }
            },

        ] 
    });
    $(".preloader").fadeOut();
}


function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "" + rupiah : ",00";
}
function number_to_price(v) {
    if (v == 0) { return '0,00'; }
    v = parseFloat(v);
    v = v.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
    v = v.split('.').join('*').split(',').join('.').split('*').join(',');
    return v;
}
function price_to_number(v) {
    if (!v) { return 0; }
    v = v.split('.').join('');
    v = v.split(',').join('.');
    return Number(v.replace(/[^0-9.]/g, ""));
}
function getMoubyIDJO() {
    var xdi = document.getElementById("Info_KodeJo1").value;
    var base_url = window.location.origin;
    $.ajax({
        url: base_url + '/pms_gut/public/LogBook/getMoubyIDAktifbyJO/',
        method: "POST",
        data: "xdi=" + xdi,
        dataType: "JSON",
        beforeSend: function () {

        },
        success: function (data) {

            $("#Info_NamaProject").val(data.NM_CLIENT);
            $("#Info_Date_Start_Project").val(data.DATE_START);
            $("#Info_Date_End_Project").val(data.DATE_END);
            $("#START_WEEK").val(data.START_WEEK);

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
            toastr["error"](data.responseText);
        }
    });
}