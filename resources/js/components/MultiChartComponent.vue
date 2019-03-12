<template>
    <canvas :id="chartId" width="500" height="200"></canvas>
</template>

<script>
    import Chart from 'chart.js';

    export default {
        props: ['values', 'labels', 'chartId', 'dataLabel'],
        created() {
        //
        },
        mounted() {
            console.log('Component mounted.');
            let data = {
                labels: this.labels,
                datasets: [{
                    label: this.dataLabel,
                    data: this.values
                }],
            };
            this.values.forEach(function(element){
                data.datasets[0].data.push({0:element[0], 1:element[1]});
            });
            //
            // backgroundColor: ['#4187ed', '#999999'],
            //     borderWidth: 0
            var ctx = document.getElementById(this.chartId).getContext("2d");

            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {}
            });

        }
    }
</script>
