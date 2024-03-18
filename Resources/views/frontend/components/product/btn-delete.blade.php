@if($showDeleteBtn)
    <x-isite::button :style="$buttonsLayout" buttonClasses="button-small delete-cart"
                     onclick="confirmDelete({{$product->id}})"
                     :withIcon="true"
                     iconClass="fa-solid fa-trash"
                     :sizeLabel="$bottomFontSize"
    />
@endif