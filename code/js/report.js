function load_project_report(seg) {
    var proj_id = $('#proj_Filter').val();

    $.post("code/load_project_report.php", {key: proj_id, seg: seg}, function (data) {
        var incomplete = JSON.parse(data).incomplete;
        var complete = JSON.parse(data).complete;
//        alert(incomplete);
//        alert(complete);
        am4core.ready(function () {
// Themes begin
            am4core.useTheme(am4themes_animated);
// Themes end
            var chart = am4core.create("chartdiv", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
            chart.legend = new am4charts.Legend();
            chart.data = [
                {
                    Incomplete: "Incomplete",
                    Completed: incomplete,

                }, {
                    Incomplete: "Completed",
                    Completed: complete,

                }
            ];
            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "Completed";
            series.dataFields.category = "Incomplete";
//            series.ticks.template.disabled = true;
            series.labels.template.disabled = true;
            series.colors.list = [
                am4core.color("#f18032"),
                am4core.color("#5c9cd6"),
            ];
           
        }); // end am4core.ready()
    });
}
function load_weightage() {
    am4core.ready(function () {

// Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
        var chart = am4core.create("chartdiv2", am4charts.XYChart);

// Add data
        chart.data = [{
                "weightage": "weightage",
                "Contract to Ops": 5,
                "Ops to Tech.SPOC": 5,
                "CTO to Ops": 15,
                "Ops to SCM SPOC": 5,
                "Package Approval Initaited(SS)": 5,
                "SCM (LOI Generation)": 15,
                "PO Approval": 10,
                "Manuf. Clearance": 10,
                "Inspection": 10,
                "MDCC": 5,
                "Mtls received at site": 10,
                "MRN": 5,

            }];

        chart.legend = new am4charts.Legend();
        chart.legend.position = "bottom";

// Create axes
        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "weightage";
        categoryAxis.renderer.grid.template.opacity = 0;

        var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
        valueAxis.min = 0;
        valueAxis.renderer.grid.template.opacity = 0;
        valueAxis.renderer.ticks.template.strokeOpacity = 0.5;
        valueAxis.renderer.ticks.template.stroke = am4core.color("#495C43");
        valueAxis.renderer.ticks.template.length = 10;
        valueAxis.renderer.line.strokeOpacity = 0.5;
        valueAxis.renderer.baseGrid.disabled = true;
        valueAxis.renderer.minGridDistance = 40;

// Create series
        function createSeries(field, name) {
            var series = chart.series.push(new am4charts.ColumnSeries3D());

            series.dataFields.valueX = field;
            series.dataFields.categoryY = "weightage";
            series.stacked = true;
            series.name = name;

            var labelBullet = series.bullets.push(new am4charts.LabelBullet());
            labelBullet.locationX = 0.5;
            labelBullet.label.text = "{valueX}";
            labelBullet.label.fill = am4core.color("#fff");
        }

        createSeries("Contract to Ops", "Contract to Ops");
        createSeries("Ops to Tech.SPOC", "Ops to Tech.SPOC");
        createSeries("CTO to Ops", "CTO to Ops");
        createSeries("Ops to SCM SPOC", "Ops to SCM SPOC");
        createSeries("Package Approval Initaited(SS)", "Package Approval Initaited(SS)");
        createSeries("SCM (LOI Generation)", "SCM (LOI Generation)");
        createSeries("PO Approval", "PO Approval");
        createSeries("Manuf. Clearance", "Manuf. Clearance");
        createSeries("Inspection", "Inspection");
        createSeries("MDCC", "MDCC");
        createSeries("Mtls received at site", "Mtls received at site");
        createSeries("MRN", "MRN");

    }); // end am4core.ready()
}


