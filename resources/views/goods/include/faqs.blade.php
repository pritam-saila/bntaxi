{{--
    FAQ section + FAQPage structured data, used on every public page that has FAQs.
    FAQs are managed in the admin panel (Page FAQs / Route handles -> FAQ).

    @include('goods.include.faqs', [
        'faqs'     => $faqs,                         // collection of App\Models\Faq
        'title'    => 'Frequently Asked Questions',  // optional
        'subtitle' => 'Everything you need to know', // optional
    ])
--}}
@php
    $faqs = collect($faqs ?? [])->filter(fn ($f) => trim((string) $f->question) !== '' && trim((string) $f->answer) !== '');
    $faqGroup = 'faq-' . substr(md5($faqs->pluck('id')->implode(',')), 0, 8);
@endphp
@if ($faqs->isNotEmpty())
@stylesheet('goods/css/partials/faqs.css')
<section class="faq-section bn-faqs" aria-labelledby="{{ $faqGroup }}-title">
    <div class="faq-title">
        <h2 id="{{ $faqGroup }}-title">{{ $title ?? 'Frequently Asked Questions' }}</h2>
        @if (!empty($subtitle ?? null))
            <p>{{ $subtitle }}</p>
        @endif
    </div>

    @foreach ($faqs as $faq)
        {{-- name="..." makes it an accordion: opening one question closes the others. --}}
        <details class="faq-item" name="{{ $faqGroup }}">
            <summary class="faq-question">
                <span>{{ $faq->question }}</span>
                <span class="faq-icon" aria-hidden="true">+</span>
            </summary>
            <div class="faq-answer">
                {{-- Answers can contain formatting entered in the admin panel; plain text is wrapped in a paragraph. --}}
                @if (\Illuminate\Support\Str::contains($faq->answer, '<'))
                    {!! $faq->answer !!}
                @else
                    <p>{{ $faq->answer }}</p>
                @endif
            </div>
        </details>
    @endforeach
</section>

@php
    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqs->map(fn ($faq) => [
            '@type' => 'Question',
            'name' => trim($faq->question),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($faq->answer), ENT_QUOTES | ENT_HTML5, 'UTF-8'))),
            ],
        ])->values()->all(),
    ];
@endphp
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
@endif
