<script>
    const API_CATEGORIAS = '/api/categorias'

    document.addEventListener('DOMContentLoaded', listarCategorias)

    async function listarCategorias() {
        const response = await fetch(API_CATEGORIAS)
        const categorias = await response.json()

        let body = document.getElementById('tbody-categorias')
        let html = ''

        categorias.forEach(categoria => {
            html += `
                <tr>
                    <td>${categoria.nombre}</td>
                    <td>${categoria.descripcion}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editarCategoria(${categoria.id})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminarCategoria(${categoria.id})">Eliminar</button>
                    </td>
                </tr>
            `
        })

        body.innerHTML = html
    }

    function nuevoCategoria() {
        document.getElementById('tituloModal').innerText = 'Nueva Categoría'
        document.getElementById('formCategoria').reset()
        document.getElementById('id').value = ''
    }

    async function editarCategoria(id) {
        const response = await fetch(`${API_CATEGORIAS}/${id}`)
        const categoria = await response.json()

        document.getElementById('tituloModal').innerText = 'Editar Categoría'
        document.getElementById('id').value = categoria.id
        document.getElementById('nombre').value = categoria.nombre
        document.getElementById('descripcion').value = categoria.descripcion

        new bootstrap.Modal(document.getElementById('modalCategoria')).show()
    }

    document.getElementById('formCategoria').addEventListener('submit', async function (e) {
        e.preventDefault()

        const id = document.getElementById('id').value
        const url = id === '' ? API_CATEGORIAS : `${API_CATEGORIAS}/${id}`
        const data = new FormData(this)

        if (id !== '') data.append('_method', 'PUT')

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: data
        })

        if (response.ok) {
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCategoria'))
            modal.hide()
            listarCategorias()
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Categoría guardada correctamente'
            })
        }
    })

    async function eliminarCategoria(id) {
        if (!confirm('¿Eliminar esta categoría?')) return

        const response = await fetch(`${API_CATEGORIAS}/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' }
        })

        if (response.ok) {
            listarCategorias()
            Swal.fire({
                icon: 'success',
                title: 'Eliminado',
                text: 'Categoría eliminada correctamente'
            })
        }
    }
</script>
