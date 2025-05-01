(function () {
    "use strict";

    // Chart
    if ($(".vertical-bar-chart").length) {
        const ctx = $(".vertical-bar-chart")[0].getContext("2d");
        
        // Get monthly sales data from a hidden input that will be added to the dashboard
        let monthlySalesData = [];
        if ($("#monthlySalesData").length) {
            monthlySalesData = JSON.parse($("#monthlySalesData").val());
        }
        
        // Use data from database or fallback to empty array if not available
        const chartData = monthlySalesData.length ? monthlySalesData : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        
        const verticalBarChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Okt",
                    "Nov",
                    "Des",
                ],
                datasets: [
                    {
                        label: "Penjualan",
                        barPercentage: 0.5,
                        barThickness: 20,
                        maxBarThickness: 80,
                        minBarLength: 20,
                        data: chartData,
                        backgroundColor: () => getColor("primary"),
                    },
                    // {
                    //     label: "Reseller",
                    //     barPercentage: 0.5,
                    //     barThickness: 6,
                    //     maxBarThickness: 8,
                    //     minBarLength: 2,
                    //     data: [0, 300, 400, 560, 320, 600, 720, 850, 300, 400, 560, 320],
                    //     backgroundColor: () =>
                    //         $("html").hasClass("dark")
                    //             ? getColor("darkmode.200")
                    //             : getColor("slate.300"),
                    // },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: getColor("slate.500", 0.8),
                        },
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: getColor("slate.500", 0.8),
                        },
                        grid: {
                            display: false,
                        },
                        border: {
                            display: false,
                        },
                    },
                    y: {
                        ticks: {
                            font: {
                                size: "12",
                            },
                            color: getColor("slate.500", 0.8),
                            callback: function (value, index, values) {
                                return value;
                            },
                        },
                        grid: {
                            color: () =>
                                $("html").hasClass("dark")
                                    ? getColor("slate.500", 0.3)
                                    : getColor("slate.300"),
                        },
                        border: {
                            dash: [2, 2],
                            display: false,
                        },
                    },
                },
            },
        });

        // Watch class name changes
        helper.watchClassNameChanges($("html")[0], (currentClassName) => {
            verticalBarChart.update();
        });
    }
})();
