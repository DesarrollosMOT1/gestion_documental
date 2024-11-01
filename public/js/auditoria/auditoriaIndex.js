$(document).ready(function() {
    const auditTable = $('#audits'); // Selecciona la tabla
    const ajaxUrl = auditTable.data('ajax'); // Lee la URL desde el atributo data-ajax

    const auditTableConfig = getDataTableConfig({
        ajax: {
            url: ajaxUrl, // Usa la URL definida en la vista
            dataSrc: 'data' // Indica que los datos están dentro de la clave 'data'
        },
        columns: [
            { data: 'id' },
            { data: 'user_type' },
            { data: 'user_name' },
            { data: 'created_at' },
            { data: 'event' },
            { data: 'auditable_type' },
            { data: 'auditable_id' },
            { data: 'old_values' },
            { data: 'new_values' },
            { data: 'url' },
            { data: 'ip_address' },
            { data: 'user_agent' },
            { data: 'tags' },
            {
                data: 'id',
                render: function(data) {
                    return `<a class="btn btn-sm btn-primary" href="{{ route('audits.show', ':id') }}"><i class="fa fa-fw fa-eye"></i></a>`.replace(':id', data);
                }
            }
        ],
        order: [[2, "desc"]] // Ordenar por la fecha
    });

    // Inicializa DataTable para la tabla de auditorías
    auditTable.DataTable(auditTableConfig);
});
