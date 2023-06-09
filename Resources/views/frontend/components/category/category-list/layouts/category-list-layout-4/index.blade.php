<section id="categoryList4">
    <div class="card-categories">
        @foreach($categories as $key => $category)
            <div class="item-category">
                <div class="bg-img">
                    <x-media::single-image :alt="$category->title" :title="$category->title" :url="$category->url"
                                           :isMedia="true" :mediaFiles="$category->mediaFiles()" imgClasses="img-fluid"/>
                </div>
                <div class="card-overlay">
                    <h5 class="card-title mb-0"><a href="{{$category->url}}">{{$category->title}}</a></h5>
                </div>
            </div>
        @endforeach
    </div>
    <style>
        #categoryList4 .card-categories {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 5px;
            margin: 5px;
        }
        #categoryList4 .card-categories .item-category {
            position: relative;
        }
        #categoryList4 .card-categories .item-category:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
            background: linear-gradient(to bottom, transparent, transparent, black);
            transition: all 0.4s ease-in-out;
        }
        #categoryList4 .card-categories .item-category .bg-img {
            height: 0;
            padding-bottom: 80%;
            position: relative;
            display: block;
        }
        #categoryList4 .card-categories .item-category .bg-img img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            position: absolute;
        }
        #categoryList4 .card-categories .item-category .card-overlay {
            position: absolute;
            right: 0;
            bottom: 0;
            padding: 1rem;
            z-index: 3;
            transition: 350ms;
        }
        #categoryList4 .card-categories .item-category .card-overlay .card-title {
            font-size: 20px;
        }
        #categoryList4 .card-categories .item-category .card-overlay .card-title a {
            display: block;
            color: #fff;
            text-align: right;
        }
        #categoryList4 .card-categories .item-category:hover {
            box-shadow: 3px 4px 27px rgba(0, 0, 0, 0.35);
        }
        #categoryList4 .card-categories .item-category:hover .card-overlay {
            right: 7px;
        }
        @media (max-width: 992px) {
            #categoryList4 .card-categories {
                grid-template-columns: repeat(2, 1fr);
            }
            #categoryList4 .card-categories .item-category .card-overlay .card-title {
                font-size: 18px;
            }
        }
        @media (max-width: 767px) {
            #categoryList4 .card-categories .item-category .card-overlay .card-title {
                font-size: 16px;
            }
        }
        @media (max-width: 576px) {
            #categoryList4 .card-categories {
                grid-template-columns: repeat(3, 1fr);
            }
            #categoryList4 .card-categories .item-category:before {
                content: none;
            }
            #categoryList4 .card-categories .item-category .bg-img {
                height: 90px;
                width: 90px;
                padding-bottom: 0;
                position: relative;
                display: block;
                margin: 0 auto;
                border-radius: 50%;
                overflow: hidden;
                box-shadow: 3px 4px 14px rgba(0, 0, 0, 0.35);
            }
            #categoryList4 .card-categories .item-category .bg-img img {
                position: absolute;
            }
            #categoryList4 .card-categories .item-category .card-overlay {
                display: block;
                position: relative;
                text-align: center;
                padding: 10px 2px 20px 2px;
            }
            #categoryList4 .card-categories .item-category .card-overlay .card-title {
                font-size: 14px;
            }
            #categoryList4 .card-categories .item-category .card-overlay .card-title a {
                color: #333;
                text-align: center;
            }
            #categoryList4 .card-categories .item-category:hover {
                box-shadow: none;
            }
            #categoryList4 .card-categories .item-category:hover .bg-img {
                border: 3px solid var(--primary);
            }
            #categoryList4 .card-categories .item-category:hover .card-overlay {
                right: 0;
            }
            #categoryList4 .card-categories .item-category:hover .card-overlay .card-title {
                font-weight: bold;
            }
        }
        .not-image #categoryList4 .card-categories {
            grid-gap: 10px;
        }
        .not-image #categoryList4 .card-categories .item-category {
            border: 1px solid #cccccc;
        }
        .not-image #categoryList4 .card-categories .item-category .bg-img {
            display: none !important;
        }
        .not-image #categoryList4 .card-categories .item-category .card-overlay {
            position: relative !important;
            padding: 15px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .not-image #categoryList4 .card-categories .item-category .card-overlay .card-title a {
            color: #333 !important;
            text-align: center !important;
        }
        .not-image #categoryList4 .card-categories .item-category:hover {
            background-color: #cccccc;
            box-shadow: none;
        }
        .not-image #categoryList4 .card-categories .item-category:hover .card-overlay {
            right: 0;
        }
        .not-image #categoryList4 .card-categories .item-category:before {
            content: none;
        }
        @media (max-width: 576px) {
            .not-image #categoryList4 .card-categories .item-category .card-overlay .card-title {
                font-size: 12px;
            }
        }

    </style>
</section>
