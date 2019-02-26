<template>
    <canvas id="myLineChart" width="80" height="40"></canvas>
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

            var ctx = document.getElementById("myLineChart").getContext("2d");

            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {}
            });

        }
    }
</script>
