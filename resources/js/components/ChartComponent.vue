<template>
    <canvas id="myChart" width="400" height="220"></canvas>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        props: ['values', 'labels'],
        created() {
        //
        },
        mounted() {
            console.log('Component mounted.')
            let data = {
                datasets: [{
                    data: this.values,
                    backgroundColor: ['#4187ed', '#999999'],
                    borderWidth: 0
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: this.labels
            };

            var ctx = document.getElementById("myChart").getContext("2d");
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
