{{-- 
    Ad Slot Component
    Designed to blend with article cards
    
    Usage: @include('components.ad-slot', ['slot' => 'article-list'])
--}}

@if(config('services.adsense.client_id'))
<div class="col">
    <div class="card ad-card h-100">
        <div class="card-body d-flex align-items-center justify-content-center">
            {{-- Google AdSense Ad Unit --}}
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="{{ config('services.adsense.client_id') }}"
                data-ad-slot="{{ config('services.adsense.slots.' . ($slot ?? 'default')) }}"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
</div>
@elseif(config('app.debug'))
{{-- Placeholder shown only in debug mode --}}
<div class="col">
    <div class="card ad-card h-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%); border: 2px dashed #cbd5e1;">
        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 250px;">
            <div style="color: #94a3b8;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6z"/>
                </svg>
                <p class="mt-3 mb-1 fw-semibold">Iklan</p>
                <small>Ad Slot: {{ $slot ?? 'default' }}</small>
            </div>
        </div>
    </div>
</div>
@endif
