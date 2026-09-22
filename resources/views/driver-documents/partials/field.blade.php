{{--
    One labelled text input with inline server-side error.
    Expects: $bag, $name, $label, $value  (optional: $inputType, $required, $hint, $placeholder,
             $autocomplete, $inputmode, $maxlength, $min, $max)
--}}
@php
    $err = $errors->getBag($bag)->first($name);
    $id  = "dd-{$bag}-{$name}";
@endphp
<div class="dd-field {{ $err ? 'has-error' : '' }}">
    <label for="{{ $id }}">{{ $label }} @if($required ?? true)<span class="dd-req-star" aria-hidden="true">*</span>@endif</label>
    <input id="{{ $id }}" type="{{ $inputType ?? 'text' }}" name="{{ $name }}" value="{{ $value }}"
           @if($required ?? true) required @endif
           autocomplete="{{ $autocomplete ?? 'off' }}"
           @isset($inputmode) inputmode="{{ $inputmode }}" @endisset
           @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
           @isset($maxlength) maxlength="{{ $maxlength }}" @endisset
           @isset($minlength) minlength="{{ $minlength }}" @endisset
           @isset($min) min="{{ $min }}" @endisset
           @isset($max) max="{{ $max }}" @endisset
           @if($err) aria-invalid="true" aria-describedby="{{ $id }}-err" @endif>
    @isset($hint)<p class="dd-hint">{{ $hint }}</p>@endisset
    @if($err)<p class="dd-field-error" id="{{ $id }}-err" role="alert">{{ $err }}</p>@endif
</div>
