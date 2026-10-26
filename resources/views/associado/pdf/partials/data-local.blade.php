{{-- "Natal/RN, dd de mês de aaaa" com campos editáveis. Use ['emBranco' => true] para sair vazio (preencher à mão). --}}
@php
    $emBranco = $emBranco ?? false;
@endphp
Natal/RN,
<span class="campo linha" contenteditable="true" data-placeholder="dd" style="min-width: 30px;">{{ $emBranco ? '' : now()->format('d') }}</span>
de
<span class="campo linha" contenteditable="true" data-placeholder="mês" style="min-width: 90px;">{{ $emBranco ? '' : now()->locale('pt_BR')->translatedFormat('F') }}</span>
de
<span class="campo linha" contenteditable="true" data-placeholder="aaaa" style="min-width: 45px;">{{ $emBranco ? '' : now()->format('Y') }}</span>
