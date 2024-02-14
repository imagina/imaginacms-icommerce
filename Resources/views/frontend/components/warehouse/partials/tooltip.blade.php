<div id="{{$warehouseLocatorId}}Tooltip">
    <div class="warehouse-tooltip-screen">aaf</div>
    <div class="warehouse-tooltip-container">
        <div class="warehouse-tooltip-body">
            <div class="warehouse-tooltip-close" onclick="closeTooltip('close')">×</div>
            <div class="warehouse-tooltip-body-title">
                {{trans('icommerce::warehouses.messages.you are going to buy for')}}
                {{$warehouse->address}}
            </div>
            <div class="warehouse-tooltip-body-description">
                {{trans('icommerce::warehouses.messages.products for this location')}}
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-sm-6 pb-3 pb-sm-0">
                    <button type="button" onclick="closeTooltip('keep')" class="btn btn-outline-primary btn-block">{{trans('icommerce::warehouses.button.keep')}}</button>
                </div>
                <div class="col-sm-6">

                    <button type="button" onclick="closeTooltip('change')" data-toggle="modal" data-target="#modalWarehouseLocator" class="btn btn-primary btn-block">
                        {{trans('icommerce::warehouses.button.change')}}
                    </button>

                </div>
            </div>
        </div>
    </div>

<style>
    .warehouse-tooltip-body {
        box-sizing: border-box;
        background-color: #fff;
        padding: 20px;
        color: #333;
        position: absolute;
        margin-top: 20px;
        border-radius: 6px;

        width: 100%;
        max-width: 400px;
        right: 0;
        left: 0;
        margin-left: auto;
        margin-right: auto;

    }

    @media screen and (min-width: 1024px) {
        .warehouse-tooltip-body {
            width:300px;
            line-height: 20px;
            animation: warehouse-tooltip-bouncing-popup 12s linear infinite;
            filter: drop-shadow(0 .2rem .3rem rgba(0,0,0,.3));
            position: absolute;


        }
    }

    .warehouse-tooltip-container {
        position: fixed;
        left: 40px;
        right: 40px;
        top: 20%;
        margin: auto;
        z-index: 99;
        font-family: Lato,sans-serif;
        font-weight: 400
    }

    /*@media (min-width: 320px) and (orientation:landscape) {
        .warehouse-tooltip-container {
            top:0
        }
    }

    @media screen and (min-width: 720px) {
        .warehouse-tooltip-container {
            left:200px;
            right: 200px
        }
    }*/

    @media screen and (min-width: 1024px) {
        .warehouse-tooltip-container {
            position: absolute;
            top: auto;
            left: 0;
            /* display: none; */
            z-index: 11;
            right: 0;
        }

        .warehouse-tooltip-body:after {
            content: " ";
            position: absolute;
            bottom: 100%;
            left: calc(50% - 6px);
            border: 12px solid transparent;
            border-bottom-color: #fff
        }
    }

    .warehouse-tooltip-body-title {
        font-size: 17px;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 15px
    }


    .warehouse-tooltip-body-description {
        font-size: 14px;
        margin-bottom: 15px
    }



    @keyframes warehouse-tooltip-bouncing-popup {
        0% {
            transform: translateY(0)
        }

        3% {
            transform: translateY(.5rem)
        }

        6% {
            transform: translateY(0)
        }

        9% {
            transform: translateY(.5rem)
        }

        12% {
            transform: translateY(0)
        }

        15% {
            transform: translateY(.5rem)
        }

        18%,to {
            transform: translateY(0)
        }
    }

    .warehouse-tooltip-close {
        position: absolute;
        box-sizing: border-box;
        z-index: 11;
        display: flex;
        justify-content: end;
        top: 3px;
        right: 15px;
        cursor: pointer;
        font-size: 25px;
    }

    .warehouse-tooltip-screen {
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 10;
        background-color: rgba(0,0,0,.5)
    }


    @media screen and (min-width: 1024px) {
        .warehouse-tooltip-close {
            display:none
        }

        .warehouse-tooltip-screen {
            display:none;
        }
    }

</style>
<script>
    function closeTooltip(from) {
        const tooltip = document.getElementById('{{$warehouseLocatorId}}Tooltip');
        if (tooltip.parentNode) {
            tooltip.parentNode.removeChild(tooltip);
        }

        if('keep'){
            //Update variable session
            window.livewire.emit('updateTooltipStatus');
        }
       
    }
    // Función para mostrar el Tooltip
    function mostrarTooltip() {
        const tooltip = document.getElementById('{{$warehouseLocatorId}}Tooltip');
        tooltip.style.display = 'block';
    }

    // Evento cuando la página se carga completamente
    document.addEventListener('DOMContentLoaded', mostrarTooltip);
</script>
</div>