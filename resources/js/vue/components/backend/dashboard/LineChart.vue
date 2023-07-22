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
        data: {
            type: Array,
            default: [],
        },
        labels: {
            type: Array,
            default: [],
        }
    },
    mounted() {
        this.initChartJS();
    },
    methods: {
        initChartJS() {
            const canvas = document.getElementById(`chartjs-${this.uid}`);

            const ctx = document.getElementById(`chartjs-${this.uid}`).getContext("2d");
            const gradient = ctx.createLinearGradient(0, 0, 0, 225);
            gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
            gradient.addColorStop(1, "rgba(215, 227, 244, 0)");

            Chart.register(...registerables);

            new Chart(canvas, {
                type: "line",
                data: {
                    labels: this.labels,
                    datasets: [{
                        label: "Checks ",
                        fill: true,
                        tension: 0.4,
                        backgroundColor: gradient,
                        borderColor: '#3B7DDD',
                        data: this.data
                    }]
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
    }
}
</script>
