@extends('user.template.main')

@section('title', 'Info Product')

@push('style')
    @include('karyawan.event.style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets-home/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" />
    </noscript>

    <style>
        .image.featured {
            display: inline-block;
            position: relative;
        }

        .hover-effect {
            transition: 0.3s ease;
            display: block;
        }

        .hover-effect:hover {
            filter: brightness(60%);
            /* Efek redup saat hover */
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Latar belakang semi-transparan */
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
            /* Pastikan overlay di atas gambar */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image.featured:hover .overlay {
            opacity: 1;
            /* Tampilkan overlay dan ikon saat hover */
        }

        .overlay i {
            font-size: 2.5rem;
            color: white;
        }
    </style>
@endpush

@push('bodystyle')
    class="hold-transition layout-top-nav"
@endpush
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">E-commerce</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content ">
            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3 class="d-inline-block d-sm-none">{{ $shop->so->nama }}</h3>
                            <div class="col-12">
                                <img src="{{ asset('assets/fotoSO/' . $shop->so->foto) }}" class="product-image"
                                    alt="Product Image">
                            </div>
                            <div class="col-12 product-image-thumbs">
                                <div class="product-image-thumb active"><img
                                        src="{{ asset('assets/fotoSO/' . $shop->so->foto) }}" alt="Product Image"></div>
                                @foreach ($shop->foto as $fotos)
                                    <div class="product-image-thumb"><img src="{{ asset('assets/asset/' . $fotos->fotos) }}"
                                            width="100" alt="Product Image">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3">{{ $shop->so->nama }}</h3>
                            <p>{{ $shop->deskripsi }}</p>
                            </p>
                            <h4 class="mt-3">Size <small>Please select one</small></h4>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                                    <span class="text-xl">S</span>
                                    <br>
                                    Small
                                </label>
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="color_option" id="color_option_b2" autocomplete="off">
                                    <span class="text-xl">M</span>
                                    <br>
                                    Medium
                                </label>
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="color_option" id="color_option_b3" autocomplete="off">
                                    <span class="text-xl">L</span>
                                    <br>
                                    Large
                                </label>
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="color_option" id="color_option_b4" autocomplete="off">
                                    <span class="text-xl">XL</span>
                                    <br>
                                    Xtra-Large
                                </label>
                            </div>

                            <div class=" py-2 px-3 mt-4">
                                <h2 class="mb-0">
                                    <span
                                        @if ($shop->discount > 0) style="text-decoration: line-through; font-size: 20px; color: red" @endif>Rp
                                        {{ number_format($harga = ($shop->so->hargamodal * $margins->margin) / 100 + $shop->so->hargamodal) }}</span>
                                    @if ($shop->discount > 0)
                                        <span>Rp {{ number_format($harga - ($harga * $shop->discount) / 100) }}</span>
                                    @endif


                                    </p>
                                </h2>
                                <h4 class="mt-0">
                                </h4>
                            </div>

                            <div class="mt-4">
                                <div class="btn btn-primary btn-lg btn-flat">
                                    <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                    Add to Cart
                                </div>

                                <div class="btn btn-default btn-lg btn-flat">
                                    <i class="fas fa-heart fa-lg mr-2"></i>
                                    Add to Wishlist
                                </div>
                            </div>

                            <div class="mt-4 product-share">
                                <a href="#" class="text-gray">
                                    <i class="fab fa-facebook-square fa-2x"></i>
                                </a>
                                <a href="#" class="text-gray">
                                    <i class="fab fa-twitter-square fa-2x"></i>
                                </a>
                                <a href="#" class="text-gray">
                                    <i class="fas fa-envelope-square fa-2x"></i>
                                </a>
                                <a href="#" class="text-gray">
                                    <i class="fas fa-rss-square fa-2x"></i>
                                </a>
                            </div>

                            <div class="mt-4">
                                <h4>Detail</h4>
                                <p>
                                    {{ $shop->detail }} 
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="row mt-4">
                        <nav class="w-100">
                            <div class="nav nav-tabs" id="product-tab" role="tablist">
                                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab"
                                    href="#product-desc" role="tab" aria-controls="product-desc"
                                    aria-selected="true">Barang Serupa</a>
                                <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab"
                                    href="#product-comments" role="tab" aria-controls="product-comments"
                                    aria-selected="false">Comments</a>
                                <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab"
                                    href="#product-rating" role="tab" aria-controls="product-rating"
                                    aria-selected="false">Rating</a>
                            </div>
                        </nav>
                        <div class="tab-content p-3" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="product-desc" role="tabpanel"
                                aria-labelledby="product-desc-tab">
                                <section class="carousel">
                                    <div class="reel">
                                        @foreach ($rekomendasi as $shop)
                                            <article>
                                                <a href="{{ url('info/' . $shop->id) }}"
                                                    class="image featured position-relative">
                                                    <img src="{{ asset('assets/fotoSO/' . $shop->so->foto) }}"
                                                        alt="" class="img-fluid hover-effect" />
                                                    <div class="overlay d-flex justify-content-center align-items-center">
                                                        <i class="bi bi-eye text-dark"></i>
                                                        <!-- Menggunakan Bootstrap Icons -->
                                                    </div>
                                                </a>
                                                <header>
                                                    <h3><a href="">{{ $shop->so->nama }}</a></h3>
                                                </header>
                                                <p><span
                                                        @if ($shop->discount >= 0) style="text-decoration: line-through" @endif>Rp
                                                        {{ number_format($harga = ($shop->so->hargamodal * $margins->margin) / 100 + $shop->so->hargamodal) }}</span>
                                                    @if ($shop->discount >= 0)
                                                        <span>Rp
                                                            {{ number_format($harga - ($harga * $shop->discount) / 100) }}</span>
                                                    @endif
                                                    <br>
                                                    {{ $shop->deskripsi }}
                                                </p>
                                            </article>
                                        @endforeach
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane fade" id="product-comments" role="tabpanel"
                                aria-labelledby="product-comments-tab"> Vivamus rhoncus nisl sed venenatis luctus. Sed
                                condimentum risus ut tortor feugiat laoreet. Suspendisse potenti. Donec et finibus sem, ut
                                commodo lectus. Cras eget neque dignissim, placerat orci interdum, venenatis odio. Nulla
                                turpis elit, consequat eu eros ac, consectetur fringilla urna. Duis gravida ex pulvinar
                                mauris ornare, eget porttitor enim vulputate. Mauris hendrerit, massa nec aliquam cursus, ex
                                elit euismod lorem, vehicula rhoncus nisl dui sit amet eros. Nulla turpis lorem, dignissim a
                                sapien eget, ultrices venenatis dolor. Curabitur vel turpis at magna elementum hendrerit vel
                                id dui. Curabitur a ex ullamcorper, ornare velit vel, tincidunt ipsum. </div>
                            <div class="tab-pane fade" id="product-rating" role="tabpanel"
                                aria-labelledby="product-rating-tab"> Cras ut ipsum ornare, aliquam ipsum non, posuere
                                elit. In hac habitasse platea dictumst. Aenean elementum leo augue, id fermentum risus
                                efficitur vel. Nulla iaculis malesuada scelerisque. Praesent vel ipsum felis. Ut molestie,
                                purus aliquam placerat sollicitudin, mi ligula euismod neque, non bibendum nibh neque et
                                erat. Etiam dignissim aliquam ligula, aliquet feugiat nibh rhoncus ut. Aliquam efficitur
                                lacinia lacinia. Morbi ac molestie lectus, vitae hendrerit nisl. Nullam metus odio,
                                malesuada in vehicula at, consectetur nec justo. Quisque suscipit odio velit, at accumsan
                                urna vestibulum a. Proin dictum, urna ut varius consectetur, sapien justo porta lectus, at
                                mollis nisi orci et nulla. Donec pellentesque tortor vel nisl commodo ullamcorper. Donec
                                varius massa at semper posuere. Integer finibus orci vitae vehicula placerat. </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    @push('script')
        @include('karyawan.event.script')
        <script>
            $(document).ready(function() {
                $('.product-image-thumb').on('click', function() {
                    var $image_element = $(this).find('img')
                    $('.product-image').prop('src', $image_element.attr('src'))
                    $('.product-image-thumb.active').removeClass('active')
                    $(this).addClass('active')
                })
            })
        </script>

        <!-- Scripts -->
        <script src="../../assets-home/js/jquery.min.js"></script>
        <script src="../../assets-home/js/jquery.dropotron.min.js"></script>
        <script src="../../assets-home/js/jquery.scrolly.min.js"></script>
        <script src="../../assets-home/js/jquery.scrollex.min.js"></script>
        <script src="../../assets-home/js/browser.min.js"></script>
        <script src="../../assets-home/js/breakpoints.min.js"></script>
        <script src="../../assets-home/js/util.js"></script>
        <script src="../../assets-home/js/main.js"></script>
    @endpush
