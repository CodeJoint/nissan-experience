<template>
    <canvas :id="chartId" width="80" height="40"></canvas>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        props: ['values', 'labels', 'chartId'],
        created() {
        //
        },
        mounted() {

            let data = {
                datasets: [{
                    data: this.values,
                    backgroundColor: ['#4187ed', '#999999'],
                    borderWidth: 0
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: this.labels
            };

            var ctx = document.getElementById(this.chartId).getContext("2d");
            var myDoughnutChart = new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    'rotation': -1 * Math.PI,
                    'circumference': 1 * Math.PI,
                    'legend': {
                        'display': false
                    }
                }
            });
        }
    }
</script>
