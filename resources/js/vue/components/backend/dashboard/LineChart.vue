<template>
    <div class="card chart-card flex-fill w-100">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ title }}</h5>
        </div>
        <div class="card-body pt-2 pb-3">
            <div class="chart chart-sm">
                <canvas :id="'chartjs-'+uid"></canvas>
            </div>
        </div>
    </div>
</template>

<script>
import { Chart, registerables  } from "chart.js";

export default {
    props: {
        title: {
            type: String,
            default: '',
        },
        datasets: {
            type: Array,
            default: () => {
                return [];
            },
        },
        labels: {
            type: Array,
            default: () => {
                return [];
            },
        }
    },
    data: () => ({
        chart: null,
    }),
    mounted() {
        this.initChartJS();
    },
    methods: {
        initChartJS() {
            const canvas = document.getElementById(`chartjs-${this.uid}`);
            Chart.register(...registerables);

            this.chart = new Chart(canvas, {
                type: "line",
                data: {
                    labels: this.labels,
                    datasets: this.datasets,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    interaction: {
                        intersect: false,
                    },
                }
            });
        }
    },
    computed: {
        uid: function () {
            return this._uid;
        }
    },
    watch: {
        datasets: {
            handler() {
                this.chart.data.datasets = this.datasets;
                this.chart.update();
            },
            deep: true,
        },
    },
}
</script>
