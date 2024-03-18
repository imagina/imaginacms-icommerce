
<x-isite::button
    buttonClasses="btn btn-primary btn-block"
    color="white"
    :disabled="$disabledBtnConfirm"
    :onclick="'window.livewire.emit(\'confirmData\')'"                 
    :withLabel="true"
    :label="trans('icommerce::warehouses.button.confirm selected')"
    :loading="$loading"
    :loadingLabel="trans('icommerce::warehouses.button.waiting')"
    />
