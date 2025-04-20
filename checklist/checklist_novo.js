document.addEventListener('DOMContentLoaded', function () {
    const clienteInput = document.getElementById('cliente');
    const veiculoSelect = document.getElementById('veiculo');
    const origemInput = document.getElementById('origem');
    const destinoInput = document.getElementById('destino');

    // Se cliente e veiculo vierem preenchidos via GET, buscar origem/destino
    // Só buscar origem/destino do veículo se NÃO estiver editando (ou seja, se não houver campo hidden com id do checklist)
    if (clienteInput.value && veiculoSelect.value && !document.querySelector('input[name="id"]')) {
        fetch('get_veiculo_info.php?cliente=' + encodeURIComponent(clienteInput.value) + '&veiculo=' + encodeURIComponent(veiculoSelect.value))
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    origemInput.value = data.origem || '';
                    destinoInput.value = data.destino || '';
                }
            });
    }
});
