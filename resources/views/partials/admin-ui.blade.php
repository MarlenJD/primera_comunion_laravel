
<script>
(function () {
    function closeAll() {
        document.querySelectorAll('.modal-backdrop').forEach(function (modal) {
            modal.hidden = true;
        });

        document.body.style.overflow = '';
    }

    document.querySelectorAll('[data-open-modal]').forEach(function (button) {
        button.addEventListener('click', function () {
            closeAll();

            const modal = document.getElementById(button.dataset.openModal);

            if (modal) {
                modal.hidden = false;
                document.body.style.overflow = 'hidden';

                const input = modal.querySelector(
                    'input:not([type=hidden]), select'
                );

                if (input) {
                    input.focus();
                }
            }
        });
    });

    document.querySelectorAll('[data-close-modal]').forEach(function (button) {
        button.addEventListener('click', closeAll);
    });

    document.querySelectorAll('.modal-backdrop').forEach(function (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeAll();
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAll();
        }
    });

    document.querySelectorAll('[data-table-search]').forEach(function (input) {
        input.addEventListener('input', function () {
            const table = document.getElementById(input.dataset.tableSearch);

            if (!table) {
                return;
            }

            const query = input.value.toLocaleLowerCase().trim();

            table.querySelectorAll('tbody tr').forEach(function (row) {
                row.hidden = !row.textContent.toLocaleLowerCase().includes(query);
            });
        });
    });

    const roleSelect = document.querySelector('select[name="rol"]');
    const linkField = document.getElementById('vinculo-catequista');

    if (roleSelect && linkField) {
        const linkSelect = linkField.querySelector('select');

        function updateLink() {
            const isCatequista = roleSelect.value === 'catequista';

            linkField.hidden = !isCatequista;
            linkSelect.disabled = !isCatequista;
            linkSelect.required = isCatequista;
        }

        roleSelect.addEventListener('change', updateLink);
        updateLink();
    }

    @if($errors->any())
        const newModal =
            document.getElementById('nuevo-registro') ||
            document.getElementById('nuevo-usuario');

        if (newModal) {
            newModal.hidden = false;
            document.body.style.overflow = 'hidden';
        }
    @endif
})();
</script>
