<button wire:click="confirmData()" type="button" class="btn btn-primary btn-block" @if($disabledBtnConfirm) disabled @endif>
    {{trans('icommerce::warehouses.button.confirm selected')}}
</button>