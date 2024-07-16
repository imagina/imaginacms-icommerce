@section('scripts')
@parent

<script>
    @if(session("warehouseAlert"))
        Swal.fire({
            title: "{{trans('icommerce::warehouses.title.important')}}",
            text: "{{trans('icommerce::warehouses.messages.address without warehouse coverage')}}",
            icon: "warning"
        }).then((result) => {
            if (result.isConfirmed) {
                //Emit to clear Sesion Variable
                window.livewire.dispatch('cleanWarehouseAlert');
            }
        });
        
    @endif
</script>

@stop
