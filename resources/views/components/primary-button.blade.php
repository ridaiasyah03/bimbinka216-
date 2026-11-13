<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full btn-search text-white font-bold py-3 rounded-xl transition-all text-sm']) }}>
    {{ $slot }}
</button>