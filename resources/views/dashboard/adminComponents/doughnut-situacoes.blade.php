    <div class="container justify-content-center" style="width: 500px; height: 500px;">
        <canvas id="chartSituacoes"></canvas>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const situacoesLabels = [
                @foreach ($situacoes as $situacao)
                    '{{ $situacao->nome }}',
                @endforeach
            ];

            const situacoesData = [
                @foreach ($situacoes as $situacao)
                    {{ $situacao->total }},
                @endforeach
            ];


            function generateColors(count) {
                const colors = [];
                for (let i = 0; i < count; i++) {
                    const hue = i * (360 / count);
                    colors.push(`hsl(${hue}, 70%, 50%)`);
                }
                return colors;
            }

            const situacoesColors = generateColors(situacoesData.length);
            
            const data = {
                labels: situacoesLabels,
                datasets: [{
                    label: 'Associados por Situação',
                    data: situacoesData,
                    backgroundColor: situacoesColors,
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Status dos Associados (Total: {{ $totalAssociados }})'
                        }
                    }
                }
            };

            new Chart(document.getElementById('chartSituacoes'), config);
        </script>
    @endpush
