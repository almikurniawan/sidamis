<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>

<div class="card card-primary">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="card-title mb-4">
                    Dashboard
                </h1>
                <hr />
            </div>
        </div>
        <?= $search_miskin?>
        <div class="row">
            <div class="col-lg-12">
                    <div id="chart"></div>
                    <script>
                        function createChart() {
                            $("#chart").kendoChart({
                                title: {
                                    text: "Statistik Kemiskinan RUTA, ART, KK"
                                },
                                legend: {
                                    position: "bottom"
                                },
                                chartArea: {
                                    background: ""
                                },
                                seriesDefaults: {
                                    type: "column",
                                    style: "smooth"
                                },
                                series: <?= json_encode($data_resume_miskin['series'])?>,
                                valueAxis: {
                                    line: {
                                        visible: false
                                    },
                                    axisCrossingValue: 0
                                },
                                categoryAxis: {
                                    categories: <?= json_encode($data_resume_miskin['categories'])?>,
                                    majorGridLines: {
                                        visible: false
                                    },
                                    labels: {
                                        rotation: "auto"
                                    }
                                },
                                tooltip: {
                                    visible: true,
                                    format: "",
                                    template: "#= series.name #: #= value #"
                                }
                            });
                        }

                        $(document).ready(createChart);
                    </script>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="chart_miskin" style="width: 100%; height: 500px;"></div>
                <script>
                    function createChart() {
                        $("#chart_miskin").kendoChart({
                            title: {
                                text: "Statistik Kemiskinan"
                            },
                            legend: {
                                position: "bottom"
                            },
                            chartArea: {
                                background: ""
                            },
                            seriesDefaults: {
                                type: "column",
                                style: "smooth"
                            },
                            series: <?= json_encode($data_miskin['series'])?>,
                            valueAxis: {
                                labels: {
                                    format: "{0}"
                                },
                                line: {
                                    visible: false
                                },
                                axisCrossingValue: -10
                            },
                            categoryAxis: {
                                categories: <?= json_encode($data_miskin['categories'])?>,
                                majorGridLines: {
                                    visible: false
                                },
                                labels: {
                                    rotation: "auto"
                                }
                            },
                            tooltip: {
                                visible: true,
                                format: "{0}%",
                                template: "#= series.name #: #= value #"
                            }
                        });
                    }

                    $(document).ready(createChart);
                    // $(document).bind("kendo:skinChange", createChart);
                </script>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="chart_disabilitas" style="width: 100%; height: 500px;"></div>
                <script>
                    function createChart() {
                        $("#chart_disabilitas").kendoChart({
                            title: {
                                text: "Statistik Disabilitas"
                            },
                            legend: {
                                position: "bottom"
                            },
                            chartArea: {
                                background: ""
                            },
                            seriesDefaults: {
                                type: "column",
                                style: "smooth"
                            },
                            series: <?= json_encode($data_disabilitas['series'])?>,
                            valueAxis: {
                                labels: {
                                    format: "{0}"
                                },
                                line: {
                                    visible: false
                                },
                                axisCrossingValue: -10
                            },
                            categoryAxis: {
                                categories: <?= json_encode($data_disabilitas['categories'])?>,
                                majorGridLines: {
                                    visible: false
                                },
                                labels: {
                                    rotation: "auto"
                                }
                            },
                            tooltip: {
                                visible: true,
                                format: "{0}%",
                                template: "#= series.name #: #= value #"
                            }
                        });
                    }

                    $(document).ready(createChart);
                    // $(document).bind("kendo:skinChange", createChart);
                </script>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="chart_penyakit" style="width: 100%; height: 500px;"></div>
                <script>
                    function createChart() {
                        $("#chart_penyakit").kendoChart({
                            title: {
                                text: "Statistik Penyakit Kronis"
                            },
                            legend: {
                                position: "bottom"
                            },
                            chartArea: {
                                background: ""
                            },
                            seriesDefaults: {
                                type: "column",
                                style: "smooth"
                            },
                            series: <?= json_encode($data_penyakit['series'])?>,
                            valueAxis: {
                                labels: {
                                    format: "{0}"
                                },
                                line: {
                                    visible: false
                                },
                                axisCrossingValue: -10
                            },
                            categoryAxis: {
                                categories: <?= json_encode($data_penyakit['categories'])?>,
                                majorGridLines: {
                                    visible: false
                                },
                                labels: {
                                    rotation: "auto"
                                }
                            },
                            tooltip: {
                                visible: true,
                                format: "{0}%",
                                template: "#= series.name #: #= value #"
                            }
                        });
                    }

                    $(document).ready(createChart);
                    // $(document).bind("kendo:skinChange", createChart);
                </script>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>