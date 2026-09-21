@extends('frontend.master')
@section('content')
    <section class="product-details-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div class="product-details-wrapper">
                        <div class="row">
                            <div class="col-lg-7 col-md-7">
                                <div class="product-images-slider-outer">
                                    <div class="slider slider-content">
                                        @foreach ($product->galleryImage as $image)
                                            <div>
                                                <img src="{{ asset('backend/images/galleryImage/' . $image->image) }}"
                                                    alt="slider images">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="slider slider-thumb">
                                        @foreach ($product->galleryImage as $image)
                                            <div>
                                                <img src="{{ asset('backend/images/galleryImage/' . $image->image) }}"
                                                    alt="slider images">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <div class="product-details-content">
                                    <h3 class="product-name">
                                        {{ $product->name }}
                                    </h3>
                                    <div class="product-price">
                                        <span>{{ $product->discount_price }} Tk.</span>
                                        <span class="" style="color: #f74b81;">
                                            <del>{{ $product->regular_price }} Tk.</del>
                                        </span>
                                    </div>

                                    <form action="{{ '/product/addtocart-details/' . $product->id }}" method="POST">
                                        @csrf
                                        <div class="product-details-select-items-wrap">
                                            @foreach ($product->color as $color)
                                                <div class="product-details-select-item-outer">
                                                    <input type="radio" name="color" id="color"
                                                        value="{{ $color->color_name }}" class="category-item-radio">
                                                    <label for="color" class="category-item-label">
                                                        {{ $color->color_name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="product-details-select-items-wrap">
                                            @foreach ($product->size as $size)
                                                <div class="product-details-select-item-outer">
                                                    <input type="radio" name="size" value="{{ $size->size_name }}"
                                                        class="category-item-radio">
                                                    <label for="size"
                                                        class="category-item-label">{{ $size->size_name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="purchase-info-outer">
                                            <div class="product-incremnt-decrement-outer" style="display: block">
                                                <a title="Decrement" class="decrement-btn" style="margin-top: -10px;">
                                                    <i class="fas fa-minus"></i>
                                                </a>
                                                <input type="number" readonly name="qty" placeholder="qty"
                                                    value="1" min="1" id="qty" style="height: 35px">
                                                <a title="Increment" class="increment-btn" style="margin-top: -10px;">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                                <input type="hidden" name="in_Stock" id="in_Stock"
                                                    value="{{ $product->qty }}">
                                            </div>
                                            <div>
                                                <button type="submit" name="action" value="addToCart" id="addToCart"
                                                    class="cart-btn-inner">
                                                    <i class="fas fa-shopping-cart"></i>
                                                    Add to Cart
                                                </button>
                                                <button type="submit" name="action" value="buyNow" id="buyNow"
                                                    class="cart-btn-inner">
                                                    <i class="fas fa-truck"></i>
                                                    Quick Order
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <button type="button" class="product-details-hot-line">
                                        <i class="fas fa-phone-alt"></i>
                                        For Call : 01914610000
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="product-details-info">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-description-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-description" type="button" role="tab"
                                        aria-controls="pills-description" aria-selected="true">
                                        Description
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-review-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-review" type="button" role="tab"
                                        aria-controls="pills-review" aria-selected="true">
                                        Review
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-policy-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-policy" type="button" role="tab"
                                        aria-controls="pills-policy" aria-selected="true">
                                        Product Policy
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                                    aria-labelledby="pills-description-tab">
                                    {!! $product->long_desc !!}
                                </div>
                                <div class="tab-pane fade" id="pills-review" role="tabpanel"
                                    aria-labelledby="pills-review-tab">
                                    <div class="review-item-wrapper">
                                        <div class="review-item-left">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="review-item-right">
                                            <h4 class="review-author-name">
                                                Saidul Islam
                                                <span class=" d-inline bg-danger badge-sm badge text-white">Verified</span>
                                            </h4>
                                            <p class="review-item-message">
                                                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Officiis minus, ut
                                                unde laudantium accusamus odio nam officia aperiam excepturi quis nesciunt
                                                eveniet eligendi.
                                            </p>
                                            <span class="review-item-rating-stars">
                                                <i class="fa-star fas"></i>
                                                <i class="fa-star fas"></i>
                                                <i class="fa-star fas"></i>
                                                <i class="fa-star fas"></i>
                                                <i class="fa-star fas"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-policy" role="tabpanel"
                                    aria-labelledby="pills-policy-tab">
                                    {!! $product->product_policy !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="product-details-sidebar">
                        <div class="product-details-categoris">
                            <h3 class="product-details-title">
                                Category
                            </h3>
                            <a href="#" class="category-item-outer">
                                <img src="{{ asset('backend/images/category/' . $product->category->image) }}"
                                    alt="category image">
                                {{ $product->category->name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- AI Agent -->
    {{-- <div id="ai-agent">
        <button type="button" id="ai-agent-toggle">💬 AI Help</button>

        <div id="ai-agent-box">
            <div class="ai-agent-header">Product Assistant</div>

            <div id="ai-agent-messages">
                <div class="ai-message ai-bot">
                    এই পণ্য সম্পর্কে কোনো প্রশ্ন থাকলে লিখুন।
                </div>
            </div>

            <form id="ai-agent-form">
                <input type="text" id="ai-agent-input" placeholder="আপনার প্রশ্ন লিখুন..." autocomplete="off"
                    required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div> --}}

    <style>
        #ai-agent-toggle {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 9999;
            border: 0;
            border-radius: 25px;
            padding: 12px 18px;
            background: #2db748;
            color: #fff;
            cursor: pointer;
        }

        #ai-agent-box {
            display: none;
            position: fixed;
            right: 22px;
            bottom: 75px;
            width: 330px;
            max-width: calc(100vw - 35px);
            z-index: 9999;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, .2);
            overflow: hidden;
        }

        .ai-agent-header {
            padding: 13px;
            background: #2db748;
            color: #fff;
            font-weight: bold;
        }

        #ai-agent-messages {
            height: 260px;
            padding: 12px;
            overflow-y: auto;
        }

        .ai-message {
            margin-bottom: 8px;
            padding: 8px 10px;
            border-radius: 6px;
            font-size: 14px;
        }

        .ai-bot {
            background: #f1f1f1;
        }

        .ai-user {
            background: #ffe1ea;
            text-align: right;
        }

        #ai-agent-form {
            display: flex;
            border-top: 1px solid #ddd;
        }

        #ai-agent-input {
            flex: 1;
            border: 0;
            padding: 10px;
            outline: 0;
        }

        #ai-agent-form button {
            border: 0;
            padding: 0 12px;
            background: #2db748;
            color: #fff;
        }
    </style>
