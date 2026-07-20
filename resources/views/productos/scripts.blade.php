<script>
    const API_PRODUCTOS = '/api/productos'
    const API_CATEGORIAS = '/api/categorias'
    const API_MARCAS = '/api/marcas'

    document.addEventListener('DOMContentLoaded', () => {
        listarProductos()
        cargarSelects()
    })

    async function listarProductos() {
        const response = await fetch(API_PRODUCTOS)
        const productos = await response.json()

        let body = document.getElementById('tbody-productos')
        let html = ''

        productos.forEach(producto => {
            html += `
                <tr>
                    <td>${producto.nombre}</td>
                    <td>${producto.categoria?.nombre ?? ''}</td>
                    <td>${producto.marca?.nombre ?? ''}</td>
                    <td>${producto.precio}</td>
                    <td>${producto.stock}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editarProducto(${producto.id})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminarProducto(${producto.id})">Eliminar</button>
                    </td>
                </tr>
            `
        })

        body.innerHTML = html
    }

    async function cargarSelects() {
        const [categoriasResp, marcasResp] = await Promise.all([
            fetch(API_CATEGORIAS),
            fetch(API_MARCAS)
        ])

        const [categorias, marcas] = await Promise.all([
            categoriasResp.json(),
            marcasResp.json()
        ])

        const categoriaSelect = document.getElementById('categoria_id')
        const marcaSelect = document.getElementById('marca_id')

        categoriaSelect.innerHTML = '<option value="">Seleccione una categoría</option>'
        marcaSelect.innerHTML = '<option value="">Seleccione una marca</option>'

        categorias.forEach(categoria => {
            categoriaSelect.innerHTML += `<option value="${categoria.id}">${categoria.nombre}</option>`
        })

        marcas.forEach(marca => {
            marcaSelect.innerHTML += `<option value="${marca.id}">${marca.nombre}</option>`
        })
    }

    function nuevoProducto() {
        document.getElementById('tituloModal').innerText = 'Nuevo Producto'
        document.getElementById('formProducto').reset()
        document.getElementById('id').value = ''
    }

    async function editarProducto(id) {
        const response = await fetch(`${API_PRODUCTOS}/${id}`)
        const producto = await response.json()

        document.getElementById('tituloModal').innerText = 'Editar Producto'
        document.getElementById('id').value = producto.id
        document.getElementById('nombre').value = producto.nombre
        document.getElementById('categoria_id').value = producto.categoria_id
        document.getElementById('marca_id').value = producto.marca_id
        document.getElementById('precio').value = producto.precio
        document.getElementById('stock').value = producto.stock

        new bootstrap.Modal(document.getElementById('modalProducto')).show()
    }

    document.getElementById('formProducto').addEventListener('submit', async function (e) {
        e.preventDefault()

        const id = document.getElementById('id').value
        const url = id === '' ? API_PRODUCTOS : `${API_PRODUCTOS}/${id}`
        const data = new FormData(this)

        if (id !== '') data.append('_method', 'PUT')

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: data
        })

        if (response.ok) {
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalProducto'))
            modal.hide()
            listarProductos()
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Producto guardado correctamente'
            })
        }
    })

    async function eliminarProducto(id) {
        if (!confirm('¿Eliminar este producto?')) return

        const response = await fetch(`${API_PRODUCTOS}/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' }
        })

        if (response.ok) {
            listarProductos()
            Swal.fire({
                icon: 'success',
                title: 'Eliminado',
                text: 'Producto eliminado correctamente'
            })
        }
    }
</script>
