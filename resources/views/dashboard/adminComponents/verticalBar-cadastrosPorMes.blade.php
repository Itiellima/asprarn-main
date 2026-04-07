<div class="container justify-content-center" style="width: 800px; height: 500px;">
    <canvas id="chartMes"></canvas>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = @json($labelsMes);
        const dataValores = @json($dadosMes);

        const dataMes = {
            labels: labels,
            datasets: [{
                label: 'Associados cadastrados por mês',
                data: dataValores,
                borderWidth: 1
            }]
        };

        const configMes = {
            type: 'bar',
            data: dataMes,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Cadastros por Mês no ano de {{ date('Y') }}'
                    }
                }
            }
        };

        new Chart(document.getElementById('chartMes'), configMes);
    </script>
@endpush