@endsection

@push('script')
    <script>
        var qtyInput = document.getElementById('qty');

        var plusBtn = document.querySelector('.increment-btn');
        var minusBtn = document.querySelector('.decrement-btn');

        plusBtn.addEventListener('click', function() {
            if (parseInt(qtyInput.value) < 5) {
                qtyInput.value = parseInt(qtyInput.value) + 1;
            }
        })
        minusBtn.addEventListener('click', function() {
            if (parseInt(qtyInput.value) > 1) {
                qtyInput.value = parseInt(qtyInput.value) - 1;
            }
        })
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Product",
            "name": "{{ $product->name }}",
            "image": "{{ asset($product->image) }}",
            "description": "{{ $product->short_description }}",
            "sku": "{{ $product->sku }}",
            "offers": {
                "@type": "Offer",
                "url": "{{ route('product.details', $product->slug) }}",
                "priceCurrency": "BDT",
                "price": "{{ $product->price }}",
                "availability": "{{ $product->in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
            }
        }
    </script>
    {{-- AI Agent Scripts --}}
    <script>
    const aiToggle = document.getElementById('ai-agent-toggle');
    const aiBox = document.getElementById('ai-agent-box');
    const aiForm = document.getElementById('ai-agent-form');
    const aiInput = document.getElementById('ai-agent-input');
    const aiMessages = document.getElementById('ai-agent-messages');

    aiToggle.addEventListener('click', function () {
    aiBox.style.display = aiBox.style.display === 'block' ? 'none' : 'block';
    });

    aiForm.addEventListener('submit', async function (event) {
    event.preventDefault();

    const message = aiInput.value.trim();

    if (!message) return;

    aiMessages.innerHTML += `
    <div class="ai-message ai-user">${message}</div>
    `;

    aiInput.value = '';

    const loading = document.createElement('div');
    loading.className = 'ai-message ai-bot';
    loading.textContent = 'উত্তর তৈরি হচ্ছে...';
    aiMessages.appendChild(loading);

    try {
    const response = await fetch('{{ route('ai.agent.chat') }}', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': '{{ csrf_token() }}',
    'Accept': 'application/json'
    },
    body: JSON.stringify({
    message: message,
    product_id: {{ $product->id }}
    })
    });

    const data = await response.json();
    loading.textContent = data.message || 'কোনো উত্তর পাওয়া যায়নি।';
    } catch (error) {
    loading.textContent = 'দুঃখিত, সংযোগে সমস্যা হয়েছে।';
    }

    aiMessages.scrollTop = aiMessages.scrollHeight;
    });
    </script>
@endpush
