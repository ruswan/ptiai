<x-filament-widgets::widget>
    <!-- Bagian Direktori Terapis -->
    <section>
        <div class="container mx-auto px-6">

            <h2 class="text-3xl font-bold text-center mb-4 header-section">Direktori Terapis</h2>
            <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Temukan terapis terbaik untuk mendukung
                perjalanan menyusui Anda.</p>

            {{ $this->table }}

        </div>
    </section>
</x-filament-widgets::widget>
