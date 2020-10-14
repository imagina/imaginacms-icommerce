<div class="top-page border-bottom mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent text-white mb-0 px-2">
                        <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Inicio</a></li>
                        {{ $slot }}
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>