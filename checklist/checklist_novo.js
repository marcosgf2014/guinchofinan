document.addEventListener('DOMContentLoaded', function () {
    const clienteInput = document.getElementById('cliente');
    const veiculoSelect = document.getElementById('veiculo');
    const origemInput = document.getElementById('origem');
    const destinoInput = document.getElementById('destino');

    // Se cliente e veiculo vierem preenchidos via GET, buscar origem/destino
    if (clienteInput.value && veiculoSelect.value) {
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
