<script>
    const API_MARCAS = '/api/marcas'

    document.addEventListener('DOMContentLoaded', listarMarcas)

    async function listarMarcas() {
        const response = await fetch(API_MARCAS)
        const marcas = await response.json()

        let body = document.getElementById('tbody-marcas')
        let html = ''

        marcas.forEach(marca => {
            html += `
                <tr>
                    <td>${marca.nombre}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editarMarca(${marca.id})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminarMarca(${marca.id})">Eliminar</button>
                    </td>
                </tr>
            `
        })

        body.innerHTML = html
    }

    function nuevaMarca() {
        document.getElementById('tituloModal').innerText = 'Nueva Marca'
        document.getElementById('formMarca').reset()
        document.getElementById('id').value = ''
    }

    async function editarMarca(id) {
        const response = await fetch(`${API_MARCAS}/${id}`)
        const marca = await response.json()

        document.getElementById('tituloModal').innerText = 'Editar Marca'
        document.getElementById('id').value = marca.id
        document.getElementById('nombre').value = marca.nombre

        new bootstrap.Modal(document.getElementById('modalMarca')).show()
    }

    document.getElementById('formMarca').addEventListener('submit', async function (e) {
        e.preventDefault()

        const id = document.getElementById('id').value
        const url = id === '' ? API_MARCAS : `${API_MARCAS}/${id}`
        const data = new FormData(this)

        if (id !== '') data.append('_method', 'PUT')

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: data
        })

        if (response.ok) {
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMarca'))
            modal.hide()
            listarMarcas()
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Marca guardada correctamente'
            })
        }
    })

    async function eliminarMarca(id) {
        if (!confirm('¿Eliminar esta marca?')) return

        const response = await fetch(`${API_MARCAS}/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' }
        })

        if (response.ok) {
            listarMarcas()
            Swal.fire({
                icon: 'success',
                title: 'Eliminado',
                text: 'Marca eliminada correctamente'
            })
        }
    }
</script>
