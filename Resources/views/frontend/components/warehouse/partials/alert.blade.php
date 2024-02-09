@section('scripts')
@parent

<script>
    @if(session("warehouseAlert"))
        Swal.fire({
            title: "Importante!",
            text: "Tu dirección no tiene cobertura para Domicilio, te hemos asignado la tienda mas cercana para que recojas tus productos",
            icon: "warning"
        }).then((result) => {
            if (result.isConfirmed) {
                //Emit to clear Sesion Variable
                window.livewire.emit('cleanWarehouseAlert');
            }
        });
        
    @endif
</script>

@stop
