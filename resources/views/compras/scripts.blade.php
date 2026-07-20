<script>
    const API_COMPRAS = '/api/compras'
    const API_PROVEEDORES = '/api/proveedores'

    document.addEventListener('DOMContentLoaded', () => {
        listarCompras()
        cargarProveedores()
    })

    async function listarCompras() {
        const response = await fetch(API_COMPRAS)
        const compras = await response.json()

        let body = document.getElementById('tbody-compras')
        let html = ''

        compras.forEach(compra => {
            html += `
                <tr>
                    <td>${compra.proveedor?.nombre ?? ''}</td>
                    <td>${compra.fecha}</td>
                    <td>${compra.total}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editarCompra(${compra.id})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminarCompra(${compra.id})">Eliminar</button>
                    </td>
                </tr>
            `
        })

        body.innerHTML = html
    }

    async function cargarProveedores() {
        const response = await fetch(API_PROVEEDORES)
        const proveedores = await response.json()
        const proveedorSelect = document.getElementById('proveedor_id')

        proveedorSelect.innerHTML = '<option value="">Seleccione un proveedor</option>'
        proveedores.forEach(proveedor => {
            proveedorSelect.innerHTML += `<option value="${proveedor.id}">${proveedor.nombre}</option>`
        })
    }

    function nuevaCompra() {
        document.getElementById('tituloModal').innerText = 'Nueva Compra'
        document.getElementById('formCompra').reset()
        document.getElementById('id').value = ''
    }

    async function editarCompra(id) {
        const response = await fetch(`${API_COMPRAS}/${id}`)
        const compra = await response.json()

        document.getElementById('tituloModal').innerText = 'Editar Compra'
        document.getElementById('id').value = compra.id
        document.getElementById('proveedor_id').value = compra.proveedor_id
        document.getElementById('fecha').value = compra.fecha
        document.getElementById('total').value = compra.total

        new bootstrap.Modal(document.getElementById('modalCompra')).show()
    }

    document.getElementById('formCompra').addEventListener('submit', async function (e) {
        e.preventDefault()

        const id = document.getElementById('id').value
        const url = id === '' ? API_COMPRAS : `${API_COMPRAS}/${id}`
        const data = new FormData(this)

        if (id !== '') data.append('_method', 'PUT')

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: data
        })

        if (response.ok) {
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCompra'))
            modal.hide()
            listarCompras()
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Compra guardada correctamente'
            })
        }
    })

    async function eliminarCompra(id) {
        if (!confirm('¿Eliminar esta compra?')) return

        const response = await fetch(`${API_COMPRAS}/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' }
        })

        if (response.ok) {
            listarCompras()
            Swal.fire({
                icon: 'success',
                title: 'Eliminado',
                text: 'Compra eliminada correctamente'
            })
        }
    }
</script>
