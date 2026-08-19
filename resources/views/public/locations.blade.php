@extends('layouts.public')

@section('content')
<div class="container py-5 mt-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-dark" data-i18n="locations_title">Our Locations</h1>
        <p class="text-muted" data-i18n="locations_subtitle">Find a Gari Bondhu hub near you.</p>
    </div>

    <div class="row g-4">
        <!-- Dhaka -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="bg-primary text-white p-3 text-center">
                    <h5 class="fw-bold mb-0" data-i18n="loc_dhaka">Dhaka (HQ)</h5>
                </div>
                <div class="p-4">
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i> <span data-i18n="loc_dhaka_addr">123 Gulshan Avenue, Gulshan 1, Dhaka 1212</span></p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> +880 1711-000000</p>
                    <p class="mb-0"><i class="bi bi-envelope-fill text-primary me-2"></i> dhaka@garibondhu.com</p>
                </div>
            </div>
        </div>

        <!-- Chittagong -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="bg-dark text-white p-3 text-center">
                    <h5 class="fw-bold mb-0" data-i18n="loc_ctg">Chittagong</h5>
                </div>
                <div class="p-4">
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i> <span data-i18n="loc_ctg_addr">45 GEC Circle, Chittagong 4000</span></p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> +880 1711-000001</p>
                    <p class="mb-0"><i class="bi bi-envelope-fill text-primary me-2"></i> ctg@garibondhu.com</p>
                </div>
            </div>
        </div>

        <!-- Sylhet -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="bg-dark text-white p-3 text-center">
                    <h5 class="fw-bold mb-0" data-i18n="loc_sylhet">Sylhet</h5>
                </div>
                <div class="p-4">
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i> <span data-i18n="loc_sylhet_addr">12 Zindabazar, Sylhet 3100</span></p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> +880 1711-000002</p>
                    <p class="mb-0"><i class="bi bi-envelope-fill text-primary me-2"></i> sylhet@garibondhu.com</p>
                </div>
            </div>
        </div>
        
        <!-- Cox's Bazar -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="bg-dark text-white p-3 text-center">
                    <h5 class="fw-bold mb-0" data-i18n="loc_cox">Cox's Bazar</h5>
                </div>
                <div class="p-4">
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i> <span data-i18n="loc_cox_addr">Hotel Motel Zone, Kolatoli, Cox's Bazar 4700</span></p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> +880 1711-000003</p>
                    <p class="mb-0"><i class="bi bi-envelope-fill text-primary me-2"></i> cox@garibondhu.com</p>
                </div>
            </div>
        </div>
        
        <!-- Rajshahi -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="bg-dark text-white p-3 text-center">
                    <h5 class="fw-bold mb-0" data-i18n="loc_rajshahi">Rajshahi</h5>
                </div>
                <div class="p-4">
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i> <span data-i18n="loc_rajshahi_addr">Saheb Bazar, Rajshahi 6000</span></p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> +880 1711-000004</p>
                    <p class="mb-0"><i class="bi bi-envelope-fill text-primary me-2"></i> rajshahi@garibondhu.com</p>
                </div>
            </div>
        </div>
        
        <!-- Khulna -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="bg-dark text-white p-3 text-center">
                    <h5 class="fw-bold mb-0" data-i18n="loc_khulna">Khulna</h5>
                </div>
                <div class="p-4">
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-primary me-2"></i> <span data-i18n="loc_khulna_addr">Shib Bari More, Khulna 9000</span></p>
                    <p class="mb-2"><i class="bi bi-telephone-fill text-primary me-2"></i> +880 1711-000005</p>
                    <p class="mb-0"><i class="bi bi-envelope-fill text-primary me-2"></i> khulna@garibondhu.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
