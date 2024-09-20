@section('scripts')
@parent
<script  type="text/javascript">
    /*
	* LIVEWIRE | Listener Component
	*/
    window.addEventListener('show-modal-alert-warehouse-coverage', event => {
            Swal.fire({
                title: "{{trans('icommerce::warehouses.title.important')}}",
                text: "{{trans('icommerce::warehouses.messages.address without warehouse coverage')}}",
                icon: "warning"
            }).then((result) => {
                if (result.isConfirmed) {
                    //Emit to clear Sesion Variable
                    window.livewire.emit('cleanWarehouseAlert');
                }
            });
    });

</script>

@stop
