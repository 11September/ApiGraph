/*--------------  bar chart 08 amchart start ------------*/
if ($('#ambarchart1').length) {
    var chart = AmCharts.makeChart("ambarchart1", {
        "theme": "light",
        "type": "serial",
        "balloon": {
            "adjustBorderColor": false,
            "horizontalPadding": 10,
            "verticalPadding": 4,
            "color": "#fff"
        },
        "dataProvider": [{
            "country": "USA",
            "year2004": 3.5,
            "year2005": 4.2,
            "color": "#bfbffd",
            "color2": "#7474F0"
        }, {
            "country": "UK",
            "year2004": 1.7,
            "year2005": 3.1,
            "color": "#bfbffd",
            "color2": "#7474F0"
        }, {
            "country": "Canada",
            "year2004": 2.8,
            "year2005": 2.9,
            "color": "#bfbffd",
            "color2": "#7474F0"
        }, {
            "country": "Japan",
            "year2004": 2.6,
            "year2005": 2.3,
            "color": "#bfbffd",
            "color2": "#7474F0"
        }, {
            "country": "France",
            "year2004": 1.4,
            "year2005": 2.1,
            "color": "#bfbffd",
            "color2": "#7474F0"
        }, {
            "country": "Brazil",
            "year2004": 2.6,
            "year2005": 4.9,
            "color": "#bfbffd",
            "color2": "#7474F0"
        }],
        "valueAxes": [{
            "unit": "%",
            "position": "left",
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "GDP grow in [[category]] (2017): <b>[[value]]</b>",
            "fillAlphas": 0.9,
            "fillColorsField": "color",
            "lineAlpha": 0.2,
            "title": "2017",
            "type": "column",
            "valueField": "year2004"
        }, {
            "balloonText": "GDP grow in [[category]] (2018): <b>[[value]]</b>",
            "fillAlphas": 0.9,
            "fillColorsField": "color2",
            "lineAlpha": 0.2,
            "title": "2018",
            "type": "column",
            "clustered": false,
            "columnWidth": 0.5,
            "valueField": "year2005"
        }],
        "plotAreaFillAlphas": 0.1,
        "categoryField": "country",
        "categoryAxis": {
            "gridPosition": "start"
        },
        "export": {
            "enabled": false
        }

    });
}

/*--------------  bar chart 08 amchart END ------------*/
/*--------------  bar chart 09 amchart start ------------*/
if ($('#ambarchart2').length) {
    var chart = AmCharts.makeChart("ambarchart2", {
        "type": "serial",
        "addClassNames": true,
        "theme": "light",
        "autoMargins": false,
        "marginLeft": 30,
        "marginRight": 8,
        "marginTop": 10,
        "marginBottom": 26,
        "balloon": {
            "adjustBorderColor": false,
            "horizontalPadding": 10,
            "verticalPadding": 8,
            "color": "#ffffff"
        },

        "dataProvider": [{
            "year": 2013,
            "income": 23.5,
            "expenses": 21.1,
            "color": "#7474f0"
        }, {
            "year": 2014,
            "income": 26.2,
            "expenses": 30.5,
            "color": "#7474f0"
        }, {
            "year": 2015,
            "income": 30.1,
            "expenses": 28.4,
            "color": "#7474f0"
        }, {
            "year": 2016,
            "income": 29.5,
            "expenses": 31.1,
            "color": "#7474f0"
        }, {
            "year": 2017,
            "income": 30.6,
            "expenses": 28.2,
            "dashLengthLine": 5,
            "color": "#7474f0"
        }, {
            "year": 2018,
            "income": 34.1,
            "expenses": 32.9,
            "dashLengthColumn": 5,
            // "alpha": 0.2,
            "additional": "(projection)",
            "color": "#f0171f"
        }],
        "valueAxes": [{
            "axisAlpha": 0,
            "position": "left"
        }],
        "startDuration": 1,
        "graphs": [{
            "alphaField": "alpha",
            "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
            "fillAlphas": 1,
            "fillColorsField": "color",
            "title": "Income",
            "type": "column",
            "valueField": "income",
            "dashLengthField": "dashLengthColumn"
        }, {
            "id": "graph2",
            "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
            "bullet": "round",
            "lineThickness": 3,
            "bulletSize": 7,
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "lineColor": "#AA59FE",
            "useLineColorForBulletBorder": true,
            "bulletBorderThickness": 3,
            "fillAlphas": 0,
            "lineAlpha": 1,
            "title": "Expenses",
            "valueField": "expenses",
            "dashLengthField": "dashLengthLine"
        }],
        "categoryField": "year",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "tickLength": 0
        },
        "export": {
            "enabled": false
        }
    });
}

/*--------------  bar chart 09 amchart END ------------*/
/*--------------  bar chart 10 amchart start ------------*/
if ($('#ambarchart3').length) {
    var chart = AmCharts.makeChart("ambarchart3", {
        "type": "serial",
        "theme": "light",
        "categoryField": "year",
        "rotate": true,
        "startDuration": 1,
        "categoryAxis": {
            "gridPosition": "start",
            "position": "left"
        },
        "trendLines": [],
        "graphs": [{
                "balloonText": "Income:[[value]]",
                "fillAlphas": 0.8,
                "id": "AmGraph-1",
                "lineAlpha": 0.2,
                "title": "Income",
                "type": "column",
                "valueField": "income",
                "fillColorsField": "color"
            },
            {
                "balloonText": "Expenses:[[value]]",
                "fillAlphas": 0.8,
                "id": "AmGraph-2",
                "lineAlpha": 0.2,
                "title": "Expenses",
                "type": "column",
                "valueField": "expenses",
                "fillColorsField": "color2"
            }
        ],
        "guides": [],
        "valueAxes": [{
            "id": "ValueAxis-1",
            "position": "top",
            "axisAlpha": 0
        }],
        "allLabels": [],
        "balloon": {},
        "titles": [],
        "dataProvider": [{
                "year": 2014,
                "income": 23.5,
                "expenses": 18.1,
                "color": "#7474f0",
                "color2": "#C5C5FD"
            },
            {
                "year": 2015,
                "income": 26.2,
                "expenses": 22.8,
                "color": "#7474f0",
                "color2": "#C5C5FD"
            },
            {
                "year": 2016,
                "income": 30.1,
                "expenses": 23.9,
                "color": "#7474f0",
                "color2": "#C5C5FD"
            },
            {
                "year": 2017,
                "income": 29.5,
                "expenses": 25.1,
                "color": "#7474f0",
                "color2": "#C5C5FD"
            },
            {
                "year": 2018,
                "income": 24.6,
                "expenses": 25,
                "color": "#7474f0",
                "color2": "#C5C5FD"
            }
        ],
        "export": {
            "enabled": false
        }

    });
}
