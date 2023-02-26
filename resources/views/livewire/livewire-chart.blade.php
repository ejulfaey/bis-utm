<canvas wire:poll.500ms id="{{ $chartId }}"></canvas>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('{{ $chartId }}'), {
        type: 'doughnut',
        data: {
            labels: @json($label),
            datasets: [{
                label: '# of Defects',
                data: @json($data),
                borderWidth: 3
            }]
        },
    });

    Livewire.on('init', data => {
        console.log(data);
    });
</script>
@endpush