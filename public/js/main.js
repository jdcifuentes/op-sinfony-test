
const categories = document.getElementById('categories');

if (categories) {
    categories.addEventListener('click', (e) => {
        if (e.target.className === 'btn btn-danger delete-category') {
            if (confirm('¿Está seguro?')) {
                const id = e.target.getAttribute('data-id');

                fetch(`/categories/${id}/delete`, {
                    method: 'DELETE'
                }).then(response => {
                    this.location.reload();
                }, error => {
                    console.log(error);
                });
            }
        }

        if (e.target.className === 'btn btn-warning change-state') {
            const id = e.target.getAttribute('data-id');
            fetch(`/categories/${id}/toggle-active`, {
                method: 'PATCH'
            }).then(response => {
                this.location.reload();
            }, error => {
                console.log(error);
            });
        }

    });
}