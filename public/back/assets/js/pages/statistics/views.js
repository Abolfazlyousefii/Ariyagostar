$(window).on('load', function () {
    $('.statistics-period li').on('click', function () {
        if ($(this).hasClass('active')) {
            return;
        }

        $(this).closest('.statistics-period').find('li').removeClass('active');
        $(this).addClass('active');

        let chartId = $(this).closest('.tab-pane').find('.chart-area').attr('id');
        prepareChart('#' + chartId);
    });

    $('#statistics-card .persian_date_picker ').on('change', function () {
        let chartId = $(this).closest('.tab-pane').find('.chart-area').attr('id');
        prepareChart('#' + chartId);
    });

    $('#statistics-card a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        let href = $(this).attr('href');

        if ($(href).find('.statistics-period .nav-link.active').length) {
            return;
        }

        let period = $(href).find('.statistics-period').data('default-period');

        $(href)
            .find('[data-period="' + period + '"]')
            .trigger('click');
    });

    $('#statistics-card .nav-tabs li').first().find('a').trigger('click');
});

function prepareChart(chartId) {
    let period = $(chartId).closest('.tab-pane').find('.statistics-period .nav-link.active').data('period');
    let from_date = $(chartId).closest('.tab-pane').find('[name="from_date"]').val();
    let to_date = $(chartId).closest('.tab-pane').find('[name="to_date"]').val();

    $.ajax({
        url: $(chartId).data('action'),
        type: 'GET',
        data: {
            period: period,
            from_date: from_date,
            to_date: to_date
        },
        success: function (data) {
            if (data.status != 'success') {
                return;
            }

            let meta = data.meta;
            data = data.data;

            categories = [];
            let total = [];

            for (const [key, value] of Object.entries(data)) {
                categories.push(value.chart_category);
                total.push(value.total);
            }

            let series = [
                {
                    name: 'بازدید',
                    data: total
                }
            ];

            renderChart(chartId, series, categories);

            switch (chartId) {
                case '#view-counts-chart': {
                    $(chartId).closest('.tab-pane').find('.views-total').text(meta.total);
                    $(chartId).closest('.tab-pane').find('.views-avg').text(meta.avg);
                    break;
                }
                case '#viewer-counts-chart': {
                    $(chartId).closest('.tab-pane').find('.viewers-total').text(meta.total);
                    $(chartId).closest('.tab-pane').find('.viewers-avg').text(meta.avg);
                    break;
                }
            }
        },
        beforeSend: function (xhr) {
            block($(chartId).closest('.tab-pane'));
        },
        complete: function () {
            unblock($(chartId).closest('.tab-pane'));
        }
    });
}

function renderChart(chartId, series, categories) {
    let options = {
        series: series,
        chart: {
            type: 'bar',
            height: 430,
            fontFamily: APP_FONT_FAMILY,
            stacked: true,
            toolbar: {
                show: true
            },
            events: {
                mounted: (chartContext, config) => {
                    setTimeout(() => {
                        addAnnotations(chartContext, config);
                    });
                },
                updated: (chartContext, config) => {
                    setTimeout(() => {
                        addAnnotations(chartContext, config);
                    });
                }
            }
        },
        stroke: {
            with: 1
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    legend: {
                        position: 'bottom',
                        offsetX: -10,
                        offsetY: 0
                    }
                }
            }
        ],
        plotOptions: {
            bar: {
                dataLabels: {position: 'top'},
                horizontal: false,
                borderRadius: 2
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            type: 'category',
            categories: categories
        },
        yaxis: {
            labels: {
                formatter: (value) => {
                    return abbreviateNumber(value);
                }
            }
        },
        colors: ['#008ffb', '#ff4560'],
        legend: {
            position: 'bottom',
            offsetY: 0
        },
        fill: {
            opacity: 1
        }
    };

    if ($(chartId).data('rendered')) {
        $(chartId).data('rendered').destroy();
        $(chartId).css('min-height', $(chartId).data('min-height'));
    }

    let chart = new ApexCharts(document.querySelector(chartId), options);

    chart.render();

    $(chartId).data('rendered', chart);
}

$('.persian_date_picker').customPersianDate();

const addAnnotations = (chart, config) => {
    const seriesTotals = config.globals.stackedSeriesTotals;
    const isHorizontal = config.config.plotOptions.bar.horizontal;
    chart.clearAnnotations();

    try {
        categories.forEach((category, index) => {
            if (seriesTotals[index]) {
                chart.addPointAnnotation(
                    {
                        y: isHorizontal ? calcHorizontalY(config, index, categories) : seriesTotals[index],
                        x: isHorizontal ? 0 : category,
                        label: {
                            text: `${abbreviateNumber(seriesTotals[index])}`,
                            borderWidth: 0,
                            style: {
                                fontWeight: 900,
                                background: 'transparent'
                            }
                        },
                        marker: {
                            size: 0
                        }
                    },
                    false
                );
            }
        });
    } catch (error) {
        console.log(`Add point annotation error: ${error.message}`);
    }
};

const calcHorizontalY = (config, index, categories) => {
    const catLength = categories.length;
    const yRange = config.globals.yRange[0];
    const minY = config.globals.minY;
    const halfBarHeight = yRange / catLength / 2;

    return minY + halfBarHeight + 2 * halfBarHeight * (catLength - 1 - index);
};
