@extends("layouts.admin")

@section("title", "System Settings")

@section("content")
<main>
    <section class="admin-container">
        <div class="admin-section">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold">System Settings</h1>
                    <p class="text-sm opacity-70 mt-1">Manage your site's branding and global configuration.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-800 rounded">
                    <strong>✓</strong> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-800 rounded">
                    <strong>✗</strong> {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-800 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.system_settings.save') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- LEFT: Logo Upload --}}
                    <div class="lg:col-span-1">
                        <div class="border rounded-lg p-6" style="background:var(--card-bg,white);">
                            <h2 class="text-lg font-bold mb-4">System Logo</h2>

                            {{-- Current Logo Preview --}}
                            <div class="mb-4 flex flex-col items-center">
                                <div id="logo-preview-wrapper" class="w-32 h-32 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden bg-gray-50 mb-3">
                                    @if($system_logo)
                                        <img id="logo-preview" src="{{ $system_logo }}" alt="Current Logo" class="w-full h-full object-contain">
                                    @else
                                        <div id="logo-placeholder" class="text-center text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            <span class="text-xs">No logo</span>
                                        </div>
                                        <img id="logo-preview" src="" alt="" class="w-full h-full object-contain hidden">
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 text-center">Recommended: square image (PNG/SVG), max 2MB</p>
                            </div>

                            <label for="system_logo" class="block w-full cursor-pointer text-center px-4 py-2 border-2 border-dashed border-gray-300 rounded-lg text-sm font-medium hover:border-black transition-colors">
                                📁 Choose Logo Image
                                <input type="file" id="system_logo" name="system_logo" accept="image/*" class="hidden" onchange="previewLogo(this)">
                            </label>
                            <p class="text-xs text-gray-400 mt-2 text-center">Supports: JPG, PNG, GIF, SVG, WEBP</p>

                            @if($system_logo)
                                <div class="mt-4 p-3 bg-green-50 rounded border border-green-200 text-xs text-green-700">
                                    <strong>✓ Logo currently active.</strong> Upload a new file above to replace it.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- RIGHT: Text Settings --}}
                    <div class="lg:col-span-2">
                        <div class="border rounded-lg p-6" style="background:var(--card-bg,white);">
                            <h2 class="text-lg font-bold mb-6">Site Identity</h2>

                            <div class="space-y-5">
                                <div>
                                    <label for="system_name" class="block text-sm font-semibold mb-1">
                                        System Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text" id="system_name" name="system_name"
                                        value="{{ $settings['system_name'] ?? config('app.name', 'ProjectSanjal') }}"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-black focus:border-black"
                                        placeholder="e.g. ProjectSanjal">
                                    <p class="text-xs text-gray-500 mt-1">Used as the main system name shown in headers, footers, and page titles.</p>
                                </div>

                                <div>
                                    <label for="system_title" class="block text-sm font-semibold mb-1">
                                        Site Title (SEO)
                                    </label>
                                    <input
                                        type="text" id="system_title" name="system_title"
                                        value="{{ $settings['system_title'] ?? '' }}"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-black focus:border-black"
                                        placeholder="e.g. ProjectSanjal">
                                    <p class="text-xs text-gray-500 mt-1">Shown in browser tab titles and on the login/register pages.</p>
                                </div>

                                <div>
                                    <label for="system_short_description" class="block text-sm font-semibold mb-1">
                                        Short Tagline / Description
                                    </label>
                                    <textarea
                                        id="system_short_description" name="system_short_description"
                                        rows="3"
                                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-black focus:border-black resize-none"
                                        placeholder="e.g. Share &amp; Collaborate IT Projects">{{ $settings['system_short_description'] ?? '' }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Shown in login pages and as a subtitle for the system.</p>
                                </div>
                            </div>

                            <div class="mt-6 flex items-center gap-4 border-t pt-4">
                                <button type="submit" class="btn px-6 py-2 font-bold">
                                    💾 Save Settings
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline px-5 py-2">Cancel</a>
                            </div>
                        </div>

                        {{-- Preview Card --}}
                        <div class="border rounded-lg p-5 mt-6" style="background:var(--card-bg,white);">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-500 mb-3">Live Preview</h3>
                            <div class="flex items-center gap-3 p-3 border rounded bg-gray-50">
                                <div id="preview-logo-box" class="w-9 h-9 rounded bg-black text-white flex items-center justify-center font-bold text-sm overflow-hidden flex-shrink-0">
                                    @if($system_logo)
                                        <img src="{{ $system_logo }}" alt="" class="w-full h-full object-contain">
                                    @else
                                        <span id="preview-initial">{{ substr($settings['system_name'] ?? 'P', 0, 1) }}</span>
                                    @endif
                                </div>
                                <span id="preview-name" class="font-bold text-gray-900">{{ $settings['system_name'] ?? config('app.name', 'ProjectSanjal') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection

@section("js")
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('logo-preview');
            img.src = e.target.result;
            img.classList.remove('hidden');

            const placeholder = document.getElementById('logo-placeholder');
            if (placeholder) placeholder.classList.add('hidden');

            // Update live preview too
            const previewBox = document.getElementById('preview-logo-box');
            previewBox.innerHTML = `<img src="${e.target.result}" alt="" class="w-full h-full object-contain">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Live preview system name
document.getElementById('system_name').addEventListener('input', function() {
    const val = this.value || 'ProjectSanjal';
    document.getElementById('preview-name').textContent = val;
    const initial = document.getElementById('preview-initial');
    if (initial) initial.textContent = val.charAt(0).toUpperCase();
});
</script>
@endsection
