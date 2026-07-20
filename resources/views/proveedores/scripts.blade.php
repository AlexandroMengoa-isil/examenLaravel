<script>
    const API_PROVEEDORES = '/api/proveedores'

    document.addEventListener('DOMContentLoaded', listarProveedores)

    async function listarProveedores() {
        const response = await fetch(API_PROVEEDORES)
        const proveedores = await response.json()

        let body = document.getElementById('tbody-proveedores')
        let html = ''

        proveedores.forEach(proveedor => {
            html += `
                <tr>
                    <td>${proveedor.nombre}</td>
                    <td>${proveedor.telefono ?? ''}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editarProveedor(${proveedor.id})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminarProveedor(${proveedor.id})">Eliminar</button>
                    </td>
                </tr>
            `
        })

        body.innerHTML = html
    }

    function nuevoProveedor() {
        document.getElementById('tituloModal').innerText = 'Nuevo Proveedor'
        document.getElementById('formProveedor').reset()
        document.getElementById('id').value = ''
    }

    async function editarProveedor(id) {
        const response = await fetch(`${API_PROVEEDORES}/${id}`)
        const proveedor = await response.json()

        document.getElementById('tituloModal').innerText = 'Editar Proveedor'
        document.getElementById('id').value = proveedor.id
        document.getElementById('nombre').value = proveedor.nombre
        document.getElementById('telefono').value = proveedor.telefono

        new bootstrap.Modal(document.getElementById('modalProveedor')).show()
    }

    document.getElementById('formProveedor').addEventListener('submit', async function (e) {
        e.preventDefault()

        const id = document.getElementById('id').value
        const url = id === '' ? API_PROVEEDORES : `${API_PROVEEDORES}/${id}`
        const data = new FormData(this)

        if (id !== '') data.append('_method', 'PUT')

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: data
        })

        if (response.ok) {
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalProveedor'))
            modal.hide()
            listarProveedores()
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Proveedor guardado correctamente'
            })
        }
    })

    async function eliminarProveedor(id) {
        if (!confirm('¿Eliminar este proveedor?')) return

        const response = await fetch(`${API_PROVEEDORES}/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' }
        })

        if (response.ok) {
            listarProveedores()
            Swal.fire({
                icon: 'success',
                title: 'Eliminado',
                text: 'Proveedor eliminado correctamente'
            })
        }
    }
</script>
