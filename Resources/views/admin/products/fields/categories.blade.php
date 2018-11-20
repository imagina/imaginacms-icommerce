<div class="row checkbox">

    <div class="col-xs-12">
        <div class="content-cat" style="max-height:490px;overflow-y: auto;">

            <label for="categories"><strong>{{trans('icommerce::products.table.categories')}}</strong></label>

            @if(count($categories)>0)



                @php

                    if(isset($product->categories) && count($product->categories)>0){

                        $oldCat = array();

                        foreach ($product->categories as $cat){

                            array_push($oldCat,$cat->id);

                        }

                    }

                @endphp



                <ul class="checkbox" style="list-style: none;padding-left: 5px;">

                    @foreach ($categories as $category)


                        @if($category->parent_id==0)

                            <li>

                                <label>

                                    <input type="checkbox" class="flat-blue jsInherit" name="categories[]"

                                           value="{{$category->id}}" @isset($oldCat) @if(in_array($category->id, $oldCat)) checked="checked" @endif @endisset> {{$category->title}}

                                </label>
                                @if(count($category->children)>0)
                                    @php
                                        $children=$category->children
                                    @endphp
                                    @include('icommerce::admin.products.fields.chlidrencategory',['children'=>$children])
                                @endif
                            </li>

                        @endif



                    @endforeach

                </ul>

            @endif

        </div>
    </div>

</div>