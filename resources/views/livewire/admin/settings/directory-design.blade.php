<div>
    <x-slot name="header">
        <div>
            <h1 class="text-xl font-bold text-slate-900">Portal Directory Design Settings</h1>
            <p class="text-xs text-slate-500">Select the visual architectural presentation for the internal organizational portal directory.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="saveDefaultDesign"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Save As Default Design</span>
            </button>
            <a href="{{ route('directory.index') }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition shadow-xs">
                <span>View Live Directory ↗</span>
            </a>
        </div>
    </x-slot>

    <!-- Design Selector Grid -->
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs mb-8">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-sm font-bold text-slate-900">Available Directory Layouts</h2>
                <p class="text-xs text-slate-500">Click any layout to trigger an instantaneous live preview below.</p>
            </div>
            <div class="text-xs font-medium text-slate-600">
                Active System Default: <span class="font-bold text-blue-600 uppercase">{{ str_replace('_', ' ', $currentSavedDesign) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            @foreach($designs as $design)
                @php
                    $isSelected = $selectedPreviewDesign === $design->value;
                    $isSaved = $currentSavedDesign === $design->value;
                @endphp
                <button type="button" wire:click="selectDesign('{{ $design->value }}')"
                        class="p-4 rounded-xl border text-left transition relative flex flex-col justify-between {{ $isSelected ? 'border-blue-600 bg-blue-50/50 ring-2 ring-blue-500/20' : 'border-slate-200 hover:border-slate-300 hover:bg-slate-50' }}">
                    <div>
                        <div class="flex items-center justify-between gap-1 mb-2">
                            <span class="text-xs font-bold {{ $isSelected ? 'text-blue-900' : 'text-slate-800' }}">
                                {{ $design->label() }}
                            </span>
                            @if($isSaved)
                                <span class="px-1.5 py-0.2 rounded text-[9px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 uppercase">
                                    Default
                                </span>
                            @endif
                        </div>
                        <p class="text-[11px] {{ $isSelected ? 'text-blue-700' : 'text-slate-500' }} line-clamp-3">
                            {{ $design->description() }}
                        </p>
                    </div>

                    <div class="mt-3 pt-2 border-t border-slate-200/60 flex items-center justify-between text-[10px] font-semibold">
                        <span class="{{ $isSelected ? 'text-blue-600' : 'text-slate-400' }}">
                            {{ $isSelected ? '● Previewing' : 'Click to preview' }}
                        </span>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Live Preview Stage -->
    <div class="border-t-2 border-dashed border-slate-300 pt-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <h3 class="text-xs uppercase font-mono font-bold tracking-wider text-slate-500">
                    Live Preview Stage — <span class="text-slate-900 uppercase">{{ str_replace('_', ' ', $selectedPreviewDesign) }}</span>
                </h3>
            </div>
            <span class="text-xs text-slate-400">Rendering live departmental data</span>
        </div>

        <div class="bg-slate-100/60 rounded-3xl p-4 sm:p-6 border border-slate-200/80">
            @if ($selectedPreviewDesign === 'card_grid')
                @include('portal.designs.card-grid', ['departments' => $departments])
            @elseif ($selectedPreviewDesign === 'employee_sections')
                @include('portal.designs.employee-sections', ['departments' => $departments])
            @elseif ($selectedPreviewDesign === 'radial')
                @include('portal.designs.radial', ['departments' => $departments])
            @elseif ($selectedPreviewDesign === 'compact')
                @include('portal.designs.compact', ['departments' => $departments])
            @elseif ($selectedPreviewDesign === 'dashboard')
                @include('portal.designs.dashboard', ['departments' => $departments])
            @endif
        </div>
    </div>
</div>
