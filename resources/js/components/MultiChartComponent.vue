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
            console.log('Component mounted.');
            let data = {
                labels: this.labels,
                datasets: [{
                    label: "Número de usuarios por tienda",
                    data: this.values
                }],
            };
            this.values.forEach(function(element){
                data.datasets[0].data.push({0:element[0], 1:element[1]});
            });
            console.log(JSON.stringify(data.datasets[0].data));
            //
            // backgroundColor: ['#4187ed', '#999999'],
            //     borderWidth: 0
            var ctx = document.getElementById("myLineChart").getContext("2d");

            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {}
            });

        }
    }
</script>
