<div class="tab-pane fade show active" id="category-00" role="tabpanel" aria-labelledby="category-tab-00">
    <div class="tab-content mb-2">
        <h4>Services</h4>
        <small>Here are some services or offerings by Barber Shop</small>
    </div>
    <div class="row">
        @forelse($services as $row)
            <div class="col-lg-3 col-md-6 col-sm-12 text-center px-1 mb-2">
                <div class="px-2 py-3 border rounded-lg d-flex flex-column justify-content-between h-100 product-card">
                    <div class="product-item">
                        <div class="photo text-center">
                            <a href="#">
                                <img src="{{ asset('public/uploads/' . $row->photo) }}">
                            </a>
                        </div>
                        <div class="text text-center">
                            <h3>
                                {{ $row->name }}
                            </h3>
                            <div class="price d-flex flex-column">
                                <small>Walking Rate:</small>
                                <span>USD {{ $row->regular_rate }}</span>
                                <small class="mt-2">Appointment Rate:</small>
                                <span>USD {{ $row->appointed_rate }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="cart-button">
                        <button class="avail-offering-btn" data-offering="{{ $row }}">
                            <i class="fas fa-cut mr-1"></i>
                            Avail Service
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <h3 class="mx-auto my-5">No services / offerings are added</h3>
        @endforelse
    </div>
</div>
@include('pages.avail_service')
